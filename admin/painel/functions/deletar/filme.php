<?php

function deletarFilme($id, $tabelas, $campos) {

    $pdo = conectarBanco();
    $pdo->beginTransaction();

    try {
        foreach ($tabelas as $k => $value):
        $deletarFilme = $pdo->prepare("DELETE FROM " . $value . " WHERE " . $campos[$k] . " = :id");
        $deletarFilme->bindValue(":id", $id);
        $deletarFilme->execute();
        endforeach;

        $pdo->commit();
        return true;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        $pdo->rollBack();
        return false;
    }
}