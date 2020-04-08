<div id="pagina">

    <?php
    try {

        $slug = segmento_url($_GET['p'], 3);
        $dadosFilme = pegarPeloId('filmes', 'filmes_slug', $slug);

        if (empty($dadosFilme)):
            throw new Exception('Escolha um filme para deletar');
        else:
        unset($_SESSION['locar'][$dadosFilme->filmes_id]);
        header('Location: http://netfilmes.com.br/meus_filmes');
        endif;
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
    echo (isset($erro)) ? '<div class="mensagem">' . $erro . '<div>' : '';
    ?>
</div>
