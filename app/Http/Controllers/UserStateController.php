<?php

namespace App\Http\Controllers;

use App\UserState;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userstates = UserState::all();
        return view('UserState.index')->with('userstates', $userstates);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('UserState.create');
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

        UserState::create($request->all());
        return redirect()->route('userstates.index')
            ->with('success','Stato utente creato');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $state = UserState::find($id);
        return view('UserState.edit',compact('state'));
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

        UserState::find($id)->update([
                'state' => $request['state'],
            ]
        );
        return redirect()->route('userstates.index')
            ->with('success','Stato utente modificato');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserState::find($id)->delete();
        return redirect()->route('userstates.index')
            ->with('success','Stato utente eliminato!');
    }

}
