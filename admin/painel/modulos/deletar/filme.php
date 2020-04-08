<?php
require_once "../../functions/functions.php";
carregarArquivos(array('deletar', 'selecionar'));
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
                        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
                        ?>  

                        <h2>Deletar Filme</h2>
                        <?php
                        /* PEGA DADOS DO CLIENTE PARA DELETAR A FOTO */
                        $dadosFilme = pegarPeloId("filmes", "filmes_id", $id);
                        $foto = $dadosFilme->filmes_foto;
                        $fotoDetalhes = $dadosFilme->filmes_foto_descricao;

                        /* DELETAR A FOTO ANTES DE DELETAR */
                        unlink("../../../../" . $foto);
                        unlink("../../../../" . $fotoDetalhes);

                          if (deletarFilme($id, array('filmes','locacoes','locacoes_cliente'), array('filmes_id','locacoes_filme','locacoes_cliente_filme'))):
                            $sucesso = "Deletado com sucesso !";
                            ?>
                            <script type="text/javascript">
                                setTimeout("window.close()", 2000);                              
                            </script>
                            <?php
                        else:
                            $erro = "Erro ao deletar !";
                            ?>
                            <script type="text/javascript">
                                setTimeout("window.close()", 2000);                              
                            </script>
                        <?php
                        endif;

                        /* MENSAGENS */
                        echo isset($erro) ? '<div class="erro">' . $erro . '</div>' : '';
                        echo isset($sucesso) ? '<div class="sucesso">' . $sucesso . '</div>' : '';
                    /* MENSAGENS */

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
