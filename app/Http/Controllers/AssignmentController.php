<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Project;
use App\ProjectState;
use App\Type;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$assignments = Assignment::where('id',3)->where('user_id',5)->get();
        $assignments = Assignment::join('users', 'assignments.user_id', '=', 'users.id')
            ->join('projects', 'assignments.project_id', '=', 'projects.id')
            ->join('project_states', 'projects.state_id', '=', 'project_states.id')
            ->where('project_states.state', 'In corso')
            ->select('users.name AS nome', 'users.surname AS cognome', 'projects.name AS progetto', 'assignments.id')
            ->get();

        return view('Assignment.index')->with('assignments', $assignments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //SUBQUERY PER VEDERE QUALE UTENTE NON HA UN ASSEGNAZIONE
        //SELECT * FROM USER WHERE ID NOT IN (SELECT USER_ID FROM ASSIGNMENT)



        $current = ProjectState::where('state', 'In corso')
            ->first();

        $available = ProjectState::where('state', 'Disponibile')
            ->first();

        $assignments = Assignment::join('projects', 'assignments.project_id', '=', 'projects.id')
            ->join('project_states', 'projects.state_id', '=', 'project_states.id')
            ->where('project_states.state', 'In corso')
            ->select('assignments.user_id')
            ->get();

        $type = Type::where('type', 'Allievo')
            ->first();

        $users = User::where('users.type_id', $type->id)
            ->whereNotIn('users.id', $assignments)
            ->get();


        $currentProjects = Project::all()
            ->where('state_id', $current->id);
        $availableProjects = Project::all()
            ->where('state_id', $available->id);


        return view('Assignment.create')->with('users', $users)->with('currentProjects', $currentProjects)->with('availableProjects', $availableProjects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|integer',
            'project_id' => 'required|integer',
        ]);

        Assignment::create($request->all());

        $current = ProjectState::where('state', 'In corso')
            ->first();

        Project::find($request['project_id'])->update([
                'state_id' => $current->id,
            ]
        );

        return redirect()->route('assignments.index')
            ->with('success', 'Assegnazione creata');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $assignment = Assignment::find($id);

        $current = ProjectState::where('state', 'In corso')
            ->first();
        $available = ProjectState::where('state', 'Disponibile')
            ->first();

        $currentProjects = Project::all()
            ->where('state_id', $current->id);
        $availableProjects = Project::all()
            ->where('state_id', $available->id);


        $assignmentsInProgress = Assignment::join('projects', 'assignments.project_id', '=', 'projects.id')
            ->join('project_states', 'projects.state_id', '=', 'project_states.id')
            ->where('project_states.state', 'In corso')
            ->select('assignments.user_id')
            ->get();

        $type = Type::where('type', 'Allievo')
            ->first();

        $users = User::where('users.type_id', $type->id)
            ->whereNotIn('users.id', $assignmentsInProgress)
            ->get();

        return view('Assignment.edit', compact('assignment'))->with('users', $users)->with('currentProjects', $currentProjects)->with('availableProjects',$availableProjects);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'user_id' => 'required|integer',
            'project_id' => 'required|integer',
        ]);

        Assignment::find($id)->update([
                'user_id' => $request['user_id'],
                'project_id' => $request['project_id'],
            ]
        );

        $current = ProjectState::where('state', 'In corso')
            ->first();

        Project::find($request['project_id'])->update([
                'state_id' => $current->id,
            ]
        );

        return redirect()->route('assignments.index')
            ->with('success', 'Assegnazione modificata');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Assignment::find($id)->delete();
        return redirect()->route('assignments.index')
            ->with('success', 'Assegnazine eliminata!');
    }

}
