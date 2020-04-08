<div id="pagina">
    <div id="mensagens_comentarios">
        <?php
        try {
            if (isset($_SESSION['logado_cliente']) AND isset($_POST['comentou']) == 'ok'):

                /* PEGAR NOME DO FILME PELO CAMPO ID VINDO DE UM CAMPO OCULTO DO FORMULARIO DE COMENTARIO */
                $filme = pegarPeloId('filmes', 'filmes_id', $_POST['id']);

                $comentario = validarDados($_POST['comentario'], 'COMENTARIO', 'STRING');
                global $mensagem;

                if (!isset($mensagem)):

                    $cliente = pegarPeloId('clientes', 'clientes_nome', $_SESSION['nome_cliente']);
                    $dados = array($cliente->clientes_id, $_POST['filme'], $comentario);
                    if (cadastrarComentario($dados)):

                        echo "<div class='sucesso'>Comentário cadastrado, seu comentário estará dispnível assim que for aprovado por nós !</div><br />";
                        ?>
                        <a href="http://netfilmes.com.br/detalhes/filme/<?php echo $filme->filmes_slug; ?>">Voltar</a>
                        <?php
                    else:
                        $erro = 'Erro ao fazer comentário, tente novamente, se o erro persistir, entre em contato conosco pelo e-mail contato@asolucoesweb.com.br';
                    endif;
                else:
                    $erro = $mensagem;
                endif;
            else:
                throw new Exception('Você tem que estar logado e escrever um comentário');
            endif;
        } catch (Exception $e) {
            $erro = $e->getMessage();
        }
        ?>
    </div>
    <!--SE EXISTIR ALGUM ERRO AO CADASTRAR O COMENTARIO MOSTRA A MENSAGEM-->
    <div id="erroComentario">
        <?php
        if (isset($erro)):
            echo $erro;
            ?>
            <a href="http://netfilmes.com.br/detalhes/filme/<?php echo $filme->filmes_slug; ?>">Voltar</a>
            <?php
        endif;
        ?>
    </div>
</div>