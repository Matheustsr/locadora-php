<?php
session_start();

require_once "../functions/functions.php";
carregarArquivos(array('datas', 'buscar', 'selecionar', 'alterar','deletar'));


/* ALTERAR STATUS DA LACACAO ATRAVES DO JQUERY */
if (isset($_POST['status']) == 'ok'):
    $dadosDevolvidos = pegarPeloId("locados", "locados_id", $_POST['id']);
    $locadosData = $dadosDevolvidos->locados_data;
    ($dadosDevolvidos->locados_status == "Locado") ? $status = "Devolvido" : $status = "Locado";
    alterarStatusLocados($status, $locadosData, $_POST['id']);
endif;
/* ALTERAR STATUS DA LACACAO ATRAVES DO JQUERY */

/* REMOVER FILME LOCADOS USANDO JQUERY */
if (isset($_POST['remover']) == 'ok'):
    $id = $_POST['idLocado'];
    deletarLocados($id);
endif;
/* REMOVER FILME LOCADOS USANDO JQUERY */

if (isset($_POST['busca'])):
    $_SESSION['busca_locados'] = $_POST['busca'];
endif;


$dados = buscar("locados", "filmes_nome", $_SESSION['busca_locados'], "INNER JOIN filmes INNER JOIN clientes ON filmes.filmes_id = locados.locados_filme AND locados.locados_cliente = clientes.clientes_id");

if (empty($dados)):
    echo '<tr><td colspan="8" align="center">Nenhum filme encontrado com esse nome</td></tr>';
else:
    $f = new ArrayIterator($dados);
    while ($f->valid()):
        /* CSS */
        ($f->current()->locados_status == 'Locado') ? $css = "tb_locado" : $css = "tb_devolvido";
        /* CSS */
        ?>
        <tr class="<?php echo $css; ?>" id="dados_filmes_locados">
            <td><?php echo $f->current()->filmes_nome; ?></td>
            <td align="center"><?php echo $f->current()->filmes_codigo; ?></td>
            <td align="center">R$ <?php echo number_format($f->current()->filmes_preco, 2, ",", "."); ?></td>
            <td><?php echo date("d/m/Y H:i:s", strtotime($f->current()->locados_data)); ?></td>
            <td><?php echo date("d/m/Y H:i:s", strtotime($f->current()->locados_devolucao)); ?></td>  
            <td>

                <?php
                /* MOSTRA QUANTO TEMPO FALTA PARA DEVOLVER FILME */
                $data = new DateTime();
                $devolucao = new DateTime($f->current()->locados_devolucao);
                $vencimento = $data->diff($devolucao);
                $porcentagem = 10;
                $calculo_vencimento = ($f->current()->filmes_preco * $porcentagem) / 100;
                tempoDevolverFilme($data, $f, $vencimento, $calculo_vencimento);
                /* MOSTRA QUANTO TEMPO FALTA PARA DEVOLVER FILME */
                ?>      
            </td>
        </td>

        <!--LINKS PARA MUDAR STATUS DA LOCACAO E REMOVER OS FILMES LOCADOS-->
        <td><a href="#" id="devolveu" data-id="<?php echo $f->current()->locados_id; ?>">Devolveu</a></td>
        <td>       
            <a href="?relocar=ok&id=<?php echo $f->current()->locados_id; ?>&f=<?php echo $f->current()->filmes_id; ?>">
                <?php echo ($f->current()->locados_status == 'Locado') ? "Relocar" : ''; ?>  
            </a>                     
        </td>
        <td>
            <a href="#" id="remover" data-id="<?php echo $f->current()->locados_id; ?>">
                <?php echo ($f->current()->locados_status == 'Devolvido') ? "Remover" : ''; ?>  
            </a>
        </td>
        <!--LINKS PARA MUDAR STATUS DA LOCACAO E REMOVER OS FILMES LOCADOS-->
        </tr>
        <?php
        $f->next();
    endwhile;
endif;
?>