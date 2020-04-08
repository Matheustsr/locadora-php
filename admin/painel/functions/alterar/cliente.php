<?php

function alterarCliente(Array $dados, $id) {

    $pdo = conectarBanco();
    try {
        $alterarCliente = $pdo->prepare("UPDATE clientes SET clientes_nome = :nome, 
                                                                    clientes_email = :email, 
                                                                    clientes_cidade = :cidade,
                                                                    clientes_telefone = :telefone,
                                                                    clientes_celular = :celular,
                                                                    clientes_cpf = :cpf,
                                                                    clientes_newsletter = :newsletter,
                                                                    clientes_foto = :foto,
                                                                    clientes_foto_detalhes = :fotosDetalhes,
                                                                    clientes_login = :login,
                                                                    clientes_senha = :senha
                                         WHERE clientes_id = :id");

        foreach ($dados as $k => $v):
            $alterarCliente->bindValue(":$k", $v);
        endforeach;
        $alterarCliente->bindValue(":id", $id);
        $alterarCliente->execute();

        if ($alterarCliente->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}