<?php

function deletarBanner($id) {

    $pdo = conectarBanco();
    try {
        $deletarBanner = $pdo->prepare("DELETE FROM banners WHERE banners_id = :id");
        $deletarBanner->bindValue(":id", $id);
        $deletarBanner->execute();

        if ($deletarBanner->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}