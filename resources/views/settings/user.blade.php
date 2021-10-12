@extends('layouts.master')

@section('title','Editar Informações')

@push('scripts')
<script>
  $("#avatarform").submit(function() {
    var formData = new FormData(this);

    $.ajax({
      url: "/settings/user",
      type: "POST",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function(response) {
        $(".btn-avatar").html(`Upload`);
        if (response.success) {
          $("#avatarform")[0].reset();
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
        $(".btn-avatar").html(`Upload`);
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
      },
      xhr: function() { // Custom XMLHttpRequest
        var myXhr = $.ajaxSettings.xhr();
        if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
          myXhr.upload.addEventListener('progress', function() {

            $(".btn-avatar").html(`Upload <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`);
          }, false);
        }
        return myXhr;
      }
    });
  });

  $(".btn-social").click(function(event) {
    event.preventDefault();

    let about = $("textarea[name=registersocial_about]").val();
    let facebook = $("input[name=registersocial_facebook]").val();
    let instagram = $("input[name=registersocial_instagram]").val();
    let twitch = $("input[name=registersocial_twitch]").val();
    let twitter = $("input[name=registersocial_twitter]").val();
    let _token = $('meta[name="csrf-token"]').attr('content');

    console.log(facebook);
    console.log(instagram);
    console.log(twitch);
    console.log(twitter);


    $.ajax({
      url: "/settings/user/social",
      type: "PUT",
      data: {
        about: about,
        facebook: facebook,
        instagram: instagram,
        twitch: twitch,
        twitter: twitter,
        _token: _token
      },
      success: function(response) {
        if (response.success) {
          $("#socialform")[0].reset();
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
        } else {
          new BsToast({
            title: 'Ocorreu um erro',
            content: 'Ocorreu um erro ao atualizar as redes sociais.',
            type: 'danger',
            pause_on_hover: true,
            delay: 5000,
            position: 'top-right'
          });
        }
      }
    });
  });

  $(".btn-password").click(function(event) {
    event.preventDefault();

    let password = $("input[name=registerpassword]").val();
    let password_current = $("input[name=registerpassword_current]").val();
    let password_confirmation = $("input[name=registerpassword_confirmation]").val();
    let _token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
      url: "/settings/user/senha",
      type: "PUT",
      data: {
        current: password_current,
        password: password,
        password_confirmation: password_confirmation,
        _token: _token
      },
      success: function(response) {
        if (response.success) {
          $("#passwordform")[0].reset();
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
        } else {
          new BsToast({
            title: 'Ocorreu um erro',
            content: 'Ocorreu um erro ao atualizar a senha.',
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
@endpush

@section('content')
<div class="container">
  <div class="row">
    <div class="col-12">
      <h1>Editar Informações</h1>
    </div>
  </div>
  <div class="p-2 p-sm-5 mb-4 jumbotron rounded-3">
    <div class="row">
      <div class="col-12 col-sm-4">
        <div class="row">
          <div style="display: inline-block;">
            @if($user->isBlocked())
            <img src="{{ URL::asset('image/default-user-image.png') }}" class="card-img-top col-lg-12 rounded-pill">
            @else
            <img src="{{$user->avatar}}" alt="{{ URL::asset('image/default-user-image.png') }}" class="img-fluid rounded mx-auto">
            @endif
          </div>
          <div class="card-body mb-4 pb-0 col-lg-12">
            <form id="avatarform" method="POST" enctype="multipart/form-data" onsubmit="return false;">
              <div class="input-group">
                @csrf
                <input class="form-control" id="avatar" name="avatar" type="file" placeholder="Selecionar Arquivo">
                <button class="btn btn-primary btn-avatar" type="submit">Upload</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-8">
        <div class="card-body mb-4 pb-0 col-lg-12">
          <div class="mb-3">
            <label for="name">Nome</label>
            <input type="text" class="form-control" id="name" name="name" disabled value="{{$user->name}}">
          </div>

          <div class="mb-3">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" disabled value="{{$user->email}}">
          </div>

          <form id="socialform" class="mb-3">
            <div class="mb-3">
              <h3>Social</h3>
            </div>

            <div class="mb-3">
              <label for="email">Sobre Mim</label>
              <textarea type="text" class="form-control" id="registersocial_about" name="registersocial_about">{{$user->about}}</textarea>
            </div>

            <div class="input-group mb-3">
              <span class="input-group-text">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                  <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                </svg>
              </span>
              <span class="input-group-text d-none d-md-block">https://twitter.com/</span>
              <input type="text" class="form-control" id="registersocial_twitter" name="registersocial_twitter" value="{{$user->twitter}}">
            </div>

            <div class="input-group mb-3">
              <span class="input-group-text">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitch" viewBox="0 0 16 16">
                  <path d="M3.857 0 1 2.857v10.286h3.429V16l2.857-2.857H9.57L14.714 8V0H3.857zm9.714 7.429-2.285 2.285H9l-2 2v-2H4.429V1.143h9.142v6.286z" />
                  <path d="M11.857 3.143h-1.143V6.57h1.143V3.143zm-3.143 0H7.571V6.57h1.143V3.143z" />
                </svg>
              </span>
              <span class="input-group-text d-none d-md-block">https://www.twitch.tv/</span>
              <input type="text" class="form-control" id="registersocial_twitch" name="registersocial_twitch" value="{{$user->twitch}}">
            </div>

            <div class="input-group mb-3">
              <span class="input-group-text">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                  <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                </svg>
              </span>
              <span class="input-group-text d-none d-md-block">https://www.instagram.com/</span>
              <input type="text" class="form-control" id="registersocial_instagram" name="registersocial_instagram" value="{{$user->instagram}}">
            </div>

            <div class="input-group mb-3">
              <span class="input-group-text">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                  <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                </svg>
              </span>
              <span class="input-group-text d-none d-md-block">https://www.facebook.com/</span>
              <input type="text" class="form-control" id="registersocial_facebook" name="registersocial_facebook" value="{{$user->facebook}}">
            </div>

            <div class="form-group">
              <button style="cursor:pointer" class="btn btn-primary btn-social">Alterar Redes Sociais</button>
            </div>
          </form>

          <form id="passwordform" class="needs-validation">
            <div class="mb-3">
              <h3>Alterar Senha</h3>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="registerpassword_current">Senha Atual</label>
                <input type="password" class="form-control" id="registerpassword_current" name="registerpassword_current" required>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="registerpassword">Nova Senha</label>
                <input type="password" class="form-control" id="registerpassword" name="registerpassword" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="registerpassword_confirmation">Digite novamente a senha</label>
                <input type="password" class="form-control" id="registerpassword_confirmation" name="registerpassword_confirmation" required>
              </div>
            </div>

            <div class="form-group">
              <button style="cursor:pointer" class="btn btn-primary btn-password">Alterar Senha</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
