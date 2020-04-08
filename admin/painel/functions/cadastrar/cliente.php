<?php

function cadastrarCliente(Array $dados) {

    $pdo = conectarBanco();
    try {
        $cadastrarCliente = $pdo->prepare("INSERT INTO clientes (clientes_nome, clientes_email, clientes_cidade, clientes_telefone, clientes_celular, clientes_cpf, clientes_newsletter, clientes_foto, clientes_foto_detalhes, clientes_login, clientes_senha)
                                                VALUES(:nome, :email, :cidade, :telefone, :celular, :cpf, :newsletter, :foto, :fotoDetalhes, :login, :senha)");
        foreach ($dados as $k => $v):
            $cadastrarCliente->bindValue(":$k", $v);
        endforeach;

        $cadastrarCliente->execute();

        if ($cadastrarCliente->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
