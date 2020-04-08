<?php

require_once "conexao.php";

set_include_path("inc/" . PATH_SEPARATOR . "../inc/" . PATH_SEPARATOR . "bibliotecas/" . PATH_SEPARATOR . "../bibliotecas/" . PATH_SEPARATOR .
        'functions/' . PATH_SEPARATOR . '../functions/' . PATH_SEPARATOR . "../../inc/" . PATH_SEPARATOR . "../../bibliotecas/");

$arquivos = array(
    'alterar' => array('comentario,cliente'),
    'busca' => array('busca'),
    'cadastrar' => array('comentario,newsletter,cliente'),
    'datas' => array('datas'),
    'locar'=>array('locar'),
    'deletar' => array('comentario,cliente'),
    'email' => array('email'),
    'selecionar' => array('selecionar'),
    'url' => array('url'),
    'validacoes' => array('validacoes'),
    'PHPmailer' => array('class.phpmailer'),
    'Pager' => array('Pager,Sliding'),
    'wide_image' => array('WideImage'),
    'logar'=>array('logar')
);

function carregarArquivos($pastas) {
    global $arquivos;
    $a = new ArrayIterator($arquivos);
    while ($a->valid()):
        if (in_array($a->key(), $pastas)):
            if (substr_count($arquivos[$a->key()][0], ",") > 0):
                $includes = explode(",", $arquivos[$a->key()][0]);
                foreach ($includes as $in):
                    require_once $a->key() . "/" . $in . ".php";
                endforeach;
            else:
                require_once $a->key() . "/" . $arquivos[$a->key()][0] . ".php";
            endif;
        endif;
        $a->next();
    endwhile;
}