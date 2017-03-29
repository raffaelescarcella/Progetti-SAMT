@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Lista assegnazioni in corso</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('assignments.create') }}"> Crea assegnazione</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered text-center">
        <tr>
            <th>Utente</th>
            <th>Progetto</th>
            <th>Docente</th>
            <th></th>
            <th></th>
        </tr>
        @foreach ($assignments as $assignment)
            <tr>
                <td style="display:none;">{{ $assignment->id  }}</td>
                <td>{{ $assignment->nome . ' ' . $assignment->cognome}}</td>
                <td>{{ $assignment->progetto}}</td>
                @php($teachers = App\Project::join('users','projects.user_id', '=', 'users.id')
                ->where('projects.name',$assignment->progetto)
                ->select('users.name AS nome','users.surname AS cognome')
                ->get())
                @foreach($teachers as $teacher)
                    <td>{{ $teacher->nome . ' ' . $teacher->cognome }}</td>
                @endforeach
                <td>
                    <a class="btn btn-primary" href="{{ route('assignments.edit',$assignment->id) }}">Modifica</a>
                </td>
                <td>
                    {!! Form::open(['method' => 'DELETE','route' => ['assignments.destroy', $assignment->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </table>

    {{-- $users->render() --}}

@endsection