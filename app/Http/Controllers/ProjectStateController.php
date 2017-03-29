<?php

namespace App\Http\Controllers;

use App\ProjectState;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projectstates = ProjectState::all();
        return view('ProjectState.index')->with('projectstates', $projectstates);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ProjectState.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'state' => 'required|max:255',
        ]);

        ProjectState::create($request->all());
        return redirect()->route('projectstates.index')
            ->with('success','Stato progetto creato');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $state = ProjectState::find($id);
        return view('ProjectState.edit',compact('state'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'state' => 'required|max:255',
        ]);

        ProjectState::find($id)->update([
                'state' => $request['state'],
            ]
        );
        return redirect()->route('projectstates.index')
            ->with('success','Stato progetto modificato');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProjectState::find($id)->delete();
        return redirect()->route('projectstates.index')
            ->with('success','Stato progetto eliminato!');
    }

}
