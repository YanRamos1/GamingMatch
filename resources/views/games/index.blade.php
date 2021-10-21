@extends('layouts.master')

@section('title','Jogos')

@push('scripts')
    <script type='text/javascript'>
        $(function () {
            $('.rating').barrating({
                theme: 'fontawesome-stars-o',
                initialRating: 0,
            });
        });

        $(document).ready(function () {
            $(".buscar-plataforma").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $(".lista-plataforma *").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $(".buscar-genero").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $(".lista-genero *").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $(".buscar-ano").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $(".lista-ano *").filter(function () {
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
                <h1 style="color:#F3821C;">Jogos</h1>
            </div>
            <div class="col-6 col-sm-6 col-md-6 d-xs-block d-sm-block d-md-none">
                <div class="w-100 text-end">
                    <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">
                        Filtros
                    </button>
                </div>
            </div>
            <div class="collapse" id="collapseFilters">
                @include('layouts.partials.filter')
            </div>
            <div class="col-12 col-sm-12 col-md-6">
                <div class="d-flex justify-content-center justify-content-md-end">
                    {!! $games->links() !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xl-2 d-none d-sm-none d-md-block">
                @include('layouts.partials.filter')
            </div>
            <div class="col-md-9 col-xl-10">
                <div class="row">
                    @foreach($games as $game)
                        <div class="col-xl-3 col-md-4 col-sm-6">
                            <div style="border: 1px solid #f3821c;" class="card mb-4 shadow-sm">
                                <a href="/games/{{$game->id}}" style="text-decoration: none;">
                                    <img src='{{ $game->image }}' class="card-img-top rounded shadow-lg"/>
                                    <div class="card-body" style="padding-bottom: 0px !important;">
                                        <h5 class="card-title text-center">{{ $game->name }}</h5>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                Lançamento:
                                                <?php
                                                $date = date_create($game->released_at);
                                                echo date_format($date, "d/m/Y");
                                                ?>
                                            </small>
                                        </p>
                                        @if(count($game->avaliacoes) == 0)
                                            <div class="row mb-4" style="padding-bottom: 0px !important; margin: auto">
                  <span class="btn btn-outline-secondary disabled">
                    Sem avaliações recentes
                  </span>
                                            </div>
                                        @else
                                            <div class="row mb-4" style="padding-bottom: 0px !important">
                                                <div class="col" style="text-align: center; margin: auto;">
                                                    <select class="rating" id="rating_{{$game->id}}">
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
                    echo $game->rating >= 4 ? 'btn-success'
                        : ($game->rating >= 3 ? 'btn-secondary' : 'btn-danger');
                    ?>
                        disabled">
                      <?php
                        echo number_format($game->rating, 2, ',', '');
                        ?>
                    </span>
                                                </div>
                                                @push('scripts')
                                                    <script type='text/javascript'>
                                                        $(document).ready(function () {
                                                            $('#rating_{{$game->id}}')
                                                                .barrating('readonly', true)
                                                                .barrating('set', <?php
                                                                    echo number_format($game->rating);
                                                                    ?>);
                                                        });
                                                    </script>
                                                @endpush
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-footer text-muted"
                                         style="background-color: rgba(243,130,28,0); border-top:1px solid #000000;">
                                        @foreach($game->plataformas as $plataforma)
                                            <span class="mw-100 badge rounded-pill d-inline-block text-truncate"
                                                  style="border: 1px solid black; background-color:#f3821c;">{{ $plataforma->name }}</span>
                                        @endforeach
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row mb-2">
                    <div class="col d-flex justify-content-center justify-content-sm-end">
                        <a class="btn btn-outline-primary btn-laranja" href="/games/search">
                            Não encontrou o jogo que queria? Cadastre-o agora!
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col d-flex justify-content-center justify-content-sm-end">
                        {!! $games->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
