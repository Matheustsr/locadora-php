<?php

function alterarAdministrador($nome, $login, $senha, $id) {

    $pdo = conectarBanco();
    try {
        $alterarAdministrador = $pdo->prepare("UPDATE administradores SET administradores_nome = :nome, administradores_login = :login, administradores_senha = :senha
                                                WHERE administradores_id = :id");
        $alterarAdministrador->bindValue(":nome", $nome);
        $alterarAdministrador->bindValue(":login", $login);
        $alterarAdministrador->bindValue(":senha", $senha);
        $alterarAdministrador->bindValue(":id", $id);
        $alterarAdministrador->execute();

        if ($alterarAdministrador->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}