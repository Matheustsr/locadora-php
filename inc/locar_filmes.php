<div id="pagina">
    <?php
    try {

        if (isset($_SESSION['logado_cliente'])):

            /* PEGA TIPO DE ENTREGA ESCOLHIDO PELO CLIENTE */
            if (!isset($_SESSION['tipo_entrega'])):
                $_SESSION['tipo_entrega'] = 'buscar';
            endif;
            

            $filmes_locados = array();
            /* PEGAR ID DOS FILMES PARA LOCAR */
            $l = new ArrayIterator($_SESSION['locar']);
            while ($l->valid()):

                $dadosFilme = pegarPeloId("filmes", "filmes_id", $l->key());
                $dadosCliente = pegarPeloId("clientes", "clientes_nome", $_SESSION['nome_cliente']);

                $filmes_locados[] = $dadosFilme->filmes_nome;

                $dados = array(
                    1 => $l->key(),
                    2 => date("Y-m-d H:i:s"),
                    3 => date("Y-m-d H:i:s", strtotime("2days")),
                    4 => $dadosCliente->clientes_id,
                    5 => "Locado",
                    6 => $dadosFilme->filmes_preco,
                    7 => $_SESSION['tipo_entrega']
                );

                if (finalizarLocacaoFilme($dados)):
                    locarFilmeCliente($dados);
                endif;
                $l->next();
            endwhile;
        else:
            throw new Exception("Você precisa estar logado para fazer a locação dos filmes");
        endif;
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }

    if (!isset($erro)):
        ?>
        <div class="mensagem">Você locou o(s) filme(s):<br />
            <?php
            foreach ($filmes_locados as $f):
                echo $f . "<br />";
            endforeach;
            ?><br />
            e será redirecionado em 5 segundos !
        </div><br />
        <?php
        if (!empty($_SESSION['locar'])):
            unset($_SESSION['locar']);
        endif;
        ?>
        <meta http-equiv="refresh" content="5;URL='http://netfilmes.com.br/minha_conta'">
        <?php
    else:
        echo '<div class="mensagem">' . $erro . '</div>';
    endif;
    ?>
</div>