<?php

function alterarStatusLinkMenu($status, $id) {
    $pdo = conectarBanco();
    try {
        $alterarmenu = $pdo->prepare("UPDATE menus SET menus_visivel = ? WHERE menus_id = ?");
        $alterarmenu->bindValue(1, $status);
        $alterarmenu->bindValue(2, $id);
        $alterarmenu->execute();

        if ($alterarmenu->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function alterarMenu($dados) {
    $pdo = conectarBanco();
    try {
        $alterarmenu = $pdo->prepare("UPDATE menus SET menus_nome = ?, menus_slug = ?, menus_link = ? WHERE menus_id = ?");
        $alterarmenu->bindValue(1, $dados[1]);
        $alterarmenu->bindValue(2, $dados[2]);
        $alterarmenu->bindValue(3, $dados[3]);
        $alterarmenu->bindValue(4, $dados[4]);
        $alterarmenu->execute();

        if ($alterarmenu->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

