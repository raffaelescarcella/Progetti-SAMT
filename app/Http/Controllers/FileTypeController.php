<?php

namespace App\Http\Controllers;

use App\FileType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Type;

class FileTypeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $types = FileType::all();
        return view('FileType.index')->with('types', $types);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('FileType.create');
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
            'type' => 'required|max:255',
        ]);

        FileType::create($request->all());
        return redirect()->route('filetypes.index')
            ->with('success','Tipo di file creato');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = FileType::find($id);
        return view('FileType.edit',compact('type'));
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
            'type' => 'required|max:255',
        ]);

        FileType::find($id)->update([
                'type' => $request['type'],
            ]
        );
        return redirect()->route('filetypes.index')
            ->with('success','Tipo di file modificato');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        FileType::find($id)->delete();
        return redirect()->route('filetypes.index')
            ->with('success','Tipo di file eliminato!');
    }

}
