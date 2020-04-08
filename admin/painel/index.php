<?php
session_start();
require_once "functions/functions.php";
carregarArquivos(array("cadastrar", "alterar", "deletar", "datas", "url", "selecionar", "Pager", "validacoes", "logar"));

if (isset($_GET['logout']) == 'ok'):
    logOut();
endif;

verificaAutorizacao();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Painel Administrativo</title>

        <link href="css/main.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css' />
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="bibliotecas/tiny_mce/tiny_mce.js"></script>
        <script type="text/javascript" src="js/initTiny.js"></script>
        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        <script type="text/javascript">google.load('visualization', '1', {packages: ['corechart']});</script>
    </head>

    <body>

        <!-- Top navigation bar -->
        <div id="topNav">
            <div class="fixed">
                <div class="wrapper">
                    <div class="welcome"><a href="#" title=""><img src="images/userPic.png" alt="" /></a><span>Bem vindo <?php echo $_SESSION['nome_admin']; ?></span></div>
                    <div class="userNav">
                        <ul>
                            <li class="dd"><img src="images/icons/topnav/messages.png" alt="" /><span>Comentários</span><span class="numberTop"><?php echo contar('comentarios'); ?></span></li>
                            <li><img src="images/icons/topnav/logout.png" alt="" /><span><a href="?logout=ok">Logout</a></span></li>
                        </ul>
                    </div>
                    <div class="fix"></div>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div id="header" class="wrapper">
            <div class="logo"><a href="index.php" title=""><img src="imagens/logo.png" alt="" /></a></div>
            <div class="middleNav">
                <ul>
                    <li class="iMes"><a href="#" title=""><span>Notícias</span></a><span class="numberMiddle"><?php echo contar('noticias'); ?></span></li>
                    <li class="iUser"><a href="#" title=""><a href="?p=clientes" title=""><span>Lista Clientes</span></a></a></li>
                </ul>
            </div>
            <div class="fix"></div>
        </div>


        <!-- Content wrapper -->
        <div class="wrapper">

            <!-- Left navigation -->
            <div class="leftNav">
                <ul id="menu">
                    <li class="dash"><a href="http://netfilmes.com.br/admin/painel/" title="" class="active"><span>Painel</span></a></li>
                    <li class="forms"><a href="?p=administradores" title=""><span>Administradores</span></a></li>
                    <li class="login"><a href="?p=clientes" title=""><span>Clientes</span></a></li>
                    <li class="typo"><a href="?p=filmes" title=""><span>Filmes</span></a></li>
                    <li class="pic"><a href="?p=comentarios" title=""><span>Comentários</span></a></li>
                    <li class="contacts"><a href="?p=noticias" title=""><span>Notícias</span></a></li>        
                    <li class="typo"><a href="?p=categorias" title=""><span>Categorias/Gêneros</span></a></li>
                    <li class="gallery"><a href="?p=menus"><span>Menu</span></a></li>    
                    <li class="pic"><a href="?p=banners" title=""><span>Banners</span></a></li>
                    <li class="contacts"><a href="?p=emails" title=""><span>E-mails</span></a></li>             
                </ul>
            </div>

            <!-- Content -->
            <div class="content">
                <?php
                try {
                    if (isset($_GET['p'])):
                        mudaUrl($_GET['p']);
                    else:
                        include_once 'inc/home.php';
                    endif;
                } catch (Exception $e) {
                    echo '<div id="erro">Erro:' . $e->getMessage() . '</div>';
                }
                ?>
            </div>
            <div class="fix"></div>
        </div>

        <!-- Footer -->
        <div id="footer">
            <div class="wrapper">
                <span>NetFilmes 2012 - Todos direitos reservados</span>
            </div>
        </div>
        <script type="text/javascript" src="js/customJS.js"></script>
        <script type="text/javascript" src="js/locar.js"></script>
        <script type="text/javascript" src="js/buscar_locados.js"></script>
        <script type="text/javascript" src="js/categoria.js"></script>
        <script type="text/javascript" src="js/menu.js"></script>
        <script type="text/javascript" src="js/lancamentos.js"></script>
        <script type="text/javascript" src="js/aprovar_comentario.js"></script>
    </body>
</html>
