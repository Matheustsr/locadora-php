<?php
require_once "../../functions/functions.php";
carregarArquivos(array('validacoes','cadastrar','selecionar','wide_image'));

if (isset($_POST['ok']) AND $_SERVER['REQUEST_METHOD'] == 'POST'):

    $genero = validarDados($_POST['genero'], "genero", 'INT');
    $nomeFilme = validarDados($_POST['nome'], "nom do filme", 'STRING');
    $preco = validarDados($_POST['preco'], "preco", 'STRING');
    $lancamento = validarDados($_POST['lancamento'], "lançamento", 'STRING');
    $recomendo = validarDados($_POST['recomendo'], "recomendo", 'STRING');
    $foto = validarDados($_FILES['foto']['name'], "recomendo", 'STRING');
    $descricao = validarDados($_POST['descricao'], "descricao", 'STRING');
    $codigo = validarDados($_POST['codigo'], "codigo", 'INT');
    $slug = validarDados($_POST['slug'], "slug", 'STRING');
    $temporario = $_FILES['foto']['tmp_name'];
    define("DIRETORIO_SITE", '../../../../fotos/site/');
    define("DIRETORIO_DESCRICAO", '../../../../fotos/descricao/');

    if (!isset($mensagem)):

        /* RENOMEAR FOTO */
        $extensao = end(explode('.', $foto));
        $novoNomeFoto = uniqid() . "." . $extensao;
        /* RENOMEAR FOTO */

        /* REDIMENSIONAR E SALVAR FOTO */
        $wide = WideImage::load($temporario);
        $redimensionar = $wide->resize(100, 120, 'outside');
        $redimensionar->saveToFile(DIRETORIO_SITE . $novoNomeFoto);
        /* REDIMENSIONAR E SALVAR FOTO */

        /* REDIMENSIONAR E SALVAR FOTO DESCRICAO */
        $wide = WideImage::load($temporario);
        $redimensionar = $wide->resize(250, 200, 'outside');
        $redimensionar->saveToFile(DIRETORIO_DESCRICAO . $novoNomeFoto);
        /* REDIMENSIONAR E SALVAR FOTO DESCRICAO */

        /* SALVAR NO BANCO DE DADOS */
        $dados = array(
            1 => $genero,
            2 => $nomeFilme,
            3 => $preco,
            4 => $slug,
            5 => $lancamento,
            6 => $recomendo,
            7 => "fotos/site/" . $novoNomeFoto,
            8 => "fotos/descricao/" . $novoNomeFoto,
            9 => $descricao,
            10 => $codigo
        );

        if (!existeCadastro("filmes", "filmes_codigo", $codigo)):
            if (cadastrarFilme($dados)):
                $sucesso = "Filme cadastrado";
                ?>
                <script type="text/javascript">
                    setTimeout("window.close()", 2000);                              
                </script>
                <?php
            else:
                /* SE NAO CADASTROU NO BANCO DELETA A AS FOTOS CADASTRADAS */
                unlink(DIRETORIO_SITE . $novoNomeFoto);
                unlink(DIRETORIO_DESCRICAO . $novoNomeFoto);
                $erro = "Erro ao cadastrar filme";
            endif;
        /* SALVAR NO BANCO DE DADOS */
        else:
            unlink(DIRETORIO_SITE . $novoNomeFoto);
            unlink(DIRETORIO_DESCRICAO . $novoNomeFoto);
            $erro = "Filme ja existe";
        endif;

    else:
        $erro = $mensagem;
    endif;



endif;
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Cadastrar Filme</title>
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

                <h2>Cadastrar Filme</h2>

                <form action="" method="post" enctype="multipart/form-data">
                    <label for="nome">Categoria:</label>
                    <select name="genero" class="input_select">
                        <option value="" selected="selected">Escolha um gênero</option>
                        <?php
                        $categorias = listar('categorias');
                        $g = new ArrayIterator($categorias);
                        while ($g->valid()):
                            ?>
                            <option value="<?php echo $g->current()->categorias_id; ?>" ><?php echo $g->current()->categorias_nome; ?></option>
                            <?php
                            $g->next();
                        endwhile;
                        ?>
                    </select>

                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" class="input" />

                    <label for="preco">Preço:</label>
                    <input type="text" name="preco" class="input_menor" />

                    <label for="lancamento">Lançamento:</label>
                    <select name="lancamento" class="input_select">
                        <option value="sim" selected="selected">Sim</option>
                        <option value="nao">Não</option>
                    </select>

                    <label for="recomendo">Recomendo:</label>
                    <select name="recomendo" class="input_select">
                        <option value="sim" selected="selected">Sim</option>
                        <option value="nao">Não</option>
                    </select>

                    <label for="foto">Foto:</label>
                    <input type="file" name="foto" class="input_file" />

                    <label for="slug">Slug:</label>
                    <input type="text" name="slug" class="input_file" />

                    <label for="codigo">Código:</label>
                    <input type="text" name="codigo" class="input_file" />

                    <label for="descricao">Descrição do filme</label>
                    <textarea name="descricao"></textarea>

                    <label for="submit"></label>
                    <input type="submit" name="ok" value="Cadastrar" class="input_button" />
                </form>

                <?php echo isset($erro) ? '<div class="erro">' . $erro . '</div>' : ''; ?>
                <?php echo isset($sucesso) ? '<div class="sucesso">' . $sucesso . '</div>' : ''; ?>

            </div>
        </div>      
    </body>
</html>
