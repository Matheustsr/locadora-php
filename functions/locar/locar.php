<?php

function estaLocado($id) {

    $pdo = conectarBanco();
    try {
        $verificaLocado = $pdo->prepare("SELECT * FROM locados WHERE locados_filme = ?");
        $verificaLocado->bindValue(1, $id);
        $verificaLocado->execute();

        return ($verificaLocado->rowCount() == 1) ? true : false;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function pegaVisitados($id) {

    if (!isset($_COOKIE['filmes'][$id])):
        setcookie("filmes[$id]", 1, time() + 4600);
    else:
        setcookie("filmes[$id]", $_COOKIE['filmes'][$id] += 1, time() + 4600);
    endif;
}

function locarFilme($id) {
    if (!isset($_SESSION['locar'])):
        $_SESSION['locar'] = array();
    endif;

    if (empty($_SESSION['locar'][$id])):
        $_SESSION['locar'][$id] = 1;
        header('location: http://netfilmes.com.br/meus_filmes');
    endif;

}

function finalizarLocacaoFilme($dados) {

    $pdo = conectarBanco();

    $pdo->beginTransaction();
    try {
        $alterarLocados = $pdo->prepare("INSERT INTO locados(locados_filme, locados_data, locados_devolucao, locados_cliente, locados_status,locados_valor,locados_entrega)VALUES(?,?,?,?,?,?,?)");
        foreach ($dados as $k => $v):
            $alterarLocados->bindValue($k, $v);
        endforeach;
        $alterarLocados->execute();

        if ($alterarLocados->rowCount() == 1):
            $verificarLocados = $pdo->prepare("SELECT * FROM locacoes WHERE locacoes_mes = ? AND locacoes_filme = ?");
            $verificarLocados->bindValue(1, substr(date("m"), 1));
            $verificarLocados->bindValue(2, $dados[1]);
            $verificarLocados->execute();
            $dadosLocacao = $verificarLocados->fetch(PDO::FETCH_OBJ);
            if ($verificarLocados->rowCount() == 1):
                $atualizarLocacao = $pdo->prepare("UPDATE locacoes SET locacoes_total = ? WHERE locacoes_id = ?");
                $atualizarLocacao->bindValue(1, $dadosLocacao->locacoes_total + 1);
                $atualizarLocacao->bindValue(2, $dadosLocacao->locacoes_id);
                $atualizarLocacao->execute();
            else:
                $cadastrarLocacao = $pdo->prepare("INSERT INTO locacoes(locacoes_mes, locacoes_filme, locacoes_total)VALUES(?,?,?)");
                $cadastrarLocacao->bindValue(1, substr(date("m"), 1));
                $cadastrarLocacao->bindValue(2, $dados[1]);
                $cadastrarLocacao->bindValue(3, 1);
                $cadastrarLocacao->execute();
            endif;
        endif;

        $pdo->commit();
        return true;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        $pdo->rollback();
        return false;
    }
}

function locarFilmeCliente($dados) {

    $pdo = conectarBanco();
    $pdo->beginTransaction();
    try {

        $verificaLocacaoCliente = $pdo->prepare("SELECT * FROM locacoes_cliente WHERE locacoes_cliente_mes = ? AND locacoes_cliente_nome = ? AND locacoes_cliente_filme = ?");
        $verificaLocacaoCliente->bindValue(1, substr(date("m"), 1));
        $verificaLocacaoCliente->bindValue(2, $dados[4]);
        $verificaLocacaoCliente->bindValue(3, $dados[1]);
        $verificaLocacaoCliente->execute();

        $dadosLocacoesCliente = $verificaLocacaoCliente->fetch(PDO::FETCH_OBJ);
        if ($verificaLocacaoCliente->rowCount() == 1):
            $atualizarFilmeCliente = $pdo->prepare("UPDATE locacoes_cliente SET locacoes_cliente_total = ? WHERE locacoes_cliente_id = ?");
            $atualizarFilmeCliente->bindValue(1, $dadosLocacoesCliente->locacoes_cliente_total + 1);
            $atualizarFilmeCliente->bindValue(2, $dadosLocacoesCliente->locacoes_cliente_id);
            $atualizarFilmeCliente->execute();
        else:
            $cadastrarFilmeCliente = $pdo->prepare("INSERT INTO locacoes_cliente(locacoes_cliente_nome, locacoes_cliente_filme,locacoes_cliente_mes, locacoes_cliente_total)
                                                    VALUES(?,?,?,?)");
            $cadastrarFilmeCliente->bindValue(1, $dados[4]);
            $cadastrarFilmeCliente->bindValue(2, $dados[1]);
            $cadastrarFilmeCliente->bindValue(3, substr(date("m"), 1));
            $cadastrarFilmeCliente->bindValue(4, 1);
            $cadastrarFilmeCliente->execute();
        endif;


        $pdo->commit();
        return true;
    } catch (PDOException $e) {
        echo $e->getMessage();
        $pdo->rollBack();
        return false;
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