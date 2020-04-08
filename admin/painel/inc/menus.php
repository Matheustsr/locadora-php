<?php
if (isset($_POST['alterarStatus'])):
    if ($_POST['alterarStatus'] == 'ok'):
        alterarStatusLinkMenu($_POST['valor'], $_POST['id']);
    endif;
endif;
?>
<h2>Menus</h2>
<!-- Dynamic table -->
<div class="table">
    <div class="head"><h5 class="iFrames">Lista de menus cadastrados</h5></div>
    <h5><a href="#" id="cadastrarMenus">Cadastrar menus</a></h5><br /><br />
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
            $menus = listar("menus");

            if (empty($menus)):
                ?>
                <tr><td colspan="4" align="center">Nenhum menu cadastrado !</td></tr>
                <?php
            else:
                $c = new ArrayIterator($menus);
                while ($c->valid()):
                    ?>
                    <tr class="gradeX">
                        <td><?php echo $c->current()->menus_nome; ?></td>
                        <td class="center"><a href="#" onclick="janelaAlterar(<?php echo $c->current()->menus_id; ?>,'menu')" ><img src="imagens/edit.png" /></a></td>
                        <td class="center"><a href="#" onclick="deletar(<?php echo $c->current()->menus_id; ?>,'menu')"><img src="imagens/delete.png" /></a></td>
                        <td align="center">Visível <input type="radio" id="visivelMenu" data-id="<?php echo $c->current()->menus_id; ?>" name="visivel<?php echo $c->current()->menus_id; ?>" <?php echo ($c->current()->menus_visivel == 'habilitado' ? "checked='checked'" : ''); ?> value="habilitado" /> 
                            Não Visível <input type="radio" id="visivelMenu" data-id="<?php echo $c->current()->menus_id; ?>" name="visivel<?php echo $c->current()->menus_id; ?>" <?php echo ($c->current()->menus_visivel == 'desabilitado' ? "checked='checked'" : ''); ?> value="desabilitado" /></td>
                    </tr>
                    <?php
                    $c->next();
                endwhile;
            endif;
            ?>

        </tbody>
    </table>
</div>