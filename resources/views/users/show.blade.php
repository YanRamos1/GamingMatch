@extends('layouts.master')

@section('title', $user->name)
<script src="https://kit.fontawesome.com/f7a428fdfe.js" crossorigin="anonymous"></script>
@push('scripts')
    <script xmlns:wire="http://www.w3.org/1999/xhtml">
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        $(function () {
            $('.rating').barrating({
                theme: 'fontawesome-stars-o',
                initialRating: 0,
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
                        window.location.href = "/users/{{$user->id}}";
                    },
                    error: function (reject) {
                        console.log(reject);
                        new BsToast({
                            title: 'Ocorreu um erro',
                            content: 'Ocorreu um erro ao tentar remover a avaliação.',
                            type: 'danger',
                            pause_on_hover: true,
                            delay: 5000,
                            position: 'top-right',
                        });
                    }
                });
            }
        });
    </script>
@endpush

@section('content')
    <div class="container">
        <div class="p-2 p-sm-5 mb-4 jumbotron rounded-3 container ">
            <div class="container">
                @if($user->isBlocked())
                    <h1>[Bloqueado]</h1>
                @else
                    <h1 style="text-align: center;
    text-transform: uppercase;">{{$user->name}}</h1>
                @endif
                @if(!$user->hasBlocked(auth()->user()))
                    <div class="col-12 col-sm-4">
                        <div class="row">
                            <div class="d-flex justify-content-center borda" style="display: inline-block;">
                                @if($user->isBlocked())
                                    <img src="{{ URL::asset('image/default-user-image.png') }}"  style="width:20rem; height:20rem"
                                         class="card-img-top col-lg-12 rounded-pill">
                                @else
                                    @if(is_null($user->avatar))
                                        <img src="{{ URL::asset('image/default-user-image.png') }}"  style="width:20rem; height:20rem"
                                             class="img-fluid rounded-pill">
                                    @else
                                        <img src="{{$user->avatar}}"
                                             alt="{{ URL::asset('image/default-user-image.png') }}"  style="width:20rem; height:20rem"
                                             class="img-fluid rounded-pill">
                                    @endif
                                @endif
                            </div>
                            <div class="card-body mb-4 pb-0 col-lg-12">
                                @if(!$user->isBlocked())
                                    @if(!is_null($user->about))
                                        <div class="row mb-3">
                                            <p class="font-monospace">
                                                {{$user->about}}
                                            </p>
                                        </div>
                                    @endif
                                    <div class="row mb-3 d-flex">
                                        <p>Seguidores: {{count($user->followers()->get())}}</p>
                                        <p>Avaliações:{{count($user->avaliacoes)}}</p>
                                        <p>Amigos:{{count($user->getAcceptedFriendships())}}</p>
                                    </div>
                                    <div>
                                        @if (Auth::id() != $user->id)
                                            @if($user->isFollowedBy(auth()->user()))
                                                <button class="btn" style="color: #F3821C;" type="button"
                                                        onclick="window.location='{{ url("/users/unfollow/$user->id") }}'">
                                                    <i class="fas fa-user-times"></i>
                                                    <span id="friendship-status-">Unfollow</span>
                                                </button>
                                            @elseif(!$user->isFollowedBy(auth()->user()))
                                                <button class="btn" style="color: #F3821C;" type="button"
                                                        onclick="window.location='{{ url("/users/follow/$user->id") }}'">
                                                    <i class="fa fa-user-plus mr-2"></i>
                                                    <span id="friendship-status-">Follow</span>
                                                </button>
                                            @endif
                                            @if(!auth()->user()->hasBlocked($user))
                                                <button class="btn" style="color: #F3821C;" type="button"
                                                        onclick="window.location='{{ url("/users/block/$user->id") }}'">
                                                    <i class="fas fa-user-lock"></i>
                                                    <span id="friendship-status-">Bloquear</span>
                                                </button>
                                            @elseif(auth()->user()->hasBlocked($user))
                                                <button class="btn" style="color: #F3821C;" type="button"
                                                        onclick="window.location='{{ url("/users/unblock/$user->id") }}'">
                                                    <i class="fas fa-unlock"></i>
                                                    <span id="friendship-status-">Unblock</span>
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="col-lg-7 text-center">
                                        <!--small modal with users->groups-->
                                        @if($user->groups()->count() > 0)
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                                <i class="fa fa-users"></i>
                                                Grupos
                                            </button>
                                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                                                 aria-labelledby="myModalLabel"
                                                 aria-hidden="true">
                                                <div class="modal-dialog mx-auto">
                                                    <div class="modal-content card container-fluid" style="height:80vh; width:80vh;">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close"><span
                                                                    aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">Grupos</h4>
                                                        </div>
                                                        <div class="modal-body" style="overflow-y: auto">
                                                            <ul class="">
                                                                @foreach($user->groups as $group)
                                                                    <div class="m-2 container card">
                                                                        <a href='{{route('groups.show',$group->id)}}'>
                                                                            <h3 class="card-header">{{$group->name}}</h3>
                                                                            <img src="{{$group->image}}"
                                                                                 class="img-responsive bordalaranja m-2"
                                                                                 style="width:13rem; height:13rem"
                                                                                 alt="">
                                                                        </a>
                                                                    </div>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Fechar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else

                                            <div class="section-title">
                                                <h5>Ainda sem comunidades</h5>
                                            </div>

                                        @endif

                                    </div>


                                    @if(!is_null($user->instagram)
                                    || !is_null($user->facebook)
                                    || !is_null($user->twitter)
                                    || !is_null($user->twitch))
                                        <hr>
                                    @endif

                                    @if(!is_null($user->instagram))
                                        <div class="row mb-2">
                                            <a class="text-decoration-none" target="_blank"
                                               href="https://instagram.com/{{$user->instagram}}">
                                                <svg style="color: #28a745;" xmlns="http://www.w3.org/2000/svg"
                                                     width="16"
                                                     height="16" fill="currentColor" class="bi bi-instagram"
                                                     viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                                                </svg>
                                                {{$user->instagram}}
                                            </a>
                                        </div>
                                    @endif

                                    @if(!is_null($user->facebook))
                                        <div class="row mb-2">
                                            <a class="text-decoration-none" target="_blank"
                                               href="https://facebook.com/{{$user->facebook}}">
                                                <svg style="color: #28a745;" xmlns="http://www.w3.org/2000/svg"
                                                     width="16"
                                                     height="16" fill="currentColor" class="bi bi-facebook"
                                                     viewBox="0 0 16 16">
                                                    <path
                                                        d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                                </svg>
                                                {{$user->facebook}}
                                            </a>
                                        </div>
                                    @endif

                                    @if(!is_null($user->twitter))
                                        <div class="row mb-2">
                                            <a class="text-decoration-none" target="_blank"
                                               href="https://twitter.com/{{$user->twitter}}">
                                                <svg style="color: #28a745;" xmlns="http://www.w3.org/2000/svg"
                                                     width="16"
                                                     height="16" fill="currentColor" class="bi bi-twitter"
                                                     viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                                                </svg>
                                                {{$user->twitter}}
                                            </a>
                                        </div>
                                    @endif

                                    @if(!is_null($user->twitch))
                                        <div class="row mb-2">
                                            <a class="text-decoration-none" target="_blank"
                                               href="https://twitch.com/{{$user->twitch}}">
                                                <svg style="color: #28a745;" xmlns="http://www.w3.org/2000/svg"
                                                     width="16"
                                                     height="16" fill="currentColor" class="bi bi-twitch"
                                                     viewBox="0 0 16 16">
                                                    <path
                                                        d="M3.857 0 1 2.857v10.286h3.429V16l2.857-2.857H9.57L14.714 8V0H3.857zm9.714 7.429-2.285 2.285H9l-2 2v-2H4.429V1.143h9.142v6.286z"/>
                                                    <path
                                                        d="M11.857 3.143h-1.143V6.57h1.143V3.143zm-3.143 0H7.571V6.57h1.143V3.143z"/>
                                                </svg>
                                                <span>
                                                {{$user->twitch}}
                                                </span>
                                            </a>
                                        </div>
                                    @endif

                                    @if(count($wishlist) > 0)
                                        <hr>
                                        <div class="row mt-2">
                                            <h5 class="mb-4 text-center center">Lista de Desejos</h5>
                                        </div>
                                        <div class="row overflow-auto mb-3" style="max-height: 200px">
                                            @foreach($wishlist as $wish)
                                                <div class="col-3 mb-2">
                                                    <a href="/games/{{$wish->jogo->id}}" style="text-decoration: none;"
                                                       data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                       title="{{$wish->jogo->name}}">
                                                        <img src='{{ $wish->jogo->image }}' class="card-img-top"/>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if(count($likedgames) > 0)
                                        <hr>
                                        <div class="row mt-2">
                                            <h5 class="mb-4 text-center center">Lista de jogos curtidos</h5>
                                        </div>
                                        <div class="row overflow-auto mb-3" style="max-height: 200px">
                                            @foreach($likedgames as $liked)
                                                <div class="col-3 mb-2">
                                                    <a href="/games/{{$liked->jogo->id}}" style="text-decoration: none;"
                                                       data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                       title="{{$liked->jogo->name}}">
                                                        <img src='{{ $liked->jogo->image }}' class="card-img-top"/>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="caption">
                            @if (Auth::id() != $user->id)
                                @if(isset($friendshipsReceived))
                                    @if(($friendshipsReceived->status == 'pending'))
                                        <div>
                                            <button class="btn" style="color: #F3821C;" type="button"
                                                    onclick="window.location='{{ url("users/accept/$user->id") }}'">
                                                <i class="fa fa-user-plus mr-2"></i>
                                                <span id="friendship-status-">
                                    Aceitar pedido de amizade
                                    </span>
                                            </button>
                                        </div>
                                    @endif
                                    @if(($friendshipsReceived->status == 'accepted'))
                                        <p>Já são amigos</p>
                                    @endif
                                @elseif($friendshipSend==null)
                                    <button class="btn" style="color: #F3821C;" type="button"
                                            onclick="window.location='{{ url("users/add/$user->id") }}'">
                                        <i class="fa fa-user-plus mr-2"></i>
                                        <span id="friendship-status">
                                    Enviar pedido de amizade
                                </span>
                                    </button>
                                @endif
                                @if(isset($friendshipsReceived))
                                    @if($friendshipsReceived->status == 'denied' and $friendshipSend == null)
                                        <button class="btn" style="color: #F3821C;" type="button"
                                                onclick="window.location='{{ url("users/add/$user->id") }}'">
                                            <i class="fa fa-user-plus mr-2"></i>
                                            <span id="friendship-status-">Enviar pedido de amizade</span>
                                        </button>
                                    @endif
                                @endif
                                @if(isset($friendshipSend))
                                    @if(($friendshipSend->status == 'pending'))
                                        Pedido de amizade pendente
                                    @elseif(($friendshipSend->status == 'accepted'))
                                        <p>Já são amigos</p>
                                    @elseif(($friendshipSend->status == 'denied' and $friendshipsReceived ==null))
                                        Pedido de amizade recusado
                                    @endif
                                @endif
                            @endif

                            @if ( Auth::id() == $user->id)
                                <div>
                                    @if($user->getFriendRequests()->count() < 1)
                                        <div class="card">
                                            <p>Não há pedidos de amizade pendentes</p>
                                        </div>
                                    @elseif($user->getFriendRequests()->count() >= 1)
                                        <div class="row mt-2">
                                            <h5 class="mb-4">Pedidos de amizade pendentes</h5>
                                            @foreach ($user->getFriendRequests() as $request)
                                                <div class="col overflow-auto mb-3">
                                                    <div
                                                        style="display: none">{{$sender_id = $request->sender->id}}</div>
                                                    <div class="card d-inline-flex" style="width:16rem;">
                                                        <a href="/users/{{$sender_id}}"
                                                           class="text-center center"><img
                                                                src="{{$request->sender->avatar}}"
                                                                alt="{{ URL::asset('image/default-user-image.png') }}"></a>

                                                        <button class="btn text-black shadow m-1" type="button"
                                                                style="background-color:#f3821c;"
                                                                onclick="window.location='{{ url("users/accept/$sender_id") }}'">
                                                            <span id="friendship-status-">Aceitar</span>
                                                        </button>
                                                        <button class="btn text-black shadow m-1" type="button"
                                                                style="background-color:#f3821c;"
                                                                onclick="window.location='{{ url("users/deny/$sender_id") }}'">
                                                            <span id="friendship-status-">Recusar</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                @if($user->getAcceptedFriendships()->count() >= 1)
                                    <h5 class="mb-4">Amigos</h5>
                                    <div class="row overflow-auto card" style="height: 50vh">
                                        @foreach($user->getAcceptedFriendships() as $friends)
                                            <div class="col">
                                                @if($friends->sender->name != $user->name)
                                                    <div class="card d-inline-flex" style="width:16rem;">
                                                        <a href="/users/{{$friends->sender->id}}">
                                                            <h5 class="text-center">{{$friends->sender->name}}</h5>
                                                            <img style="width:16rem" src="{{$friends->sender->avatar}}"
                                                                 alt="{{ URL::asset('image/default-user-image.png') }}">
                                                        </a>
                                                        <div
                                                            style="display: none">{{$friend_id = $friends->sender->id}}</div>
                                                        <button class="btn text-black shadow m-1" type="button"
                                                                style="background-color:#f3821c;"
                                                                onclick="window.location='{{ url("users/delete/$friend_id") }}'">
                                                            <span id="friendship-status-">Deletar amigo</span>
                                                        </button>
                                                    </div>
                                                @endif

                                                @if($friends->sender->name == $user->name)
                                                    <div class="card" style="width:16rem;">
                                                        <div style="display:
                                                            none">{{$friend_id = $friends->recipient->id}}>
                                                        </div>
                                                        <a href="/users/{{$friend_id}}"
                                                           class="text-center center">
                                                            <h5 class="text-center">{{$friends->recipient->name}}</h5>
                                                            <img style="width:16rem"
                                                                 src="{{$friends->recipient->avatar}}"
                                                                 alt="Perfil sem imagem">
                                                        </a>

                                                        <button class="btn text-black shadow m-1" type="button"
                                                                style="background-color:#f3821c;"
                                                                onclick="window.location='{{ url("users/delete/$friend_id") }}'">
                                                            <i class="fa fa-user-plus mr-2"></i>
                                                            <span id="friendship-status-">Deletar amigo</span>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="container-fluid">
                        <h1 class="display-10">Avaliações</h1>
                        <div>
                            @if(count($user->avaliacoes) == 0)
                                <h5 class="mb-4">Esse usuário não fez nenhuma avaliação</h5>
                            @else
                                <h5 class="mb-4">Avaliações recentes</h5>
                                @foreach($user->avaliacoes as $avaliacao)
                                    <hr>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <a href="/games/{{$avaliacao->jogo->id}}">
                                                <img alt="image" src="{{ $avaliacao->jogo->image }}" class="mr-3"
                                                     height="96"/>
                                            </a>
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

                                                    <a href="/games/{{$avaliacao->jogo->id}}">
                                                        <h6 class="mb-1 text-black">{{$avaliacao->jogo->name}}</h6>
                                                    </a>
                                                    <p class="text-gray very-small">
                                                        {{$avaliacao->updated_at->diffForHumans()}}
                                                    </p>
                                                </div>

                                                @if(auth()->user()->id == $avaliacao->user_id || auth()->user()->isAdmin())
                                                    <div>
                                                        <button style="cursor:pointer"
                                                                class="btn btn-danger btn-remover-avaliacao"
                                                                id="{{$avaliacao->id}}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                 height="16"
                                                                 fill="currentColor" class="bi bi-trash"
                                                                 viewBox="0 0 16 16">
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
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @elseif($user->hasBlocked(auth()->user()))
                    <div class="text-white text-center">
                        Você está bloqueado por este usuário.
                    </div>
                @endif
            </div>
        </div>
    </div>





@endsection
