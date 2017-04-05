@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Dettagli progetto in corso</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('currentprojects.index') }}"> Back</a>

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
                <th>Allievo</th>
                <th>Progetto</th>
                <th>Docente</th>
                <th>Anno</th>
                <th>Numero</th>
                <th>Ambito</th>
                <th>Data di inizio</th>
                <th>Data di fine</th>
            </tr>
            <tr>
                <td>{{ $user->name . ' ' . $user->surname }}</td>
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
            </tr>
        </table>

    </div>
    <br><br><br>

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>File associati</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('currentprojects.edit',$assignment) }}">Aggiungi file</a>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <tbody></tbody>
            <tr>
                <th>Nome</th>
                <th>Data</th>
                <th>Tipo</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            @foreach ($files as $file)
                @if($file->type->id != \App\FileType::where('type','Valutazione Finale')->first()->id)
                    <tr>
                        <td>{{ $file->name }}</td>
                        <td>{{ $file->date }}</td>
                        <td> {{ $file->type->type }}</td>
                        <td>
                            <a target="_blank" href="{{ '/files/'.$user->surname.'-'.$project->name.'/'.$file->name }}">Visualizza</a>
                        </td>
                        <td>
                            <a download
                               href="{{ '/files/'.$user->surname.'-'.$project->name.'/'.$file->name }}">Scarica </a>
                        </td>
                        <td>
                            {!! Form::open(['method' => 'DELETE','route' => ['currentprojects.destroy', $file->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @elseif(Auth::user()->type_id == \App\Type::where('type', 'Admin')->first()->id || Auth::user()->id == $project->user_id)
                    <tr>
                        <td>{{ $file->name }}</td>
                        <td>{{ $file->date }}</td>
                        <td> {{ $file->type->type }}</td>
                        <td>
                            <a target="_blank" href="{{ '/files/'.$user->surname.'-'.$project->name.'/'.$file->name }}">Visualizza</a>
                        </td>
                        <td>
                            <a download
                               href="{{ '/files/'.$user->surname.'-'.$project->name.'/'.$file->name }}">Scarica </a>
                        </td>
                        <td>
                            {!! Form::open(['method' => 'DELETE','route' => ['currentprojects.destroy', $file->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endif
            @endforeach
        </table>
    </div>
@endsection