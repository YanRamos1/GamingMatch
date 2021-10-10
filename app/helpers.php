<?php

function gerarLinkFiltros($filtro, $valor, $exibicao)
{
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $currentURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    $path = parse_url($currentURL, PHP_URL_PATH);

    $link =  $protocol . $_SERVER['HTTP_HOST'] . $path . '?';
    foreach ($_GET as $key => $val) {
        if ($key != 'page')
            $link = $link . $key . '=' . $val . '&';
    }
    $link = $link . $filtro. '=' . $valor;
    echo '<a href="' . $link . '" class="list-group-item list-group-item-action">' . $exibicao . '</a>';
}

function gerarLinkRemoverFiltro($filtro)
{
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $currentURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    $path = parse_url($currentURL, PHP_URL_PATH);

    $link =  $protocol . $_SERVER['HTTP_HOST'] . $path . '?';
    foreach ($_GET as $key => $val) {
        if ($key != $filtro && $key != 'page')
            $link = $link . $key . '=' . $val . '&';
    }
    $link = substr($link, 0, -1);
    return '<a href="' . $link . '" class="close" style="text-decoration:none"><span aria-hidden="true">&times;</span></a>';
}

/**
 * funções para os links de ordenação
 */
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function obterTextoLinkOrdenacao($ordenacao)
{
    switch ($ordenacao) {
        case 'avaliacao':
            return 'Avaliação';
        case 'nome':
            return 'Nome';
        case 'novo':
            return 'Mais Novo';
        case 'antigo':
            return 'Mais Antigo';
        default:
            return 'Avaliação';
    }
}

function gerarLinkOrdenacao($ordenacao)
{
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $currentURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    $path = parse_url($currentURL, PHP_URL_PATH);

    $link =  $protocol . $_SERVER['HTTP_HOST'] . $path . '?';
    foreach ($_GET as $key => $val) {
        if ($key != 'order' && $key != 'page')
            $link = $link . $key . '=' . $val . '&';
    }
    $link = $link . 'order=' . $ordenacao;
    return '<a class="list-group-item list-group-item-action" href="' . $link . '" >' . obterTextoLinkOrdenacao($ordenacao) . '</a>';
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////