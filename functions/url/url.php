<?php

function carregarPagina($url) {

    set_include_path('inc/' . PATH_SEPARATOR . '../inc/' . PATH_SEPARATOR . 'modulos/cadastrar/' . PATH_SEPARATOR . 'modulos/alterar/'.PATH_SEPARATOR . 'modulos/excluir/');
    $diretorios = array('inc/', 'modulos/alterar/', 'modulos/cadastrar/','modulos/excluir/');

    if (substr_count($url, '/') > 0):
        $pagina = explode('/', $url);
        $total = count($pagina);
        $total_dir = count($diretorios);

        for ($i = 0; $i < $total; $i++):
            for ($j = 0; $j < $total_dir; $j++):
                if (is_file($diretorios[$j] . $pagina[$i] . ".php")):
                    require_once $pagina[$i] . ".php";
                endif;
            endfor;
        endfor;
    else:
        if (is_file("inc/" . $url . ".php")):
            require_once "inc/" . $url . ".php";
        else:
            require_once "inc/principal.php";
        endif;
    endif;
}

function segmento_url($url, $segmento) {
    $explode = explode('/', $url);
    return $explode[$segmento - 1];
}