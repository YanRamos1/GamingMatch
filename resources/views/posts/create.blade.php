@extends('layouts.master')

@section('title','Criar postagem')

@section('content')
    <h1>Create Post</h1>
    <form class="container card" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Título">
        </div>
        <div class="form-group">
            <label for="body">Corpo</label>
            <textarea name="body" id="body" cols="30" rows="10" class="form-control" placeholder=""></textarea>
        </div>
        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
        <input type="hidden" name="group_id" value="{{$id}}">
        <input class="form-control" id="image" name="image" type="file" placeholder="Selecionar Arquivo">
        <button type="submit" class="btn btn-primary">Criar</button>
    </form>
@endsection
