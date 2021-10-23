@extends('layouts.master')

@section('title','News')
<style>
    img.img1{
        width: 100%;
        height: 260px;
    }
</style>
@section('content')
    <div class="mx-auto  col-sm-3 col-md-9 col-xl-10">
        <div class="row">
            @foreach($news as $new)
                <div class="col-sm-3 col-md-4">
                    <div style="border: 1px solid #f3821c;" class="card mb-4 shadow-sm w-100">
                        <a href="{{$new->url}}" style="text-decoration: none;">
                            <img src='{{ $new->urlToImage}}' class="card-img-top rounded img1" />
                            <div class="card-body" style="height: 95px;padding-bottom: 0px !important;">
                                <h5 class="card-title text-center">{{ $new->title }}</h5>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
