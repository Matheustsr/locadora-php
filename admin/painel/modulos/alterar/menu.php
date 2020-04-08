<?php
require_once "../../functions/functions.php";
carregarArquivos(array('validacoes', 'alterar', 'selecionar'));
if (isset($_POST['ok']) AND $_SERVER['REQUEST_METHOD'] == 'POST'):

    $nome = validarDados($_POST['nome'], "NOME", "STRING");
    $slug = validarDados($_POST['slug'], "slug", "STRING");
    $link = validarDados($_POST['link'], "link", "STRING");

    if (!isset($mensagem)):
        
        $dados = array(
            1 => $nome,
            2 => $slug,
            3 => $link,
            4 => $_GET['id']
        );

        if (alterarMenu($dados)):
            $sucesso = "Menu alterado";
            ?>
            <script type="text/javascript">
                setTimeout("window.close()", 2000);                              
            </script>
            <?php
        else:
            $erro = "Erro ao alterar menu";
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
                        $dadosMenu = pegarPeloId("menus", "menus_id", $_GET['id']);
                        ?>  

                        <h2>Alterar Menu</h2>

                        <form action="" method="post" enctype="multipart/form-data">
                            <label for="nome">Categoria:</label>
                            <input type="text" name="nome" class="input" value="<?php echo $dadosMenu->menus_nome; ?>" />

                            <label for="slug">Slug:</label>
                            <input type="text" name="slug" class="input" id="slug" value="<?php echo $dadosMenu->menus_slug; ?>" />

                            <label for="link">Link:</label>
                            <input type="text" name="link" class="input" id="link" value="<?php echo $dadosMenu->menus_link; ?>" />
                                                   
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
        <script type="text/javascript" src="../../js/jquery.js"></script>
        <script type="text/javascript" src="../../js/menu.js"></script>
    </body>
</html>
