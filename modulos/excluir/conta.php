<div id="pagina">

    <?php
    /*
     * VERIFICAR SE ESTA LOGADO E SE A CONTA QUE QUER EXCLUIR E A MESMO A DELE
     * VERIFICAR SE O CLIENTE TEM ALGUM FILME LOCADO
     * SE TIVER NAO DEIXA DELETAR A CONTA E MOSTRA MENSAGEM DE ERRO
     * SE NAO TIVER EXCLUI CLIENTE E FILMES LOCADOS DA TABELA LOCACOES CLIENTE
     */

    try {

        $dadosCliente = pegarPeloId("clientes", "clientes_nome", $_SESSION['nome_cliente']);
        if (empty($dadosCliente)):
            throw new Exception('Você não pode deletar essa conta, se o erro persistir entre em contato conosco');
        endif;


        if (isset($_SESSION['logado_cliente']) AND $_SESSION['nome_cliente'] == $dadosCliente->clientes_nome):

            //verificar se existe filme locado para o cliente
            $filmesLocados = listar('locados', 'where locados_cliente = ' . $dadosCliente->clientes_id);
            if (empty($filmesLocados)):
                //se estiver vazio pode deletar
                if (deletarCliente($dadosCliente->clientes_id)):

                    $comentarios_cliente = listar('comentarios', 'where comentarios_cliente = ' . $dadosCliente->clientes_id);
                    if (!empty($comentarios_cliente)):
                        $cc = new ArrayIterator($comentarios_cliente);
                        while ($cc->valid()):
                            deletarComentario($cc->current()->comentariilmesos_id);
                            $cc->next();
                        endwhile;
                    endif;

                    $sucesso = 'Conta excluida, muito obrigado por ficar a tanto tempo conosco<br />';
                    $sucesso .= 'Você será redirecionado em 5 segundos';
                    unset($_SESSION['logado_cliente']);
                    ?>
                    <meta http-equiv="refresh" content="5;URL='http://netfilmes.com.br/'">
                    <?php
                else:
                    throw new Exception('Ocorreu um erro ao tentar deletar sua conta, se o problema persistir entre em contato conosco');
                endif;
            else:
                //se nao estiver vazio nao pode deletar
                throw new Exception('Você não pode deletar essa conta, pois você ainda tem filmes pendentes para devolver');
            endif;

        else:
            throw new Exception('Você não pode deletar essa conta, se o erro persistir entre em contato conosco');
        endif;
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
    ?>
    <div class="mensagem">
        <?php echo isset($erro) ? $erro : ''; ?>
        <?php echo isset($sucesso) ? $sucesso : ''; ?> 
    </div>

</div>