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
                <th>Numero partecipanti</th>
                <th>Stato</th>
                @if(Auth::check() && Auth::user()->type_id == \App\Type::where('type','Allievo')->first()->id && $bool == 0)
                    <th></th>
                @endif
            </tr>
            @foreach ($projects as $project)

                <tr>
                    <td>{{ $project->name }}</td>
                    @php($teacher = \App\User::where('id',$project->user)->first())
                    <td>{{ $teacher->name . ' ' . $teacher->surname }}</td>
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
                    @php($ambit = \App\Ambit::where('id',$project->ambit)->first())
                    <td>{{ $ambit->ambit }}</td>
                    <td>{{ $project->start_date }}</td>
                    <td>{{ $project->end_date }}</td>
                    @php
                        $currentParticipants = \App\Project::join('assignments','projects.id','=','assignments.project_id')
                            ->join('project_states','projects.state_id','=','project_states.id')
                            ->where('projects.id',$project->id)
                            ->whereNull('assignments.deleted_at')
                            ->count();
                    @endphp
                    <td>{{ $currentParticipants . '/' . $project->max_participants }}</td>
                    <td>{{ $project->state }}</td>
                    @if(Auth::user()->type_id == \App\Type::where('type','Allievo')->first()->id && $bool == 0)
                        @if($project->max_participants > $currentParticipants)
                            <td>
                                {!! Form::open(['method' => 'PATCH','route' => ['freeprojects.update', $project->name],'style'=>'display:inline']) !!}
                                {!! Form::submit('Seleziona', ['class' => 'btn btn-primary']) !!}
                                {!! Form::close() !!}
                            </td>
                        @else
                            <td></td>
                        @endif
                    @elseif(Auth::user()->type_id == \App\Type::where('type','Allievo')->first()->id && $bool == 0)
                    @endif
                </tr>
            @endforeach
        </table>
    </div>

    {{-- $users->render() --}}

@endsection