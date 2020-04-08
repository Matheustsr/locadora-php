<?php
if (isset($_POST['logar_verifica_logado'])):
    $login = validarDados($_POST['login'], 'LOGIN', 'STRING');
    $senha = validarDados($_POST['senha'], 'SENHA', 'STRING');
    global $mensagem;
    if (!isset($mensagem)):
        (!logar($login, $senha)) ? $erro = 'Login ou senha inválidos' : $sucesso = 'Você logou com sucesso, em 5 segundos será redirecionado.';
    else:
        $erro = $mensagem;
    endif;
endif;
?>
<div id="pagina">
    <h2>Logar</h2>
    <?php
    if (!isset($_SESSION['logado_cliente'])):
        ?>
        <div id="mensagem_logado">
            <p>Você não está logado, se ja tiver cadastro no site, faça o login abaixo, senão cadastre-se clicando em cadastrar no menu do topo ou na opção abaixo.</p>
        </div>

        <div id="logar_cliente">

            <div id="logar">
                <h4>LOGAR</h4>
                <p id="mensagem_logar"> Se você ja for cadastrado no site, digite seu login e sua senha para continuar a loação do filme.</p>

                <form action="http://netfilmes.com.br/<?php echo basename($_SERVER['REQUEST_URI']); ?>" method="post">
                    <label for="login">Login:</label>
                    <input type="text" name="login" class="text_login" />

                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" class="text_login" />

                    <label for="submit"></label>
                    <input type="submit" name="logar_verifica_logado" value="Fazer login" class="button_logar_cliente" />
                </form>
                <?php echo isset($erro) ? '<div class="mensagem">' . $erro . '</div>' : ''; ?>
            </div>
            <div id="cadastrar">
                <h4>CADASTRAR</h4>
                <p id="mensagem_cadastrar">
                    Se você ainda não for cadastrado no site, clique no link abaixo, para se cadastrar e poder locar o filme.<br /><br />
                    Qualquer dúvida, entre em contato conosco através do e-mail: contato@asolucoesweb.com.br<br /><br />
                    <a href="http://netfilmes.com.br/cadastrar">CADASTRAR</a>
                </p>
            </div>
        </div>
        <?php
    else:
        /* SE ESTIVER LOGADO REDIRECIONA PARA A PAGINA DOS FILMES LOCADOS */
        /*ob_start()
         *ob_end_flush()
         * header('location: http://netfilmes.com.br/meus_filmes');
         */
        echo (isset($sucesso)) ? '<div id="logado_cliente">' . $sucesso . '</div>' : '<div id="logado_cliente">Você esta logado e será redirecionado em 5 segundos !</div>';
        ?>
        <meta http-equiv="refresh" content="5;URL='http://netfilmes.com.br/'">
    <?php endif;?>
    <div class="fix"></div>
</div>