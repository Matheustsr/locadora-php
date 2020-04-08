<?php

function alterarNoticia($titulo, $slug, $noticia, $id) {
    $pdo = conectarBanco();
    try {
        $alterarNoticia = $pdo->prepare("UPDATE noticias SET noticias_titulo = ?, noticias_slug = ?, noticias_texto = ?
                                         WHERE noticias_id = ?");
        $alterarNoticia->bindValue(1, $titulo);
        $alterarNoticia->bindValue(2, $slug);
        $alterarNoticia->bindValue(3, $noticia);
        $alterarNoticia->bindValue(4, $id);
        $alterarNoticia->execute();

        if ($alterarNoticia->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}