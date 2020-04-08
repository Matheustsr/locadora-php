<h2>Administradores</h2>
<div class="table">
    <div class="head"><h5 class="iFrames">Lista de administradores cadastrados</h5></div>
    <h5><a href="#" id="cadastrarAdmin">Cadastrar Administrador</a></h5>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Editar</th>
                <th>Deletar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $administradores = listar("administradores", $parametros = null);

            $params = array(
                'mode' => 'Sliding',
                'perPage' => 10,
                'delta' => 2,
                'itemData' => $administradores
            );
            $pager = & Pager::factory($params);
            $data = $pager->getPageData();

            $a = new ArrayIterator($data);
            while ($a->valid()):
                ?>
                <tr class="gradeX">
                    <td><?php echo $a->current()->administradores_nome; ?></td>
                    <td class="center"><a href="#" onclick="janelaAlterar(<?php echo $a->current()->administradores_id; ?>,'administrador')" ><img src="imagens/edit.png" /></a></td>
                    <td class="center"><a href="#" onclick="deletar(<?php echo $a->current()->administradores_id; ?>,'administrador')"><img src="imagens/delete.png" /></a></td>
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
