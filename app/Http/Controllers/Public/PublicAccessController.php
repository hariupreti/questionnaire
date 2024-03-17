<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\question;
use App\Models\questionnaire;
use App\Models\student;
use App\Models\studentAnswers;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicAccessController extends Controller
{
    public function accessTest($token)
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

    public function saveTestAnswer(Request $request)
    {
        // Just doing basic validation and recording answers data
        $validated = $request->validate([
            'questionnaireId' => 'required|numeric|exists:questionnaires,id',
            'studentId' => 'required|numeric|exists:students,id',
            'answerData' => 'required|array',
        ]);

        if($validated){
            $studentAnswers = new studentAnswers();
            $studentAnswers->student_id = $request->input('studentId');
            $studentAnswers->questionnaire_id = $request->input('questionnaireId');
            $studentAnswers->answer_data = serialize($request->input('answerData'));
        }

        return redirect('/')->with("success","You have completed your test!!!");
    }
}
