<?php

function listar($tabela, $parametros = null) {
    $pdo = conectarBanco();
    try {

        if ($parametros == null):
            $listar = $pdo->query("SELECT * FROM $tabela");
        else:
            $listar = $pdo->query("SELECT * FROM $tabela " . $parametros);
        endif;

        if ($listar->rowCount() > 0):
            return $listar->fetchAll(PDO::FETCH_OBJ);
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function existeCadastro($tabela, $campo, $valor) {
    $pdo = conectarBanco();

    try {
        $verifica = $pdo->prepare("SELECT * FROM $tabela WHERE $campo = :campo");
        $verifica->bindValue(":campo", $valor);
        $verifica->execute();

        if ($verifica->rowCount() > 0):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function pegarPeloId($tabela, $campoTabela, $valor) {
    $pdo = conectarBanco();

    try {
        $dados = $pdo->prepare("SELECT * FROM $tabela WHERE $campoTabela = :campo");
        $dados->bindValue(":campo", $valor);
        $dados->execute();

        if ($dados->rowCount() > 0):
            return $dados->fetch(PDO::FETCH_OBJ);
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function existeCadastroAlterar($tabela, $campo, $valor, $campoId, $id) {
    $pdo = conectarBanco();

    try {

        $verifica = $pdo->prepare("SELECT * FROM $tabela WHERE $campo = :campo AND $campoId != :id");
        $verifica->bindValue(":campo", $valor);
        $verifica->bindValue(":id", $id);
        $verifica->execute();

        if ($verifica->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function contar($tabela) {
    $pdo = conectarBanco();
    try {
        $count = $pdo->query("SELECT * FROM $tabela");
        return $count->rowCount();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function hoje($tabela, $campo, $dataHoje) {
    $pdo = conectarBanco();
    try {
        $hoje = $pdo->prepare("SELECT * FROM $tabela WHERE date($campo) = :dataHoje");
        $hoje->bindValue(":dataHoje", $dataHoje);
        $hoje->execute();

        return $hoje->rowCount();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
