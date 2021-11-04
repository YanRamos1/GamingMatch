@extends('layouts.master')
<script src="https://kit.fontawesome.com/f7a428fdfe.js" crossorigin="anonymous"></script>
@section('title', $post->title)

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<script src="https://kit.fontawesome.com/f7a428fdfe.js" crossorigin="anonymous"></script>

@section('content')
    @comments(['model' => $post])
@endsection
