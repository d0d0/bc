<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>BC</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{ HTML::style('css/bootstrap.min.css') }}
        {{ HTML::style('css/bootstrap-minimit.min.css') }}
        {{ HTML::script('js/jquery.min.js') }}
        {{ HTML::script('js/bootstrap.min.js') }}
        @yield('js')
        <style>
            @yield('style')
        </style>
        <script>
            $(document).ready(function () {
                @yield('ready_js')
            });
        </script>
    </head>
    <body>
        <div class="container-fluid">
            @if(Auth::check())
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        {{ HTML::linkAction('HomeController@showWelcome', '.Home', array(), array('class' => 'navbar-brand')) }}
                    </div>
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                @if(Auth::user()->lastSubject)
                                    {{{ Auth::user()->lastSubject->name }}}
                                @else
                                .Aktualny predmet
                                @endif
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                @forelse(Auth::user()->subjects()->withoutselected()->get() as $subject)
                                    <li><a href="#">
                                        {{ HTML::linkAction('UserController@setSelectedSubject', $subject->name, array('id' => $subject->id)) }}
                                    </li>
                                @empty
                                    <li><a href="#">.Žiadny predmet</a></li>
                                @endforelse
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>{{ HTML::linkAction('UserController@show', Auth::user()->getFullName()) }}</li>
                        <li>{{ HTML::linkAction('LoginController@getLogout', '.Odhlásenie') }}</li>
                    </ul>
                </div>
            </nav>
            @yield('top_row')
            @endif
            @if(Auth::check())
            <div class="row">
                <div class="col-md-2">
                    <ul class="nav nav-pills nav-stacked" style="text-align: center">
                        <li>{{ HTML::linkAction('SolutionController@show', '.Editor', array()) }}</li>
                        <li>{{ HTML::linkAction('SubjectController@create', '.Vytvor predmet', array()) }}</li>
                        <li>{{ HTML::linkAction('TaskController@create', '.Vytvor zadanie', array()) }}</li>
                        <li>{{ HTML::linkAction('TaskController@all', '.Všetky zadania', array()) }}</li>
                    </ul>
                    <p class="lead"></p>
                    <div class="thumbnail">

                    </div>
                </div>
                <div class="col-md-10">
                    @if(Session::has('error'))
                    <div class="alert alert-danger" role="alert">{{Session::get('error')}}</div>
                    @endif
                    @if(Session::has('warning'))
                    <div class="alert alert-warning" role="alert">{{Session::get('warning')}}</div>
                    @endif
                    @if(Session::has('message'))
                    <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
                    @endif
                    @yield('content')
                </div>
            </div>
            @else
            @yield('content')
            @endif
        </div>
        @yield('last')
    </body>
</html>
