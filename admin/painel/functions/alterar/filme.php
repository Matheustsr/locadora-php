<?php

function alterarFilme($dados) {

    if (is_array($dados)):
        $pdo = conectarBanco();
        try {
            $alterarFilme = $pdo->prepare("UPDATE filmes SET filmes_categoria = ?, filmes_nome = ?, filmes_preco = ?, filmes_slug = ?, filmes_lancamento = ?, filmes_recomendo = ?, filmes_foto = ?, filmes_foto_descricao = ?, filmes_descricao = ?, filmes_codigo = ? WHERE filmes_id = ?");
            foreach ($dados as $k => $v):
                $alterarFilme->bindValue($k, $v);
            endforeach;
            $alterarFilme->execute();

            if ($alterarFilme->rowCount() == 1):
                return true;
            else:
                return false;
            endif;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    else:
        echo "O valor passado por parametro deve ser um array";
    endif;
}

function locarFilme($dados) {

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

function alterarLancamento($lancamento, $id) {
        $pdo = conectarBanco();
        try {
            $alterarLancamento = $pdo->prepare("UPDATE filmes SET filmes_lancamento = ? WHERE filmes_id = ?");
            $alterarLancamento->bindValue(1, $lancamento);
            $alterarLancamento->bindValue(2, $id);
            $alterarLancamento->execute();

            if ($alterarLancamento->rowCount() == 1):
                return true;
            else:
                return false;
            endif;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
}