@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Aggiungi file a {{$project->name . ' di '. $user->name .' '. $user->surname}}</h2>
                {{--  --}}
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('currentprojects.index').'/'.$assignment }}"> Back</a>
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


    {!! Form::open(array(
    'url'=>'currentprojects/upload',
    'method'=>'POST',
    'files'=>true)) !!}


    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>File</strong>
                {!! Form::file('file', null,array('class' => 'form-control')) !!}
                {!! Form::hidden('id', $assignment) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Tipo:</strong>
                @php($filetypes = \App\FileType::all())
                <select name="file_type_id" class="selectpicker form-control" data-live-search="true">
                    <option hidden selected id="file_type_id" value=""></option>
                    @foreach ($filetypes as $type)
                        <option id="file_type_id" value="{{$type->id}}">{{ $type->type }}</option>
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