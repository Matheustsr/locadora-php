<div id="pagina">
    <div class="mensagens">
        <?php
        try {
            if (isset($_POST['cadastrar_newsletter'])):

                $email = validarDados($_POST['email'], 'EMAIL', 'EMAIL');
                global $mensagem;

                if (!isset($mensagem)):
                    if (!existeCadastro('newsletter', 'newsletter_email', $email)):
                        if (cadastrarNewsletter($email)):

                            echo "E-mail cadastrado, voce será redirecionado para a pagina anterior em 5 segundos !<br />";
                            ?>
                            <script type="text/javascript">
                                setTimeout( function() {
                                    location="http://netfilmes.com.br"
                                }, 5000 );                         
                            </script>
                            <?php
                        else:
                            $erro = 'Erro ao cadastrar e-mail, tente novamente, se o erro persistir, entre em contato conosco pelo e-mail contato@asolucoesweb.com.br';
                        endif;
                    else:
                        $erro = 'Esse e-mail ja está cadastrado !';
                    endif;
                else:
                    $erro = $mensagem;
                endif;
            else:
                throw new Exception('Digite seu e-mail');
            endif;
        } catch (Exception $e) {
            $erro = $e->getMessage();
        }
        ?>
    </div>
    <!--SE EXISTIR ALGUM ERRO AO CADASTRAR O COMENTARIO MOSTRA A MENSAGEM-->
    <div id="erroComentario">
        <?php
        if (isset($erro)):
            echo $erro . "<br />";
            echo "Você será redirecionado para a página anterior em 5 segundos";
            ?>       
               <script type="text/javascript">
                       setTimeout( function() {
                       location="http://netfilmes.com.br"
                   }, 5000 );                         
            </script>                        
            <?php
        endif;
        ?>
    </div>
</div>