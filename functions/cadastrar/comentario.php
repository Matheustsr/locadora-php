<?php

function cadastrarComentario($dados) {

    $pdo = conectarBanco();
    try {

        $cadastrarComentario = $pdo->prepare('insert into comentarios(comentarios_cliente, comentarios_filme, comentarios_data, comentarios_texto, comentarios_aprovado)
                                             VALUES(?,?,?,?,?)');

        $cadastrarComentario->bindValue(1, $dados[0]);
        $cadastrarComentario->bindValue(2, $dados[1]);
        $cadastrarComentario->bindValue(3, date('Y-m-d H:i:s'));
        $cadastrarComentario->bindValue(4, $dados[2]);
        $cadastrarComentario->bindValue(5, 2);
        $cadastrarComentario->execute();
        return ($cadastrarComentario->rowCount() == 1) ? true : false;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
