@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Crea assegnazione</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('assignments.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(array('route' => 'assignments.store','method'=>'POST')) !!}

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Utente:</strong>
            <select name="user_id" class="selectpicker form-control" data-live-search="true">
                <option selected id="user_id " value=""></option>
                @foreach ($users as $user)
                    <option id="user_id" value="{{$user->id}}">{{ $user->name . ' ' .$user->surname  }}</option>

                @endforeach
            </select>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Progetto:</strong>
            <select name="project_id" class="selectpicker form-control" data-live-search="true">
                <option selected id="project_id " value=""></option>
                @foreach ($currentProjects as $project)
                    @php( $currentParticipants = \App\Project::join('assignments','projects.id','=','assignments.project_id')
            ->join('project_states','projects.state_id','=','project_states.id')
            ->where('projects.id',$project->id)
            ->whereNull('assignments.deleted_at')
            ->count())
                    @if($project->max_participants > $currentParticipants)
                    <option id="project_id" value="{{$project->id}}">{{ $project->name . ' ' .$currentParticipants . '/' . $project->max_participants    }}</option>
                    @endif
                @endforeach
                @foreach ($availableProjects as $project)
                    <option id="project_id" value="{{$project->id}}">{{ $project->name  . ' 0/' . $project->max_participants }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

    </div>
    {!! Form::close() !!}

@endsection