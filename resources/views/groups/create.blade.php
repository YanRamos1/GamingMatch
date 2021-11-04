@extends('layouts.master')

@section('title','Novo Jogo')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Cadastrar Jogo</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form method="GET" action="/games/search">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="query" placeholder="Buscar Novo Jogo" aria-label="Buscar Novo Jogo" required>
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit" id="btn-buscar">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if(array_key_exists('query', $_GET))
    <div class="p-2 p-sm-5 mb-4 jumbotron rounded-3">
        <div class="row">
            @if(count($games) > 0)
            <div class="col-12">
                <p>Exibindo {{count($games)}} jogos.</p>
            </div>
            <div class="col-12">
                @foreach($games as $game)
                <hr>
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <img src="{{$game['image']}}" width="128" class="mr-1" alt="...">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="d-flex">
                            <div class="me-auto">
                                <h6 class="mb-1 text-black">{{$game['name']}}</h6>
                                <p class="text-gray very-small">
                                    Lançado em:
                                    <?php
                                    $date = date_create($game['released_at']);
                                    echo date_format($date, "d/m/Y");
                                    ?>
                                </p>
                            </div>
                            <div>
                                <form method="POST" action="/games">
                                    {{ csrf_field() }}
                                    <input hidden value="{{$game['igdb_id']}}" name="jogo" />
                                    <button class="btn btn-primary" type="submit" id="btn-buscar">Cadastrar</button>
                                </form>
                            </div>
                        </div>
                        <p>{{$game['description']}}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @elseif(array_key_exists('query', $_GET))
            <div class="col-12">
                <p>Não foram encontrados jogos para a busca <strong>{{$_GET['query']}}.</strong></p>
            </div>
            @else
            <div class="col-12">
                <p>O resultado da busca aparecerá aqui.</p>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection