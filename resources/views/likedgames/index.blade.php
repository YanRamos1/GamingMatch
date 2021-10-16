@extends('layouts.master')

@section('title', 'Lista de Desejos')

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
                <h1>Lista de jogos curtidos</h1>
            </div>
            <div class="col-12 col-sm-12 col-md-6">
                <div class="col d-flex justify-content-center justify-content-sm-end">
                    @if(count($likedgames) >=5)
                        <div class="row">
                            <div class="col d-flex justify-content-center justify-content-sm-end">
                                {!! $likedgames->links() !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($likedgames as $liked)
                <div class="col-xl-3 col-md-3 col-sm-6">
                    <div class="card mb-4 shadow-sm">
                        <a href="/games/{{$liked->jogo->id}}" style="text-decoration: none;">
                            <img src='{{ $liked->jogo->image }}' class="card-img-top"/>
                            <div class="card-body" style="padding-bottom: 0px !important;">
                                <h5 class="card-title">{{ $liked->jogo->name }}</h5>
                                <p class="card-text">
                                    <small class="text-muted">
                                        Lançamento:
                                        <?php
                                        $date = date_create($liked->jogo->released_at);
                                        echo date_format($date, "d/m/Y");
                                        ?>
                                    </small>
                                </p>
                                @if(count($liked->jogo->avaliacoes) == 0)
                                    <div class="row mb-4" style="padding-bottom: 0px !important; margin: auto">
              <span class="btn btn-outline-secondary disabled">
                Sem avaliações recentes
              </span>
                                    </div>
                                @else
                                    <div class="row mb-4" style="padding-bottom: 0px !important">
                                        <div class="col" style="text-align: center; margin: auto;">
                                            <select class="rating" id="rating_{{$liked->jogo->id}}">
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
                echo $liked->jogo->rating->rating >= 4 ? 'btn-success'
                    : ($liked->jogo->rating->rating >= 3 ? 'btn-secondary' : 'btn-danger');
                ?>
                    disabled">
                  <?php
                    echo number_format($liked->jogo->rating->rating, 2, ',', '');
                    ?>
                </span>
                                        </div>
                                        @push('scripts')
                                            <script type='text/javascript'>
                                                $(document).ready(function () {
                                                    $('#rating_{{$liked->jogo->id}}')
                                                        .barrating('readonly', true)
                                                        .barrating('set', <?php
                                                            echo number_format($liked->jogo->rating->rating);
                                                            ?>);
                                                });
                                            </script>
                                        @endpush
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer text-muted">
                                @foreach($liked->jogo->plataformas as $plataforma)
                                    <span
                                        class="mw-100 badge rounded-pill bg-primary d-inline-block text-truncate">{{ $plataforma->name }}</span>
                                @endforeach
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
                @if(count($likedgames) >=5)
                    <div class="row">
                        <div class="col d-flex justify-content-center justify-content-sm-end">
                            {!! $likedgames->links() !!}
                        </div>
                    </div>
                @endif
        </div>

    </div>
@endsection
