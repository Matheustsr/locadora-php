<?php

function enviarEmail($dadosEmail) {

    if (is_array($dadosEmail)):
        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";
        $mail->SMTPSecure = "ssl";
        $mail->IsSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Username = "alecar2007@gmail.com";
        $mail->Password = "";
        $mail->IsHTML(true);
        $mail->SetFrom($dadosEmail['from']);
        $mail->From = $dadosEmail['from'];
        $mail->FromName = $dadosEmail['nome'];
        $mail->AddAddress($dadosEmail['email']);
        //$mail->AddAddress('xandecar@hotmail.com');
        $mail->Subject = $dadosEmail['assunto'];
        $mail->Body = $dadosEmail['mensagem'];
        //$mail->MsgHTML();

        if ($mail->Send()) :
            return true;
        else :
            return false;
        endif;
    else:
        echo "Valor passado por parametro para a funcao email, tem que ser um array";
    endif;
}

function atualizarEmail($id) {
    $pdo = conectarBanco();
    try {
        $atualizarEmail= $pdo->prepare("update contato set contato_status = 2 where contato_id = ?");
        $atualizarEmail->bindValue(1, $id);
        $atualizarEmail->execute();

        if ($atualizarEmail->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function deletarEmail($id) {
    $pdo = conectarBanco();
    try {
        $deletarEmail= $pdo->prepare("delete from contato where contato_id = ?");
        $deletarEmail->bindValue(1, $id);
        $deletarEmail->execute();

        if ($deletarEmail->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}