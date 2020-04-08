<div id="pagina">
    <h2>Meus Filmes Escolhidos</h2>
    <?php
    try {
        if (isset($_SESSION['logado_cliente'])):
            /* PEGA O SEGMENTO DA URL PARA USAR COMO SLUG */

            if (substr_count($_GET['p'], '/') <= 1):
                if (!empty($_SESSION['locar'])):
                    $key = array_keys($_SESSION['locar']);
                    $dados = pegarPeloId('filmes', 'filmes_id', $key[0]);
                    $slug = $dados->filmes_slug;
                else:
                    throw new Exception('Nenhum filme escolhido');
                endif;
            else:
                $segmento = count(explode("/", $_GET['p']));
                $slug = segmento_url($_GET['p'], $segmento);
            endif;

            $filmes = pegarPeloId('filmes', 'filmes_slug', $slug);
            $totalLocacao = 0;

            if (empty($filmes)):
                throw new Exception("Escolha um filme para locar");
            else:

                locarFilme($filmes->filmes_id);
                $f = new ArrayIterator($_SESSION['locar']);
                ?>
                <table width="780" cellspacing="0" id="tabela_meus_filmes">
                    <thead>
                        <tr class="titulo_tabela_filmes_locados">
                            <th>Foto</th>
                            <th>Filme</th>
                            <th>Preço</th>
                            <th align="center">Remover</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($f->valid()):
                            $filmes = pegarPeloId("filmes", "filmes_id", $f->key());
                            $totalLocacao += $filmes->filmes_preco;
                            ?>
                            <tr class="tabela_filmes_locados">
                                <td><img src="http://netfilmes.com.br/<?php echo $filmes->filmes_foto ?>" width="45" height="35"/></td>
                                <td><?php echo $filmes->filmes_nome ?></td>
                                <td> R$ <?php echo number_format($filmes->filmes_preco, 2, ",", "."); ?></td>
                                <td align="center"><a href="http://netfilmes.com.br/deletar/filme/<?php echo $filmes->filmes_slug; ?>"><img src="http://netfilmes.com.br/imagens/delete.png" /></a></td>
                            </tr>

                            <?php
                            $f->next();
                        endwhile;
                        ?>
                        <tr>
                            <td colspan="1" class="total_meus_filmes">Total: R$ <?php echo number_format($totalLocacao, 2, ",", "."); ?></td>
                            <td colspan="1" class="total_meus_filmes"><a href="http://netfilmes.com.br/locar_filmes">Locar Filmes</a></td>
                            <td colspan="2" class="total_meus_filmes"><a href="http://netfilmes.com.br">Continuar Locando</a></td>
                        </tr>

                    <div class="entrega">
                        Escolha o tipo de entrega : 
                        <div id="escolhas_entrega">
                            Buscar Filme <input type="radio" name="tipo_entrega" checked="checked" value="buscar" />
                            Entregar Filme <input type="radio" name="tipo_entrega" value="entregar" />
                        </div>
                    </div>
                <?php
                endif;
            else:
                $erro = 'Nenhum filme escolhido até o momento';
            endif;
        } catch (Exception $e) {
            $erro = $e->getMessage();
        }
        ?>    
        </tbody>
    </table>

    <!--MENSAGEM DE ERRO-->
    <table>
        <tr>
            <td colspan="4" align="center" class="mensagem_erro_meus_filmes">
                <?php echo (isset($erro)) ? $erro : ''; ?>
            </td>
        </tr>
    </table>
</div>