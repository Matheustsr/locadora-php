<?php

function alterarLocados($dataLocado, $id) {
    $pdo = conectarBanco();
    try {
        $alterarLocados = $pdo->prepare("UPDATE locados SET locados_data = :data WHERE locados_id = :id");

        $alterarLocados->bindValue(":data", $dataLocado);
        $alterarLocados->bindValue(":id", $id);
        $alterarLocados->execute();

        if ($alterarLocados->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function alterarStatusLocados($status, $dataLocado, $id) {
    $pdo = conectarBanco();
    try {
        $alterarLocados = $pdo->prepare("UPDATE locados SET locados_status = :status, locados_data = :data WHERE locados_id = :id");

        $alterarLocados->bindValue(":status", $status);
        $alterarLocados->bindValue(":data", $dataLocado);
        $alterarLocados->bindValue(":id", $id);
        $alterarLocados->execute();

        if ($alterarLocados->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

/* RELOCAR FILME */

function relocar($dados) {

    $pdo = conectarBanco();
    $pdo->beginTransaction();

    try {
        $alterarLocado = $pdo->prepare('UPDATE locados SET locados_data = ?, locados_devolucao = ?, locados_valor = ? WHERE locados_id = ?');
        $alterarLocado->bindValue(1, $dados[5]);
        $alterarLocado->bindValue(2, $dados[2]);
        $alterarLocado->bindValue(3, $dados[3]);
        $alterarLocado->bindValue(4, $dados[6]);
        $alterarLocado->execute();

        if ($alterarLocado->rowCount() == 1):
            $verificaLocacao = $pdo->prepare("SELECT * FROM locacoes WHERE locacoes_mes = ? AND locacoes_filme= ?");
            $verificaLocacao->bindValue(1, substr(date("m"), 1));
            $verificaLocacao->bindValue(2, $dados[1]);
            $verificaLocacao->execute();
            $dadosLocacoes = $verificaLocacao->fetch(PDO::FETCH_OBJ);
            if ($verificaLocacao->rowCount() == 1):
                $atualizarLocacoes = $pdo->prepare("UPDATE locacoes SET locacoes_total = ? WHERE locacoes_id = ?");
                $atualizarLocacoes->bindValue(1, $dadosLocacoes->locacoes_total+1);
                $atualizarLocacoes->bindValue(2, $dadosLocacoes->locacoes_id);
                $atualizarLocacoes->execute();
            else:
                $cadastrarLocacao = $pdo->prepare("INSERT INTO locacoes(locacoes_mes, locacoes_filme, locacoes_total)VALUES(?,?,?)");
                $cadastrarLocacao->bindValue(1, substr(date("m"), 1));
                $cadastrarLocacao->bindValue(2, $dados[1]);
                $cadastrarLocacao->bindValue(3, 1);
                $cadastrarLocacao->execute();
            endif;
        else:
            return false;
        endif;


        $pdo->commit();
        return true;
    } catch (PDOException $e) {
        echo $e->getMessage();
        $pdo->rollBack();
        return false;
    }
}