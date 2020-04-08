<?php

function busca($busca) {

    $pdo = conectarBanco();
    try {
        $buscar = $pdo->prepare("SELECT * FROM filmes WHERE filmes_nome LIKE ? order by filmes_nome asc");
        $buscar->bindValue(1, "%".$busca."%");
        $buscar->execute();
        return $buscar->fetchAll(PDO::FETCH_OBJ);
        
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}