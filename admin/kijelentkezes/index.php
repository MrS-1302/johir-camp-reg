<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/core/session.php");
if(isset($_COOKIE['am'])) {
    unset($_COOKIE['am']);
    setcookie('am', null, -1, '/'); 
}

if(session_destroy()) {
    header("Location: /admin/");
}
?>