<?php

function cadastrarAdministrador($nome, $login, $senha) {

    $pdo = conectarBanco();
    try {
        $cadastrarAdministrador = $pdo->prepare("INSERT INTO administradores (administradores_nome, administradores_login, administradores_senha)
                                                VALUES(:nome, :login, :senha)");
        $cadastrarAdministrador->bindValue(":nome", $nome);
        $cadastrarAdministrador->bindValue(":login", $login);
        $cadastrarAdministrador->bindValue(":senha", $senha);
        $cadastrarAdministrador->execute();

        if ($cadastrarAdministrador->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}