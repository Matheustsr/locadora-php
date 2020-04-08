<link rel="stylesheet" media="screen" type="text/css" href="http://netfilmes.com.br/css/edit.css" />
<script type="text/javascript" src="http://netfilmes.com.br/js/editar_comentario_jquery.js"></script>

<?php
include_once '../../functions/functions.php';
carregarArquivos(array('selecionar', 'alterar'));

try {
    if (!isset($_POST['id'])):
        throw new Exception('Você precisa escolher um comentário para editar');
    else:
        $id = $_POST['id'];
        $dados = pegarPeloId('comentarios', 'comentarios_id', $id);
        ?>
        <form action="" method="post" id="form_edit_comentario">

            <label for="comentario">Comentário cadastrado</label>
            <textarea name="alterar_comentario" id="comentario" class="input_textarea"><?php echo $dados->comentarios_texto; ?></textarea>

            <input type="hidden" id="id" data-id="<?php echo $id ?>" />

            <label for="submit"></label>
            <input type="submit" id="edit_comentario" name="edit_comentario" value="Atualizar" class="input_button" />

        </form>
        <div class="mensagem_alterar_comentario"></div>
    <?php
    endif;
} catch (Exception $e) {
    echo $e->getMessage();
}
?>