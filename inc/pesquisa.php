<div id="pagina">
    <h2>Busca</h2>
    <?php
    try {
        if (isset($_POST['ok']) || isset($_SESSION['pesquisa'])):

            if (isset($_POST['pesquisa'])):
                if (isset($_SESSION['pesquisa'])):
                    unset($_SESSION['pesquisa']);
                endif;
                $_SESSION['pesquisa'] = $_POST['pesquisa'];
            endif;

            $busca = validarDados($_SESSION['pesquisa'], 'BUSCA', 'STRING');

            global $mensagem;
            if (!isset($mensagem)):
                $resultado_busca = busca($busca);

                if (!empty($resultado_busca)):

                    /* PAGINACAO COM PAGER DO PEAR */
                    $params = array(
                        'mode' => 'Sliding',
                        'perPage' => 15,
                        'delta' => 2,
                        'urlVar' => 'pag',
                        'itemData' => $resultado_busca
                    );
                    $pager = & Pager::factory($params);
                    $data = $pager->getPageData();
                    /* PAGINACAO COM PAGER DO PEAR */


                    /* FAZ A LISTAGEM DOS FILMES PESQUISADOS */
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
                            /* VERIFICA SE FILME ESTA LOCADO E COLOCA UMA FAIXA EM CIMA DA FOTO DO FILME */
                            ?>

                            <h3><?php echo $c->current()->filmes_nome; ?></h3>
                            <div class="foto_filme_categoria"><img src="http://netfilmes.com.br/<?php echo $c->current()->filmes_foto; ?>" /></div>
                            <div class="dados_filme">
                                <?php echo "Código do filme " . $c->current()->filmes_codigo; ?><br />
                                <?php echo "R$ " . number_format($c->current()->filmes_preco, 2, ",", "."); ?><br /><br />
                                <a href="http://netfilmes.com.br/detalhes/filme/<?php echo $c->current()->filmes_slug; ?>" class="bt_detalhes">Detalhes</a> | 

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
                    /* FAZ A LISTAGEM DOS FILMES PESQUISADOS */
                    ?>


                    <!--PAGINACAO-->
                    <div class="paginacao">
                        <?php
                        $links = $pager->getLinks();
                        echo str_replace('index.php', '', $links['all']);
                        ?>
                    </div>
                    <!--PAGINACAO-->


                    <?php
                else:
                    throw new Exception('Nenhum resultado encontrado para ' . $busca);
                endif;

            else:
                throw new Exception($mensagem);
            endif;
        else:
            throw new Exception('Busca Inválida !');
        endif;
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }

    echo (isset($erro)) ? '<div id="erroBusca">' . $erro . '</div>' : '';
    ?>

</div>