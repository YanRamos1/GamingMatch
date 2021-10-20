@extends('layouts.master')

@section('title', 'Configurações')

@section('content')
<div class="container py-3">
  <div class="row">
    <div class="col-lg-4">
      <h2 style="color: #f3821c;">Plataformas</h2>
      <p style="color: #f3821c;">Atualiza a base de dados com plataformas.</p>
      <button style="cursor:pointer" class="btn btn-secondary btn-plataformas">
        Sincronizar &raquo;
      </button>
    </div><!-- /.col-lg-4 -->

    <div class="col-lg-4">
      <h2 style="color: #f3821c;">Gêneros</h2>
      <p style="color: #f3821c;">Atualiza a base de dados com gêneros de jogos.</p>
      <button style="cursor:pointer" class="btn btn-secondary btn-generos">
        Sincronizar &raquo;
      </button>
    </div><!-- /.col-lg-4 -->

    <div class="col-lg-4">
      <h2 style="color: #f3821c;">Jogos</h2>
      <p style="color: #f3821c;">Atualiza a base de dados com jogos. É necessário ter sincronizado Plataformas e Gêneros antes.</p>
      <button style="cursor:pointer" class="btn btn-secondary btn-jogos">
        Sincronizar &raquo;
      </button>
    </div><!-- /.col-lg-4 -->
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(".btn-plataformas").click(function(event) {
    event.preventDefault();

    $(".btn-plataformas").prop("disabled", true);
    $(".btn-plataformas").html(`Sincronizar <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`);

    $.ajax({
      url: "/admin/settings/plataforma",
      type: "POST",
      data: {
        "_token": "{{ csrf_token() }}"
      },
      success: function(response) {
        $(".btn-plataformas").prop("disabled", false);
        $(".btn-plataformas").html(
          `Sincronizar &raquo`
        );
        if (response.success) {
          new BsToast({
            title: 'Sincornizar',
            content: response.success,
            type: 'success',
            pause_on_hover: true,
            delay: 5000,
            position: 'top-right',
            icon: '<i class="fas fa-home"></i>'
          });
        } else if (response.error) {
          new BsToast({
            title: 'Ocorreu um erro',
            content: response.error,
            type: 'danger',
            pause_on_hover: true,
            delay: 5000,
            position: 'top-right',
            icon: '<i class="fas fa-home"></i>'
          });
        }
      },
      error: function(reject) {
        $(".btn-plataformas").prop("disabled", false);
        $(".btn-plataformas").html(
          `Sincronizar &raquo`
        );
        var errors = $.parseJSON(reject.responseText);
        if (errors.message) {
          new BsToast({
            title: 'Ocorreu um erro',
            content: errors.message,
            type: 'danger',
            pause_on_hover: true,
            delay: 5000,
            position: 'top-right',
            icon: '<i class="fas fa-home"></i>'
          });
        }
      }
    });
  });

  $(".btn-generos").click(function(event) {
    event.preventDefault();

    $(".btn-generos").prop("disabled", true);
    $(".btn-generos").html(`Sincronizar <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`);

    $.ajax({
      url: "/admin/settings/genero",
      type: "POST",
      data: {
        "_token": "{{ csrf_token() }}"
      },
      success: function(response) {
        $(".btn-generos").prop("disabled", false);
        $(".btn-generos").html(
          `Sincronizar &raquo`
        );
        if (response.success) {
          new BsToast({
            title: 'Sincornizar',
            content: response.success,
            type: 'success',
            pause_on_hover: true,
            delay: 5000,
            position: 'top-right',
            icon: '<i class="fas fa-home"></i>'
          });
        } else if (response.error) {
          new BsToast({
            title: 'Ocorreu um erro',
            content: response.error,
            type: 'danger',
            pause_on_hover: true,
            delay: 5000,
            position: 'top-right',
            icon: '<i class="fas fa-home"></i>'
          });
        }
      },
      error: function(reject) {
        $(".btn-generos").prop("disabled", false);
        $(".btn-generos").html(
          `Sincronizar &raquo`
        );
        var errors = $.parseJSON(reject.responseText);
        if (errors.message) {
          new BsToast({
            title: 'Ocorreu um erro',
            content: errors.message,
            type: 'danger',
            pause_on_hover: true,
            delay: 5000,
            position: 'top-right',
            icon: '<i class="fas fa-home"></i>'
          });
        }
      }
    });
  });

  $(".btn-jogos").click(function(event) {
    event.preventDefault();

    $(".btn-jogos").prop("disabled", true);
    $(".btn-jogos").html(`Sincronizar <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`);

    $.ajax({
      url: "/admin/settings/jogo",
      type: "POST",
      data: {
        "_token": "{{ csrf_token() }}"
      },
      success: function(response) {
        $(".btn-jogos").prop("disabled", false);
        $(".btn-jogos").html(
          `Sincronizar &raquo`
        );
        if (response.success) {
          new BsToast({
            title: 'Sincornizar',
            content: response.success,
            type: 'success',
            pause_on_hover: true,
            delay: 5000,
            position: 'top-right',
            icon: '<i class="fas fa-home"></i>'
          });
        } else if (response.error) {
          new BsToast({
            title: 'Ocorreu um erro',
            content: response.error,
            type: 'danger',
            pause_on_hover: true,
            delay: 5000,
            position: 'top-right',
            icon: '<i class="fas fa-home"></i>'
          });
        }
      },
      error: function(reject) {
        $(".btn-jogos").prop("disabled", false);
        $(".btn-jogos").html(
          `Sincronizar &raquo`
        );
        var errors = $.parseJSON(reject.responseText);
        if (errors.message) {
          new BsToast({
            title: 'Ocorreu um erro',
            content: errors.message,
            type: 'danger',
            pause_on_hover: true,
            delay: 5000,
            position: 'top-right',
            icon: '<i class="fas fa-home"></i>'
          });
        }
      }
    });
  });
</script>
@endpush