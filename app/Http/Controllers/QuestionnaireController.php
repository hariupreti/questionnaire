<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorequestionnaireRequest;
use App\Http\Requests\UpdatequestionnaireRequest;
use App\Models\questionnaire;
use Illuminate\Support\Facades\Date;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
            $newQuestionnaire = questionnaire::create([
                'title' => $request->title,
                'expiry_date' => date('Y-m-d', strtotime($request->selectedExpiryDate))
            ]);
            if ($newQuestionnaire) {
                //Start random question assign process
            }
            return back()->with("success", "Questionnaire generated successfully!!!");
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
