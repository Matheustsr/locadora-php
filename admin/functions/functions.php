<?php

function logarSistema($login, $senha) {
    $pdo = conectarBanco();

    try {

        $logar = $pdo->prepare("SELECT * FROM administradores WHERE administradores_login = :login AND administradores_senha = :senha");
        $logar->bindValue(":login", $login);
        $logar->bindValue(":senha", $senha);
        $logar->execute();

        if ($logar->rowCount() == 1):
            
            $dados = $logar->fetch(PDO::FETCH_OBJ);
            $_SESSION['logado_admin'] = true;
            $_SESSION['nome_admin'] = $dados->administradores_nome;
                      
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function redirecionaLogado($painel){
    header("Location:$painel");
}