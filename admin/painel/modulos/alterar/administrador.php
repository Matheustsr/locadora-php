<?php
require_once "../../functions/functions.php";
carregarArquivos(array('validacoes','selecionar','alterar'));

if (isset($_POST['ok']) AND $_SERVER['REQUEST_METHOD'] == 'POST'):

    $nome = validarDados($_POST['nome'], "nome", "STRING");
    $login = validarDados($_POST['login'], "login", "STRING");
    $senha = $_POST['senha'];

    if (!isset($mensagem)):
        if (existeCadastroAlterar("administradores", "administradores_nome", $nome, "administradores_id", $_POST['id'])):
            $erro = "Ja existe um administrador com esse nome";
        else:
            if (existeCadastroAlterar("administradores", "administradores_login", $login, "administradores_id", $_POST['id'])):
                $erro = "Ja existe um login com esse nome";
            else:
                /* ATUALIZAR DADOS DO ADMINISTRADOR */
                if (empty($senha)):
                    $idAdmin = pegarPeloId("administradores", "administradores_id", $_POST['id']);
                    $senhaAtualizar = $idAdmin->administradores_senha;
                else:
                    $senhaAtualizar = md5($senha);
                endif;

                if (alterarAdministrador($nome, $login, $senhaAtualizar, $_POST['id'])):
                    $sucesso = "Administrador atualizado";
                    ?>
                    <script type="text/javascript">
                        setTimeout("window.close()", 2000);                              
                    </script>
                    <?php
                else:
                    $erro = "Nao foi possível atualizar o administrador, tente novamente !";
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
        <link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css' />
        <link href="../../css/styleJanela.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="form_cadastrar">

            <div class="form">
                <?php
                try {
                    if (filter_var($_GET['id'], FILTER_VALIDATE_INT)):
                        /* LISTAR OS DADOS DO ADMINISTRADOR */
                        $dadosAdmin = pegarPeloId("administradores", "administradores_id", $_GET['id']);
                        ?>  

                        <h2>Alterar Administrador</h2>

                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                            <label for="nome">Nome:</label>
                            <input type="text" name="nome" class="input" value="<?php echo $dadosAdmin->administradores_nome; ?>" />

                            <label for="login">Login:</label>
                            <input type="text" name="login" class="input" value="<?php echo $dadosAdmin->administradores_login; ?>" />

                            <label for="senha">Senha:</label>
                            <input type="text" name="senha" class="input" />

                            <label for="submit"></label>
                            <input type="submit" name="ok" value="Atualizar" class="input_button" />
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
