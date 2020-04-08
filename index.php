<?php
session_start();
require_once 'functions/functions.php';
carregarArquivos(array('selecionar', 'url', 'logar', 'validacoes', 'Pager', 'busca', 'cadastrar', 'datas', 'locar', 'wide_image', 'deletar','email'));

/* FAZER LOGIN */
if (isset($_POST['logar'])):
    $login = validarDados($_POST['login'], 'LOGIN', 'STRING');
    $senha = validarDados($_POST['senha'], 'SENHA', 'STRING');
    if (!isset($mensagem)):
        (!logar($login, $senha)) ? $erroLogin = 'Login ou senha inválidos' : '';
    else:
        $erroLogin = $mensagem;
    endif;
endif;
/* FAZER LOGIN */

/* FAZER LOGOUT */
if (isset($_GET['logout'])):
    if ($_GET['logout'] == 'ok'):
        (logOut()) ? header('Location: http://netfilmes.com.br') : $erroLogin = 'Erro ao deslogar';
    endif;
endif;
/* FAZER LOGOUT */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Locadora</title>
        <link rel="stylesheet" media="screen" type="text/css" href="http://netfilmes.com.br/css/style.css" />
        <link rel="stylesheet" media="screen" type="text/css" href="http://netfilmes.com.br/css/estilo.css" />
        <link rel="stylesheet" media="screen" type="text/css" href="http://netfilmes.com.br/css/gallery_view.css" />
        <link rel="stylesheet" media="screen" type="text/css" href="http://netfilmes.com.br/css/liquidcarousel.css" />
        <link rel="stylesheet" media="screen" type="text/css" href="http://netfilmes.com.br/css/qtip.css" />
        <link rel="stylesheet" media="screen" type="text/css" href="http://netfilmes.com.br/css/pagination_jquery.css" />
        <link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css' />  
        <script type="text/javascript" src="http://netfilmes.com.br/js/jquery.js"></script>

    </head>
    <body>                          
        <div id="topo">
            <div class="logo">
                <a href="http://netfilmes.com.br/"><img src="http://netfilmes.com.br/imagens/logo.png" width="215" height="70" alt="Logo" /></a>
            </div><!-- logo -->

            <div class="menu">
                <?php require_once 'inc/menu_topo.php'; ?>
            </div><!-- menu -->
        </div>

        <div id="tudo">
            <div id="sidebar">
                <?php require_once 'inc/sidebar.php'; ?>
            </div><!-- sidebar -->

            <div id="conteudo">
                <div class="ptcima">
                    <?php require_once 'inc/redes_sociais.php'; ?>
                </div>

                <?php
                try {
                    if (isset($_GET['p'])):
                        carregarPagina($_GET['p']);
                    else:
                        require_once 'inc/home.php';
                    endif;
                } catch (Exception $e) {
                    echo '<div id="erro404">' . $e->getMessage() . '</div>';
                }
                ?>
            </div><!-- conteudo -->
        </div><!-- tudo -->

        <div id="rodape">
            netfilmes 2012 - Todos direitos reservados<br />
            É proibida a reprodução total ou parcial de qualquer conteúdo do site.
        </div><!-- rodape -->
    </body>
    <!--EDITAR COMENTARIO-->
    <script type="text/javascript" src="http://netfilmes.com.br/js/editar_comentario.js"></script>

    <!--SLIDE DE FILMES-->   
    <script type="text/javascript" src="http://netfilmes.com.br/js/jquery_timer.js"></script>
    <script type="text/javascript" src="http://netfilmes.com.br/js/jquery_gallery.js"></script>
    <script type="text/javascript" src="http://netfilmes.com.br/js/galleryInit.js"></script>

    <!--SLIDES DE LANCAMENTOS-->
    <script type="text/javascript" src="http://netfilmes.com.br/js/jquery_lancamentos.js"></script>
    <script type="text/javascript" src="http://netfilmes.com.br/js/carouselInit.js"></script>

    <!--QTIP-->
    <script type="text/javascript" src="http://netfilmes.com.br/js/qtip.js"></script>
    <script type="text/javascript" src="http://netfilmes.com.br/js/qtipInit.js"></script> 

    <!--PAGINACAO JQUERY MEUS DADOS-->
    <script type="text/javascript" src="http://netfilmes.com.br/js/pagination_jquery.js"></script> 
    <script type="text/javascript" src="http://netfilmes.com.br/js/pagination_jquery_comentarios_minha_conta.js"></script>
    <script type="text/javascript" src="http://netfilmes.com.br/js/pagination_jquery_locados_mes_minha_conta.js"></script> 

    <!--MASK CADASTRO CLIENTES-->
    <script type="text/javascript" src="http://netfilmes.com.br/js/mask_plugin.js"></script> 
    <script type="text/javascript" src="http://netfilmes.com.br/js/mask_clientes.js"></script>

    <!--EDITAR CLIENTE-->
    <script type="text/javascript" src="http://netfilmes.com.br/js/editar_cliente.js"></script> 

    <!--TIPO ENTREGA-->
    <script type="text/javascript" src="http://netfilmes.com.br/js/tipo_entrega.js"></script> 

</html>