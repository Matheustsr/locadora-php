<?php
if(isset($_POST['aprovarComentario']) == 'ok'):
    aprovarComentario($_POST['valor'], $_POST['id']);
endif;
?>

<h2>Comentários</h2>
<!-- Dynamic table -->
<div class="table">
    <div class="head"><h5 class="iFrames">Lista de comentários cadastrados</h5></div>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Filme</th>
                <th>Aprovar</th>
                <th>Editar</th>
                <th>Deletar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $comentarios = listar("comentarios", "INNER JOIN filmes INNER JOIN clientes ON comentarios.comentarios_filme = filmes.filmes_id AND comentarios.comentarios_cliente = clientes.clientes_id");

            $params = array(
                'mode' => 'Sliding',
                'perPage' => 10,
                'delta' => 2,
                'itemData' => $comentarios
            );
            $pager = & Pager::factory($params);
            $data = $pager->getPageData();

            $a = new ArrayIterator($data);
            while ($a->valid()):
                ?>
                <tr class="gradeX">
                    <td><?php echo $a->current()->clientes_nome; ?></td>
                    <td><?php echo $a->current()->filmes_nome; ?></td>
                    <td>
                        Aprovar <input type="radio" id="aprovar" <?php echo ($a->current()->comentarios_aprovado == 1)  ? "checked='checked'" : ''; ?> name="aprovar<?php echo $a->current()->comentarios_id; ?>" data-id="<?php echo $a->current()->comentarios_id; ?>" value="1"/>
                        Reprovar <input type="radio" id="aprovar" <?php echo ($a->current()->comentarios_aprovado == 2)  ? "checked='checked'" : ''; ?> name="aprovar<?php echo $a->current()->comentarios_id; ?>" data-id="<?php echo $a->current()->comentarios_id; ?>" value="2"/>
                    </td>
                    <td class="center"><a href="#" onclick="janelaAlterar(<?php echo $a->current()->comentarios_id; ?>,'comentario')" ><img src="imagens/edit.png" /></a></td> 
                    <td class="center"><a href="#" onclick="deletar(<?php echo $a->current()->comentarios_id; ?>,'comentario')"><img src="imagens/delete.png" /></a></td>
                </tr>
                <?php
                $a->next();
            endwhile;
            ?>
            <tr>
                <td colspan="3" align="center">
                    <?php
                    $links = $pager->getLinks();
                    echo $links['all'];
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>