<?php
session_start();
require_once "functions/functions.php";
require_once "functions/conexao.php";

/* LOGAR NO SISTEMA */
if (isset($_POST['ok']) AND $_SERVER['REQUEST_METHOD'] == 'POST'):

    $login = $_POST['login'];
    $senha = $_POST['senha'];

    if (logarSistema($login, $senha)):
        redirecionaLogado("painel/");
    else:
        $erro = "Login ou senha inválidos !";
    endif;

endif;
/* LOGAR NO SISTEMA */
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>
        <div id="login">

            <div id="logo"><img src="imagens/logo.png" /></div>

            <div id="form_login">
                <form action="" method="post">

                    <label for="login">Login:</label>
                    <input type="text" name="login" class="input_login" />

                    <label for="senha">Senha:</label>
                    <input type="password" name="senha"  class="input_login"  />

                    <label for="submot"></label>
                    <input type="submit" name="ok" value="logar" id="botao_logar" />

                </form>
                <?php echo isset($erro) ? '<div id="mensagem">' . $erro . '</div>' : ''; ?>
            </div>
        </div>
    </body>
</html>
