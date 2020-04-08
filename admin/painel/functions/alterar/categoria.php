<?php

function alterarCategoria($dados) {

    $pdo = conectarBanco();
    try {
        $alterarcategoria = $pdo->prepare("UPDATE categorias SET categorias_nome = ?, categorias_slug = ?, categorias_link = ?, categorias_visivel = ?
                                            WHERE categorias_id = ?");
        $c = new ArrayIterator($dados);
        while ($c->valid()):
            $alterarcategoria->bindValue($c->key(), $c->current());
            $c->next();
        endwhile;
        $alterarcategoria->execute();

        if ($alterarcategoria->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function alterarStatusLink($status, $id) {
    $pdo = conectarBanco();
    try {
        $alterarcategoria = $pdo->prepare("UPDATE categorias SET categorias_visivel = ? WHERE categorias_id = ?");
        $alterarcategoria->bindValue(1, $status);
        $alterarcategoria->bindValue(2, $id);
        $alterarcategoria->execute();

        if ($alterarcategoria->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}