@extends('layouts.master')

@section('title','Novo Jogo')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Buscar Usuários</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form method="GET" action="/users">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="query" placeholder="Buscar Usuários"
                               aria-label="Buscar Usuários" required>
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit" id="btn-buscar">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if(array_key_exists('query', $_GET))
            <div class="p-2 mb-4 jumbotron rounded-3">
                <div class="row">
                    @if(count($users) > 0)

                        @if(count($users) == 1)
                            <div class="col-12">
                                <p>Exibindo {{count($users)}} usuário.</p>
                            </div>
                        @else
                            <div class="col-12">
                                <p>Exibindo {{count($users)}} usuários.</p>
                            </div>
                        @endif

                    @elseif(array_key_exists('query', $_GET))
                        <div class="col-12">
                            <p>Não foram encontrados usuários para a busca <strong>{{$_GET['query']}}.</strong></p>
                        </div>
                    @else
                        <div class="col-12">
                            <p>O resultado da busca aparecerá aqui.</p>
                        </div>
                    @endif
                </div>
            </div>


            <div class="col-12">
                <div class="row">
                    @foreach($users as $user)
                        <div class="col-xl-3 col-md-3 col-sm-6">
                            <div class="card mb-4 shadow-sm">
                                <a href="/users/{{$user->id}}" style="text-decoration: none;">
                                    @if(is_null($user->avatar))
                                        <img src="{{ URL::asset('https://www.kindpng.com/picc/m/24-248253_user-profile-default-image-png-clipart-png-download.png') }}"
                                             class="card-img-top">
                                    @else
                                        <img src="{{$user->avatar}}"
                                             alt="{{ URL::asset('https://www.kindpng.com/picc/m/24-248253_user-profile-default-image-png-clipart-png-download.png') }}"
                                             class="card-img-top">
                                    @endif
                                    <div class="card-body" style="padding-bottom: 0px !important;">
                                        <h5 class="card-title text-center">{{$user['name']}}</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
    </div>
    @endif
@endsection
