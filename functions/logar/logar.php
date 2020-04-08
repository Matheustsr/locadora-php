<?php

function logar($login, $senha) {

    $pdo = conectarBanco();
    try {
        $logar = $pdo->prepare('select * from clientes where clientes_login = ? and clientes_senha = ?');
        $logar->bindValue(1, $login);
        $logar->bindValue(2, md5($senha));
        $logar->execute();

        if ($logar->rowCount() == 1):
            $dadosLogin = $logar->fetch(PDO::FETCH_OBJ);
            $_SESSION['logado_cliente'] = true;
            $_SESSION['nome_cliente'] = $dadosLogin->clientes_nome;
            $_SESSION['email_cliente'] = $dadosLogin->clientes_email;
            //$_SESSION['id'] = $dadosLogin->clientes_id;
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function logOut() {
    if (isset($_SESSION['logado_cliente']) AND isset($_SESSION['nome_cliente'])):
        unset($_SESSION['logado_cliente']);
        unset($_SESSION['nome_cliente']);
        session_destroy();
        return true;
    endif;
}