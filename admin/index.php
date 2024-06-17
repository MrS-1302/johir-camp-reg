<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/admin/core/login.php");

if(isset($_POST["username"]) && !empty($_POST["username"])) {
    if(isset($_POST["password"]) && !empty($_POST["password"])) {
        require_once($_SERVER["DOCUMENT_ROOT"]."/core/db.handle.php");
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);

        $query = "SELECT * FROM `admin` WHERE nev='$username' and password='".hash('sha256', 'admin_JÓ'.$password.'HÍR2024')."'";
        $user = $db->query($query);
        $userResNum = $user->numRows();

        if(isset($userResNum) && $userResNum == 1) {
            $user = $user->fetchArray();
            require_once($_SERVER["DOCUMENT_ROOT"]."/core/session.php");

            $_SESSION["ai"] = $user['id'];
            $user__id = $user['id'];
            $user__name = $user['nev'];

            $uniqstring = rand(1000,9999).$user['id']."_".md5(strrev($user__name."jil1r-<g%8"));
            setcookie('am', $uniqstring, time() + (86400 * 7), '/', 'localhost', 1);
        } else {
            $valasz['hiba'] = 3;
            $valasz['hibaDesc'] = "HIBÁS ADATOK!";
        }
    }
}
if (isset($user__id)) {
    header("Location: /admin/napok/");
}

require($_SERVER["DOCUMENT_ROOT"]."/admin/pages/tpl/head.php");

require($_SERVER["DOCUMENT_ROOT"]."/admin/pages/login.php");

require($_SERVER["DOCUMENT_ROOT"]."/admin/pages/tpl/footer.php");
?>