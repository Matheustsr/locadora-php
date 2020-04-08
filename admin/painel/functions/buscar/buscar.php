<?php

function buscar($tabela, $campo, $buscar_filme, $filtro = null) {
    $pdo = conectarBanco();

    try {

        if (is_null($filtro)):
            $busca = $pdo->prepare("SELECT * FROM $tabela WHERE $campo LIKE :busca");
        else:
            $busca = $pdo->prepare("SELECT * FROM $tabela $filtro WHERE $campo LIKE :busca");
        endif;

        $busca->bindValue(":busca", "%" . $buscar_filme . "%");
        $busca->execute();

        if ($busca->rowCount() > 0):
            return $busca->fetchAll(PDO::FETCH_OBJ);
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}