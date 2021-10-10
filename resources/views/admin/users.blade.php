@extends('layouts.master')

@section('title','Usuários')

@push('scripts')
<script>
    $(".buscar").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $(".btn-demote-user").click(function(event) {
        event.preventDefault();
        if (confirm('Você realmente deseja rebaixar esse acesso para USER?')) {
            var id = $(this).attr('id');

            $.ajax({
                url: "/admin/users/demote",
                type: "PUT",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                },
                success: function(response) {
                    window.location.href = "users";
                },
                error: function(reject) {
                    new BsToast({
                        title: 'Ocorreu um erro',
                        content: 'Ocorreu um erro ao tentar rebaixar o acesso do usuário.',
                        type: 'danger',
                        pause_on_hover: true,
                        delay: 5000,
                        position: 'top-right',
                        icon: '<i class="fas fa-home"></i>'
                    });
                }
            });
        }
    });

    $(".btn-promote-user").click(function(event) {
        event.preventDefault();
        if (confirm('Você realmente deseja promover esse usuário para ADMIN?')) {
            var id = $(this).attr('id');

            $.ajax({
                url: "/admin/users/promote",
                type: "PUT",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                },
                success: function(response) {
                    window.location.href = "users";
                },
                error: function(reject) {
                    new BsToast({
                        title: 'Ocorreu um erro',
                        content: 'Ocorreu um erro ao tentar promover o acesso do usuário.',
                        type: 'danger',
                        pause_on_hover: true,
                        delay: 5000,
                        position: 'top-right',
                        icon: '<i class="fas fa-home"></i>'
                    });
                }
            });
        }
    });

    $(".btn-block-user").click(function(event) {
        event.preventDefault();
        if (confirm('Você realmente deseja remover esse acesso?')) {
            var id = $(this).attr('id');

            $.ajax({
                url: "/admin/users",
                type: "DELETE",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                },
                success: function(response) {
                    window.location.href = "users";
                },
                error: function(reject) {
                    new BsToast({
                        title: 'Ocorreu um erro',
                        content: 'Ocorreu um erro ao tentar remover o acesso do usuário.',
                        type: 'danger',
                        pause_on_hover: true,
                        delay: 5000,
                        position: 'top-right',
                        icon: '<i class="fas fa-home"></i>'
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
            <h1>Usuários</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-group mb-3">
                <input type="text" class="form-control buscar" id="buscar" type="text" placeholder="Buscar Usuário" aria-label="Buscar Usuário">
                <div class="input-group-append">
                    <button class="btn btn-success" type="submit" id="btn-buscar">Buscar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive-sm w-100">
            <table class="table table-dark table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Email</th>
                        <th scope="col">Último Acesso</th>
                        <th scope="col">Nível</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="tbody">
                    @foreach($users as $user)
                    <tr <?php
                        if ($user->blocked != 0) echo 'class = "table-danger"'
                        ?>>
                        <a style="cursor:pointer" href="/users/{{$user->id}}">
                            <th scope="row">{{$user -> id}}</th>
                            <td>
                                <a href="/users/{{$user->id}}">
                                    {{$user -> name}}
                                </a>
                            </td>
                            <td> {{$user -> email}} </td>
                            <td>
                                <?php
                                if (!is_null($user->last_access_at))
                                    echo Carbon\Carbon::parse($user->last_access_at)->diffForHumans();
                                ?>
                            </td>
                            <td> {{$user -> nivel -> name}} </td>
                            <td class="text-center">
                                @if($user->isAdmin())
                                <button style="cursor:pointer" class="btn btn-success btn-demote-user" id="{{$user->id}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-frown" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z" />
                                    </svg>
                                </button>
                                @else
                                <button style="cursor:pointer" class="btn btn-success btn-promote-user" id="{{$user->id}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-award" viewBox="0 0 16 16">
                                        <path d="M9.669.864 8 0 6.331.864l-1.858.282-.842 1.68-1.337 1.32L2.6 6l-.306 1.854 1.337 1.32.842 1.68 1.858.282L8 12l1.669-.864 1.858-.282.842-1.68 1.337-1.32L13.4 6l.306-1.854-1.337-1.32-.842-1.68L9.669.864zm1.196 1.193.684 1.365 1.086 1.072L12.387 6l.248 1.506-1.086 1.072-.684 1.365-1.51.229L8 10.874l-1.355-.702-1.51-.229-.684-1.365-1.086-1.072L3.614 6l-.25-1.506 1.087-1.072.684-1.365 1.51-.229L8 1.126l1.356.702 1.509.229z" />
                                        <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z" />
                                    </svg>
                                </button>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($user->blocked == 0)
                                <button style="cursor:pointer" class="btn btn-danger btn-block-user" id="{{$user->id}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                    </svg>
                                </button>
                                @endif
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection