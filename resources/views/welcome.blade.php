<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>GamingScore</title>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>


  <script src="{{ asset('js/toast5.js') }}"></script>


  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

  <!-- Styles -->
  <!-- Bootstrap core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link href="{{ URL::asset('css/welcome.css') }}" rel="stylesheet">




  <link href="{{ URL::asset('css/toast.css') }}" rel="stylesheet">

  {{--Favicon--}}
  <link rel="shortcut icon" href="{{ URL::asset('image/favicon.ico') }}" type="image/x-icon" />
</head>

<body>
  @include('layouts.partials.flash')
  <header>
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
      <ol class="carousel-indicators">
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="carousel-item active" style="background-image: url('{{ URL::asset('image/bkg-0.png') }}')"></div>
        <div class="carousel-item" style="background-image: url('{{ URL::asset('image/bkg-1.png') }}')"></div>
        <div class="carousel-item" style="background-image: url('{{ URL::asset('image/bkg-2.png') }}')"></div>
        <div class="carousel-item" style="background-image: url('{{ URL::asset('image/bkg-3.png') }}')"></div>
      </div>
    </div>
  </header>

  <div class="w-100 h-100" style="position: absolute; top: 0; background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5));">
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
      <header class="masthead mb-auto">
        <div class="inner">
          <a href="/games">
            <h3 class="masthead-brand">
              <svg  width="40" height="32" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-controller" viewBox="0 0 16 16">
                <path d="M11.5 6.027a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1zm2.5-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1zm-6.5-3h1v1h1v1h-1v1h-1v-1h-1v-1h1v-1z" />
                <path d="M3.051 3.26a.5.5 0 0 1 .354-.613l1.932-.518a.5.5 0 0 1 .62.39c.655-.079 1.35-.117 2.043-.117.72 0 1.443.041 2.12.126a.5.5 0 0 1 .622-.399l1.932.518a.5.5 0 0 1 .306.729c.14.09.266.19.373.297.408.408.78 1.05 1.095 1.772.32.733.599 1.591.805 2.466.206.875.34 1.78.364 2.606.024.816-.059 1.602-.328 2.21a1.42 1.42 0 0 1-1.445.83c-.636-.067-1.115-.394-1.513-.773-.245-.232-.496-.526-.739-.808-.126-.148-.25-.292-.368-.423-.728-.804-1.597-1.527-3.224-1.527-1.627 0-2.496.723-3.224 1.527-.119.131-.242.275-.368.423-.243.282-.494.575-.739.808-.398.38-.877.706-1.513.773a1.42 1.42 0 0 1-1.445-.83c-.27-.608-.352-1.395-.329-2.21.024-.826.16-1.73.365-2.606.206-.875.486-1.733.805-2.466.315-.722.687-1.364 1.094-1.772a2.34 2.34 0 0 1 .433-.335.504.504 0 0 1-.028-.079zm2.036.412c-.877.185-1.469.443-1.733.708-.276.276-.587.783-.885 1.465a13.748 13.748 0 0 0-.748 2.295 12.351 12.351 0 0 0-.339 2.406c-.022.755.062 1.368.243 1.776a.42.42 0 0 0 .426.24c.327-.034.61-.199.929-.502.212-.202.4-.423.615-.674.133-.156.276-.323.44-.504C4.861 9.969 5.978 9.027 8 9.027s3.139.942 3.965 1.855c.164.181.307.348.44.504.214.251.403.472.615.674.318.303.601.468.929.503a.42.42 0 0 0 .426-.241c.18-.408.265-1.02.243-1.776a12.354 12.354 0 0 0-.339-2.406 13.753 13.753 0 0 0-.748-2.295c-.298-.682-.61-1.19-.885-1.465-.264-.265-.856-.523-1.733-.708-.85-.179-1.877-.27-2.913-.27-1.036 0-2.063.091-2.913.27z" />
              </svg>
              GamingScore
            </h3>
          </a>
          <nav class="nav nav-masthead justify-content-center">
            <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
            <a class="nav-link" id="login-tab" data-bs-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="false">Entrar</a>
            <a class="nav-link" id="register-tab" data-bs-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Cadastrar</a>
            <a class="nav-link" id="home-tab" href="/games">Jogos</a>
          </nav>
        </div>
      </header>

      <main role="main" class="text-center inner cover">

        <div class="tab-content">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <h1 class="cover-heading">GamingScore</h1>
            <p class="lead">Levando em consideração todo o cenário virtual nos dias atuais, temos que escolher uma solução adequada e facilitadora para a escolha do seu futuro jogo.</p>
            <p class="lead">
              <a href="https://github.com/richardmcr/tads_projeto_1#readme" class="btn btn-lg btn-secondary">Saiba mais</a>
            </p>
          </div>

          <div class="tab-pane fade" id="login" role="tabpanel" aria-labelledby="login-tab">
            <form id="loginform" class="needs-validation">
              <div class="mb-3">
                <label for="loginemail">Email</label>
                <input type="email" class="form-control" id="loginemail" name="loginemail" required autofocus>
              </div>

              <div class="mb-3">
                <label for="loginpassword">Senha</label>
                <input type="password" class="form-control" id="loginpassword" name="loginpassword" required>
              </div>

              <div class="form-group">
                <button style="cursor:pointer" class="btn btn-primary btn-login">Entrar</button>
              </div>
            </form>
              <a class="btn btn-primary btn-logintext-black shadow m-1" href="{{ route('social.login',['provider'=>'github']) }}"><span class="fa fa-github"></span>
                  Login Github
              </a>
              <a class="btn btn-primary btn-loginfacebook btn-social btn-facebook text-black shadow m-1" href="{{ route('social.login',['provider'=>'facebook']) }}"><span class="fa fa-facebook"></span>
                  Login Facebook
              </a>
              <a class="btn btn-primary btn-login google btn-social btn-google text-black shadow m-1" href="{{ route('social.login',['provider'=>'google']) }}"><span class="fa fa-google"></span>
                  Login Google
              </a>
          </div>

          <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
            <form id="registerform" class="needs-validation">
              <div class="mb-3">
                <label for="registername">Nome</label>
                <input type="text" class="form-control" id="registername" name="registername" required>
              </div>

              <div class="mb-3">
                <label for="registeremail">Email</label>
                <input type="email" class="form-control" id="registeremail" name="registeremail" required>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="registerpassword">Senha</label>
                  <input type="password" class="form-control" id="registerpassword" name="registerpassword" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="registerpassword_confirmation">Digite novamente a senha</label>
                  <input type="password" class="form-control" id="registerpassword_confirmation" name="registerpassword_confirmation" required>
                </div>
              </div>

              <div class="form-group">
                <button style="cursor:pointer" class="btn btn-primary btn-register">Cadastrar</button>
              </div>
            </form>
          </div>
        </div>


      </main>

      <footer class="text-center mastfoot mt-auto">
        <div class="inner">
          <p>Projeto Prático de Programação, 2021</a>.</p>
        </div>
      </footer>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      if (location.hash) {
        let selectedTab = window.location.hash;
        let link = $('a[href="' + selectedTab + '"][data-bs-toggle="tab"]');
        // link.trigger('click');
        link[0].click();
      }
    });

    $("*").focus(function(event) {
      $(this).removeClass('is-invalid');
    });

    $(".btn-login").click(function(event) {
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
        success: function(response) {
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
        error: function(reject) {
          var errors = $.parseJSON(reject.responseText);
          if (reject.status === 422) {

            $.each(errors.errors, function(key, val) {
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

    $(".btn-register").click(function(event) {
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
        success: function(response) {
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
        error: function(reject) {
          var errors = $.parseJSON(reject.responseText);
          if (reject.status === 422) {

            $.each(errors.errors, function(key, val) {
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
