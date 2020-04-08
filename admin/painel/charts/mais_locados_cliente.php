<?php
session_start();
require_once '../functions/functions.php';
carregarArquivos(array('datas'));
$mes = pegaMesAtual(date("m"));
$pdo = conectarBanco();
$maisLocados = $pdo->query("SELECT * FROM locacoes_cliente INNER JOIN clientes INNER JOIN filmes INNER JOIN meses 
ON locacoes_cliente.locacoes_cliente_nome = clientes.clientes_id
AND locacoes_cliente.locacoes_cliente_filme = filmes.filmes_id
AND locacoes_cliente.locacoes_cliente_mes = meses.meses_id 
WHERE meses_nome =  '$mes' AND locacoes_cliente_nome = {$_SESSION['idCliente']} ORDER BY locacoes_cliente_total DESC LIMIT 6");
echo json_encode($maisLocados->fetchAll(PDO::FETCH_ASSOC));