<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Progetti SAMT</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">


                <!-- Collapsed Hamburger -->

                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Progetti SAMT
                </a>


            </div>


            <div class="collapse navbar-collapse" id="app-navbar-collapse">

                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Registrati</a></li>
                    @else
                        <li class="dropdown">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('/logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
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
                        <td><a href="/projectstates">Stati dei progetti</a></td>
                    </tr>
                    <tr>
                        <td><a href="/filetypes">Tipi di file</a></td>
                        <td><a href="/freeprojects">Progetti liberi</a></td>
                        <td><a href="/ambits">Ambiti progetto</a></td>

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
    </nav>


    <div class="container">

        @yield('content')
    </div>

</div>

<!-- Scripts -->
<script src="/js/app.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="/css/bootstrap-select.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="/js/bootstrap-select.min.js"></script>
</body>
</html>
