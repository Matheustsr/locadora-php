<div id="mensagem_filme_locado"></div>
<?php

/*ATUALIZAR LANCAMENTO*/
if(isset($_POST['alterarlancamento']) == 'ok'):
    alterarLancamento($_POST['valor'], $_POST['id']);
endif;
/*ATUALIZAR LANCAMENTO*/


/* ORDENAR */
if (isset($_POST['order'])):
    $_SESSION['ordenarFilme'] = $_POST['ordenar'];
    $_SESSION['orderFilme'] = $_POST['orderby'];
endif;
/* ORDENAR */
?>

<!-- Dynamic table -->
<div class="table">
    <div class="head"><h5 class="iFrames">Filmes cadastrados</h5></div>

    <h5><a href="#" id="cadastrarFilmes">Cadastrar Filmes</a></h5><br /><br />

    <!-- Search -->
    <div class="busca_locados">
        <form action="">
            <input type="text" name="search" id="buscar_filmes" data-pagina="buscar_filmes" placeholder="Busque o filme aqui..." />
        </form>
    </div>


    <div class="ordenar">Ordenar por:
        <form action="" method="post">
            <select name="ordenar" id="select_ordenar">
                <option value="filmes_nome">Filme</option>
                <option value="filmes_preco">Preço</option>
                <option value="filmes_lancamento">Lançamento</option>
                <option value="locados_status">Locação</option>
            </select> 

            <select name="orderby" id="select_orderby">
                <option value="ASC">Cresente</option>
                <option value="DESC">Decresente</option>
            </select> 

            <input type="submit" name="order" value="ordenar" />
        </form>
    </div>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Código</th>
                <th>Preço</th>
                <th>Foto</th>
                <th>Lançamento</th>
                <th>Disponível</th>
                <th>Editar</th>
                <th>Deletar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            (isset($_SESSION['ordenarFilme']) ? $ordem_tabela_filme = $_SESSION['ordenarFilme'] : $ordem_tabela_filme = 'filmes_nome');
            (isset($_SESSION['orderFilme']) ? $orderby_filme = $_SESSION['orderFilme'] : $orderby_filme = 'ASC');

            $filmes = listar("filmes", "LEFT JOIN locados ON filmes.filmes_id = locados.locados_filme order by $ordem_tabela_filme $orderby_filme");
            $params = array(
                'mode' => 'Sliding',
                'perPage' => 30,
                'delta' => 2,
                'itemData' => $filmes
            );
            $pager = & Pager::factory($params);
            $data = $pager->getPageData();

            $a = new ArrayIterator($data);
            while ($a->valid()):

                /* VERIFICA QUAIS FILMES ESTAO LOCADOS PARA ALTERAR A COR DA LINHA */
                ($a->current()->locados_status == "Locado") ? $classe = "tb_filme_locado" : $classe = "grayX";
                /* VERIFICA QUAIS FILMES ESTAO LOCADOS PARA ALTERAR A COR DA LINHA */
                ?>
                <tr class="<?php echo $classe; ?>">
                    <td><?php echo $a->current()->filmes_nome; ?></td>
                    <td align="center"><?php echo $a->current()->filmes_codigo; ?></td>
                    <td align="center">R$ <?php echo number_format($a->current()->filmes_preco, 2, ",", "."); ?></td>                      
                    <td align="center"><img src="../../../<?php echo $a->current()->filmes_foto; ?>" width="80" height="60" /></td>
                    <td align="center">
                        Sim <input type="radio" id="lancamento" data-id="<?php echo $a->current()->filmes_id; ?>" name="lancamento<?php echo $a->current()->filmes_id ?>" <?php echo ($a->current()->filmes_lancamento == 'sim') ? "checked='checked'": ''; ?> value="sim" />
                        Não <input type="radio" id="lancamento" data-id="<?php echo $a->current()->filmes_id; ?>" name="lancamento<?php echo $a->current()->filmes_id ?>" <?php echo ($a->current()->filmes_lancamento == 'nao') ? "checked='checked'": ''; ?> value="nao"/>                     
                    </td>
                    <td id="locar">
                        <?php
                        if ($a->current()->locados_status == 'Locado'):
                            echo "Locado";
                        else:
                            ?>
                            <label for="cliente">Digite o nome do cliente:</label>
                            <input type="text" name="cliente" id="input_cliente" data-id="<?php echo $a->current()->filmes_id; ?>" />
                            <div id="link"></div>
                        <?php
                        endif;
                        ?>
                    </td>
                    <td align="center"><a href="#" onclick="janelaAlterar(<?php echo $a->current()->filmes_id; ?>,'filme')" ><img src="imagens/edit.png" /></a></td>
                    <td align="center">
                        <?php if ($a->current()->locados_status != 'Locado'): ?>
                            <a href="#" onclick="deletar(<?php echo $a->current()->filmes_id; ?>,'filme')"><img src="imagens/delete.png" /></a>             
                        <?php endif; ?>
                    </td>
                </tr>
                <?php
                $a->next();
            endwhile;
            ?>
            <tr>
                <td colspan="7" align="center">
                    <?php
                    $links = $pager->getLinks();
                    echo $links['all'];
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>