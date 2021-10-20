@extends('layouts.master')

@section('title','News')

@section('content')

    <h2 class="mt-5 text-center d-block text-gray-300 uppercase tracking-wide font-semibold">Notícias</h2>
    <div class="grid col-3 grid-column-3">
        @foreach($news as $gaa)
            <div class="ripple shadow-1-strong my-3 rounded" style="border: 1px solid #f3821c; width:30rem;">
                <div class="text-white rounded-lg">
                    <div class="">
                        <a href="{{$gaa->url}}">
                            <img class="rounded p-2 hover:opacity-50 fill shadow-lg transition ease-in-out duration-10 img-responsive img-fluid"
                                 data-mdb-ripple-color="light"  src="{{$gaa->urlToImage}}" alt="Card image cap">
                        </a>
                    </div>
                    <div class="card-body mx-auto">
                        <a href="{{$gaa->url}}">
                            <h5 class="card-title text-white center text-center mb-3">{{$gaa->title}}</h5>
                        </a>
                        <h2>{{ \Carbon\Carbon::parse($gaa->publishedAt)->format('d/m/Y') }}</h2>
                        <p class="h4 card-text">{{$gaa->source->name}}</p>
                        <p class="card-text">{{$gaa->description}}</p>
                        <p class="h5 mt-4 card-text">Autor:</p>
                        <p class="card-text">{{$gaa->author}}</p>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
