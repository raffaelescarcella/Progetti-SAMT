<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Progetti SAMT</title>


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        a {
            color: #636b6f;
            text-decoration: inherit;
        }

        .table.no-border tr td, .table.no-border tr th {
            border-width: 0;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @if (Auth::check())
                {{ Auth::user()->name . ' ' . Auth::user()->surname }}
                <a href="{{ url('/logout') }}"
                   onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            @else
                <a href="{{ url('/login') }}">Login</a>
                <a href="{{ url('/register') }}">Registrati</a>
            @endif
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
            Gestione Progetti SAMT
        </div>


        <table class="table table-responsive no-border">
            <tbody>
            <tr>
                <td><a href="/finishedprojects">Storico progetti</a></td>
                <td><a href="/currentprojects">Progetti in corso</a></td>
                @if(Auth::check() && Auth::user()->type_id == \App\Type::where('type','Admin')->first()->id)
                    <td><a href="/users">Utenti</a></td>
                    <td><a href="/projects">Progetti</a></td>
            </tr>
            <tr>
                <td><a href="/types">Tipi di utente</a></td>
                <td><a href="/assignments">Assegnazioni</a></td>
                <td><a href="/assignmentshistory">Storico assegnazioni</a></td>
                <td><a href="/userstates">Stati di utente</a></td>
            </tr>
            <tr>
                <td><a href="/freeprojects">Progetti liberi</a></td>
                <td><a href="/ambits">Ambiti progetto</a></td>
                <td><a href="/projectstates">Stati dei progetti</a></td>
            </tr>
            <tr>
            @elseif(Auth::check() && Auth::user()->type_id == \App\Type::where('type','Docente')->first()->id)
                    <td><a href="/freeprojects">Progetti liberi</a></td>
                    <td><a href="/assignments">Assegnazioni</a></td>
            </tr>
            <tr>
                    <td></td>
                    <td><a href="/assignmentshistory">Storico assegnazioni</a></td>
                    <td><a href="/projects">Progetti</a></td>
            @elseif(Auth::check() && Auth::user()->type_id == \App\Type::where('type','Allievo')->first()->id)
                    <td><a href="/freeprojects">Progetti liberi</a></td>
            @else
            @endif
            </tr>


            </tbody>
        </table>


    </div>
</div>
</body>
</html>
