@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Lista progetti disponibili</h2>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <tr>
                <th>Nome</th>
                <th>Docente</th>
                <th>Anno</th>
                <th>Numero</th>
                <th>Ambito</th>
                <th>Data di inizio</th>
                <th>Data di fine</th>
                <th>Stato</th>
                @if(Auth::check() && Auth::user()->type_id == \App\Type::where('type','Allievo')->first()->id && $bool == 0)
                    <th></th>
                @endif
            </tr>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->user->name . ' ' . $project->user->surname }}</td>
                    @php
                        $date = explode('-',$project->start_date);
                        $year = intval($date[0]);
                        $month = intval($date[1]);
                    @endphp
                    @if($month>=8)
                        <td>{{ $year .'-'. ($year+1) }}</td>
                    @else
                        <td>{{ ($year-1) .'-'. $year }}</td>
                    @endif
                    <td>{{ $project->number }}</td>
                    <td>{{ $project->ambit->ambit }}</td>
                    <td>{{ $project->start_date }}</td>
                    <td>{{ $project->end_date }}</td>
                    <td>{{ $project->projectstate->state }}</td>
                    @php

                    @endphp
                    @if(Auth::user()->type_id == \App\Type::where('type','Allievo')->first()->id && $bool == 0 && Auth::user()->state_id == \App\UserState ::where('state','Attivo')->first()->id)
                        <td>
                            {!! Form::open(['method' => 'PATCH','route' => ['freeprojects.update', $project->name],'style'=>'display:inline']) !!}
                            {!! Form::submit('Seleziona', ['class' => 'btn btn-primary']) !!}
                            {!! Form::close() !!}
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>

    {{-- $users->render() --}}

@endsection