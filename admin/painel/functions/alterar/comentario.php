<?php
function aprovarComentario($aprovar, $id) {
        $pdo = conectarBanco();
        try {
            $aprovarComentario = $pdo->prepare("UPDATE comentarios SET comentarios_aprovado = ? WHERE comentarios_id = ?");
            $aprovarComentario->bindValue(1, $aprovar);
            $aprovarComentario->bindValue(2, $id);
            $aprovarComentario->execute();

            if ($aprovarComentario->rowCount() == 1):
                return true;
            else:
                return false;
            endif;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
}