<?php
if (isset($_POST['alterar_slug']) == '1'):
    $noticia = $_POST['noticia'];
    $substituir = array("á", "é", 'í', "ó", "ú", "ç", "ã", "ô", " ");
    $por = array("a", "e", 'i', "o", "u", "c", "a", "o", "-");
    echo strtolower(str_replace($substituir, $por, $noticia));
endif;


require_once "../../functions/functions.php";
carregarArquivos(array('validacoes', 'cadastrar', 'selecionar'));

if (isset($_POST['ok'])):

    $titulo = validarDados($_POST['noticia_titulo'], "TITULO", 'STRING');
    $slug = validarDados($_POST['slug'], "SLUG", 'STRING');
    $noticia = validarDados($_POST['noticia'], "SLUG", 'STRING');

    if (!isset($mensagem)):
        /*
         * CADASTRAR A NOTICIA
         */
        if (existeCadastro('noticias', 'noticias_titulo', $titulo)):
            $erro = "Essa notícia já esta cadastrada";
        else:
            if (cadastrarNoticia($titulo, $slug, $noticia)):
                $sucesso = 'Notícia cadastrada';
            else:
                $erro = 'Erro ao cadastrar notícia';
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
        <script type="text/javascript" src="../../bibliotecas/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript" src="../../bibliotecas/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
        <script type="text/javascript" src="../../js/initTiny.js" ></script>
    </head>

    <body>
        <div class="form_cadastrar">

            <div class="form">

                <h2>Cadastrar Notícia</h2>

                <form action="" method="post">
                    <label for="titulo">Notícia Título:</label>
                    <input type="text" name="noticia_titulo" id="noticia_titulo" class="input" />

                    <label for="slug">Slug:</label>
                    <input type="text" name="slug" id="slug_noticia" class="input" />

                    <label for="noticia">Notícia:</label>
                    <textarea name="noticia"></textarea>

                    <label for="submit"></label>
                    <input type="submit" name="ok" value="Cadastrar" class="input_button" />
                </form>

                <?php echo isset($erro) ? '<div class="erro">' . $erro . '</div>' : ''; ?>
                <?php echo isset($sucesso) ? '<div class="sucesso">' . $sucesso . '</div>' : ''; ?>

            </div>
        </div>      
    </body>
    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript" src="../../js/noticia.js"></script>
</html>