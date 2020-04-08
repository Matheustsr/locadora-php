<?php
require_once "../../functions/functions.php";
carregarArquivos(array('deletar'));
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

                        <h2>Deletar Menu</h2>
                        <?php
                        if (deletarMenu($id)):
                            $sucesso = "Deletado com sucesso !";
                            ?>
                            <script type="text/javascript">
                                setTimeout("window.close()", 2000);                              
                            </script>
                            <?php
                        else:
                            $erro = "Erro ao deletar !";
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
