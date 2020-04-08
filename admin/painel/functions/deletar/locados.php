<?php

function deletarLocados($id) {
    $pdo = conectarBanco();
    try {
        $deletar = $pdo->prepare("delete from locados where locados_id = :id");
        $deletar->bindValue(":id", $id);
        $deletar->execute();
        if ($deletar->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function deletarFilmeLocado() {
    $pdo = conectarBanco();
    try {
        $verifica = $pdo->prepare("SELECT * FROM locados WHERE locados_status = :status AND NOW() >= DATE_ADD(locados_devolucao, INTERVAL 1 DAY)");
        $verifica->bindValue(":status", "Devolvido");
        $verifica->execute();

        if ($verifica->rowCount() > 0):
            return $verifica->fetchAll(PDO::FETCH_OBJ);
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}