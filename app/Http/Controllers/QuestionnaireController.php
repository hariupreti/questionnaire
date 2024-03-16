<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorequestionnaireRequest;
use App\Http\Requests\UpdatequestionnaireRequest;
use App\Jobs\SendQuestionnaireAnnouncementEmailJob;
use App\Models\question;
use App\Models\questionnaire;
use App\Models\student;
use Illuminate\Support\Facades\Date;
use Inertia\Inertia;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($token)
    {
        $decryptToken = decrypt($token);
        if (!empty($decryptToken)) {
            $validity = $decryptToken['valid_till'];
            $studentEmail = $decryptToken['email'];
            $quessionnaireId = $decryptToken['quessionnaire_id'];

            $errorMessage = "";
            //validate
            $today = strtotime(date("Y-m-d"));
            $validTill = strtotime($validity);
            $difference = abs($validTill - $today) / (60 * 60 * 24);
            if ($difference > 0) {
                $studentExistCheck =  student::where("email", $studentEmail)->first();
                if (!empty($studentExistCheck)) {
                    //Load questionnaire and start test
                    $questionnaire = questionnaire::findOrFail($quessionnaireId);
                    $serializeIds = unserialize($questionnaire->questions);
                    if (!empty($serializeIds)) {
                        $allQuestions = question::whereIn("id", $serializeIds)->with("answers")->get();
                        return Inertia::render("Test", ["questions" => $allQuestions, "student" => $studentExistCheck, "questionnaire" => $questionnaire]);
                    }
                } else {
                    $errorMessage = "unauthorized access!!!";
                }
            } else {
                $errorMessage = "Sorry, questionnaire already got expired";
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    private function getRandomQuestions($subject, $count)
    {
        // Fetch random questions from database based on section and count
        return question::whereHas('section', function ($query) use ($subject) {
            $query->where('name', $subject);
        })->inRandomOrder()->limit($count)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorequestionnaireRequest $request)
    {
        if ($request->id > 0) {
            questionnaire::where("id", $request->id)->update([
                'title' => $request->title,
                'expiry_date' => date('Y-m-d', strtotime($request->selectedExpiryDate)),
            ]);
            return back()->with("success", "Questionnaire updated successfully!");
        } else {
            $questionnaire = new Questionnaire();
            $questionnaire->title = $request->title;
            $questionnaire->expiry_date = date('Y-m-d', strtotime($request->selectedExpiryDate));
            if ($questionnaire) {
                // Creating new questinnaire questions 
                // collection from physics and chemestry 
                // section taking 5 from each section

                // Fetch 5 5 random questions
                $physicsQuestionsIds = $this->getRandomQuestions('Physics', 5)->pluck("id")->toArray();
                $chemistryQuestionsIds = $this->getRandomQuestions('Chemistry', 5)->pluck("id")->toArray();

                $questionnaire->questions = serialize(array_merge($physicsQuestionsIds, $chemistryQuestionsIds));
                $questionnaire->save();

                //Run mail functionality
                $subject = "Questionnaire Announcement";
                $students = student::all();
                foreach ($students as $student) {
                    $content = "Please click on below link or paste it browser URL field to access your test. \n";
                    $uniqueURLHanlder = [
                        "valid_till" => date('Y-m-d', strtotime($request->selectedExpiryDate)),
                        "email" => $student->email,
                        "quessionnaire_id" => $questionnaire->id
                    ];
                    $encryptedURL = encrypt($uniqueURLHanlder, true);
                    $fullLink = url("/questionnaire/access/{$encryptedURL}");
                    $content .= $fullLink;
                    SendQuestionnaireAnnouncementEmailJob::dispatch($student->email, $subject, $content);
                }

                return back()->with("success", "Questionnaire generated successfully and mail is queued!!!");
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(questionnaire $questionnaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(questionnaire $questionnaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatequestionnaireRequest $request, questionnaire $questionnaire)
    {
        dd($request->all(), $questionnaire);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($questionnaireId = 0)
    {
        questionnaire::find($questionnaireId)->delete();
        return back()->with("success", "Questionnaire deleted!!!");
    }
}
