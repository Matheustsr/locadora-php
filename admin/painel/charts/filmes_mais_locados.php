<?php
require_once '../functions/functions.php';
carregarArquivos(array('datas'));
$mes = pegaMesAtual(date("m"));
$pdo = conectarBanco();
$maisLocados = $pdo->query("SELECT * FROM locacoes INNER JOIN meses INNER JOIN filmes ON locacoes.locacoes_mes = meses.meses_id AND locacoes.locacoes_filme = filmes.filmes_id WHERE meses_nome =  '$mes' ORDER BY locacoes_total DESC LIMIT 7");
echo json_encode($maisLocados->fetchAll(PDO::FETCH_ASSOC));