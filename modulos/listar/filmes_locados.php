<?php
session_start();
require_once '../../functions/functions.php';
carregarArquivos(array('selecionar'));
?>

<table width="780" cellspacing="0" id="tabela_meus_filmes">
    <thead>
        <tr class="titulo_tabela_filmes_locados">
            <th>Foto</th>
            <th>Filme</th>
            <th>Preço</th>
            <th align="center">Remover</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totalLocacao = 0;
        $f = new ArrayIterator($_SESSION['locar']);
        while ($f->valid()):
        
            $filmes = pegarPeloId("filmes", "filmes_id", $f->key());
            $totalLocacao += $filmes->filmes_preco;
            ?>
            <tr class="tabela_filmes_locados">
                <td><img src="http://netfilmes.com.br/<?php echo $filmes->filmes_foto ?>" width="45" height="35"/></td>
                <td><?php echo $filmes->filmes_nome ?></td>
                <td> R$ <?php echo number_format($filmes->filmes_preco, 2, ",", "."); ?></td>
                <td align="center"><img src="http://netfilmes.com.br/imagens/delete.png" /></td>
            </tr>

            <?php
            $f->next();
        endwhile;
        ?>
        <tr>
            <td colspan="1" class="total_meus_filmes">Total: R$ <?php echo number_format($totalLocacao, 2, ",", "."); ?></td>
            <td colspan="1" class="total_meus_filmes"><a href="">Locar Filmes</a></td>
            <td colspan="2" class="total_meus_filmes"><a href="http://netfilmes.com.br">Continuar Locando</a></td>
        </tr>
    <tbody>
</table>
