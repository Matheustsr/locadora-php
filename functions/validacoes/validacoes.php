<?php

function validarDados($valor, $nomeCampo, $tipo) {

    global $mensagem;

    if (empty($valor)):
        $mensagem = "O campo $nomeCampo não pode ficar em branco !";
    else:

        switch ($tipo):

            case "STRING":
                $string = filter_var($valor, FILTER_SANITIZE_STRING);
                return $string;
                break;

            case "INT":
                if (filter_var($valor, FILTER_VALIDATE_INT)):
                    $int = filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
                    return $int;
                else:
                    $mensagem = "O valor digitado não é um numero inteiro válido";
                endif;
                break;

            case "EMAIL":
                if (filter_var($valor, FILTER_VALIDATE_EMAIL)):
                    $email = filter_var($valor, FILTER_SANITIZE_EMAIL);
                    return $email;
                else:
                    $mensagem = "O e-mail digitado não é valido";
                endif;
                break;

        endswitch;
    endif;
}
