<?php

function deletarCliente($id) {

    $pdo = conectarBanco();
    $pdo->beginTransaction();

    try {
        $deletarCliente = $pdo->prepare("DELETE FROM clientes WHERE clientes_id = :id");
        $deletarCliente->bindValue(":id", $id);
        $deletarCliente->execute();

        if ($deletarCliente->rowCount() == 1):
            $deletarLocacoesCliente = $pdo->prepare("DELETE FROM locacoes_cliente WHERE locacoes_cliente_nome = :id");
            $deletarLocacoesCliente->bindValue(":id", $id);
            $deletarLocacoesCliente->execute();
        endif;

        $pdo->commit();
        return true;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        $pdo->rollBack();
        return false;
    }
}