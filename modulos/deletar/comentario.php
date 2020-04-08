<?php

include_once '../../functions/functions.php';
carregarArquivos(array('deletar'));

try {

    if (isset($_POST['id'])):
        $id = (int) $_POST['id'];
        deletarComentario($id);
    else:
        throw new Exception('Para deletar um comentario é preciso passar qual comentário deseja deletar');
    endif;
} catch (Exception $e) {
    echo $e->getMessage();
}