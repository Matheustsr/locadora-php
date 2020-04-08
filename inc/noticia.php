<div id="pagina">   
    <?php
    try {
        /*
         * PEGA O SEGMENTO DA URL PARA USAR COMO SLUG
         */
        $slug = segmento_url($_GET['p'], 2);
        $noticia = pegarPeloId('noticias', 'noticias_slug', $slug);
        if (empty($noticia)):
            throw new Exception('Escolha uma notícia !');
        else:
            ?>

            <h2><?php echo $noticia->noticias_titulo; ?> - Data da notícia - <?php echo date('d/m/Y', strtotime($noticia->noticias_data)); ?></h2>
            <div id="noticia">
                <p><?php echo stripslashes(str_replace("\&quot;", '',$noticia->noticias_texto)); ?></p><br />           
            </div>
        </div>
    <?php
    endif;
} catch (Exception $e) {
    echo '<div class="erro_categoria">' . $e->getMessage() . '</div>';
}
?>
</div>