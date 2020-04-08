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
        $mail->Password = "emailgmail2013!";
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

function cadastrarEmail($dados) {
    $pdo = conectarBanco();
    try {
        $cadastrarEmail= $pdo->prepare("INSERT INTO contato (contato_nome, contato_email, contato_telefone, contato_assunto, contato_mensagem, contato_status)
                                        VALUES(?,?,?,?,?,?)");
        foreach ($dados as $k => $v):
            $cadastrarEmail->bindValue($k, $v);
        endforeach;

        $cadastrarEmail->execute();

        if ($cadastrarEmail->rowCount() == 1):
            return true;
        else:
            return false;
        endif;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
