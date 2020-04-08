<?php

session_start();

if (!isset($_SESSION['tipo_entrega'])):
    $_SESSION['tipo_entrega'] = $_POST['tipo'];
else:
    if ($_SESSION['tipo_entrega'] != $_POST['tipo']):
        $_SESSION['tipo_entrega'] = $_POST['tipo'];
    endif;
endif;