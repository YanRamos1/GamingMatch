@extends('layouts.master')
<script src="https://kit.fontawesome.com/f7a428fdfe.js" crossorigin="anonymous"></script>
@section('title', $group->name)

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<script src="https://kit.fontawesome.com/f7a428fdfe.js" crossorigin="anonymous"></script>

@section('content')
    <!--posts page -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="">
                    @if($user != null)
                        @if(!$group->contains(Auth::user()))
                            <button class="btn btn-laranja m-1" type="button"
                                    onclick="window.location='{{ route('groups.addUser',$group->id)}}'">
                                <i class="fas"></i>
                                Entrar no grupo
                            </button>
                        @elseif($group->contains(Auth::user()))
                            <button class="btn btn-laranja m-1" type="button"
                                    onclick="window.location='{{route('groups.removeUser',$group->id) }}'">
                                <i class="fas"></i>
                                Sair do grupo
                            </button>
                        @endif
                    @endif
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center">
                    <div class="section-title">
                        <h2>Postagens da comunidade</h2>
                        <image class="img-responsive" src="{{$group->image}}"></image>

                    </div>
                    {{$group->created_at->diffForHumans()}}
                </div>
                <div class="col-lg-7 text-center">
                    <!--small modal with users-->
                    @if($group->users->count() > 0)
                        <button class="btn btn-laranja m-2 p-1" data-toggle="modal" data-target="#myModal">
                            <i class="fa fa-users"></i>
                            Membros da comunidade
                        </button>
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog" style="height:50vh; width:50vh;">
                                <div class="modal-content card">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Membros da comunidade</h4>
                                    </div>
                                    <div class="modal-body" style="overflow-y: auto">
                                        <div class="">
                                            @foreach($group->users as $user)
                                                <div class="card my-3 bordalaranja">
                                                    <a href='{{route('users.show',$user->id)}}'>
                                                        <p class="">{{$user->name}}</p>
                                                        <img src="{{$user->avatar}}"
                                                             class="img-responsive img-circle rounded-circle bordalaranja"
                                                             style="width:5rem; height:5rem" alt="">
                                                    </a>
                                                    <p class="">
                                                        Seguidores: {{$user->followers()->count()}}</p>
                                                    <p class="">
                                                        Amigos: {{$user->getAcceptedFriendships()->count()}}</p>

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-laranja" data-dismiss="modal">Fechar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else

                        <div class="section-title">
                            <h2>Ainda não há membros neste grupo</h2>
                        </div>

                    @endif
                </div>


                <div class="container row">
                    @if(isset($posts))
                        @foreach($posts as $post)
                            <div class="justify-content p-2 m-3 container-fluid">
                                <div class="container-fluid card row">
                                    <div class="blog-grid mx-auto">
                                        <h2 class="text-center mx-auto card-header"><a
                                                href="{{route('posts.show', $post->id)}}">{{$post->title}}</a>
                                        </h2>

                                        <!--image profile on left side -->
                                        <div class="blog-img">
                                            <div class="">
                                                @if(isset($post->image))
                                                    <img class="img-responsive" src="{{$post->image}}">
                                                @else
                                                    <img class="img-responsive"
                                                         src="https://via.placeholder.com/350x280/FFB6C1/000000">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="blog-info">
                                            <div class="date">{{$post->created_at->diffForHumans()}}</div>
                                            <h3 class="text ">{{$post->body}}</h3>
                                            <div class="blog-meta">
                                                <i class="fas fa-comments"></i>{{$post->comments->count()}}
                                            @if(Auth::check())
                                                <!--buttons toggle like buttons-->
                                                    @if(!$post->isVotedBy($user))
                                                        <a href="{{route('posts.upvote',$post->id)}}">
                                                            <button class="btn" style="color: #F3821C;">
                                                                <i class="fa fa-thumbs-up"
                                                                   style="color:white">{{$post->upvotersCount()}}</i>
                                                            </button>
                                                        </a>
                                                        <a href="{{route('posts.downvote',$post->id)}}">
                                                            <button class="btn" style="color: #F3821C;">
                                                                <i class="fa fa-thumbs-down"
                                                                   style="color:white">{{$post->downvotersCount()}}</i>
                                                            </button>
                                                        </a>
                                                    @elseif(!$user->hasUpvoted($post))
                                                        <a href="{{route('posts.upvote',$post->id)}}">
                                                            <button class="btn" style="color: #F3821C;">
                                                                <i class="fa fa-thumbs-up"
                                                                   style="color: white;">{{$post->upvotersCount()}}</i>
                                                            </button>
                                                        </a>
                                                        <a href="{{route('posts.cancelvote',$post->id)}}">
                                                            <button class="btn" style="color: #F3821C;">
                                                                <i class="fa fa-thumbs-down"> {{$post->downvotersCount()}}</i>
                                                            </button>
                                                        </a>
                                                    @elseif(!$user->hasDownvoted($post))
                                                        <a href="{{route('posts.cancelvote',$post->id)}}">
                                                            <button class="btn" style="color: #F3821C;">
                                                                <i class="fa fa-thumbs-up">{{$post->upvotersCount()}}</i>
                                                            </button>
                                                        </a>
                                                        <a href="{{route('posts.downvote',$post->id)}}">
                                                            <button class="btn" style="color: #F3821C;">
                                                                <i class="fa fa-thumbs-down "
                                                                   style="color: white;"> {{$post->downvotersCount()}}</i>
                                                            </button>
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="col-md-3 pull-left m-3 p-2 card">
                                                <!-- card inline-->
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <img src="{{$post->user->avatar}}"
                                                             class="img-responsive img-circle rounded-circle bordalaranja"
                                                             style="width:5rem; height:5rem" alt="">
                                                    </div>
                                                    <div class="col-md-10 justify-content-start text-center">
                                                        <p class="">
                                                            <a href="{{route('users.show',$user->id)}}">
                                                                <strong
                                                                    class="text-center mx-auto">{{$post->user->name}}</strong>
                                                            </a>
                                                        </p>
                                                        <div class="mx-auto">
                                                            <div class="d-inline">
                                                                <i class="fas fa-heart"></i>
                                                                {{$user->followers()->count()}}
                                                            </div>
                                                            <div class="d-inline">
                                                                <i class="fas fa-user-friends"></i>
                                                                {{$user->getAcceptedFriendships()->count()}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-6 p-2">
                                                <a href="{{route('posts.show',$post->id)}}"
                                                   class="btn  btn-laranja">
                                                    <i class="fa fa-eye"></i>
                                                    Ver
                                                </a>
                                            </div>
                                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-6 p-2">
                                                @if(Auth::check())
                                                    @if($post->user_id == Auth::user()->id or Auth::user()->role_id == 1)
                                                        <a href="{{route('posts.edit',$post->id)}}"
                                                           class="btn  btn-laranja">
                                                            <i class="fa fa-pencil"></i>
                                                            Editar
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="col-lg-4 col-md-2 col-sm-2 col-xs-6 p-2">
                                                @if(Auth::check())
                                                    @if($post->user_id == Auth::user()->id or Auth::user()->role_id == 1)
                                                        <a href="{{route('posts.destroy',$post->id)}}"
                                                           class="btn  btn-laranja">
                                                            <i class="fas fa-trash"></i>
                                                            Deletar
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h1 class="text-center text-white">Sem Postagens ainda</h1>
                    @endif
                    @if(Auth::check())
                        @if($group->contains(Auth::user()))
                            <div class="container mx-auto">
                                <a class="btn  btn-laranja" href="{{route('posts.create',$group->id)}}">Criar
                                    nova
                                    postagem</a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
