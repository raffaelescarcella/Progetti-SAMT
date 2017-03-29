<?php

namespace App\Http\Controllers;

use App\Ambit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AmbitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ambits = Ambit::all();
        return view('Ambit.index')->with('ambits', $ambits);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Ambit.create');
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
            'ambit' => 'required|max:255',
        ]);

        Ambit::create($request->all());
        return redirect()->route('ambits.index')
            ->with('success','Ambito creato');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ambit = Ambit::find($id);
        return view('Ambit.edit',compact('ambit'));
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
            'ambit' => 'required|max:255',
        ]);

        Ambit::find($id)->update([
                'ambit' => $request['ambit'],
            ]
        );
        return redirect()->route('ambits.index')
            ->with('success','Ambito modificato');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ambit::find($id)->delete();
        return redirect()->route('ambits.index')
            ->with('success','Ambito eliminato!');
    }

}
