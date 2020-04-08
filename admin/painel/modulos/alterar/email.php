<?php
require_once "../../functions/functions.php";
require_once "../../bibliotecas/PHPMailer/class.phpmailer.php";
carregarArquivos(array('validacoes', 'alterar', 'selecionar', 'email'));
if (isset($_POST['ok']) AND $_SERVER['REQUEST_METHOD'] == 'POST'):

    $assunto = validarDados($_POST['assunto'], 'ASSUNTO', 'STRING');
    $mensagem_cliente = validarDados($_POST['mensagem'], 'MENSAGEM', 'STRING');

    global $mensagem;

    if (!isset($mensagem)):

        /* DADOS PARA ENVIAR EMAIL */
        $dadosEmail = array(
            "from" => 'contato@asolucoesweb.com.br',
            "nome" => 'Alexandre Cardoso',
            "email" => 'contato@asolucoesweb.com.br',
            "assunto" => 'RE: ' . $assunto,
            "mensagem" => $mensagem_cliente
        );

        if (enviarEmail($dadosEmail)):
            atualizarEmail((int) $_POST['id']);
            $sucesso = "E-mail enviado";
            ?>
            <script type="text/javascript">
                setTimeout("window.close()", 2000);                              
            </script>
            <?php
        else:
            $erro = "Erro ao enviar email";
        endif;

    else:
        $erro = $mensagem;
    endif;
endif;
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css' />
        <link href="../../css/styleJanela.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="../../js/jquery.js"></script>
        <script type="text/javascript" src="../../bibliotecas/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript" src="../../js/initTiny.js"></script>
    </head>
    <body>
        <div class="form_cadastrar">

            <div class="form">
                <?php
                try {
                    if (filter_var($_GET['id'], FILTER_VALIDATE_INT)):
                        /* LISTAR OS DADOS DO ADMINISTRADOR */
                        $dadosEmail = pegarPeloId("contato", "contato_id", $_GET['id']);
                        ?>  

                        <h2>Alterar Cliente</h2>

                        <form action="" method="post" enctype="multipart/form-data">
                            <label for="nome">Nome:</label>
                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                            <input type="text" name="nome" disabled="disabled" class="input" value="<?php echo $dadosEmail->contato_nome ?>" />

                            <label for="email">E-mail:</label>
                            <input type="text" name="email" class="input" disabled="disabled" value="<?php echo $dadosEmail->contato_email ?>" />

                            <label for="telefone">Telefone:</label>
                            <input type="text" name="telefone" class="input" disabled="disabled" value="<?php echo $dadosEmail->contato_telefone; ?>" />

                            <label for="assunto">Assunto:</label>
                            <input type="text" name="assunto" class="input" value="<?php echo $dadosEmail->contato_assunto; ?>" />

                            <label for="mensagem">Mensagem:</label>
                            <textarea name="mensagem"><?php echo $dadosEmail->contato_mensagem; ?></textarea>

                            <label for="submit"></label>
                            <input type="submit" name="ok" value="Responder" class="input_button" />
                        </form>

                        <?php echo isset($erro) ? '<div class="erro">' . $erro . '</div>' : ''; ?>
                        <?php echo isset($sucesso) ? '<div class="sucesso">' . $sucesso . '</div>' : ''; ?>

                        <?php
                    else:
                        throw new Exception("O valor ID passado pela url, tem que ser um numero inteiro");
                    endif;
                } catch (Exception $e) {
                    echo "Erro " . $e->getMessage();
                }
                ?>
            </div>
        </div>   
    </body>
</html>
