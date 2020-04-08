<div class="destaques">

    <ul id="myGallery">
        <?php
        $banners = listar('banners');
        $b = new ArrayIterator($banners);
        while ($b->valid()):
            ?>
            <li><img src="http://netfilmes.com.br/<?php echo $b->current()->banners_caminho; ?>" alt="<?php echo $b->current()->banners_slug; ?>" data-href="http://netfilmes.com.br/detalhes/filmes/<?php echo $b->current()->banners_slug; ?>"> </li></a>
            <?php
            $b->next();
        endwhile;
        ?>
    </ul>
</div><!-- destaques -->

<!-- LANCAMENTOS -->
<div class="lancamentos">
    <h2>LANÇAMENTOS</h2>
    <div id="listar_lancamentos">
        <div class="liquid">
            <span class="previous"><img src="http://netfilmes.com.br/imagens/previous.png" /></span>
            <div class="wrapper">
                <ul>
                    <?php
                    $listarLancamentos = listar("filmes", "where filmes_lancamento = 'sim'order by filmes_id DESC LIMIT 15");
                    $lan = new ArrayIterator($listarLancamentos);
                    while ($lan->valid()):
                        ?>
                        <li>
                            <a href="http://netfilmes.com.br/detalhes/filme/<?php echo $lan->current()->filmes_slug; ?>"><img src="http://netfilmes.com.br/<?php echo $lan->current()->filmes_foto; ?>" width="80" height="90" alt="<?php echo $lan->current()->filmes_slug; ?>"/></a>
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


<div class="en">
    <div class="publicidade">
        <img src="http://netfilmes.com.br/imagens/publicidade.png" />
    </div><!-- enquete -->

    <div class="noticias">
        <h4>ÚLTIMAS NOTÍCIAS</h4>
        <ul>
            <?php
            $noticias = listar('noticias', 'order by noticias_id DESC LIMIT 4');
            $n = new ArrayIterator($noticias);
            while ($n->valid()):
                ?>
                <li>
                    <span class="data_noticia">Data da notícia - <?php echo date("d/m/Y", strtotime($n->current()->noticias_data)); ?></span><br />
                    <a href="http://netfilmes.com.br/noticia/<?php echo $n->current()->noticias_slug; ?>"><?php echo resumeTexto(strip_tags(stripslashes($n->current()->noticias_texto)), 150); ?></a>
                </li>
                <?php
                $n->next();
            endwhile;
            ?>
            <span class="vejamais"><a href="http://netfilmes.com.br/noticias">Veja todas as notícias...</a></span>
        </ul>
    </div><!-- noticias -->
    <div class="fix"></div>
</div><!-- en -->

<div class="filmesmenu">
    <h4>FILMES RECOMENDADOS</h4>
    <div id="listar_recomendados">
        <ul>
            <?php
            $listarRecomendados = listar("filmes", "where filmes_recomendo = 'sim' order by rand() LIMIT 6");
            $r = new ArrayIterator($listarRecomendados);
            while ($r->valid()):
                ?>
                <li>
                    <a href="http://netfilmes.com.br/detalhes/filme/<?php echo $r->current()->filmes_slug; ?>"><img src="http://netfilmes.com.br/<?php echo $r->current()->filmes_foto; ?>" width="100" height="90" alt="<?php echo $r->current()->filmes_slug; ?>"/></a>
                    <br />
                    <span id="nome_filme"><?php echo $r->current()->filmes_nome; ?></span>
                </li>

                <?php
                $r->next();
            endwhile;
            ?>
        </ul>
        <div class="fix"></div>
    </div>
</div><!-- filmesmenu -->
