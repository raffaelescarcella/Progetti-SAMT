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

class CurrentProjectController extends Controller
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
            ->join('user_states','users.state_id','=','user_states.id')
            ->where('project_states.state', 'In corso')
            ->whereNull('assignments.deleted_at')
            ->where('user_states.state','Attivo')
            ->select('projects.id as id', 'projects.user_id',
                'projects.name', 'projects.number',
                'projects.ambit_id', 'projects.start_date',
                'projects.end_date', 'projects.state_id', 'projects.final_rating',
                'users.name AS nome', 'users.surname AS cognome',
                'assignments.id as assignment')
            ->get();
        return view('CurrentProject.index')->with('projects', $projects);
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

        $adminType = \App\Type::where('type','Admin')->first();
        if(Auth::check() && (Auth::id() == $user->id ||Auth::id() == $project->user->id || Auth::user()->type_id == $adminType->id)){
            return view('CurrentProject.show', compact('project'))->with('files', $files)->with('user', $user)->with('assignment', $id);
        }
        else{
            return redirect()->route('currentprojects.index')
                ->with('redirect', "Non hai l'autorizzazione per vedere i dettagli del progetto selezionato");
        }


    }

    public function edit($id)
    {

        $userId = Assignment::join('users', 'assignments.user_id', '=', 'users.id')
            ->where('assignments.id', $id)
            ->first();

        $projectId = Assignment::join('projects', 'assignments.project_id', '=', 'projects.id')
            ->where('assignments.id', $id)
            ->first();

        $user = User::all()->where('id', $userId->id)->first();
        $project = Project::all()->where('id', $projectId->id)->first();

        return view('CurrentProject.edit')->with('assignment', $id)->with('user', $user)->with('project', $project);
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file',
        ]);

        $id = $request['id'];

        $userId = Assignment::join('users', 'assignments.user_id', '=', 'users.id')
            ->where('assignments.id', $id)
            ->first();

        $projectId = Assignment::join('projects', 'assignments.project_id', '=', 'projects.id')
            ->where('assignments.id', $id)
            ->first();

        $user = User::all()->where('id', $userId->id)->first();
        $project = Project::all()->where('id', $projectId->id)->first();

        $file = array('file' => Input::file('file'));

        $rules = array('file' => 'required',);

        $validator = Validator::make($file, $rules);

        if ($validator->fails()) {
            return Redirect::to('currentprojects'.'/'.$id)->withInput()->withErrors($validator);
        } else {
            if (Input::file('file')->isValid()) {


                $destinationPath = 'files/' . $user->surname . '-' . $project->name . '/';
                $name = Input::file('file')->getClientOriginalName();
                Input::file('file')->move($destinationPath, $name);


                if (File::withTrashed()->where('name', $name)->exists()) {
                    File::withTrashed()->where('name', $name)
                        ->update(['date' => date("Y-m-d")]);
                    File::withTrashed()->where('name', $name)->restore();
                } else {
                    $db = new File;
                    $db->name = $name;
                    $db->assignment_id = $id;
                    $db->date = date("Y-m-d");
                    $db->save();
                }


                return Redirect::to('currentprojects'.'/'.$id);
            } else {

                return Redirect::to('currentprojects'.'/'.$id);
            }
        }
    }

    public function destroy($id)
    {
        $idAssignment = File::where('id',$id)->first();
        File::find($id)->delete();
        return  Redirect::to('currentprojects'.'/'.$idAssignment->assignment_id)
            ->with('success', 'File eliminato!');
    }

}
