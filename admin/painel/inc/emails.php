<h2>E-mails</h2>
<!-- Dynamic table -->
<div class="table">
    <div class="head"><h5 class="iFrames">Lista de emails recebidos</h5></div>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Editar</th>
                <th>Deletar</th>
                <th>Ver/Responder</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $listaEmails = listar("contato");
            if (empty($listaEmails)):
                ?>
                <tr class="gradeX">
                    <td colspan="3" align="center">Nenhum E-mail recebido</td>
                </tr>
                <?php
            else:
                $params = array(
                    'mode' => 'Sliding',
                    'perPage' => 15,
                    'delta' => 2,
                    'itemData' => $listaEmails
                );
                $pager = & Pager::factory($params);
                $data = $pager->getPageData();

                $e = new ArrayIterator($data);
                while ($e->valid()):

                    $css = ($e->current()->contato_status == 1) ? 'novo' : 'respondido';
                    ?>
                    <tr class="<?php echo $css; ?>">
                        <td><?php echo ucwords($e->current()->contato_nome); ?></td>
                        <td class="center"><?php echo $e->current()->contato_email; ?></td>
                        <td class="center"><a href="#" onclick="deletar(<?php echo $e->current()->contato_id; ?>,'email')"><img src="imagens/delete.png" /></a></td>
                        <td class="center"><a id="responder" href="#" onclick="janelaAlterar(<?php echo $e->current()->contato_id; ?>,'email')">Ver/Responder</a></td>
                    </tr>               
                    <?php
                    $e->next();
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
            <?php endif; ?>
        </tbody>
    </table>
</div>