<?php
require_once "../../functions/functions.php";
carregarArquivos(array('validacoes', 'alterar', 'selecionar', 'wide_image'));
if (isset($_POST['ok']) AND $_SERVER['REQUEST_METHOD'] == 'POST'):

    $id = validarDados($_POST['id'], "id", 'INT');
    $genero = validarDados($_POST['genero'], "genero", 'INT');
    $nomeFilme = validarDados($_POST['nome'], "nom do filme", 'STRING');
    $preco = validarDados($_POST['preco'], "preco", 'STRING');
    $lancamento = validarDados($_POST['lancamento'], "lançamento", 'STRING');
    $recomendo = validarDados($_POST['recomendo'], "recomendo", 'STRING');
    $descricao = $_POST['descricao'];
    $codigo = validarDados($_POST['codigo'], "codigo", 'INT');
    $slug = validarDados($_POST['slug'], "slug", 'STRING');
    $temporario = $_FILES['foto']['tmp_name'];
    define("DIRETORIO_SITE", '../../../../fotos/site/');
    define("DIRETORIO_DESCRICAO", '../../../../fotos/descricao/');


    if (!isset($mensagem)):

        if (existeCadastroAlterar("filmes", "filmes_codigo", $_POST['codigo'], "filmes_id", $id)):
            $erro = "Ja existe um filme com esse códio";
        else:

            /* PEGAR FOTO PARA AÇTERAR NO BANCO */
            if (empty($_FILES['foto']['name'])):
                $foto = $_POST['fotoSite'];
                $fotoDescricao = $_POST['fotoSiteDetalhes'];

                /* SALVAR NO BANCO DE DADOS */
                $dados = array(
                    1 => $genero,
                    2 => $nomeFilme,
                    3 => $preco,
                    4 => $slug,
                    5 => $lancamento,
                    6 => $recomendo,
                    7 => $foto,
                    8 => $fotoDescricao,
                    9 => $descricao,
                    10 => $codigo,
                    11 => $id
                );

                if (alterarFilme($dados)):
                    $sucesso = "Filme alterado";
                    ?>
                    <script type="text/javascript">
                        setTimeout("window.close()", 2000);                              
                    </script>
                    <?php
                else:
                    $erro = "Erro ao alterar filme";
                endif;

            else:
                $extensao = end(explode(".", $_FILES['foto']['name']));
                $novoNome = uniqid() . "." . $extensao;

                /* REDIMENSIONAR E SALVAR A FOTO SITE */
                $wide = WideImage::load($temporario);
                $redimensionar = $wide->resize(100, 120, "outside");
                $redimensionar->saveToFile(DIRETORIO_SITE . $novoNome);


                /* REDIMENSIONAR E SALVAR A FOTO SITE DESCRICAO */
                $wide = WideImage::load($temporario);
                $redimensionar = $wide->resize(250, 200, "outside");
                $redimensionar->saveToFile(DIRETORIO_DESCRICAO . $novoNome);

                /* SALVAR NO BANCO DE DADOS */
                $dados = array(
                    1 => $genero,
                    2 => $nomeFilme,
                    3 => $preco,
                    4 => $slug,
                    5 => $lancamento,
                    6 => $recomendo,
                    7 => "fotos/site/" . $novoNome,
                    8 => "fotos/descricao/" . $novoNome,
                    9 => $descricao,
                    10 => $codigo,
                    11 => $id
                );

                /* EXCLUIR A FOTO ANTIGA ANTES DE CADASTRAR OS DADOS NO BANCO */
                unlink('../../../../' . $_POST['fotoSite']);
                unlink('../../../../' . $_POST['fotoSiteDetalhes']);
                /* EXCLUIR A FOTO ANTIGA ANTES DE CADASTRAR OS DADOS NO BANCO */

                if (alterarFilme($dados)):
                    $sucesso = "Filme alterado";
                    ?>
                    <script type="text/javascript">
                        setTimeout("window.close()", 2000);                              
                    </script>
                    <?php
                else:
                    $erro = "Erro ao alterar filme";
                    unlink(DIRETORIO_SITE . $novoNome);
                    unlink(DIRETORIO_DESCRICAO . $novoNome);
                endif;
            endif;
        /* PEGAR FOTO PARA ALTERAR NO BANCO */
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
        <script type="text/javascript" src="../../js/jquery.js"></script>
        <script type="text/javascript" src="../../bibliotecas/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript" src="../../js/initTiny.js"></script>
    </head>
    <body>
        <div class="form_cadastrar">

            <div class="form">
                <?php
                try {
                    if (filter_var($_GET['id'], FILTER_VALIDATE_INT)):
                        /* LISTAR OS DADOS DO ADMINISTRADOR */
                        $dadosFilme = pegarPeloId("filmes", "filmes_id", $_GET['id']);
                        ?>  

                        <h2>Alterar Cliente</h2>

                        <form action="" method="post" enctype="multipart/form-data">
                            <label for="nome">Nome:</label>
                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                            <input type="text" name="nome" class="input" value="<?php echo $dadosFilme->filmes_nome ?>" />

                            <label for="nome">Preço:</label>
                            <input type="text" name="preco" class="input" value="<?php echo $dadosFilme->filmes_preco ?>" />

                            <label for="genero">Gênero</label>
                            <select name="genero" class="input_select">
                                <?php
                                $categorias = listar("categorias");
                                $g = new ArrayIterator($categorias);
                                while ($g->valid()):
                                    ?>
                                    <option value="<?php echo $g->current()->categorias_id; ?>" <?php echo ($g->current()->categorias_id == $dadosFilme->filmes_categoria ? "selected='selected'" : $g->current()->categorias_id); ?>><?php echo $g->current()->categorias_nome; ?></option>
                                    <?php
                                    $g->next();
                                endwhile;
                                ?>
                            </select>

                            <label for="lancamento">Lançamento</label>
                            <select name="lancamento" class="input_select">                     
                                <option value="sim" <?php echo ($dadosFilme->filmes_lancamento == "sim" ? "selected='selected'" : $dadosFilme->filmes_lancamento); ?>>SIM</option>   
                                <option value="nao" <?php echo ($dadosFilme->filmes_lancamento == "nao" ? "selected='selected'" : $dadosFilme->filmes_lancamento); ?>>NÂO</option>   
                            </select>

                            <label for="recomendo">Recomendo</label>
                            <select name="recomendo" class="input_select">                     
                                <option value="sim" <?php echo ($dadosFilme->filmes_recomendo == "sim" ? "selected='selected'" : $dadosFilme->filmes_recomendo); ?>>SIM</option>   
                                <option value="nao" <?php echo ($dadosFilme->filmes_recomendo == "nao" ? "selected='selected'" : $dadosFilme->filmes_recomendo); ?>>NÂO</option>   
                            </select>

                            <label for="nome">Slug:</label>
                            <input type="text" name="slug" class="input" value="<?php echo $dadosFilme->filmes_slug; ?>" />

                            <label for="nome">Código:</label>
                            <input type="text" name="codigo" class="input" value="<?php echo $dadosFilme->filmes_codigo; ?>" />

                            <label for="foto">Foto:</label>
                            <input type="hidden" name="fotoSite" value="<?php echo $dadosFilme->filmes_foto; ?>" />
                            <input type="hidden" name="fotoSiteDetalhes" value="<?php echo $dadosFilme->filmes_foto_descricao; ?>" />
                            <input type="file" name="foto" class="input_file" />


                            <label for="descricao">Descrição:</label>
                            <textarea name="descricao"><?php echo $dadosFilme->filmes_descricao; ?></textarea>

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
        <script type="text/javascript" src="../../js/mask_plugin.js"></script>
        <script type="text/javascript" src="../../js/mask_clientes.js"></script>
    </body>
</html>
