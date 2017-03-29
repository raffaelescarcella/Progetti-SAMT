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

class UserConfirmationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $state = UserState::all()->where('state','Attivo')->first()->id;
        $users = User::all()->where('state_id','!=',$state);

        return view('UserConfirmation.index')->with('users', $users);
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
        $active = UserState::where('state', 'Attivo')
            ->first()->id;

        User::find($id)->update([
            'state_id' => $active,
        ]);

        return redirect()->route('userconfirmations.index')
            ->with('success', 'Utente accettato!');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('userconfirmations.index')
            ->with('success', 'Utente eliminato!');
    }


}
