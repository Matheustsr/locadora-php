<?php

function alterarComentario($comentario, $id) {

    $pdo = conectarBanco();
    try {

        $alterarComentario = $pdo->prepare('update comentarios set comentarios_texto = ? where comentarios_id = ?');

        $alterarComentario->bindValue(1, $comentario);
        $alterarComentario->bindValue(2, $id);
        $alterarComentario->execute();
        return ($alterarComentario->rowCount() == 1) ? true : false;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
