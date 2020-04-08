<?php
session_start();

require_once "../functions/functions.php";
carregarArquivos(array('datas', 'buscar', 'selecionar', 'alterar', 'deletar'));


if (isset($_POST['busca'])):
    $_SESSION['busca_locados'] = $_POST['busca'];
endif;

$dados = buscar("filmes", "filmes_nome", $_SESSION['busca_locados'], "LEFT JOIN locados ON filmes.filmes_id = locados.locados_filme");

if (empty($dados)):
    echo '<tr><td colspan="8" align="center">Nenhum filme encontrado com esse nome</td></tr>';
else:
    $a = new ArrayIterator($dados);
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
                Sim <input type="radio" id="lancamento" data-id="<?php echo $a->current()->filmes_id; ?>" name="lancamento<?php echo $a->current()->filmes_id ?>" <?php echo ($a->current()->filmes_lancamento == 'sim') ? "checked='checked'" : ''; ?> value="sim" />
                Não <input type="radio" id="lancamento" data-id="<?php echo $a->current()->filmes_id; ?>" name="lancamento<?php echo $a->current()->filmes_id ?>" <?php echo ($a->current()->filmes_lancamento == 'nao') ? "checked='checked'" : ''; ?> value="nao"/>                             
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
endif;
?>
<script type="text/javascript" src="js/locar.js"></script>
<script type="text/javascript" src="js/lancamentos.js"></script>