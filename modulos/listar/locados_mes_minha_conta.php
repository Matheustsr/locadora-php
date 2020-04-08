<?php
session_start();

require_once '../../functions/functions.php';
carregarArquivos(array('selecionar'));

$idCliente = pegarPeloId('clientes', 'clientes_nome', $_SESSION['nome_cliente']);
$filmes_locados = listar("locacoes_cliente", "INNER JOIN filmes ON locacoes_cliente.locacoes_cliente_filme = filmes.filmes_id WHERE locacoes_cliente_nome = $idCliente->clientes_id AND locacoes_cliente_mes = " . substr(date('m'), 1).' order by locacoes_cliente_total DESC ');
echo json_encode($filmes_locados);