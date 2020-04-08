<?php
require_once "../../functions/functions.php";
carregarArquivos(array('validacoes', 'selecionar', 'alterar'));

if (isset($_POST['ok'])):

    $titulo = validarDados($_POST['noticia_titulo'], "TITULO", 'STRING');
    $slug = validarDados($_POST['slug'], "SLUG", 'STRING');
    $noticia = $_POST['noticia'];

    if (preg_match("/http:\/\//", $_POST['noticia'])):
        $noticia = $_POST['noticia'];
    else:
        $noticia = str_replace("http:/", "http://", $_POST['noticia']);
    endif;


    if (!isset($mensagem)):
        if (existeCadastroAlterar('noticias', 'noticias_titulo', $titulo, 'noticias_id', $_GET['id'])):
            $erro = 'Essa notíca já esta cadastrada';
        else:
            /*
             * ALTERAR NOTICIA
             */
            if (alterarNoticia($titulo, $slug, $noticia, $_GET['id'])):
                $sucesso = 'Notícia alterada';
                ?>
                <script type="text/javascript">
                    setTimeout("window.close()", 2000);                              
                </script>
                <?php
            else:
                $erro = 'Erro ao aletrar noticia';
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
        <script type="text/javascript" src="../../bibliotecas/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript" src="../../bibliotecas/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
        <script type="text/javascript" src="../../js/initTiny.js" ></script>
    </head>
    <body>
        <div class="form_cadastrar">

            <div class="form">
                <?php
                try {
                    if (filter_var($_GET['id'], FILTER_VALIDATE_INT)):
                        /* LISTAR OS DADOS DO ADMINISTRADOR */
                        $dadosNoticia = pegarPeloId("noticias", "noticias_id", $_GET['id']);
                        ?>  

                        <h2>Alterar Notícia</h2>

                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                            <label for="noticia_titulo">Título:</label>
                            <input type="text" name="noticia_titulo" class="input" value="<?php echo $dadosNoticia->noticias_titulo; ?>" />

                            <label for="login">Slug:</label>
                            <input type="text" name="slug" class="input" value="<?php echo $dadosNoticia->noticias_slug; ?>" />

                            <label for="noticia">Notícia:</label>
                            <textarea name="noticia"><?php echo $dadosNoticia->noticias_texto; ?></textarea>

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
