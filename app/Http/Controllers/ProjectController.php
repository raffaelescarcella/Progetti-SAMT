<?php

namespace App\Http\Controllers;

use App\Ambit;
use App\Assignment;
use App\Project;
use App\ProjectState;
use App\User;
use App\UserState;
use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = Project::all();
        return view('Project.index')->with('projects', $projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::join('types', 'users.type_id', '=', 'types.id')
            ->where('types.type', 'Docente')
            ->select('users.id', 'users.name', 'users.surname')
            ->get();
        return view('Project.create')->with('users', $users);
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
            'name' => 'required|max:255|unique:projects',
            'number' => 'required|integer|min:1|max:3',
            'ambit_id' => 'required|integer',
            'user_id' => 'required|integer',
            'max_participants' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        Project::create($request->all());
        return redirect()->route('projects.index')
            ->with('success', 'Progetto creato');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
        $ambits = Ambit::all();
        $users = User::join('types', 'users.type_id', '=', 'types.id')
            ->where('types.type', 'Docente')
            ->select('users.id', 'users.name', 'users.surname')
            ->get();
        $projectstates = ProjectState::all()->where('state', '!=', 'In corso');

        $adminStates = ProjectState::all()->where('state', 'In corso');


        $adminType = \App\Type::where('type', 'Admin')->first();

        if (Auth::user()->type_id == $adminType->id || Auth::user()->id == $project->user_id) {

            return view('Project.edit', compact('project'))->with('ambits', $ambits)->with('users', $users)->with('projectstates', $projectstates)->with('adminStates',$adminStates);
        }
        else{
            return redirect()->route('projects.index')
                ->with('deny', "Non hai l'autorizzazione per vedere i dettagli del progetto selezionato");
        }
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
            'name' => 'required|max:255|unique:projects,name,' . $id,
            'number' => 'required|integer|min:1|max:3',
            'ambit_id' => 'required|integer',
            'max_participants' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'state_id' => 'required|integer',
            'user_id' => 'required|integer',

        ]);




        $date1 = date_create($request['start_date']);
        $date2 = date_create($request['end_date']);

        $diff = intval(date_diff($date1, $date2)->format("%a"));
        if ($diff > 365) {

            $day = intval(date('d', strtotime($request['end_date'])));
            $month = intval(date('m', strtotime($request['start_date'])));

            if ($month > 8) {
                $year = intval(date('Y', strtotime($request['start_date']))) + 1;
            } else {
                $year = intval(date('Y', strtotime($request['start_date'])));
            }


            $date2 = date_create($year . "-" . $month . "-" . $day);
        }


        $idFinished = ProjectState::where('state','Concluso')->first()->id;

        $bool = 0;


        if(Project::find($id)->first()->state_id == $idFinished && $request['state_id'] != $idFinished){
            Assignment::where('project_id','=',$id)
                ->update(['final_rating' => null]);
        }


        Project::find($id)->update([
                'name' => $request['name'] . ' ' . $bool,
                'number' => $request['number'],
                'ambit_id' => $request['ambit_id'],
                'max_participants' => $request['max_participants'],
                'user_id' => $request['user_id'],
                'start_date' => $request['start_date'],
                'end_date' => $date2,
                'state_id' => $request['state_id'],
            ]
        );







        return redirect()->route('projects.index')
            ->with('success', 'Progetto modificato');
    }

}
