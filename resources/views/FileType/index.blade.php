@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Lista tipi di utente</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('filetypes.create') }}"> Crea tipo</a>
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
                <th>Tipo</th>
                <th></th>
                <th></th>
            </tr>
            @foreach ($types as $type)
                <tr>
                    <td style="display:none;">{{ $type->id  }}</td>
                    <td>{{ $type->type}}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('filetypes.edit',$type->id) }}">Modifica</a>
                    </td>
                    <td>
                        {!! Form::open(['method' => 'DELETE','route' => ['filetypes.destroy', $type->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    {{-- $users->render() --}}

@endsection