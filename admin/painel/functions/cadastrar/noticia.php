<?php

function cadastrarNoticia($titulo, $slug, $noticia) {

    $pdo = conectarBanco();
    try {
        $cadastrarNoticia = $pdo->prepare("INSERT INTO noticias (noticias_titulo, noticias_slug, noticias_texto, noticias_data)
                                                VALUES(?,?,?,?)");
        $cadastrarNoticia->bindValue(1, $titulo,PDO::PARAM_STR);
        $cadastrarNoticia->bindValue(2, $slug,PDO::PARAM_STR);
        $cadastrarNoticia->bindValue(3, $noticia,PDO::PARAM_STR);
        $cadastrarNoticia->bindValue(4, date("Y-m-d"));
        $cadastrarNoticia->execute();

        if ($cadastrarNoticia->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}