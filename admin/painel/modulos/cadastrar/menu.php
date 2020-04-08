<?php
require_once "../../functions/functions.php";
carregarArquivos(array('validacoes', 'cadastrar', 'selecionar'));

if (isset($_POST['ok'])):

    $menu = validarDados($_POST['menu'], 'menu', 'STRING');
    $slug = validarDados($_POST['slug'], 'Slug', 'STRING');
    $link = validarDados($_POST['link'], 'Link', 'STRING');

    if (!isset($mensagem)):

        $dados = array(
            1 => $menu,
            2 => $slug,
            3 => $link,
            4 => 'habilitado'
            
        );
        if (cadastrarmenu($dados)):
            $sucesso = "Cadastrado com sucesso !";
            ?>
            <script type="text/javascript">
                setTimeout("window.close()", 2000);                              
            </script>
            <?php
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

                <h2>Cadastrar Menus</h2>

                <form action="" method="post">
                    <label for="menu">Menu:</label>
                    <input type="text" name="menu" class="input" />

                    <label for="slug">Slug:</label>
                    <input type="text" name="slug" class="input" id="slug" />

                    <label for="link">Link:</label>
                    <input type="text" name="link" class="input" id="link" />

                    <label for="submit"></label>
                    <input type="submit" name="ok" value="Cadastrar" class="input_button" />
                </form>

                <?php echo isset($erro) ? '<div class="erro">' . $erro . '</div>' : ''; ?>
                <?php echo isset($sucesso) ? '<div class="sucesso">' . $sucesso . '</div>' : ''; ?>

            </div>
        </div>      
    </body>
</html>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/menu.js"></script>