<div id="pagina">
    <h2>Últimas Notícias</h2>
    <?php
    $noticias = listar('noticias', 'order by noticias_id DESC');

    $params = array(
        'mode' => 'Sliding',
        'perPage' => 10,
        'delta' => 2,
        'itemData' => $noticias
    );
    $pager = & Pager::factory($params);
    $data = $pager->getPageData();


    if (empty($data)):
        echo '<div id="mensagem">Nenhuma notícia cadastrada</div>';
    else:
        $n = new ArrayIterator($data);
        while ($n->valid()):
            ?>
            <div class="exibeNoticia">
                <h2><?php echo $n->current()->noticias_titulo; ?> -  Data da notícia <?php echo date("d/m/Y", strtotime($n->current()->noticias_data)); ?></h2>
                <p><?php echo stripslashes(strip_tags(resumeTexto($n->current()->noticias_texto, 500))); ?><br />
                    <span class="leiaMais"> <a href="http://netfilmes.com.br/noticia/<?php echo $n->current()->noticias_slug; ?>">Leia mais...</a></span></p>
            </div>
            <?php
            $n->next();
        endwhile;
    endif;
    ?>

    <div class="paginacao">
        <?php
        $links = $pager->getLinks();
        echo str_replace("index.php?p=","",$links['all']);
        ?>

    </div>

</div>