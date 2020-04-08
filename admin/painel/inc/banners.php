<?php
require_once '../functions/functions.php';
carregarArquivos(array('cadastrar', 'selecionar'));

/* PEGANDO SLUG DO FILME PARA PODER CADASTRAR EM BANNERS */
if (isset($_POST['cadastrarBanner'])):
    if ($_POST['cadastrarBanner'] == 'ok'):
        $idFilme = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $slug = pegarPeloId('filmes', 'filmes_id', $idFilme);
        echo $slug->filmes_slug;
        exit();
    endif;
endif;
/* PEGANDO SLUG DO FILME PARA PODER CADASTRAR EM BANNERS */
?>

<h2>Banners</h2>
<!-- Dynamic table -->
<div class="table">
    <div class="head"><h5 class="iFrames">Lista de banners cadastrados</h5></div>
    <h5><a href="#" id="cadastrarBanner">Cadastrar Banners</a></h5><br /><br />
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                <th>Banner</th>
                <th>Editar</th>
                <th>Deletar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $banners = listar('banners', ' INNER JOIN filmes ON banners.banners_filme = filmes.filmes_id');

            $params = array(
                'mode' => 'Sliding',
                'perPage' => 10,
                'delta' => 2,
                'itemData' => $banners
            );
            $pager = & Pager::factory($params);
            $data = $pager->getPageData();


            $b = new ArrayIterator($data);
            while ($b->valid()):
                ?>
                <tr class="gradeX">
                    <td><?php echo $b->current()->filmes_nome; ?></td>
                    <td class="center"><a href="#" onclick="janelaAlterar(<?php echo $b->current()->banners_id; ?>,'banner')" ><img src="imagens/edit.png" /></a></td>
                    <td class="center"><a href="#" onclick="deletar(<?php echo $b->current()->banners_id; ?>,'banner')"><img src="imagens/delete.png" /></a></td>
                </tr>
                <?php
                $b->next();
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