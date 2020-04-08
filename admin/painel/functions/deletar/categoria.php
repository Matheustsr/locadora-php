<?php
function deletarcategoria($id) {

    $pdo = conectarBanco();
    try {
        $deletarcategoria = $pdo->prepare("DELETE FROM categorias WHERE categorias_id = :id");
        $deletarcategoria->bindValue(":id", $id);
        $deletarcategoria->execute();

        if ($deletarcategoria->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}