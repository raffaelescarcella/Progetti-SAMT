@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Dettagli progetto in corso</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('finishedprojects.index') }}"> Back</a>

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

    @php
        $projectName = $project->name;
        $userName = $project->user->name;
    @endphp

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>File associati</h2>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <tr>
                <th>Nome</th>
                <th>Data</th>
                <th></th>
                <th></th>
            </tr>
            @foreach ($files as $file)
                <tr>
                    <td>{{ $file->name }}</td>
                    <td>{{ $file->date }}</td>
                    @php
                        $fileName = $file->name;
                    @endphp
                    <td>
                        <a target="_blank" href="{{ '/files/'.$user->surname.'-'.$project->name.'/'.$file->name }}">Visualizza</a>
                    </td>
                    <td>
                        <a download
                           href="{{ '/files/'.$user->surname.'-'.$project->name.'/'.$file->name }}">Scarica </a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection