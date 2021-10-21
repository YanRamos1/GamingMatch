<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GameMatch</title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>


    <script src="{{ asset('js/toast5.js') }}"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link href="{{ URL::asset('css/welcome.css') }}" rel="stylesheet">


    <link href="{{ URL::asset('css/toast.css') }}" rel="stylesheet">

    {{--Favicon--}}
    <link rel="shortcut icon" href="{{ URL::asset('image/favicon.ico') }}" type="image/x-icon"/>
</head>

<body>
@include('layouts.partials.flash')
<header>
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators" style="display: none">
            <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
            <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
            <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
            <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active" style="background-image: url('{{ URL::asset('image/bkg-0.jpg') }}')">
            </div>
            <div class="carousel-item" style="background-image: url('{{ URL::asset('image/bkg-1.png') }}')"></div>
            <div class="carousel-item" style="background-image: url('{{ URL::asset('image/bkg-2.jpg') }}')"></div>
            <div class="carousel-item" style="background-image: url('{{ URL::asset('image/bkg-3.png') }}')"></div>
        </div>
    </div>
</header>

<div class="w-100 h-100"
     style="position: absolute; top: 0; background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)); height: 100vh; width: 100vh;">
    <div class="cover d-flex w-100 h-100 p-3 mx-auto flex-column">
        <header class="masthead">
            <div class="inner">
                <a href="/" style="text-decoration:none !important;">
                    <h3 class="masthead-brand logo-inicio">
                        <img src="{{ URL::asset('image/logogif.gif') }}" width="56" height="56">
                        <span
                            style="position:relative; font-size:28px; top:5px; text-decoration:none !important;">GAME
                                MATCH</span>
                    </h3>
                </a>
                <nav class="nav nav-masthead justify-content-center">
                    <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                       aria-controls="home" aria-selected="true">Home</a>
                    <a class="nav-link" id="login-tab" data-bs-toggle="tab" href="#login" role="tab"
                       aria-controls="login" aria-selected="false">Entrar</a>
                    <a class="nav-link" id="register-tab" data-bs-toggle="tab" href="#register" role="tab"
                       aria-controls="register" aria-selected="false">Cadastrar</a>
                    <a class="nav-link" id="home-tab" href="/games">Jogos</a>
                </nav>
            </div>
        </header>

        <main role="main" class="text-center inner cover container mx-auto mb-3" style="height:20rem">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <h1 class="cover-heading">GameMatch</h1>
                    <p class="lead">Facilitando seu entretenimento no mundo dos jogos!</p>
                    <p class="lead">
                        <a href="https://discord.com/" class="btn btn-lg btn-secondary">Saiba mais</a>
                    </p>
                </div>

                <div class="tab-pane fade texto-left" id="login" role="tabpanel" aria-labelledby="login-tab">
                    <form id="loginform" class="needs-validation">
                        <div class="mb-3">
                            <label for="loginemail" style="
                  display: flex;">Email</label>
                            <input type="email" class="form-control" id="loginemail" name="loginemail" required
                                   autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="loginpassword" style="
                    display: flex;">Senha</label>
                            <input type="password" class="form-control" id="loginpassword" name="loginpassword"
                                   required>
                        </div>

                        <div class="form-group">
                            <button style="cursor:pointer;background-color:#f3821c;"
                                    class="btn btn-login text-black shadow m-1">Entrar
                            </button>
                        </div>
                    </form>
                    <a class="btn text-black shadow m-1" style="background-color:#f3821c; cursor:pointer;"
                       href="{{ route('social.login',['provider'=>'github']) }}"><span class="fa fa-github"></span>
                        Login Github
                    </a>
                    <a class="btn text-black shadow m-1" style="background-color:#f3821c; cursor:pointer;"
                       href="{{ route('social.login',['provider'=>'facebook']) }}"><span
                            class="fa fa-facebook"></span>
                        Login Facebook
                    </a>
                    <a class="btn text-black shadow m-1" style="background-color:#f3821c; cursor:pointer;"
                       href="{{ route('social.login',['provider'=>'google']) }}"><span class="fa fa-google"></span>
                        Login Google
                    </a>
                </div>

                <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                    <form id="registerform" class="needs-validation">
                        <div class="mb-3">
                            <label for="registername" style="
                        display: flex;">Nome</label>
                            <input type="text" class="form-control" id="registername" name="registername" required>
                        </div>

                        <div class="mb-3">
                            <label for="registeremail" style="
                  display: flex;">Email</label>
                            <input type="email" class="form-control" id="registeremail" name="registeremail"
                                   required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="registerpassword" style="
                      display: flex;">Senha</label>
                                <input type="password" class="form-control" id="registerpassword"
                                       name="registerpassword" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="registerpassword_confirmation">Digite novamente a senha</label>
                                <input type="password" class="form-control" id="registerpassword_confirmation"
                                       name="registerpassword_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <button style="cursor:pointer" class="btn btn-primary btn-register">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <div class="container ">
            <div class="row">
                @foreach($games as $game)
                    <div class="col">
                        <div style="border: 1px solid #f3821c;" class="shadow-sm">
                            <a href="/games/{{$game->id}}" style="text-decoration: none;">
                                <img src='{{ $game->image }}' class="rounded img-fluid shadow-lg" alt=""/>

                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <footer class="text-center mastfoot mt-auto transparent">
            <div class="inner">
            </div>
        </footer>
    </div>
</div>

<script>
    $(document).ready(function () {
        if (location.hash) {
            let selectedTab = window.location.hash;
            let link = $('a[href="' + selectedTab + '"][data-bs-toggle="tab"]');
            // link.trigger('click');
            link[0].click();
        }
    });

    $("*").focus(function (event) {
        $(this).removeClass('is-invalid');
    });

    $(".btn-login").click(function (event) {
        event.preventDefault();

        let email = $("input[name=loginemail]").val();
        let password = $("input[name=loginpassword]").val();
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "/login",
            type: "POST",
            data: {
                email: email,
                password: password,
                _token: _token
            },
            success: function (response) {
                if (response.success) {
                    $("#loginform")[0].reset();
                    window.location.href = "games";
                } else if (response.error) {
                    new BsToast({
                        title: 'Ocorreu um erro',
                        content: response.error,
                        type: 'danger',
                        pause_on_hover: true,
                        delay: 5000,
                        position: 'top-right'
                    });
                }
            },
            error: function (reject) {
                var errors = $.parseJSON(reject.responseText);
                if (reject.status === 422) {

                    $.each(errors.errors, function (key, val) {
                        $("#login" + key).addClass('is-invalid');
                        new BsToast({
                            title: 'Ocorreu um erro',
                            content: val,
                            type: 'danger',
                            pause_on_hover: true,
                            delay: 5000,
                            position: 'top-right'
                        });
                    });
                } else if (errors.message) {
                    new BsToast({
                        title: 'Ocorreu um erro',
                        content: errors.message,
                        type: 'danger',
                        pause_on_hover: true,
                        delay: 5000,
                        position: 'top-right'
                    });
                }
            }
        });
    });

    $(".btn-register").click(function (event) {
        event.preventDefault();

        let name = $("input[name=registername]").val();
        let email = $("input[name=registeremail]").val();
        let password = $("input[name=registerpassword]").val();
        let password_confirmation = $("input[name=registerpassword_confirmation]").val();
        let _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "/register",
            type: "POST",
            data: {
                name: name,
                email: email,
                password: password,
                password_confirmation: password_confirmation,
                _token: _token
            },
            success: function (response) {
                if (response.success) {
                    $("#registerform")[0].reset();
                    window.location.href = "/settings/user";
                } else if (response.error) {
                    new BsToast({
                        title: 'Ocorreu um erro',
                        content: response.error,
                        type: 'danger',
                        pause_on_hover: true,
                        delay: 5000,
                        position: 'top-right'
                    });
                }
            },
            error: function (reject) {
                var errors = $.parseJSON(reject.responseText);
                if (reject.status === 422) {

                    $.each(errors.errors, function (key, val) {
                        $("#register" + key).addClass('is-invalid');
                        new BsToast({
                            title: 'Ocorreu um erro',
                            content: val,
                            type: 'danger',
                            pause_on_hover: true,
                            delay: 5000,
                            position: 'top-right'
                        });
                    });
                } else if (errors.message) {
                    new BsToast({
                        title: 'Ocorreu um erro',
                        content: errors.message,
                        type: 'danger',
                        pause_on_hover: true,
                        delay: 5000,
                        position: 'top-right'
                    });
                }
            }
        });
    });
</script>
</body>

</html>
