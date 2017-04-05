@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Lista utenti</h2>
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
                <th>Email</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Tipo</th>
                <th>Cellulare</th>
                <th>Data di nascita</th>
                <th>Verificato(mail)</th>
                <th></th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->surname}}</td>
                    <td>{{ $user->type->type}}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->birthday }}</td>
                    <td>{{ $user->verified ? 'Si' : 'No' }}</td>
                    <td>
                    <!--a class="btn btn-info" href="{{-- route('userCRUD.show',$user->id) --}}">Show</a-->
                        <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Modifica</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    {{-- $users->render() --}}

@endsection