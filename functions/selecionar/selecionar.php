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

function contarPeloId($tabela, $campo, $id) {
    $pdo = conectarBanco();
    try {
        $count = $pdo->prepare("SELECT * FROM $tabela WHERE $campo = ?");
        $count->bindValue(1, $id);
        $count->execute();
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

function checkEdit($idCliente, $idComentario) {
    $pdo = conectarBanco();
    try {
        $check = $pdo->prepare("SELECT * FROM comentarios INNER JOIN clientes ON comentarios.comentarios_cliente = clientes.clientes_id WHERE comentarios_cliente = ? AND comentarios_id = ? AND NOW() <= DATE_ADD(comentarios_data, INTERVAL 30 MINUTE)");
        $check->bindValue(1, $idCliente);
        $check->bindValue(2, $idComentario);
        $check->execute();

        return ($check->rowCount() > 0) ? true : false;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function resumeTexto($texto, $qtdePalavras) {

    /*
     * Ola, meu nome é Alexandre Cardoso, visitem o meu site.
     */

    $resumo = substr($texto, 0, $qtdePalavras);

    /*
     * Ola, meu nome é Alex
     * 
     */

    $corta_texto = strrpos($resumo, ' ');
    /*
     * Ola, meu nome é
     * 
     */
    return substr($resumo, 0, $corta_texto) . "...";

    /*
     * Ola, meu nome é...
     * 
     */
}

function recuperaDados($nome, $valor) {

    /* VERIFICA SE A VARIAVEL VALOR E NULA */
    if (is_null($valor)):
        /* SE FOR NULA VERIFICA SE JA EXISTE A SESSAO */
        if (isset($_SESSION[$nome])):
            /* SE JA EXISTOR A SESSAO RETORNA ELA */
            return $_SESSION[$nome];
        else:
            /* SE NAO EXISTIR RETORNA UM CAMPO VAZIO */
            echo '';
        endif;
    else:
        /* SE A VARIAVEL VALOR NAO FOR NULA E EXISTIR A SESSAO */
        if (isset($_SESSION[$nome])):
            /* RETORNA A SESSAO DESEJADA */
            return $_SESSION[$nome];
        else:
            /* SE NAO EXISTIR A SESSAO CIRA ELA E ATRIBUI O VALOR PASSADO COMO PARAMETRO */
            $_SESSION[$nome] = $valor;
            /* RETORNA A SESSAO */
            return $_SESSION[$nome];
        endif;
    endif;
}