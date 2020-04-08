<?php
require_once "../../functions/functions.php";
carregarArquivos(array('validacoes', 'cadastrar', 'selecionar'));

if (isset($_POST['ok'])):

    $banner = validarDados($_FILES['banner']['name'], 'BANNER', 'STRING');
    $filme = validarDados($_POST['filme'], 'FILME', 'INT');
    $slug = validarDados($_POST['slug'], 'SLUG', 'STRING');

    if (!isset($mensagem)):

        if (existeCadastro('banners', 'banners_filme', $filme)):
            $erro = 'Já existe um cadastro de banner para este filme';
        else:
            /* SE NAO EXISTIR O CADASTRO DE BANNER PARA O FILME ESCOLHIDO FAZ O CADASTRO */
            define('DIR_BANNER', 'fotos/banners/');
            $extensao = end(explode(".", basename($banner)));
            $novoNome = uniqid() . "." . $extensao;
            $dados = array($slug, $filme, DIR_BANNER . $novoNome);
            $temporario = $_FILES['banner']['tmp_name'];

            if (move_uploaded_file($temporario, '../../../../' . DIR_BANNER . $novoNome)):
                if (cadastrarBanner($dados)):
                    $sucesso = "Cadastrado !"
                    ?>
                    <script type="text/javascript">
                        setTimeout("window.close()", 2000);                              
                    </script>
                    <?php
                else:
                    $erro = 'Erro ao cadastrar Banner';
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

                <h2>Cadastrar Banners</h2>

                <form action="" method="post" enctype="multipart/form-data">

                    <label for="banner">Banner:</label>
                    <input type="file" name="banner" />

                    <label for="filme">Filme:</label>
                    <select name="filme" class="input_select" id="select_banner">
                        <option value="" selected="selected">Escolha um filme</option>
                        <?php
                        $filmes = listar('filmes');
                        $f = new ArrayIterator($filmes);
                        while ($f->valid()):
                            ?>   
                            <option value="<?php echo $f->current()->filmes_id; ?>"><?php echo $f->current()->filmes_nome; ?></option>
                            <?php
                            $f->next();
                        endwhile;
                        ?>
                    </select>

                    <label for="slug">Slug:</label>
                    <input type="text" name="slug" class="input" id="slug" />

                    <label for="submit"></label>
                    <input type="submit" name="ok" value="Cadastrar" class="input_button" />
                </form>

                <?php echo isset($erro) ? '<div class="erro">' . $erro . '</div>' : ''; ?>
                <?php echo isset($sucesso) ? '<div class="sucesso">' . $sucesso . '</div>' : ''; ?>

            </div>
        </div>      
    </body>
    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript" src="../../js/banners.js"></script>
</html>
