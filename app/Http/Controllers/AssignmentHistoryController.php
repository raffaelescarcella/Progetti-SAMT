<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Project;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssignmentHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $assignments = Assignment::join('users','assignments.user_id', '=', 'users.id')
            ->join('projects','assignments.project_id','=', 'projects.id')
            ->join('project_states','projects.state_id','=', 'project_states.id')
            ->where('project_states.state','Concluso')
            ->select('users.name AS nome','users.surname AS cognome','projects.name AS progetto')
            ->get();
        return view('AssignmentHistory.index')->with('assignments', $assignments);
    }

}
