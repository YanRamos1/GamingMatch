<div class="row">

    <div class="card bg-filters shadow-sm mb-4 px-0">
        <button class="text-start btn bg-filters dropdown-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSort" aria-expanded="false" aria-controls="collapseSort">
            <span class="small"> Ordenação:
                @if(array_key_exists('order', $_GET))
                <?php
                echo obterTextoLinkOrdenacao($_GET['order']);
                ?>
                @else
                Avaliação
                @endif
            </span>
        </button>
        <div class="list-group-flush collapse" id="collapseSort">
            <?php
            echo gerarLinkOrdenacao('avaliacao');
            echo gerarLinkOrdenacao('nome');
            echo gerarLinkOrdenacao('novo');
            echo gerarLinkOrdenacao('antigo');
            ?>
        </div>
    </div>

    @if(array_key_exists('plataforma', $_GET))
    <div class="w-100 shadow-sm mb-4 card bg-filters card-header container-fluid">
        <div class="d-flex">
            <div class="flex-grow-1 text-truncate">
                <span class="small">Plataforma: {{ $platforms[array_search($_GET['plataforma'], array_column($platforms, 'id'))]['name'] }} </span>
            </div>
            <?php
            echo gerarLinkRemoverFiltro('plataforma');
            ?>
        </div>
    </div>
    @endif

    @if(array_key_exists('genero', $_GET))
    <div class="w-100 shadow-sm mb-4 card bg-filters card-header container-fluid">
        <div class="d-flex">
            <div class="flex-grow-1 text-truncate">
                <span class="small">Gênero: {{ $genres[array_search($_GET['genero'], array_column($genres, 'id'))]['name'] }} </span>
            </div>
            <?php
            echo gerarLinkRemoverFiltro('genero');
            ?>
        </div>
    </div>
    @endif

    @if(array_key_exists('ano', $_GET))
    <div class="w-100 shadow-sm mb-4 card bg-filters card-header container-fluid">
        <div class="d-flex">
            <div class="flex-grow-1 text-truncate">
                <span class="small">Ano de Lançamento: {{ $_GET['ano'] }} </span>
            </div>
            <?php
            echo gerarLinkRemoverFiltro('ano');
            ?>
        </div>
    </div>
    @endif

    @if(!array_key_exists('plataforma', $_GET))
    <div class="w-100 card mb-4">
        <div class="card-header bg-filters">
            <span class="small">Plataformas</span>
            <input class="form-control buscar-plataforma mt-2" id="buscar-plataforma" type="text" placeholder="Buscar">
        </div>
        <div class="list-group list-group-flush lista-plataforma" id="lista-plataforma">
            @foreach($platforms as $platform)
            <?php
            echo gerarLinkFiltros('plataforma', $platform['id'],  $platform['name']);
            ?>
            @endforeach
        </div>
    </div>
    @endif

    @if(!array_key_exists('genero', $_GET))
    <div class="w-100 card mb-4">
        <div class="card-header bg-filters">
            <span class="small">Gêneros</span>
            <input class="form-control buscar-genero mt-2" id="buscar-genero" type="text" placeholder="Buscar">
        </div>
        <div class="list-group list-group-flush lista-genero" id="lista-genero">
            @foreach($genres as $genre)
            <?php
            echo gerarLinkFiltros('genero', $genre['id'],  $genre['name']);
            ?>
            @endforeach
        </div>
    </div>
    @endif

    @if(!array_key_exists('ano', $_GET))
    <div class="w-100 card mb-4">
        <div class="card-header bg-filters">
            <span class="small">Ano de Lançamento</span>
            <input class="form-control buscar-ano mt-2" id="buscar-ano" type="text" placeholder="Buscar">
        </div>
        <div class="list-group list-group-flush lista-ano" id="lista-ano">
            @foreach($years as $year)
            <?php
            echo gerarLinkFiltros('ano', $year['year'],  $year['year']);
            ?>
            @endforeach
        </div>
    </div>
    @endif
</div>