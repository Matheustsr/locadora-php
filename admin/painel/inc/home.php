<script type="text/javascript" src="js/chart_filmes_locados.js"></script>
<?php
/* VERIFICA SE O FILME DEVOLVIDO JA PASSOU DE 1 DIA */
$dadosFilmesLocados = deletarFilmeLocado();
if (!empty($dadosFilmesLocados)):
    $f = new ArrayIterator($dadosFilmesLocados);
    while ($f->valid()):
        if (deletarLocados($f->current()->locados_id))
            header("Location: http://netfilmes.com.br/admin/painel/");
        $f->next();
    endwhile;

endif;
/* VERIFICA SE O FILME DEVOLVIDO JA PASSOU DE 1 DIA */


/* RELOCAR FILME */
if (isset($_GET['relocar'])):
    if ($_GET['relocar'] == 'ok'):
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $idFilme = filter_var($_GET['f'], FILTER_SANITIZE_NUMBER_INT);
        $valor = pegarPeloId("locados", "locados_id", $id);
        $preco_locacao = pegarPeloId("filmes", "filmes_id", $idFilme);

        $dados = array(
            1 => $idFilme,
            2 => date("Y-m-d H:i:s", strtotime("+2days")),
            3 => $valor->locados_valor + $preco_locacao->filmes_preco,
            4 => $valor->locados_cliente,
            5 => date("Y-m-d H:i:s"),
            6 => $id,
        );

        if (relocar($dados))
            locarFilmeCliente($dados);
        header("Location: http://netfilmes.com.br/admin/painel/");

    endif;
endif;
/* RELOCAR FILME */

/* ATUALIZAR SE FILME LOCADO ESTA VISIVEL OU NAO */
if (isset($_GET['remover'])):

    if ($_GET['remover'] == 'ok'):
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        deletarLocados($id);
        header("Location: http://netfilmes.com.br/admin/painel/");
    endif;

endif;
/* ATUALIZAR SE FILME LOCADO ESTA VISIVEL OU NAO */

/* ATUALIZAR SE FILME FOI DEVOLVIDO */
if (isset($_GET['devolvido'])):

    if ($_GET['devolvido'] == 'ok'):
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $dadosDevolvidos = pegarPeloId("locados", "locados_id", $id);
        $locadosData = $dadosDevolvidos->locados_data;
        ($dadosDevolvidos->locados_status == "Locado") ? $status = "Devolvido" : $status = "Locado";
        alterarStatusLocados($status, $locadosData, $id);
        header("Location: http://netfilmes.com.br/admin/painel/");
    endif;

endif;
/* ATUALIZAR SE FILME FOI DEVOLVIDO */


/* ORDENAR */
if (isset($_POST['order'])):
    $_SESSION['ordenar'] = $_POST['ordenar'];
    $_SESSION['order'] = $_POST['orderby'];
endif;
/* ORDENAR */
?>
<div class="title"><h5>Painel</h5></div>

<!-- Statistics -->
<div class="stats">
    <ul>
        <li><a href="#" class="count grey" title="">
                <!--FILMES CADASTRADOS-->
                <?php echo contar("filmes"); ?>
                <!--FILMES CADASTRADOS-->
            </a><span>Filmes cadastrados</span></li>

        <li><a href="#" class="count grey" title="">
                <!--FILMES LOCADOS HOJE-->
                <?php echo hoje("locados", "locados_data", date("Y-m-d")); ?>
                <!--FILMES LOCADOS HOJE-->
            </a><span>Locados hoje</span></li>

        <li><a href="#" class="count grey" title="">
                <!--COMENTARIOS HOJE-->   
                <?php echo hoje("comentarios", "comentarios_data", date("Y-m-d")); ?>
                <!--COMENTARIOS HOJE-->
            </a><span>Comentários hoje</span></li>
        <li class="last"><a href="#" class="count grey" title="">
                <!--USUARIOS CADASTRADOS-->
                <?php echo contar("clientes"); ?>
                <!--USUARIOS CADASTRADOS-->
            </a><span>Usuários cadastrados</span></li>
    </ul>
    <div class="fix"></div>
</div>


<!-- Dynamic table -->
<div class="table">
    <div class="head"><h5 class="iFrames">Filmes mais locados desse mês</h5></div>
    <div id="visualization" style="width: 600px; height: 400px;"></div>
</div>


<!-- Dynamic table -->
<div class="table">
    <div class="head"><h5 class="iFrames">Lista de Filmes Locados</h5></div>

    <!-- Search -->
    <div class="busca_locados">
        <form action="">
            <input type="text" name="search" id="buscar_filmes" data-pagina="buscar_filmes_locados" placeholder="Busque o filme aqui..." />
        </form>
    </div>


    <div class="ordenar">Ordenar por:
        <form action="" method="post">
            <select name="ordenar" id="select_ordenar">
                <option value="filmes_nome">Filme</option>
                <option value="filmes_preco">Preço</option>
                <option value="locados_devolucao">Devolução</option>
                <option value="locados_status">Status</option>
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
                <th>Locado</th>
                <th>Devolução</th>
                <th>Faltam para devolver</th>
                <th>Devolveu</th>              
                <th>Relocar</th>
                <th>Entrega</th>
                <th>Remover</th>
            </tr>
        </thead>
        <tbody>
            <?php
            (isset($_SESSION['ordenar']) ? $ordem_tabela = $_SESSION['ordenar'] : $ordem_tabela = 'locados_data');
            (isset($_SESSION['order']) ? $orderby = $_SESSION['order'] : $orderby = 'DESC');

            $filmes = listar("locados", "INNER JOIN filmes INNER JOIN clientes ON filmes.filmes_id = locados.locados_filme AND locados.locados_cliente = clientes.clientes_id ORDER BY $ordem_tabela $orderby");

            if (empty($filmes)):
                ?>
                <tr><td colspan="8" align="center">Nenhum filme locado</td></tr>
                <?php
            else:

                $params = array(
                    'mode' => 'Sliding',
                    'perPage' => 10,
                    'delta' => 2,
                    'itemData' => $filmes);

                $pager = & Pager::factory($params);
                $data = $pager->getPageData();
                $links = $pager->getLinks();

                $f = new ArrayIterator($data);
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
                        <td>
                            <a class="bt_devolver_relocar" href="?devolvido=ok&id=<?php echo $f->current()->locados_id; ?>">Devolveu</a><br /><br />                              
                        </td>
                        <td>       
                            <a href="?relocar=ok&id=<?php echo $f->current()->locados_id; ?>&f=<?php echo $f->current()->filmes_id; ?>">
                                <?php echo ($f->current()->locados_status == 'Locado') ? "Relocar" : ''; ?>  
                            </a>                     
                        </td>
                         <td>                             
                            <?php echo ($f->current()->locados_entrega == 'buscar') ? "Cliente vem buscar filme" : 'Nós entregaremos o filme'; ?>                     
                        </td>                    
                        <td>       
                            <a href="?remover=ok&id=<?php echo $f->current()->locados_id; ?>">
                                <?php echo ($f->current()->locados_status == 'Devolvido') ? "Remover" : ''; ?>  
                            </a>                     
                        </td>
                    </tr>
                    <?php
                    $f->next();
                endwhile;
                ?>
                <!--PAGINACAO-->
                <tr><td colspan="5"><?php echo $links['all']; ?></td></tr>
                <!--PAGINACAO-->
            <?php
            endif;
            ?>

        </tbody>
    </table>
</div>
