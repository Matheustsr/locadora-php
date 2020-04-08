<?php

function mudaUrl($url) {
    if (isset($url)):
        if (is_file('inc/' . $url . ".php")):
            include_once $url . ".php";
        else:
            throw new Exception("Página $url não existe !");
        endif;
    endif;
}