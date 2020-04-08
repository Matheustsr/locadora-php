<?php

session_start();

if (!isset($_SESSION['tipo_entrega'])):
    $_SESSION['tipo_entrega'] = $_POST['tipo'];
else:
    if ($_SESSION['tipo_entrega'] != $_POST['tipo']):
        $_SESSION['tipo_entrega'] = $_POST['tipo'];
    endif;
endif;


    try {

        if (isset($_SESSION['logado_cliente'])):
            ?>

            <!--COMENTARIOS DO MES-->

            <div class="comentarios_mes">
                <h2>Filmes locados no mês de <?php echo pegaMesAtual(substr(date('m'), 1)) ?></h2>
                <?php $idCliente = pegarPeloId('clientes', 'clientes_nome', $_SESSION['nome_cliente']); ?>
                <?php
                $comentarios_mes = listar("comentarios", "INNER JOIN filmes ON comentarios.comentarios_filme = filmes_id WHERE comentarios_cliente = $idCliente->clientes_id");
                if (empty($comentarios_mes)):
                    echo '<div class="mensagem">Nenhum comentário feito no mês</div>';
                else:
                    ?>
                    <div class="div_filmes_locados_mes">
                        <table width="780" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Filme</th>
                                    <th align="center">Comentário</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cm = new ArrayIterator($comentarios_mes);
                                while ($cm->valid()):
                                    ?>
                                    <!--LISTAGEM DOS FILMES DO MES -->
                                    <tr class="tabela_filmes_locados">
                                        <td><?php echo $cm->current()->filmes_nome ?></td>
                                        <td><?php echo resumeTexto($cm->current()->comentarios_texto, 80); ?></td>                                 
                                    </tr>
                                    <?php
                                    $cm->next();
                                endwhile;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>



            <!--LOCADOS DO MES-->

            <div class="filmes_locados_mes">
                <h2>Filmes locados no mês de <?php echo pegaMesAtual(substr(date('m'), 1)) ?></h2>
                <?php
                $filmes_locados = listar("locacoes_cliente", "INNER JOIN filmes ON locacoes_cliente.locacoes_cliente_filme = filmes.filmes_id WHERE locacoes_cliente_nome = $idCliente->clientes_id AND locacoes_cliente_mes = " . substr(date('m'), 1));
                if (empty($filmes_locados)):
                    echo '<div class="mensagem">Nenhum filme locado esse mês</div>';
                else:
                    ?>
                    <div id="div_filmes_locados_mes">
                        <table width="780" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Filme</th>
                                    <th align="center">Quantidade de locações no mês</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $fm = new ArrayIterator($filmes_locados);
                                while ($fm->valid()):
                                    ?>
                                    <!--LISTAGEM DOS FILMES DO MES -->
                                    <tr class="tabela_filmes_locados">
                                        <td><img src="http://netfilmes.com.br/<?php echo $fm->current()->filmes_foto ?>" width="45" height="35" /></td>
                                        <td><?php echo $fm->current()->filmes_nome; ?></td>
                                        <td align="center"><?php echo $fm->current()->locacoes_cliente_total; ?></td>
                                    </tr>
                                    <?php
                                    $fm->next();
                                endwhile;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
        else:
            throw new Exception('Voce precisa estar logado');
        endif;
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }

    echo isset($erro) ? '<div class="erro_categoria">' . $erro . '</div>' : '';
    ?>
</div>


















if (preg_match("/http:\/\//", $_POST['noticia'])):
        $noticia = $_POST['noticia'];
    else:
        $noticia = str_replace("http:/", "http://", $_POST['noticia']);
    endif;



<!-- CSS PARA LISTAR LANCAMENTOS SEM JQUERY
#conteudo #listar_lancamentos{margin-top: 10px;width: 780px;}
#conteudo #listar_lancamentos li{float: left;width: 85px;height: 145px;margin-left: 23px;}
-->

<!--LANCAMENTOS COM JQUERY-->
<div class="lancamentos">
    <h2>LANÇAMENTOS</h2>
    <div id="listar_lancamentos">
        <div class="liquid">
            <span class="previous"><img src="http://netfilmes.com.br/imagens/previous.png" /></span>
            <div class="wrapper">
                <ul>
                    <?php
                    $listarLancamentos = listar("filmes", "where filmes_lancamento = 'sim' LIMIT 15");
                    $lan = new ArrayIterator($listarLancamentos);
                    while ($lan->valid()):
                        ?>
                        <li>
                            <a href="http://netfilmes.com.br/detalhes/<?php echo $lan->current()->filmes_slug; ?>"><img src="http://netfilmes.com.br/<?php echo $lan->current()->filmes_foto; ?>" width="80" height="90" alt="<?php echo $lan->current()->filmes_slug; ?>"/></a>
                            <br />
                            <span id="nome_filme"><?php echo $lan->current()->filmes_nome; ?></span>
                        </li>

                        <?php
                        $lan->next();
                    endwhile;
                    ?>
                </ul>
            </div>
            <span class="next"><img src="http://netfilmes.com.br/imagens/next.png" /></span>
        </div>
    </div>
</div><!-- lancamentos -->


<div id="pagina">
    <h2>Meus Filmes Escolhidos</h2>
    <?php
    try {
        /* PEGA O SEGMENTO DA URL PARA USAR COMO SLUG */
        if (substr_count($_GET['p'], '/') <= 0):
            
            $valor = array_keys($_SESSION['locar']);
            $filmeEscolhido = pegarPeloId('filmes', 'filmes_id', $valor[0]);
            $segmento = $filmeEscolhido->filmes_slug;
        else:
            $segmento = count(explode("/", $_GET['p']));
         $slug = segmento_url($_GET['p'], $segmento);
        endif;
        
       

        $filmes = pegarPeloId('filmes', 'filmes_slug', $slug);
        print_r($filmes);
        
        $totalLocacao = 0;

        if (empty($filmes)):
            throw new Exception("Escolha um filme para locar");
        else:

            $filmes_escolhidos = locarFilme($filmes->filmes_id);
            $f = new ArrayIterator($filmes_escolhidos);
            ?>
            <table width="780" cellspacing="0" id="tabela_meus_filmes">
                <thead>
                    <tr class="titulo_tabela_filmes_locados">
                        <th>Foto</th>
                        <th>Filme</th>
                        <th>Preço</th>
                        <th>Remover</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($f->valid()):
                        $filmes = pegarPeloId("filmes", "filmes_id", $f->key());
                        $totalLocacao += $filmes->filmes_preco;
                        ?>
                        <tr class="tabela_filmes_locados">
                            <td><img src="http://netfilmes.com.br/<?php echo $filmes->filmes_foto ?>" width="45" height="35"/></td>
                            <td><?php echo $filmes->filmes_nome ?></td>
                            <td> R$ <?php echo number_format($filmes->filmes_preco, 2, ",", "."); ?></td>
                            <td align="center"><img src="http://netfilmes.com.br/imagens/delete.png" /></td>
                        </tr>

                        <?php
                        $f->next();
                    endwhile;
                endif;
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            ?>
            <tr><td colspan="1" class="total_meus_filmes">Total: R$ <?php echo number_format($totalLocacao, 2, ",", "."); ?></td>
                <td colspan="1" class="total_meus_filmes"><a href="">Locar Filmes</a></td>
                <td colspan="2" class="total_meus_filmes"><a href="http://netfilmes.com.br">Continuar Locando</a></td>
            </tr>
        <tbody>
    </table>
</div>


<?php
session_start();
require_once '../../functions/functions.php';
carregarArquivos(array('selecionar'));
?>
<table width="780" cellspacing="0" id="tabela_meus_filmes">
    <thead>
        <tr class="titulo_tabela_filmes_locados">
            <th>Foto</th>
            <th>Filme</th>
            <th>Preço</th>
            <th align="center">Remover</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totalLocacao = 0;
        $f = new ArrayIterator($_SESSION['locar']);
        while ($f->valid()):
            $filmes = pegarPeloId("filmes", "filmes_id", $f->key());
            $totalLocacao += $filmes->filmes_preco;
            ?>
            <tr class="tabela_filmes_locados">
                <td><img src="http://netfilmes.com.br/<?php echo $filmes->filmes_foto ?>" width="45" height="35"/></td>
                <td><?php echo $filmes->filmes_nome ?></td>
                <td> R$ <?php echo number_format($filmes->filmes_preco, 2, ",", "."); ?></td>
                <td align="center"><img src="http://netfilmes.com.br/imagens/delete.png" /></td>
            </tr>
            <?php
            $f->next();
        endwhile;
        ?>
        <tr>
            <td colspan="1" class="total_meus_filmes">Total: R$ <?php echo number_format($totalLocacao, 2, ",", "."); ?></td>
            <td colspan="1" class="total_meus_filmes"><a href="">Locar Filmes</a></td>
            <td colspan="2" class="total_meus_filmes"><a href="http://netfilmes.com.br">Continuar Locando</a></td>
        </tr>
    <tbody>
</table>



<div id="pagina">

    <?php
    try {

        if (isset($_SESSION['logado_cliente'])):
            ?>

            <!--COMENTARIOS DO MES-->

            <div class="comentarios_mes">
                <h2>Filmes locados no mês de <?php echo pegaMesAtual(substr(date('m'), 1)) ?></h2>
                <?php $idCliente = pegarPeloId('clientes', 'clientes_nome', $_SESSION['nome_cliente']); ?>
                <?php
                $comentarios_mes = listar("comentarios", "INNER JOIN filmes ON comentarios.comentarios_filme = filmes_id WHERE comentarios_cliente = $idCliente->clientes_id");
                if (empty($comentarios_mes)):
                    echo '<div class="mensagem">Nenhum comentário feito no mês</div>';
                else:
                    ?>
                    <div class="div_filmes_locados_mes">
                        <table width="780" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Filme</th>
                                    <th align="center">Comentário</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cm = new ArrayIterator($comentarios_mes);
                                while ($cm->valid()):
                                    ?>
                                    <!--LISTAGEM DOS FILMES DO MES -->
                                    <tr class="tabela_filmes_locados">
                                        <td><?php echo $cm->current()->filmes_nome ?></td>
                                        <td><?php echo resumeTexto($cm->current()->comentarios_texto, 80); ?></td>                                 
                                    </tr>
                                    <?php
                                    $cm->next();
                                endwhile;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>



            <!--LOCADOS DO MES-->

            <div class="filmes_locados_mes">
                <h2>Filmes locados no mês de <?php echo pegaMesAtual(substr(date('m'), 1)) ?></h2>
                <?php
                $filmes_locados = listar("locacoes_cliente", "INNER JOIN filmes ON locacoes_cliente.locacoes_cliente_filme = filmes.filmes_id WHERE locacoes_cliente_nome = $idCliente->clientes_id AND locacoes_cliente_mes = " . substr(date('m'), 1));
                if (empty($filmes_locados)):
                    echo '<div class="mensagem">Nenhum filme locado esse mês</div>';
                else:
                    ?>
                    <div id="div_filmes_locados_mes">
                        <table width="780" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Filme</th>
                                    <th align="center">Quantidade de locações no mês</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $fm = new ArrayIterator($filmes_locados);
                                while ($fm->valid()):
                                    ?>
                                    <!--LISTAGEM DOS FILMES DO MES -->
                                    <tr class="tabela_filmes_locados">
                                        <td><img src="http://netfilmes.com.br/<?php echo $fm->current()->filmes_foto ?>" width="45" height="35" /></td>
                                        <td><?php echo $fm->current()->filmes_nome; ?></td>
                                        <td align="center"><?php echo $fm->current()->locacoes_cliente_total; ?></td>
                                    </tr>
                                    <?php
                                    $fm->next();
                                endwhile;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
        else:
            throw new Exception('Voce precisa estar logado');
        endif;
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }

    echo isset($erro) ? '<div class="erro_categoria">' . $erro . '</div>' : '';
    ?>
</div>
