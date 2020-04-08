<?php
session_start();

require_once '../../functions/functions.php';
carregarArquivos(array('selecionar'));

$idCliente = pegarPeloId('clientes', 'clientes_nome', $_SESSION['nome_cliente']);
$comentariosCliente = listar("comentarios","INNER JOIN filmes ON comentarios.comentarios_filme = filmes_id WHERE comentarios_cliente = $idCliente->clientes_id");
echo json_encode($comentariosCliente);