<?php
function cadastrarBanner($dados) {

    $pdo = conectarBanco();
    try {
        $cadastrarBanner = $pdo->prepare("INSERT INTO banners (banners_slug, banners_filme, banners_caminho)
                                                VALUES(?,?,?)");
        $cadastrarBanner->bindValue(1, $dados[0]);
        $cadastrarBanner->bindValue(2, $dados[1]);
        $cadastrarBanner->bindValue(3, $dados[2]);
        $cadastrarBanner->execute();
 
        if ($cadastrarBanner->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}