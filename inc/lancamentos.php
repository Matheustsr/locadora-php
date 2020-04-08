<div id="pagina">
    <h3>Lançamentos</h3>
    <?php
    $listar = listar("filmes", " where filmes_lancamento = 'sim' order by filmes_nome ASC");

    /* PAGINACAO COM PAGER DO PEAR */
    $params = array(
        'mode' => 'Sliding',
        'perPage' => 15,
        'delta' => 2,
        'itemData' => $listar
    );
    $pager = & Pager::factory($params);
    $data = $pager->getPageData();
    /* PAGINACAO COM PAGER DO PEAR */


    if (empty($data)):
        echo '<div class="erro_categoria">' . 'Nenhum filme cadastrado como lançamento' . '</div>';
    else:
        $c = new ArrayIterator($data);
        while ($c->valid()):
            ?>
            <!--FAZ A LISTAGEM DOS FILMES-->
            <div class="filmes_categoria">

                <?php
                /* VERIFICA SE FILME ESTA LOCADO E COLOCA UMA FAIXA EM CIMA DA FOTO DO FILME */
                $verificaLocado = listar('locados', 'where locados_filme = ' . $c->current()->filmes_id);

                if (!empty($verificaLocado)):
                    ?>
                    <div class="faixa_locado"><img src="http://netfilmes.com.br/imagens/faixa.png" /></div>
                    <?php
                endif;
                ?>

                <h3><?php echo $c->current()->filmes_nome; ?></h3>
                <div class="foto_filme_categoria"><img src="http://netfilmes.com.br/<?php echo $c->current()->filmes_foto; ?>" /></div>
                <div class="dados_filme">
                    <?php echo "Código do filme " . $c->current()->filmes_codigo; ?><br />
                    <?php echo "R$ " . number_format($c->current()->filmes_preco, 2, ",", "."); ?><br /><br />
                    <a href="http://netfilmes.com.br/detalhes/filme/<?php echo $c->current()->filmes_slug; ?>" class="bt_detalhes">Detalhes</a>
                    | 

                    <?php
                    if (!empty($verificaLocado)):
                        ?>
                        Filme Locado
                        <?php
                    else:
                        //SE ESTIVER LOGADO VAI DIRETO PARA A PAGINA MEUS FILMES SENAO VAI PARA A PAGINA
                        //VERIFICA_LOGADO
                        (!isset($_SESSION['logado_cliente'])) ? $link = 'verifica_logado' : $link = 'meus_filmes/filme/' . $c->current()->filmes_slug;

                        if (isset($_SESSION['locar']) && array_key_exists($c->current()->filmes_id, $_SESSION['locar'])):

                            echo 'Filme já escolhido';
                        else:
                            ?>
                            <a href="http://netfilmes.com.br/<?php echo $link; ?>" class="locar_filme">Locar Filme</a>
                        <?php
                        endif;
                    endif;
                    ?>
                </div>
            </div>
            <!--FAZ A LISTAGEM DOS FILMES-->
            <?php
            $c->next();
        endwhile;
        ?>
        <div class="paginacao">
            <?php
            $links = $pager->getLinks();
            echo str_replace("index.php?p=", "", $links['all']);
            ?>

        </div>
    <?php
    endif;
    ?>

    <div class="fix"></div>
</div>