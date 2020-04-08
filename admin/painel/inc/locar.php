<?php
require_once "../functions/functions.php";
carregarArquivos(array('alterar', 'selecionar','deletar'));
if (isset($_POST['locar'])):
    if ($_POST['locar'] == 'ok'):
        try {
            if (filter_var($_POST['filme'], FILTER_VALIDATE_INT)):

                /* PEGAR VALOR DA LOCACAO PARA CADASTRAR NO BANCO */
                $dadosFilme = pegarPeloId("filmes", "filmes_id", $_POST['filme']);

                $dados = array(
                    1 => $_POST['filme'],
                    2 => date("Y-m-d H:i:s"),
                    3 => date("Y-m-d H:i:s", strtotime("2days")),
                    4 => $_POST['cliente'],
                    5 => "Locado",
                    6 => $dadosFilme->filmes_preco,
                    7 => 'buscar'    
                );
              
                if (locarFilme($dados)):
                    locarFilmeCliente($dados);
                endif;
            else:
                throw new Exception("Filme não existe !");
            endif;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    endif;
endif;
/* ALTERAR STATUS DA LOCACAO */