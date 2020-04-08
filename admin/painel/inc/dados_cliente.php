<script type="text/javascript" src="js/chart_filmes_clientes.js"></script>
<?php
require_once "bibliotecas/PHPMailer/class.phpmailer.php";

if (isset($_POST['enviar_email'])):

    $dados = pegarPeloId("clientes", "clientes_id", $_GET['id']);
    $email = $dados->clientes_email;
    $dadosEmail = array(
        "from" => "contato@asolucoesweb.com.br",
        "nome" => "Alexandre Eduardo Cardoso",
        "email" => $email,
        "assunto" => "Devolve o filme",
        "mensagem" => $_POST['email']
    );

    if (enviarEmail($dadosEmail)):
        $sucesso = "E-mail enviado";
    else:
        $erro = "Erro ao enviar email";
    endif;
endif;
?>
<div id="dados_cliente">
    <?php
    try {
        if (isset($_GET['id'])):

            if (filter_var($_GET['id'], FILTER_VALIDATE_INT)):
      
                if (!isset($_SESSION['idCliente'])):
                    $_SESSION['idCliente'] = $_GET['id'];
                else:
                    if ($_SESSION['idCliente'] != $_GET['id']):
                        $_SESSION['idCliente'] = $_GET['id'];
                    endif;
                endif;
                
                $dados = pegarPeloId("clientes", "clientes_id", $_GET['id']);
                ?>
                <!-- Dynamic table -->
                <div class="table">
                    <div class="head"><h5 class="iFrames">Dados do cliente <?php echo $dados->clientes_nome; ?></h5></div>
                    <div id="foto"><img src="<?php echo "../../".$dados->clientes_foto_detalhes; ?>"/></div>
                    <div id="dados">

                        <p>Nome Cliente: <?php echo $dados->clientes_nome; ?></p>
                        <p>E-mail Cliente: <?php echo $dados->clientes_email; ?> | <a href="?p=dados_cliente&id=<?php echo $_GET['id']; ?>&mail=ok">Enviar e-mail</a></p>
                        <p>Cidade Cliente: <?php echo $dados->clientes_cidade; ?></p>
                        <p>Telefone Cliente: <?php echo $dados->clientes_telefone; ?></p>
                        <p>Celular Cliente: <?php echo $dados->clientes_celular; ?></p>
                        <p>CPF Cliente: <?php echo $dados->clientes_cpf; ?></p>

                        <?php
                        if (isset($_GET['mail'])):
                            if ($_GET['mail'] == 'ok'):
                                ?>
                                <div id="enviarEmail">
                                    <h2>Enviar E-mail</h2>
                                    <form action="" method="post">
                                        <textarea name="email"></textarea><br />
                                        <input type="submit" name="enviar_email" value="enviar" />
                                    </form>
                                    <?php
                                    /* MENSAGENS */
                                    echo isset($erro) ? '<div class="erro">' . $erro . '</div>' : '';
                                    echo isset($sucesso) ? '<div class="sucesso">' . $sucesso . '</div>' : '';
                                    /* MENSAGENS */
                                    ?>
                                </div>
                                <?php
                            endif;
                        endif;
                        ?>  
                    </div>
                </div>
                <?php
            else:
                throw new Exception("Cliente não existe");
            endif;

        else:
            throw new Exception("Cliente não existe");
        endif;
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
    ?>


    <div id="mais_locados_cliente">
        <!-- FILMES MAIS LOCADOS PELO CLIENTE -->
        <div class="table">
            <div class="head"><h5 class="iFrames">Filmes mais locados pelo cliente <?php echo $dados->clientes_nome; ?></h5></div>   
            <div id="visualization" style="width: 600px; height: 400px;"></div>
        </div>
    </div>

</div>