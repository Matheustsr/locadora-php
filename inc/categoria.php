<div id="pagina">
    <?php
    try {
        /*
         * PEGA O SEGMENTO DA URL PARA USAR COMO SLUG
         */
        $slug = segmento_url($_GET['p'], 2);
        $filmes = pegarPeloId('categorias', 'categorias_slug', $slug);
        if (empty($filmes)):
            throw new Exception('Escolha uma categoria !');
        else:
            ?>
            <!--PEGAR O NOME DA CATEGORIA ATUAL-->
            <h2><?php echo $filmes->categorias_nome; ?></h2>
            <?php
            /*
             * PEGAR ID PARA LISTAR OS FILMES DA CATEGORIA ESCOLHIDA
             */
            $id = $filmes->categorias_id;


            /*
             * LISTAR OS FILMES DA CATEGORIA
             */
            $idCategoria = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            if (filter_var($idCategoria, FILTER_VALIDATE_INT)):
                $listar = listar("filmes", " where filmes_categoria = $id order by filmes_nome ASC");


                /* PAGINACAO COM PAGER DO PEAR */
                $params = array(
                    'mode' => 'Sliding',
                    'perPage' => 5,
                    'delta' => 2,
                    'itemData' => $listar
                );
                $pager = & Pager::factory($params);
                $data = $pager->getPageData();
                /* PAGINACAO COM PAGER DO PEAR */


                if (empty($data)):
                    echo '<div class="erro_categoria">' . 'Nenhum filme cadastrado para essa categoria' . '</div>';
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

                    <div class="fix"></div>

                    <!--PAGINACAO-->
                    <div class="paginacao">
                        <?php
                        $links = $pager->getLinks();
                        echo str_replace("index.php?p=", "", $links['all']);
                        ?>

                    </div>
                    <!--PAGINACAO-->


                <?php
                endif;
            else:
                echo '<div class=erro_categoria">' . 'Essa categoria não existe' . '</div>';
            endif;
        endif;
    } catch (Exception $e) {
        echo '<div class="erro_categoria">' . $e->getMessage() . '</div>';
    }
    ?>
</div>