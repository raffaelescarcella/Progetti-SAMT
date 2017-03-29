@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Lista ambiti progetto</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('ambits.create') }}"> Crea ambito</a>
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
            <th>Ambito</th>
            <th></th>
            <th></th>
        </tr>
        @foreach ($ambits as $ambit)
            <tr>
                <td style="display:none;">{{ $ambit->id  }}</td>
                <td>{{ $ambit->ambit}}</td>
                <td>
                    <a class="btn btn-primary" href="{{ route('ambits.edit',$ambit->id) }}">Modifica</a>
                </td>
                <td>
                    {!! Form::open(['method' => 'DELETE','route' => ['ambits.destroy', $ambit->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </table>

    {{-- $users->render() --}}

@endsection