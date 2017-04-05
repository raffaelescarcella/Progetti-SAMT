<?php

namespace App\Http\Controllers;

use App\Ambit;
use App\Assignment;
use App\File;
use App\Project;
use App\ProjectState;
use App\User;
use App\UserState;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinishedProjectController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = Project::join('project_states', 'projects.state_id', '=', 'project_states.id')
            ->join('assignments', 'projects.id', '=', 'assignments.project_id')
            ->join('users', 'assignments.user_id', '=', 'users.id')
            ->where('project_states.state', 'Concluso')
            ->whereNull('assignments.deleted_at')
            ->select('projects.id as id', 'projects.user_id',
                'projects.name', 'projects.number',
                'projects.ambit_id', 'projects.start_date',
                'projects.end_date', 'projects.state_id',
                'users.name AS nome', 'users.surname AS cognome',
                'assignments.id as assignment','assignments.final_rating as final_rating')
            ->get();
        return view('FinishedProject.index')->with('projects', $projects);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $assignmentsProject = Assignment::join('projects', 'assignments.project_id', '=', 'projects.id')
            ->where('assignments.id', $id)
            ->select('projects.id as project', 'assignments.id as id')
            ->first();

        $assignmentsUser = Assignment::join('users', 'assignments.user_id', '=', 'users.id')
            ->where('assignments.id', $id)
            ->select('users.id as user')
            ->first();

        $project = Project::find($assignmentsProject->project);
        $user = User::find($assignmentsUser->user);

        $files = File::where('assignment_id', $id)->orderBy('name')->get();

        return view('FinishedProject.show', compact('project'))->with('files', $files)->with('user', $user)->with('assignment', $id);
    }
}
