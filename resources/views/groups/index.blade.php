@extends('layouts.master')

@section('title','Comunidades')
<style>
    img.img1{
        width: 100%;
        height: 260px;
    }
</style>
@section('content')
    <div class="mx-auto  col-sm-3 col-md-9 col-xl-10">
        <div class="row">
            @foreach($groups as $group)
                <div class="col-sm-3 col-md-3">
                    <div style="border: 1px solid #f3821c;" class="card mb-4 shadow-sm ">
                        <a href="{{route('groups.show',$group->id)}}" style="text-decoration: none;">
                            <h5 class="card-title text-center">{{ $group->name }}</h5>
                            <img src='{{ $group->image}}' class="card-img-top rounded img1"  alt=""/>
                            <div class="card-body" style="padding-bottom: 0px !important;">
                                <p class="text-center">{{count($group->users)}} Membros</p>
                                <p class="text-center">{{count($group->posts)}} Postagens</p>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
