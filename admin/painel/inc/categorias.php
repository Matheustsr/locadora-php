<?php
if (isset($_POST['alterarStatus'])):
    if ($_POST['alterarStatus'] == 'ok'):
        alterarStatusLink($_POST['valor'], $_POST['id']);
    endif;
endif;
?>

<h2>Categorias</h2>
<!-- Dynamic table -->
<div class="table">
    <div class="head"><h5 class="iFrames">Lista de categorias cadastrados</h5></div>
    <h5><a href="#" id="cadastrarCategoria">Cadastrar Categorias</a></h5><br /><br />

    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Editar</th>
                <th>Deletar</th>
                <th>Visível</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $categorias = listar("categorias");
            $c = new ArrayIterator($categorias);
            while ($c->valid()):
                ?>
                <tr class="gradeX">
                    <td><?php echo $c->current()->categorias_nome; ?></td>
                    <td class="center"><a href="#" onclick="janelaAlterar(<?php echo $c->current()->categorias_id; ?>,'categoria')" ><img src="imagens/edit.png" /></a></td>
                    <td class="center"><a href="#" onclick="deletar(<?php echo $c->current()->categorias_id; ?>,'categoria')"><img src="imagens/delete.png" /></a></td>
                    <td align="center">Visível <input type="radio" id="visivel" data-id="<?php echo $c->current()->categorias_id; ?>" name="visivel<?php echo $c->current()->categorias_id; ?>" <?php echo ($c->current()->categorias_visivel == 'habilitado' ? "checked='checked'" : ''); ?> value="habilitado" /> 
                        Não Visível <input type="radio" id="visivel" data-id="<?php echo $c->current()->categorias_id; ?>" name="visivel<?php echo $c->current()->categorias_id; ?>" <?php echo ($c->current()->categorias_visivel == 'desabilitado' ? "checked='checked'" : ''); ?> value="desabilitado" /></td>
                </tr>
                <?php
                $c->next();
            endwhile;
            ?>
        </tbody>
    </table>
</div>