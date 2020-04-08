<div id="pagina">

    <?php
    if (isset($_SESSION['logado_cliente'])):

        /*PEGAR DADOS DO CLIENTE*/
        $idCliente = pegarPeloId("clientes", "clientes_nome", $_SESSION['nome_cliente']);
        ?>

        <h2>Minha conta - <?php echo $_SESSION['nome_cliente']; ?></h2>
        <div id="opcoes_cliente">
            <a href="#" onclick="janelaAlterar(<?php echo $idCliente->clientes_id; ?>,'cliente')">Editar</a> - <a href="http://netfilmes.com.br/modulos/excluir/conta">Encerrar Conta</a>
        </div>

        <div id="filme_devolver">
            <h4>Filmes para devolver</h4>
            <table width="780">
                <thead>
                <th>Foto</th>
                <th>Filme</th>
                <th>Devolução</th>
                <th>Preço</th>
                <th>Relocar</th>
                </thead>
                <tbody>
                    <?php
                    $filmesLocados = listar("locados", "inner join filmes on locados.locados_filme = filmes.filmes_id where locados_cliente = " . $idCliente->clientes_id);

                    if (empty($filmesLocados)):
                        echo '<tr class="lista_filmes_devolver"><td colspan="5" align="center">Nenhum filme para devolver</td></tr>';
                    else:


                        $fl = new ArrayIterator($filmesLocados);
                        while ($fl->valid()):
                            ?>
                            <tr class="lista_filmes_devolver">
                                <td><img src="<?php echo $fl->current()->filmes_foto ?>" width="45" height="35" /></td>
                                <td><?php echo $fl->current()->filmes_nome; ?></td>
                                <td><?php echo date("d/m/Y", strtotime($fl->current()->locados_devolucao)); ?></td>
                                <td>R$ <?php echo number_format($fl->current()->locados_valor, 2, ",", "."); ?></td>
                                <td><a href="http://netfilmes.com.br/relocar/filme/<?php echo $fl->current()->filmes_slug; ?>/locacao/<?php echo $fl->current()->locados_id; ?>">Relocar</a></td>
                            </tr>


                            <?php
                            $fl->next();
                        endwhile;
                    endif;
                    ?>
                </tbody>
            </table>
        </div>


        <div id="comentarios_cliente"></div>
        <div id="Pagination_comentarios" class="pagination"></div>

        <div class="fix"></div>

        <div id="locados_mes"></div>
        <div id="Pagination_locados" class="pagination"></div>

        <div class="fix"></div>

    <?php else: ?>
        <div class="mensagem">Você tem que estar logado para ver sua página !</div>
    <?php endif; ?>
</div>