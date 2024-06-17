<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/core/session.php");
if(isset($_COOKIE['um'])) {
    unset($_COOKIE['um']);
    setcookie('um', null, -1, '/'); 
}

if(session_destroy()) {
    header("Location: /");
}
?>