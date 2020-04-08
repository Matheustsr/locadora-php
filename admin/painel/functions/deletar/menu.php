<?php

function deletarMenu($id) {
    $pdo = conectarBanco();
    try {
        $deletarMenu = $pdo->prepare("DELETE FROM menus WHERE menus_id = :id");
        $deletarMenu->bindValue(":id", $id);
        $deletarMenu->execute();

        if ($deletarMenu->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}