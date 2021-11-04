@extends('layouts.master')
<script src="https://kit.fontawesome.com/f7a428fdfe.js" crossorigin="anonymous"></script>
@section('title', $game->name)

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<script src="https://kit.fontawesome.com/f7a428fdfe.js" crossorigin="anonymous"></script>
@push('scripts')
    <style>
        .fill {
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden
        }

        .fill img {
            flex-shrink: 0;
            min-width: 100%;
            min-height: 100%
        }

        .popout {
            position: absolute !important;
        }

        .imagem {
            margin-left: auto;
            margin-right: auto;
            display: block;
        }

        .divcolor1 {
            background: #5176A6;
        }

        .divcolor2 {
            background: #283240;
        }

        .divcolor3 {
            background: #465E73;
        }

        .divcolor4 {
            background: #7B92A6;
        }

        .divcolor5 {
            background: #9da7b5;
        }
    </style>
    <script>
        $("*").focus(function (event) {
            $(this).removeClass('is-invalid');
        });

        $(function () {
            $('.rating').barrating({
                theme: 'fontawesome-stars-o',
                initialRating: 0,
            });
        });

        $("*").focus(function (event) {
            $(this).removeClass('is-invalid');
        });

        $(".btn-wishlist").click(function (event) {
            event.preventDefault();

            let game = "{{$game->id}}";
            let wishlist = "{{$wishlist}}";


            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "/wishlist",
                type: "POST",
                data: {
                    game: game,
                    wishlist: wishlist,
                    _token: _token,
                },
                success: function (response) {
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
                error: function (reject) {
                    var errors = $.parseJSON(reject.responseText);
                    if (reject.status === 422) {

                        $.each(errors.errors, function (key, val) {
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

        $(".btn-remover-wishlist").click(function (event) {
            event.preventDefault();

            let game = "{{$game->id}}";
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "/wishlist-delete",
                type: "DELETE",
                data: {
                    game: game,

                    _token: _token,
                },
                success: function (response) {
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


        $(".btn-liked").click(function (event) {
            event.preventDefault();

            let game = "{{$game->id}}";


            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "/liked",
                type: "POST",
                data: {
                    game: game,
                    _token: _token,
                },
                success: function (response) {
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
                error: function (reject) {
                    var errors = $.parseJSON(reject.responseText);
                    if (reject.status === 422) {

                        $.each(errors.errors, function (key, val) {
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

        $(".btn-unliked").click(function (event) {
            event.preventDefault();

            let game = "{{$game->id}}";
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "/liked",
                type: "DELETE",
                data: {
                    game: game,

                    _token: _token,
                },
                success: function (response) {
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


        $(".btn-avaliar").click(function (event) {
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
                success: function (response) {
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

        $(".btn-remover-avaliacao").click(function (event) {
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
                    success: function (response) {
                        window.location.href = "/games/{{$game->id}}";
                    },
                    error: function (reject) {
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
        <div class="p-2 mt-3 p-sm-5 mb-4 jumbotron rounded-3">
            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="row">
                        <img src='{{ $game->image }}' class="card-img-top col-lg-12 rounded"/>
                        <div class="card-body mb-4 pb-0 col-lg-12">
                            <div>
                                <i class="fas fa-heart"></i> {{$game->likersCount()}}</div>
                            @if(count($game->avaliacoes) == 0)
                                <div class="row mb-4"
                                     style="padding-bottom: 0px !important; margin: auto; margin-top:10px;">
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
                                            $(document).ready(function () {
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

                                @if($wishlist == null)
                                    <button type="button" class="btn btn-warning btn-wishlist"
                                            style="background:#f3821c; border-color:#f3821c;">Adicionar à lista de
                                        desejos
                                    </button>
                                @else
                                    <button type="button" class="btn btn-danger btn-remover-wishlist">Remover da lista
                                        de desejos
                                    </button>
                                @endif
                            </div>
                            <div class="row" style="padding-bottom: 0px !important; margin: auto">

                                @if($likedgames == null)
                                    <button style="background:#f3821c; border-color:#f3821c; margin-top:5px;"
                                            class="btn btn-warning btn-liked m-1" type="button"
                                            onclick="window.location='{{ url("/games/like/$game->id") }}'">
                                        <i class="fas fa-heart"></i>
                                        <span id="friendship-status-">Curtir</span>
                                    </button>
                                @else
                                    <button class="btn btn-danger btn-unliked m-1" type="button"
                                            onclick="window.location='{{ url("/games/unlike/$game->id") }}'">
                                        <i class="fas fa-heart-broken"></i>
                                        <span id="friendship-status-">Descurtir</span>
                                    </button>
                                @endif
                            </div>
                            @if(Auth::user() != null)
                                <h3 class="mx-auto">Comunidade</h3>
                            <div class="row p-3">
                                @if($group == null)
                                    <button style="background:#f3821c; border-color:#f3821c; margin-top:5px;"
                                            class="btn btn-warning m-1" type="button"
                                            onclick="window.location='{{ url("/games/group/create/$game->igdb_id") }}'">
                                        <i class="fas fa-heart"></i>
                                        <span id="friendship-status-">Criar Grupo</span>
                                    </button>
                                @elseif(!$group->contains(Auth::user()))
                                    <button class="btn btn-danger m-1" type="button"
                                            onclick="window.location='{{ url("/games/group/enter/$game->igdb_id") }}'">
                                        <i class="fas"></i>
                                        Entrar no grupo
                                    </button>
                                    @elseif($group->contains(Auth::user()))
                                        <button class="btn btn-danger m-1" type="button"
                                                onclick="window.location='{{ url("/games/group/leave/$game->igdb_id") }}'">
                                            <i class="fas"></i>
                                            Sair do grupo
                                        </button>
                                    <button class="btn btn-danger m-1" type="button"
                                            onclick="window.location='{{ url("/groups/show/$game->igdb_id") }}'">
                                        <i class="fas"></i>
                                        Ver grupo
                                    </button>

                                    @endif
                            </div>
                                @endif
                        </div>
                        <div class="center flex flex-wrap d-flex justify-content-center m-4">
                            @if(isset($gameigdb->websites))
                                <h3 class="text-white text-center">Links</h3>
                                <div class="grid grid-cols-4 container m-2">
                                    @foreach($gameigdb->websites as $website)
                                        @if($website['category']===1)
                                            <button
                                                class="m-1 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 hover:shadow-lg hover:border-transparent rounded">
                                                <a class="text-center" href="{{$website['url']}}">Site Oficial</a>
                                            </button>
                                        @endif
                                        @if($website['category']===2)
                                            <button
                                                class="m-1 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 hover:shadow-lg hover:border-transparent rounded">
                                                <a href="{{$website['url']}}">
                                                    <svg class="mx-auto" xmlns="http://www.w3.org/2000/svg"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                                                         role="img"
                                                         width="1em" height="1em" preserveAspectRatio="xMidYMid meet"
                                                         viewBox="0 0 24 24">
                                                        <path
                                                            d="M22.192 11.317c0 .2-.08.392-.222.533l-9.28 9.306a.686.686 0 0 1-.512.224a.743.743 0 0 1-.534-.225l-.654-.614a.284.284 0 0 1-.007-.41l10.713-10.72c.182-.182.497-.054.497.201v1.706zm-11.904 7.018l-.532.475a.445.445 0 0 1-.604-.014l-7.065-6.897a.918.918 0 0 1-.277-.66V9.952c0-.464.566-.698.9-.371l7.499 7.322c.13.13.35.396.35.717c0 .205-.047.495-.27.717zM3.973 4.987l2.431-2.402a.292.292 0 0 1 .41 0l8.139 8.045a2.19 2.19 0 0 1 0 3.12l-2.43 2.401a.293.293 0 0 1-.408 0l-8.14-8.047a2.172 2.172 0 0 1-.65-1.56c0-.59.23-1.144.648-1.557zm9.632 1.375l2.54-2.51a2.241 2.241 0 0 1 1.897-.623c.5.068.956.326 1.313.679l2.571 2.542a.284.284 0 0 1 0 .406l-3.91 3.867a.29.29 0 0 1-.41 0l-4.001-3.956a.285.285 0 0 1 0-.405zM23.7 5.885L18.04.19a.603.603 0 0 0-.852-.002l-4.493 4.485a.898.898 0 0 1-1.262.002L6.94.237a.603.603 0 0 0-.842-.002L.31 5.871c-.2.194-.31.458-.31.733v5.34c0 .271.11.534.305.726l11.277 11.145a.603.603 0 0 0 .846 0L23.696 12.67c.194-.193.304-.455.304-.727V6.606c0-.27-.106-.529-.298-.72z"
                                                            fill="currentColor"/>
                                                    </svg>
                                                </a>
                                            </button>
                                        @endif
                                        @if($website['category']===3)
                                            <button
                                                class="m-1 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 hover:shadow-lg hover:border-transparent rounded">
                                                <a href="{{$website['url']}}"><i class="fab fa-wikipedia-w"></i></a>
                                            </button>
                                        @endif
                                        @if($website['category']===4)
                                            <button
                                                class="m-1 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 hover:shadow-lg hover:border-transparent rounded">
                                                <a href="{{$website['url']}}"><i class="fab fa-facebook"></i></a>
                                            </button>
                                        @endif
                                        @if($website['category']===5)
                                            <button
                                                class="m-1 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 hover:shadow-lg hover:border-transparent rounded">
                                                <a href="{{$website['url']}}"><i class="fab fa-twitter"></i></a>
                                            </button>
                                        @endif
                                        @if($website['category']===6)
                                            <button
                                                class="m-1 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 hover:shadow-lg hover:border-transparent rounded">
                                                <a href="{{$website['url']}}"><i class="fab fa-twitch"></i></a>
                                            </button>
                                        @endif
                                        @if($website['category']===8)
                                            <button
                                                class="m-1 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 hover:shadow-lg hover:border-transparent rounded">
                                                <a href="{{$website['url']}}"><i class="fab fa-instagram"></i></a>
                                            </button>
                                        @endif
                                        @if($website['category']===9)
                                            <button
                                                class="m-1 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 hover:shadow-lg hover:border-transparent rounded">
                                                <a href="{{$website['url']}}"><i class="fab fa-youtube"></i></a>
                                            </button>
                                        @endif
                                        @if($website['category']===13)
                                            <button
                                                class="m-1 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 hover:shadow-lg hover:border-transparent rounded">
                                                <a href="{{$website['url']}}"><i class="fab fa-steam"></i></a>
                                            </button>
                                        @endif
                                        @if($website['category']===14)
                                            <button
                                                class="m-1 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 hover:shadow-lg hover:border-transparent rounded">
                                                <a href="{{$website['url']}}"><i class="fab fa-reddit"></i></a>
                                            </button>
                                        @endif
                                        @if($website['category']===15)
                                            <button
                                                class="m-1 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 hover:shadow-lg hover:border-transparent rounded">
                                                <a href="{{$website['url']}}"><i class="fab fa-itch-io"></i></a>
                                            </button>
                                        @endif
                                        @if($website['category']===16)
                                            <button
                                                class="m-1 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 hover:shadow-lg hover:border-transparent rounded">
                                                <a href="{{$website['url']}}"><span class="mx-auto iconify"
                                                                                    data-icon="simple-icons:epicgames"></span></a>
                                            </button>
                                        @endif
                                        @if($website['category']===17)
                                            <button
                                                class="m-1 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 hover:shadow-lg hover:border-transparent rounded">
                                                <a href="{{$website['url']}}">
                                                    <svg class="mx-auto" xmlns="http://www.w3.org/2000/svg"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                                                         role="img"
                                                         width="1em" height="1em" preserveAspectRatio="xMidYMid meet"
                                                         viewBox="0 0 32 32">
                                                        <path
                                                            d="M9.531 20.317H5.812a.535.535 0 0 0-.531.537v2.667c0 .281.24.531.531.531h3.735v1.76H4.88a1.37 1.37 0 0 1-1.359-1.375v-4.516c0-.749.615-1.359 1.375-1.359h4.635zm1.349-4.932c0 .776-.625 1.401-1.401 1.401H3.506v-1.803h5.041a.528.528 0 0 0 .532-.531V8.52a.532.532 0 0 0-.532-.537H5.855a.536.536 0 0 0-.548.537v2.692c0 .308.24.532.532.532H8v1.801H4.907a1.392 1.392 0 0 1-1.401-1.385V7.572c0-.761.631-1.385 1.401-1.385H9.47c.771 0 1.395.624 1.395 1.385v7.812zm17.599 10.427h-1.76v-5.495h-1.24a.535.535 0 0 0-.531.537v4.957h-1.776v-5.495h-1.24a.535.535 0 0 0-.531.537v4.957h-1.776v-5.891c0-.749.615-1.359 1.375-1.359h7.479zm.016-10.427c0 .776-.631 1.401-1.401 1.401h-5.973v-1.803h5.041a.53.53 0 0 0 .532-.531V8.52a.535.535 0 0 0-.532-.537h-2.708a.532.532 0 0 0-.532.537v2.692c0 .308.24.532.532.532h2.161v1.801h-3.084a1.386 1.386 0 0 1-1.395-1.385V7.572c0-.761.624-1.385 1.395-1.385h4.573c.776 0 1.401.624 1.401 1.385v7.812zM18.292 6.188h-4.584c-.776 0-1.391.624-1.391 1.385v4.588a1.38 1.38 0 0 0 1.391 1.385h4.584a1.39 1.39 0 0 0 1.391-1.385V7.573c0-.761-.631-1.385-1.391-1.385zm-.396 2.333v2.692c0 .297-.24.532-.536.532h-2.709a.53.53 0 0 1-.531-.532V8.53c0-.291.229-.531.531-.531h2.683c.307 0 .531.24.531.531zm-1.057 10.042h-4.521c-.755 0-1.369.609-1.369 1.359v4.516c0 .76.615 1.375 1.369 1.375h4.521c.76 0 1.375-.615 1.375-1.375v-4.516c0-.749-.615-1.359-1.375-1.359zm-.402 2.292v2.667a.53.53 0 0 1-.531.531v-.011h-2.652a.535.535 0 0 1-.536-.536v-2.651a.54.54 0 0 1 .536-.537h2.667c.292 0 .532.245.532.537zm14.88-19.386A2.32 2.32 0 0 0 29.666.77H2.333A2.322 2.322 0 0 0 0 3.103v25.792a2.322 2.322 0 0 0 2.333 2.333h27.333a2.322 2.322 0 0 0 2.333-2.333V3.103c0-.635-.265-1.224-.683-1.651zm0 27.427a1.638 1.638 0 0 1-1.651 1.651H2.333a1.643 1.643 0 0 1-1.667-1.651V3.104a1.646 1.646 0 0 1 1.651-1.651H29.65c.917 0 1.656.74 1.656 1.651v25.792z"
                                                            fill="currentColor"/>
                                                    </svg>
                                                </a>
                                            </button>
                                        @endif
                                        @if($website['category']===18)
                                            <button
                                                class="m-1 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 hover:shadow-lg hover:border-transparent rounded">
                                                <a href="{{$website['url']}}">
                                                    <svg class="mx-auto" xmlns="http://www.w3.org/2000/svg"
                                                         xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                                                         role="img"
                                                         width="1em" height="1em" preserveAspectRatio="xMidYMid meet"
                                                         viewBox="0 0 24 24">
                                                        <g fill="none">
                                                            <path
                                                                d="M20.317 4.492c-1.53-.69-3.17-1.2-4.885-1.49a.075.075 0 0 0-.079.036c-.21.369-.444.85-.608 1.23a18.566 18.566 0 0 0-5.487 0a12.36 12.36 0 0 0-.617-1.23A.077.077 0 0 0 8.562 3c-1.714.29-3.354.8-4.885 1.491a.07.07 0 0 0-.032.027C.533 9.093-.32 13.555.099 17.961a.08.08 0 0 0 .031.055a20.03 20.03 0 0 0 5.993 2.98a.078.078 0 0 0 .084-.026c.462-.62.874-1.275 1.226-1.963c.021-.04.001-.088-.041-.104a13.201 13.201 0 0 1-1.872-.878a.075.075 0 0 1-.008-.125c.126-.093.252-.19.372-.287a.075.075 0 0 1 .078-.01c3.927 1.764 8.18 1.764 12.061 0a.075.075 0 0 1 .079.009c.12.098.245.195.372.288a.075.075 0 0 1-.006.125c-.598.344-1.22.635-1.873.877a.075.075 0 0 0-.041.105c.36.687.772 1.341 1.225 1.962a.077.077 0 0 0 .084.028a19.963 19.963 0 0 0 6.002-2.981a.076.076 0 0 0 .032-.054c.5-5.094-.838-9.52-3.549-13.442a.06.06 0 0 0-.031-.028zM8.02 15.278c-1.182 0-2.157-1.069-2.157-2.38c0-1.312.956-2.38 2.157-2.38c1.21 0 2.176 1.077 2.157 2.38c0 1.312-.956 2.38-2.157 2.38zm7.975 0c-1.183 0-2.157-1.069-2.157-2.38c0-1.312.955-2.38 2.157-2.38c1.21 0 2.176 1.077 2.157 2.38c0 1.312-.946 2.38-2.157 2.38z"
                                                                fill="currentColor"/>
                                                        </g>
                                                    </svg>
                                                </a>
                                            </button>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="col-12 col-sm-8">
                    <div class="container-fluid">
                        <h1 class="display-5">{{ $game->name }}</h1>
                        <hr class="my-4">
                        <p class="lead">{{$game->description}}</p>
                        @if(isset($involved_companies))
                            <h3>Desenvolvedoras</h3>
                            @foreach($involved_companies as $involved)
                                <p class="text-gray-300">
                                    {{$involved->company['name']}}
                                </p>
                            @endforeach
                        @endif
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
                        <div>
                            @if(isset($gameigdb->dlcs))
                                <h3 class="text-center text-black">DLC's</h3>
                                <div class="grid grid-cols-3 md:grid-cols-3 gap-3">
                                    @foreach($gameigdb->dlcs as $dlc)
                                        <div class="items-center mx-auto">
                                            <a href="{{$dlc['url']}}">
                                                <h3 class="text-center text-y-auto justify-self-center text-black">
                                                    {{$dlc['name']}}
                                                </h3>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif


                            @if(isset($gameigdb['videos']))
                                @foreach($gameigdb['videos'] as $video)
                                    <div class="responsive-container overflow-hidden relative" style="padding-top: 10%">
                                        <iframe width="560" height="315"
                                                class="responsive-iframe absolute top-0 left-0 w-full h-full"
                                                src="https://www.youtube.com/embed/{{$video['video_id']}}"
                                                style="border:0;"
                                                allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                    </div>
                                @endforeach
                            @endif


                            @if(isset($gameigdb->similar_games))
                                <h3 class="text-center text-white">Jogos similares</h3>
                                <div class="row">
                                    @foreach($gameigdb->similar_games as $similar_games)
                                        <div class="d-block" style="width: 12rem;">
                                            <div class="d-block fill">
                                                <img
                                                    src="{{ str_replace('t_thumb', 't_cover_big', $similar_games['cover']['url'] ?? null) }}"
                                                    alt="game cover"
                                                    class="cardimg img-fluid rounded relative d-block mx-auto d-block hover:opacity-0 transition ease-in-out duration-150">
                                            </div>
                                            <form method="POST" action="/games">
                                                {{ csrf_field() }}
                                                <input hidden value="{{$similar_games['id']}}" name="jogo"/>
                                                <button class="btn btn-primary container-fluid" type="submit"
                                                        id="btn-buscar">Ver
                                                </button>
                                            </form>
                                        </div>

                                    @endforeach
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($gameigdb->screenshots))
            <div class="p-2 p-sm-5 mb-4 jumbotron rounded-3">
                <h1 class="display-5">Screenshots</h1>
                <div id="carouselScreenshots" class="carousel slide carousel-fade d-md-none d-lg-block"
                     data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $first = true;
                        foreach ($gameigdb->screenshots as $screenshot) {
                            echo '<div class="carousel-item';
                            if ($first) {
                                $first = false;
                                echo ' active';
                            };

                            echo '"> <img src="https://images.igdb.com/igdb/image/upload/t_screenshot_big/' . $screenshot['image_id'] . '.png" class="d-block w-100">';
                            echo '</div>';
                        };
                        ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselScreenshots"
                            data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselScreenshots"
                            data-bs-slide="next">
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
                                <img src="{{auth()->user()->avatar}}"
                                     alt="{{ URL::asset('image/default-user-image.png') }}"
                                     width="32" height="32" class="rounded-circle">
                            @else
                                <img src="{{ URL::asset('image/default-user-image.png') }}" width="32" height="32"
                                     class="rounded-circle">
                            @endif
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="d-flex flex-column">
                                <select class="rating float-right" id='rating_avaliacao' data-id='rating_avaliacao'
                                        name="rating_avaliacao">
                                    <option value=""></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                                @push('scripts')
                                    <script type='text/javascript'>
                                        $(document).ready(function () {
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
                                        <button class="btn btn-primary btn-sm btn-avaliar"
                                                style="background:#f3821c; border-color:#f3821c;"> Enviar Avaliação
                                        </button>
                                    @else
                                        <a href="/#login" class="btn btn-primary btn-sm btn-entrar"> Enviar
                                            Avaliação </a>
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
                                    <img alt="image" src="{{ URL::asset('image/default-user-image.png') }}"
                                         class="mr-3 rounded-pill"/>
                                @else
                                    <a href="/users/{{$avaliacao->usuario->id}}">
                                        @if(is_null($avaliacao->usuario->avatar))
                                            <img src="{{ URL::asset('image/default-user-image.png') }}"
                                                 class="mr-3 rounded-pill">
                                        @else
                                            <img src="{{$avaliacao->usuario['avatar']}}"
                                                 alt="{{ URL::asset('image/default-user-image.png') }}"
                                                 class="mr-3 rounded-pill">
                                        @endif
                                    </a>
                                @endif
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex">
                                    <div class="me-auto">
                                        <select class="rating float-right" id='rating_{{$avaliacao->id}}'
                                                data-id='rating_{{$avaliacao->id}}'>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                        @push('scripts')
                                            <script type='text/javascript'>
                                                $(document).ready(function () {
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
                                            <button style="cursor:pointer" class="btn btn-danger btn-remover-avaliacao"
                                                    id="{{$avaliacao->id}}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor"
                                                     class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                    <path fill-rule="evenodd"
                                                          d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                <p>{{$avaliacao->commentary}}</p>
                                <div>
                                    @if(auth()->user() !== null)
                                        @if(auth()->user()->hasliked($avaliacao))
                                            <div>
                                                <button class="btn btn-info" type="button"
                                                        onclick="window.location='{{ url("/rating/unlike/$avaliacao->id") }}'">
                                                    <span id="friendship-status-">Unlike</span>
                                                </button>
                                            </div>
                                        @elseif(!auth()->user()->hasliked($avaliacao))
                                            <button class="btn btn-info" type="button"
                                                    onclick="window.location='{{ url("/rating/like/$avaliacao->id") }}'">
                                                <span id="friendship-status-">Like</span>
                                            </button>
                                        @endif
                                    @endif
                                    <i class="fas fa-heart"></i> {{count($avaliacao->likers()->get())}}
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div>
        </div>
        @endif
    </div>
@endsection
