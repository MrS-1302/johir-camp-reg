<?php
if(isset($_POST["email"]) && !empty($_POST["email"])) {
    if(isset($_POST["pass"]) && !empty($_POST["pass"])) {
        require_once($_SERVER["DOCUMENT_ROOT"]."/core/db.handle.php");
        $email = htmlspecialchars($_POST["email"]);
        $password = htmlspecialchars($_POST["pass"]);
        
        $query = "SELECT * FROM `gondviselo` WHERE email='".$email."' and password='".hash('sha256', 'JÓ'.$password.'HÍR2024')."'";
        $user = $db->query($query);
        $userResNum = $user->numRows();
        
        if(isset($userResNum) && $userResNum == 1) {
            $user = $user->fetchArray();
            require_once($_SERVER["DOCUMENT_ROOT"]."/core/session.php");
            
            $_SESSION["ui"] = $user['id'];
            $user__id = $user['id'];
            $user__name = $user['nev'];
            
            $uniqstring = rand(1000,9999).$user['id']."_".md5(strrev($user['email']."jil1r-<g%8"));
            setcookie('um', $uniqstring, time() + (86400 * 7), '/');
        } else {
            $valasz['hiba'] = 3;
            $valasz['hibaDesc'] = "HIBÁS ADATOK!";
        }
    }
}
require_once($_SERVER["DOCUMENT_ROOT"]."/core/login.php");

require($_SERVER["DOCUMENT_ROOT"]."/pages/tpl/head.php");

require($_SERVER["DOCUMENT_ROOT"]."/pages/login.php");

require($_SERVER["DOCUMENT_ROOT"]."/pages/tpl/footer.php");
?>