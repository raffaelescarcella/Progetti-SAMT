@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Modifica assegnazione</h2>
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

    {{Form::model($assignment, ['method' => 'PATCH','route' => ['assignments.update', $assignment->id]]) }}
    <div class="row">


        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Utente:</strong>
                <select name="user_id" class="selectpicker form-control" data-live-search="true">
                    <option style="display: none" selected id="user_id" value="{{$assignment->user->id}}">{{ $assignment->user->name . ' ' . $assignment->user->surname}}</option>
                    @foreach ($users as $user)
                        <option id="user_id" value="{{$user->id}}">{{ $user->name . ' ' .$user->surname }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Progetto:</strong>
                <select name="project_id" class="selectpicker form-control" data-live-search="true">
                    <option style="display: none" selected id="project_id " value="{{ $assignment->project->id }}"> {{ $assignment->project->name }}</option>
                    @foreach ($currentProjects   as $project)
                        <option id="project_id" value="{{$project->id}}">{{ $project->name }}</option>
                    @endforeach
                    @foreach ($availableProjects as $project)
                        <option id="project_id" value="{{$project->id}}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>

    </div>
    {{  Form::close() }}

@endsection