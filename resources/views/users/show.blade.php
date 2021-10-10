@extends('layouts.master')

@section('title', $user->name)

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
        <div class="row">
            <div class="col-12">
                @if($user->isBlocked())
                    <h1>[Bloqueado]</h1>
                @else
                    <h1>{{$user->name}}</h1>
                @endif
            </div>
        </div>
        <div class="p-2 p-sm-5 mb-4 jumbotron rounded-3">
            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="row">
                        <div style="display: inline-block;">
                            @if($user->isBlocked())
                                <img src="{{ URL::asset('image/default-user-image.png') }}"
                                     class="card-img-top col-lg-12 rounded-pill">
                            @else
                                @if(is_null($user->avatar))
                                    <img src="{{ URL::asset('image/default-user-image.png') }}" class="img-fluid">
                                @else
                                    <img src="{{$user->avatar}}" alt="{{ URL::asset('image/default-user-image.png') }}"
                                         class="img-fluid">
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
                                            <svg style="color: #28a745;" xmlns="http://www.w3.org/2000/svg" width="16"
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
                                            <svg style="color: #28a745;" xmlns="http://www.w3.org/2000/svg" width="16"
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
                                            <svg style="color: #28a745;" xmlns="http://www.w3.org/2000/svg" width="16"
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
                                            <svg style="color: #28a745;" xmlns="http://www.w3.org/2000/svg" width="16"
                                                 height="16" fill="currentColor" class="bi bi-twitch"
                                                 viewBox="0 0 16 16">
                                                <path
                                                    d="M3.857 0 1 2.857v10.286h3.429V16l2.857-2.857H9.57L14.714 8V0H3.857zm9.714 7.429-2.285 2.285H9l-2 2v-2H4.429V1.143h9.142v6.286z"/>
                                                <path
                                                    d="M11.857 3.143h-1.143V6.57h1.143V3.143zm-3.143 0H7.571V6.57h1.143V3.143z"/>
                                            </svg>
                                            </span>
                                            {{$user->twitch}}
                                        </a>
                                    </div>
                                @endif

                                @if(count($wishlist) > 0)
                                    <hr>
                                    <div class="row mt-2">
                                        <h5 class="mb-4">Lista de Desejos</h5>
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

                            @endif
                        </div>
                    </div>
                </div>
                <div>
                    <div class="caption">
                            @if ( Auth::id() != $user->id)
                            <button wire:click="addToFriend({{ $user->id }})" type="button"
                                    class="btn btn-sm btn-success js_friend-add">
                                <i class="fa fa-user-plus mr-2"></i>
                                <span id="friendship-status-{{$user->id}}">
                                    Add Friend
                                </span>
                            </button>
                            @endif
                    </div>
                </div>
                <div class="col-12 col-sm-8">
                    <h1 class="display-5">Avaliações</h1>
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
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
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
            </div>
        </div>
    </div>

@endsection
