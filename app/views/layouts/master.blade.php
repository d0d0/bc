<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>BC</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{HTML::style('css/bootstrap.min.css')}}
        {{HTML::style('css/bootstrap-minimit.min.css')}}
        {{HTML::script('js/jquery.min.js')}}
        {{HTML::script('js/bootstrap.min.js')}}
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
                <div class="row" style="margin-bottom: 10px; margin-top: 10px">
                    <div class="col-md-12">
                        <ul class="nav nav-pills nav-justified text-center">
                            <li role="presentation">{{ HTML::linkAction('LoginController@getLogout', '.Odhlásenie') }}</li>
                        </ul>
                    </div>
                </div>
                @yield('top_row')
            @endif
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
    </body>
</html>
