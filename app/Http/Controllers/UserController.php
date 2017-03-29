<?php

namespace App\Http\Controllers;

use App\Type;
use App\UserState;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::all();
        return view('User.index')->with('users', $users);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $usertypes = Type::all();
        $userstates = UserState::all();
        return view('User.edit',compact('user'))->with('usertypes', $usertypes)->with('userstates',$userstates);
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
            'email' => 'required|email|max:255|unique:users,email,' . $id.'|email_domain:'.$request['email'],
            'type_id' => 'required|integer',
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'phone' => 'required|min:13|max:14',
            'birthday' => 'required|date',
            'state_id' => 'required|integer',
        ]);

        User::find($id)->update([
                'email' => $request['email'],
                'type_id' => $request['type_id'],
                'name' => $request['name'],
                'surname' => $request['surname'],
                'phone' => $request['phone'],
                'birthday' => $request['birthday'],
                'state_id' => $request['state_id'],
            ]
        );
        return redirect()->route('users.index')
            ->with('success','Utente modificato');
    }

    public function anyData()
    {
        return Datatables::of(User::query())->make(true);
    }

}
