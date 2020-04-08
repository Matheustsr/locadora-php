<?php
session_start();

require_once '../../functions/functions.php';
carregarArquivos(array('selecionar'));

$dados = listar("comentarios", "INNER JOIN filmes ON comentarios.comentarios_filme = filmes_id WHERE comentarios_cliente = 13");
echo json_encode($dados);