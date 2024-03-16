<?php

namespace App\Http\Controllers;

use App\Models\questionnaire;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request){
        $listActiveQuestionnaire = questionnaire::all();
        return Inertia::render('Dashboard',["questionnaire"=>$listActiveQuestionnaire]);
    }
}
