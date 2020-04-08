<?php

function cadastrarCategoria($dados) {
    $pdo = conectarBanco();
    try {
        $cadastrarcategoria = $pdo->prepare("INSERT INTO categorias (categorias_nome, categorias_slug, categorias_link, categorias_visivel)
                                                VALUES(?,?,?,?)");
        $cadastrarcategoria->bindValue(1, $dados[1]);
        $cadastrarcategoria->bindValue(2, $dados[2]);
        $cadastrarcategoria->bindValue(3, $dados[3]);
        $cadastrarcategoria->bindValue(4, $dados[4]);
        $cadastrarcategoria->execute();

        if ($cadastrarcategoria->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}