@extends('layouts.master')

@section('title', $game->name)

@push('scripts')
<script>
  $("*").focus(function(event) {
    $(this).removeClass('is-invalid');
  });

  $(function() {
    $('.rating').barrating({
      theme: 'fontawesome-stars-o',
      initialRating: 0,
    });
  });

  $("*").focus(function(event) {
    $(this).removeClass('is-invalid');
  });

  $(".btn-wishlist").click(function(event) {
    event.preventDefault();

    let game = "{{$game->id}}";
    let _token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
      url: "/wishlist",
      type: "POST",
      data: {
        game: game,
        _token: _token,
      },
      success: function(response) {
        if (response.success) {
          $("#reviewform")[0].reset();
          window.location.href = "/games/{{$game->id}}";
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
            content: `Ocorreu um erro ao adicionar este jogo à lista de desejos`,
            type: 'danger',
            pause_on_hover: true,
            delay: 5000,
            position: 'top-right'
          });
        }
      }
    });
  });

  $(".btn-remover-wishlist").click(function(event) {
    event.preventDefault();

    let game = "{{$game->id}}";
    let _token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
      url: "/wishlist",
      type: "DELETE",
      data: {
        game: game,
        _token: _token,
      },
      success: function(response) {
        if (response.success) {
          window.location.href = "/games/{{$game->id}}";
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
            content: `Ocorreu um erro ao remover este jogo da lista de desejos`,
            type: 'danger',
            pause_on_hover: true,
            delay: 5000,
            position: 'top-right'
          });
        }
      }
    });
  });

  $(".btn-avaliar").click(function(event) {
    event.preventDefault();

    let avaliacao = $("select[name=rating_avaliacao]").val();
    let comentario = $("textarea[name=comentario]").val();
    let game = "{{$game->id}}";
    let _token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
      url: "/review",
      type: "POST",
      data: {
        avaliacao: avaliacao,
        comentario: comentario,
        game: game,
        _token: _token,
      },
      success: function(response) {
        if (response.success) {
          $("#reviewform")[0].reset();
          window.location.href = "/games/{{$game->id}}";
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
            content: `Ocorreu um erro ao avaliar o jogo.`,
            type: 'danger',
            pause_on_hover: true,
            delay: 5000,
            position: 'top-right'
          });
        }
      }
    });
  });

  $(".btn-remover-avaliacao").click(function(event) {
    event.preventDefault();
    if (confirm('Você realmente deseja remover essa avaliação?')) {
      var id = $(this).attr('id');

      $.ajax({
        url: "/review",
        type: "DELETE",
        data: {
          "_token": "{{ csrf_token() }}",
          "id": id,
        },
        success: function(response) {
          window.location.href = "/games/{{$game->id}}";
        },
        error: function(reject) {
          console.log(reject);
          new BsToast({
            title: 'Ocorreu um erro',
            content: 'Ocorreu um erro ao tentar remover a avaliação.',
            type: 'danger',
            pause_on_hover: true,
            delay: 5000,
            position: 'top-right'
          });
        }
      });
    }
  });
</script>
@endpush

@section('content')
<div class="container">
  <div class="p-2 p-sm-5 mb-4 jumbotron rounded-3">
    <div class="row">
      <div class="col-12 col-sm-4">
        <div class="row">
          <img src='{{ $game->image }}' class="card-img-top col-lg-12" />
          <div class="card-body mb-4 pb-0 col-lg-12">
            @if(count($game->avaliacoes) == 0)

            <div class="row mb-4" style="padding-bottom: 0px !important; margin: auto">
              <span class="btn btn-outline-primary btn-outline-secondary disabled">
                Sem avaliações recentes
              </span>
            </div>
            @else
            <div class="row mb-4">
              <div class="col-7" style="text-align: center; margin: auto;">
                <select class="rating" id='rating_jogo' data-id='rating_jogo'>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </div>
              <div class="col rating-number">
                <span class="btn
                  <?php
                  echo $game->rating->rating >= 3.5 ? 'btn-success'
                    : ($game->rating->rating >= 3 ? 'btn-secondary' : 'btn-danger');
                  ?>
                  disabled">
                  <?php
                  echo number_format($game->rating->rating, 2, ',', '');
                  ?>
                </span>
              </div>

              @push('scripts')
              <script type='text/javascript'>
                $(document).ready(function() {
                  $('#rating_jogo')
                    .barrating('readonly', true)
                    .barrating('set', <?php
                                      echo number_format($game->rating->rating);
                                      ?>);
                });
              </script>
              @endpush
            </div>
            @endif
            <div class="row" style="padding-bottom: 0px !important; margin: auto">
              @if(count($game->wishlists) == 0)
              <button type="button" class="btn btn-warning btn-wishlist">Adicionar à lista de desejos</button>
              @else
              <button type="button" class="btn btn-danger btn-remover-wishlist">Remover da lista de desejos</button>
              @endif
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-8">
        <div class="container-fluid">
          <h1 class="display-5">{{ $game->name }}</h1>
          <hr class="my-4">
          <p class="lead">{{$game->description}}</p>
          <p>Lançamento:
            <?php
            $date = date_create($game->released_at);
            echo date_format($date, "d/m/Y"); ?>
          </p>
          <?php
          echo '<p>' . ($game->generos->count() == 1 ? 'Gênero:' : 'Gêneros:') . '</p>';
          echo '<ul>';
          foreach ($game->generos as $genero) {
            echo '<li>';
            echo $genero->name;
            echo '</li>';
          }
          echo '</ul>';

          echo '<p>Disponível para:</p>';
          echo '<ul>';
          foreach ($game->plataformas as $plataforma) {
            echo '<li>';
            echo $plataforma->name;
            echo '</li>';
          }
          echo '</ul>';
          ?>

        </div>
      </div>
    </div>
  </div>

  @if(count($game->screenshots) != 0)
  <div class="p-2 p-sm-5 mb-4 jumbotron rounded-3">
    <h1 class="display-5">Screenshots</h1>
    <div id="carouselScreenshots" class="carousel slide carousel-fade d-md-none d-lg-block" data-bs-ride="carousel">
      <div class="carousel-inner">
        <?php
        $first = true;
        foreach ($game->screenshots as $screenshot) {
          echo '<div class="carousel-item';
          if ($first) {
            $first = false;
            echo ' active';
          };
          echo '"> <img src="' . $screenshot->url . '" class="d-block w-100">';
          echo '</div>';
        };
        ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselScreenshots" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselScreenshots" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
  @endif

  <div class="p-2 p-sm-5 mb-4 jumbotron rounded-3">
    <h1 class="display-5">Avaliações</h1>
    <div>
      @if(count($game->avaliacoes) == 0)
      <h5 class="mb-4">Seja o primeiro a deixar uma avaliação</h5>
      @else
      <h5 class="mb-4">Deixe sua avaliação</h5>
      @endif
      <hr>
      <form class="needs-validation" id="reviewform">
        @csrf
        <div class="d-flex avaliacao">
          <div class="flex-shrink-0">
            @if(auth()->check())
            <img src="{{auth()->user()->avatar}}" alt="{{ URL::asset('image/default-user-image.png') }}" width="32" height="32" class="rounded-circle">
            @else
            <img src="{{ URL::asset('image/default-user-image.png') }}" width="32" height="32" class="rounded-circle">
            @endif
          </div>
          <div class="flex-grow-1 ms-3">
            <div class="d-flex flex-column">
              <select class="rating float-right" id='rating_avaliacao' data-id='rating_avaliacao' name="rating_avaliacao">
                <option value=""></option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
              @push('scripts')
              <script type='text/javascript'>
                $(document).ready(function() {
                  $('#rating_avaliacao')
                    .barrating('set', 0);
                });
              </script>
              @endpush

              <div class="form-group mb-4">
                <label for="avaliacao">Seu Comentário</label>
                <textarea name="comentario" id="comentario" class="form-control"></textarea>
              </div>
              <div class="form-group">
                @if(auth()->check())
                <button class="btn btn-primary btn-sm btn-avaliar"> Enviar Avaliação </button>
                @else
                <a href="/#login" class="btn btn-primary btn-sm btn-entrar"> Enviar Avaliação </a>
                @endif
              </div>
            </div>
          </div>
        </div>
      </form>

      @if(count($game->avaliacoes) != 0)
      <h5 class="mb-4 mt-5">Avaliações recentes</h5>
      @foreach($game->avaliacoes as $avaliacao)
      <hr>
      <div class="d-flex avaliacao">
        <div class="flex-shrink-0">
          @if($avaliacao->usuario->isBlocked())
          <img alt="image" src="{{ URL::asset('image/default-user-image.png') }}" class="mr-3 rounded-pill" />
          @else
          <a href="/users/{{$avaliacao->usuario->id}}">
            @if(is_null($avaliacao->usuario->avatar))
            <img src="{{ URL::asset('image/default-user-image.png') }}" class="mr-3 rounded-pill">
            @else
            <img src="{{$avaliacao->usuario['avatar']}}" alt="{{ URL::asset('image/default-user-image.png') }}" class="mr-3 rounded-pill">
            @endif
          </a>
          @endif
        </div>
        <div class="flex-grow-1 ms-3">
          <div class="d-flex">
            <div class="me-auto">
              <select class="rating float-right" id='rating_{{$avaliacao->id}}' data-id='rating_{{$avaliacao->id}}'>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
              @push('scripts')
              <script type='text/javascript'>
                $(document).ready(function() {
                  $('#rating_<?php echo $avaliacao->id; ?>')
                    .barrating('readonly', true)
                    .barrating('set', <?php echo $avaliacao->rating; ?>);
                });
              </script>
              @endpush

              @if($avaliacao->usuario->isBlocked())
              [Bloqueado]
              @else
              <a href="/users/{{$avaliacao->usuario->id}}">
                <h6 class="mb-1 text-black">{{$avaliacao->usuario->name}}</h6>
              </a>
              @endif
              <p class="text-gray very-small">
                {{$avaliacao->updated_at->diffForHumans()}}
              </p>
            </div>
            
            @if(auth()->check() && (auth()->user()->id == $avaliacao->user_id || auth()->user()->isAdmin()))
            <div>
              <button style="cursor:pointer" class="btn btn-danger btn-remover-avaliacao" id="{{$avaliacao->id}}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                </svg>
              </button>
            </div>
            @endif
          </div>
          <p>{{$avaliacao->commentary}}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endif
</div>
@endsection