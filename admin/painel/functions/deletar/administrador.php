<?php

function deletarAdministrador($id) {

    $pdo = conectarBanco();
    try {
        $deletarAdministrador = $pdo->prepare("DELETE FROM administradores WHERE administradores_id = :id");
        $deletarAdministrador->bindValue(":id", $id);
        $deletarAdministrador->execute();

        if ($deletarAdministrador->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}