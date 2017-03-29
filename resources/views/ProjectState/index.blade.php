@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Lista stati progetto</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('projectstates.create') }}"> Crea stato</a>
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
                <th>Stato</th>
                <th></th>
                <th></th>
            </tr>
            @foreach ($projectstates as $state)
                <tr>
                    <td style="display:none;">{{ $state->id  }}</td>
                    <td>{{ $state->state}}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('projectstates.edit',$state->id) }}">Modifica</a>
                    </td>
                    <td>
                        {!! Form::open(['method' => 'DELETE','route' => ['projectstates.destroy', $state->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    {{-- $users->render() --}}

@endsection