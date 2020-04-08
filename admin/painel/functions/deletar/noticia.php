<?php
function deletarNoticia($id) {

    $pdo = conectarBanco();
    try {
        $deletarNoticia = $pdo->prepare("DELETE FROM noticias WHERE noticias_id = :id");
        $deletarNoticia->bindValue(":id", $id);
        $deletarNoticia->execute();

        if ($deletarNoticia->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}