<div id="pagina">
    <?php
    try {

        if (isset($_SESSION['logado_cliente'])):

            $slug = segmento_url($_GET['p'], 3);
            $idFilme = pegarPeloId("filmes", "filmes_slug", $slug);
            $idLocacao = segmento_url($_GET['p'], 5);

            $valor = pegarPeloId("locados", "locados_id", $idLocacao);
            $preco_locacao = pegarPeloId("filmes", "filmes_id", $idFilme->filmes_id);

            $dados = array(
                1 => $idFilme->filmes_id,
                2 => date("Y-m-d H:i:s", strtotime("+2days")),
                3 => $valor->locados_valor + $preco_locacao->filmes_preco,
                4 => $valor->locados_cliente,
                5 => date("Y-m-d H:i:s"),
                6 => $idLocacao,
            );


            if (relocar($dados))
                locarFilmeCliente($dados);
            ?>
            <div class="mensagem">Você relocou o filme <?php echo $idFilme->filmes_nome; ?>, e será redirecionado para sua página em 5 segundos.</div><br />
            <meta http-equiv="refresh" content="5;URL='http://netfilmes.com.br/minha_conta'">
            <?php
        //header("Location: http://netfilmes.com.br/minha_conta");



        endif;
    } catch (Exeption $e) {
        $erro = $e->getMessage();
    }

    echo isset($erro) ? '<div class="mensagem">' . $erro . '</div>' : '';
    ?>      
</div>