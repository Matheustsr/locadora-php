<?php
require_once "../functions/functions.php";
carregarArquivos(array('selecionar'));


$filme = $_POST['filme'];
$cliente = $_POST['cliente'];
$dados = pegarPeloId("clientes", "clientes_nome", $cliente);
if (empty($dados)):
    echo "Cliente ainda nao encontrado";
else:
    ?>
    <a href="#" id="locarFilme" data-cliente="<?php echo $dados->clientes_nome; ?>" data-filme="<?php echo $filme; ?>" data-id="<?php echo $dados->clientes_id; ?>">Locar para <?php echo $dados->clientes_nome; ?></a>
   <?php
endif;
?>