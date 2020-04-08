<?php

function deletarComentario($id) {

    $pdo = conectarBanco();
    try {
        $deletarComentario = $pdo->prepare('delete from comentarios where comentarios_id = ?');

        $deletarComentario->bindValue(1, $id);
        $deletarComentario->execute();
        return ($deletarComentario->rowCount() == 1) ? true : false;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}