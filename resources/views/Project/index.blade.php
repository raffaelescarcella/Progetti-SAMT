@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Lista progetti</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('projects.create') }}"> Crea progetto</a>
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
                <th>Voto finale</th>
                <th></th>
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
                    <td>{{ $project->final_rating }}</td>
                    <td>
                    <!--a class="btn btn-info" href="{{-- route('userCRUD.show',$user->id) --}}">Show</a-->
                        <a class="btn btn-primary" href="{{ route('projects.edit',$project->id) }}">Modifica</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    {{-- $users->render() --}}

@endsection