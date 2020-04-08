<?php
function cadastrarMenu($dados) {
    $pdo = conectarBanco();
    try {
        $cadastrarmenu = $pdo->prepare("INSERT INTO menus (menus_nome, menus_slug, menus_link, menus_visivel)
                                                VALUES(?,?,?,?)");
        $cadastrarmenu->bindValue(1, $dados[1]);
        $cadastrarmenu->bindValue(2, $dados[2]);
        $cadastrarmenu->bindValue(3, $dados[3]);
        $cadastrarmenu->bindValue(4, $dados[4]);
        $cadastrarmenu->execute();

        if ($cadastrarmenu->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}