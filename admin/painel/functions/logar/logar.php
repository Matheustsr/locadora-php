<?php

function logOut() {
    if (isset($_SESSION['logado_admin'])):
        unset($_SESSION['logado_admin']);
        session_destroy();
    endif;
}