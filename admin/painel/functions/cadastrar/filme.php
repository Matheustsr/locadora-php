<?php

function cadastrarFilme(Array $dados) {

    $pdo = conectarBanco();
    try {
        $cadastrarFilme = $pdo->prepare("INSERT INTO filmes (filmes_categoria, filmes_nome, filmes_preco, filmes_slug, filmes_lancamento, filmes_recomendo, filmes_foto, filmes_foto_descricao, filmes_descricao, filmes_codigo)
                                                VALUES(?,?,?,?,?,?,?,?,?,?)");       
        
        foreach ($dados as $k => $v):
            $cadastrarFilme->bindValue($k, $v);
        endforeach;

        $cadastrarFilme->execute();

        if ($cadastrarFilme->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
