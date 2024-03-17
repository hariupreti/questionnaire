<?php

namespace App\Http\Controllers;

use App\Models\questionnaire;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request){
        $listActiveQuestionnaire = questionnaire::whereDate('expiry_date', '>', Carbon::now())->get();
        return Inertia::render('Dashboard',["questionnaire"=>$listActiveQuestionnaire]);
    }
}
