@extends('layouts.master')

@section('title', 'Lista de Desejos')

@push('scripts')
<script type='text/javascript'>
  $(function() {
    $('.rating').barrating({
      theme: 'fontawesome-stars-o',
      initialRating: 0,
    });
  });

  $(document).ready(function() {
    $(".buscar-plataforma").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $(".lista-plataforma *").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    $(".buscar-genero").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $(".lista-genero *").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    $(".buscar-ano").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $(".lista-ano *").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>
@endpush

@section('content')
<div class="container">
  <div class="row">
    <div class="col-6 col-sm-6 col-md">
      <h1>Lista de Desejos</h1>
    </div>
  </div>
  <div class="row">
    @foreach($wishlist as $wish)
    <div class="col-xl-3 col-md-3 col-sm-6">
      <div class="card mb-4 shadow-sm">
        <a href="/games/{{$wish->jogo->id}}" style="text-decoration: none;">
          <img src='{{ $wish->jogo->image }}' class="card-img-top" />
          <div class="card-body" style="padding-bottom: 0px !important;">
            <h5 class="card-title">{{ $wish->jogo->name }}</h5>
            <p class="card-text">
              <small class="text-muted">
                Lançamento:
                <?php
                $date = date_create($wish->jogo->released_at);
                echo date_format($date, "d/m/Y");
                ?>
              </small>
            </p>
            @if(count($wish->jogo->avaliacoes) == 0)
            <div class="row mb-4" style="padding-bottom: 0px !important; margin: auto">
              <span class="btn btn-outline-secondary disabled">
                Sem avaliações recentes
              </span>
            </div>
            @else
            <div class="row mb-4" style="padding-bottom: 0px !important">
              <div class="col" style="text-align: center; margin: auto;">
                <select class="rating" id="rating_{{$wish->jogo->id}}">
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
              echo $wish->jogo->rating->rating >= 4 ? 'btn-success'
                : ($wish->jogo->rating->rating >= 3 ? 'btn-secondary' : 'btn-danger');
              ?>
              disabled">
                  <?php
                  echo number_format($wish->jogo->rating->rating, 2, ',', '');
                  ?>
                </span>
              </div>
              @push('scripts')
              <script type='text/javascript'>
                $(document).ready(function() {
                  $('#rating_{{$wish->jogo->id}}')
                    .barrating('readonly', true)
                    .barrating('set', <?php
                                      echo number_format($wish->jogo->rating->rating);
                                      ?>);
                });
              </script>
              @endpush
            </div>
            @endif
          </div>
          <div class="card-footer text-muted">
            @foreach($wish->jogo->plataformas as $plataforma)
            <span class="mw-100 badge rounded-pill bg-primary d-inline-block text-truncate">{{ $plataforma->name }}</span>
            @endforeach
          </div>
        </a>
      </div>
    </div>
    @endforeach
    <div class="row">
      <div class="col d-flex justify-content-center justify-content-sm-end">
      </div>
    </div>
  </div>
</div>
@endsection
