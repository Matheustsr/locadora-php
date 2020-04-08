<?php
require_once "../../functions/functions.php";
carregarArquivos(array('validacoes','cadastrar','selecionar'));

if (isset($_POST['ok']) AND $_SERVER['REQUEST_METHOD'] == 'POST'):

    $nome = validarDados($_POST['nome'], "nome", "STRING");
    $login = validarDados($_POST['login'], "login", "STRING");
    $senha = validarDados($_POST['senha'], "senha", "STRING");

    if (!isset($mensagem)):
        if (existeCadastro("administradores", "administradores_nome", $nome)):
            $erro = "Já existe um administrador com esse nome";
        else:
            if (existeCadastro("administradores", "administradores_login", $login)):
                $erro = "Já existe um administrador com esse login";
            else:
                //CADASTRAR O ADMINISTRADOR
                if (cadastrarAdministrador($nome, $login, md5($senha))):
                    $sucesso = "Administrador cadastrado";
                    ?>
                    <script type="text/javascript">
                        setTimeout("window.close()", 2000);                              
                    </script>
                    <?php
                else:
                    $erro = "Erro ao cadastrar administrador";
                endif;
            endif;
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
        <link href="../../css/styleJanela.css" rel="stylesheet" type="text/css" />
        <link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css' />
    </head>
    <body>
        <div class="form_cadastrar">

            <div class="form">

                <h2>Cadastrar Administrador</h2>

                <form action="" method="post">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" class="input" />

                    <label for="login">Login:</label>
                    <input type="text" name="login" class="input" />

                    <label for="senha">Senha:</label>
                    <input type="text" name="senha" class="input" />

                    <label for="submit"></label>
                    <input type="submit" name="ok" value="Cadastrar" class="input_button" />
                </form>

                <?php echo isset($erro) ? '<div class="erro">' . $erro . '</div>' : ''; ?>
                <?php echo isset($sucesso) ? '<div class="sucesso">' . $sucesso . '</div>' : ''; ?>

            </div>
        </div>      
    </body>
</html>
