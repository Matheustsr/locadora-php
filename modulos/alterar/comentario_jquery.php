<?php

include_once '../../functions/functions.php';
carregarArquivos(array('selecionar', 'alterar'));

if (isset($_POST['atualizar_comentario'])):

    if ($_POST['atualizar_comentario'] == 'ok'):

        if (alterarComentario($_POST['comentario'], $_POST['id'])):
            echo 'Comentário alterado';
        else:
            echo 'O comentário não foi alterado';
        endif;
    endif;
endif;