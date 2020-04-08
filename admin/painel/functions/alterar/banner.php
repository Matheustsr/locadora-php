<?php

function alterarABanner($banner, $id) {

    $pdo = conectarBanco();
    try {
        $alterarBanner = $pdo->prepare("UPDATE banners SET banners_caminho = ? WHERE banners_id = ?");
        $alterarBanner->bindValue(1, $banner);
        $alterarBanner->bindValue(2, $id);
        $alterarBanner->execute();

        if ($alterarBanner->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}