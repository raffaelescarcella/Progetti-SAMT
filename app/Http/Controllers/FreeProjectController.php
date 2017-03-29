<?php

namespace App\Http\Controllers;

use App\Ambit;
use App\Assignment;
use App\Project;
use App\ProjectState;
use App\User;
use App\UserState;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FreeProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = Project::join('project_states','projects.state_id','=','project_states.id')
            ->where('project_states.state','Disponibile')
            ->orWhere('project_states.state','In corso')
            ->get();

        $assignment = Assignment::join('projects','assignments.project_id','=','projects.id')
            ->join('project_states','projects.state_id','=','project_states.id')
            ->join('users','assignments.user_id','=','users.id')
            ->where('project_states.state','Disponibile')
            ->orWhere('project_states.state','In corso')
            ->get();

        $bool = $assignment->contains(Auth::user()->id)?1:0;

        return view('FreeProject.index')->with('projects', $projects)->with('bool',$bool);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nome)
    {

        $projectId = Project::where('name',$nome)->first()->id;
        $current = ProjectState::where('state', 'In corso')
            ->first()->id;


        $assignment = new Assignment;
        $assignment->user_id = Auth::user()->id;
        $assignment->project_id = $projectId;
        $assignment->save();

        /*Assignment::firstOrCreate(['user_id' => Auth::user()->id, 'project_id' => $projectId]);
        Assignment::insert(['user_id'=> Auth::user()->id,'project_id' => $projectId]);*/

        //Assignment::create(array(Auth::user()->id, $projectId));

        /*DB::table('assignments')->insert(
            ['user_id' => Auth::user()->id, 'project_id' => $projectId]
        );*/

        Project::find($projectId)->update([
                'state_id' => $current,
            ]
        );

        return redirect()->route('freeprojects.index')
            ->with('success', 'Assegnazione creata!');


    }


}
