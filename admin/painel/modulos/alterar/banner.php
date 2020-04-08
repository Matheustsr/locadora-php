<?php
require_once "../../functions/functions.php";
carregarArquivos(array('validacoes', 'selecionar', 'alterar'));
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


                        /* FAZ O UPDATE DO BANNER */
                        if (isset($_POST['ok'])):

                            $banner = validarDados($_FILES['banner']['name'], 'BANNER', 'STRING');
                            if (!isset($mensagem)):

                                /* EXCLUIR O BANNER ANTERIOR */
                                $dadosBanner = pegarPeloId('banners', 'banners_id', $_GET['id']);
                                if (!unlink('../../../../' . $dadosBanner->banners_caminho)):
                                    throw new Exception('Erro ao deletar foto');
                                endif;


                                /* PEGAR O NOME DA FOTO E RENOMEAR */
                                $extensao = end(explode(".", $banner));
                                $novoNome = uniqid() . "." . $extensao;
                                $temporario = $_FILES['banner']['tmp_name'];
                                define('DIR_BANNER', 'fotos/banners/');

                                if (move_uploaded_file($temporario, '../../../../' . DIR_BANNER . $novoNome)):
                                    /* FAZER O UPDATE DA FOTO NO BANCO */
                                    if (alterarABanner($novoNome, $_GET['id'])):
                                        $sucesso = 'Banner alterado';
                                        ?>
                                        <script type="text/javascript">
                                            setTimeout("window.close()", 2000);                              
                                        </script>
                                        <?php
                                    else:
                                        $erro = 'Erro ao alterar banner';
                                        unlink('../../../../' . DIR_BANNER . $novoNome);
                                    endif;
                                else:
                                    $erro = 'Erro ao fazer upload da foto';
                                endif;
                            else:
                                $erro = $mensagem;
                            endif;

                        endif;
                        ?>  

                        <h2>Alterar Banner</h2>

                        <form action="" method="post" enctype="multipart/form-data">

                            <label for="banner">Banner:</label>
                            <input type="file" name="banner" />

                            <label for="submit"></label>
                            <input type="submit" name="ok" value="Cadastrar" class="input_button" />
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

