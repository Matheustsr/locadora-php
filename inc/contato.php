<?php
require_once "bibliotecas/PHPMailer/class.phpmailer.php";

if (isset($_POST['ok'])):

    $nome = validarDados($_POST['nome'], 'NOME', 'STRING');
    $email = validarDados($_POST['email'], 'EMAIL', 'STRING');
    $telefone = validarDados($_POST['telefone'], 'TELEFONE', 'STRING');
    $assunto = validarDados($_POST['assunto'], 'ASSUNTO', 'STRING');
    $mensagem_cliente = validarDados($_POST['mensagem'], 'MENSAGEM', 'STRING');
    global $mensagem;
    
    if (!isset($mensagem)):

        /*DADOS PARA ENVIAR EMAIL*/
        $dadosEmail = array(
            "from" => $email,
            "nome" => $nome,
            "email" => $email,
            "assunto" => $assunto,
            "mensagem" => $mensagem_cliente
        );

        if (enviarEmail($dadosEmail)):
            
            $dados = array(
                1=> $nome,
                2=> $email,
                3=> $telefone,
                4=> $assunto,
                5=> $mensagem_cliente,
                6=> 1
            );    
            cadastrarEmail($dados);
            $sucesso = "E-mail enviado";
        else:
            $erro = "Erro ao enviar email";
        endif;
    else:
        $erro = $mensagem;
    endif;
endif;
?>
<div id="pagina">
    <h2>Contato</h2>
    <div id="contato">      
        <form action="" method="post">

            <label for="nome">Nome:</label>
            <input type="text" name="nome" class="input_text" />

            <label for="email">E-mail:</label>
            <input type="text" name="email" class="input_text" />

            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" class="input_text" />

            <label for="assunto">Assunto:</label>
            <input type="text" name="assunto" class="input_text" />

            <label for="mensagem">Mensagem:</label>
            <textarea name="mensagem" class="input_textarea" rows="10"></textarea>

            <label for="submit"></label>
            <input type="submit" name="ok" value="Enviar" class="input_submit" />

        </form>

        <?php
        /* MENSAGENS */
        echo isset($erro) ? '<div class="erro">' . $erro . '</div>' : '';
        echo isset($sucesso) ? '<div class="sucesso">' . $sucesso . '</div>' : '';
        /* MENSAGENS */
        ?>
    </div> 
</div>