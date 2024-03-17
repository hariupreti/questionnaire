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
                    $content = "Please click on below link to access your test. \n";
                    $uniqueURLHanlder = [
                        "valid_till" => date('Y-m-d', strtotime($request->selectedExpiryDate)),
                        "email" => $student->email,
                        "quessionnaire_id" => $questionnaire->id
                    ];
                    $encryptedURL = encrypt($uniqueURLHanlder, true);
                    $fullLink = url("/questionnaire/access/{$encryptedURL}");
                    $content .= '<a href="' . $fullLink . '" target="_blank"> Access Test </a>';
                    SendQuestionnaireAnnouncementEmailJob::dispatch($student->email, $subject, $content);
                }

                return back()->with("success", "Questionnaire generated successfully and mail is queued!!!");
            }
        }
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
