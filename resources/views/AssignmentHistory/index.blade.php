@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Lista storico assegnazioni</h2>
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
        </tr>
        @foreach ($assignments as $assignment)
            <tr>
                <td style="display:none;">{{ $assignment->id  }}</td>
                <td>{{ $assignment->nome . ' ' . $assignment->cognome }}</td>
                <td>{{ $assignment->progetto }}</td>
                @php($teachers = App\Project::join('users','projects.user_id', '=', 'users.id')
                ->where('projects.name',$assignment->progetto)
                ->select('users.name AS nome','users.surname AS cognome')
                ->get())
                @foreach($teachers as $teacher)
                    <td>{{ $teacher->nome . ' ' . $teacher->cognome }}</td>
                @endforeach

            </tr>
        @endforeach

    </table>

    {{-- $users->render() --}}

@endsection