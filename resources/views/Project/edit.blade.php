@extends('layouts.app')
<head>

</head>
@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Modifica progetto</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('projects.index') }}"> Back</a>
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

    {{Form::model($project, ['method' => 'PATCH','route' => ['projects.update', $project->id], 'onsubmit' => 'return ConfirmDelete()']) }}
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nome:</strong>
                {{ Form::text('name', null, array('placeholder' => 'Nome','class' => 'form-control')) }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Docente:</strong>
                <br>
                <select name="user_id" class="selectpicker form-control" data-live-search="true">
                    <option style="display: none" selected id="user_id"
                            value="{{$project->user->id}}">{{ $project->user->name . ' ' . $project->user->surname}}</option>
                    @foreach ($users as $user)
                        <option id="user_id" value="{{$user->id}}">{{ $user->name . ' ' . $user->surname}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Numero:</strong>
                {{ Form::number('number', null, array('placeholder' => 'Numero','class' => 'form-control')) }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Ambito:</strong>
                <br>
                <select name="ambit_id" class="selectpicker form-control" data-live-search="true">
                    <option style="display: none" selected id="ambit_id"
                            value="{{$project->ambit->id}}">{{ $project->ambit->ambit }}</option>
                    @foreach ($ambits as $ambit)
                        <option id="ambit_id" value="{{$ambit->id}}">{{ $ambit->ambit }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Data di inizio:</strong>
                {{ Form::date('start_date', null, array('placeholder' => 'Data di inizio','class' => 'form-control')) }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Data di fine:</strong>
                {{ Form::date('end_date', null, array('placeholder' => 'Data di fine','class' => 'form-control')) }}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Numero massimo di partecipanti:</strong>
                {{ Form::number('max_participants', null, array('placeholder' => 'Numero massimo di partecipanti','class' => 'form-control')) }}
            </div>
        </div>


        @if(Auth::user()->type_id == \App\Type::where('type', 'Admin')->first()->id)
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Stato:</strong>
                    <br>
                    <select name="state_id" class="selectpicker form-control" data-live-search="true">
                        <option style="display: none" selected id="state_id"
                                value="{{$project->projectstate->id}}">{{ $project->projectstate->state }}</option>
                        @foreach ($projectstates as $state)
                            <option id="type_id" value="{{$state->id}}">{{ $state->state }}</option>
                        @endforeach
                        @foreach ($adminStates as $state)

                            <option id="type_id" value="{{$state->id}}">{{ $state->state }}</option>

                        @endforeach
                    </select>
                    <h5>(Se si modifica lo stato del progetto da "Concluso" ad un altro stato, tutte le note legate a
                        quel
                        progetto saranno cancellate!)</h5>
                </div>

            </div>
        @endif


        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {{  Form::close() }}


@endsection