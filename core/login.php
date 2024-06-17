<?php
if(!isset($_SESSION["ui"])){
    if(isset($_COOKIE['um'])) {
        $uniqstring = $_COOKIE['um'];
        $uniqstring = explode("_", $uniqstring);
        if ($uniqstring != '0') {
            require_once($_SERVER["DOCUMENT_ROOT"]."/core/db.handle.php");
            $uid = $uniqstring[0];
            $uid = substr($uniqstring[0], 4);
            $uid = intval($uid);
            $user = $db->query("SELECT * FROM `gondviselo` WHERE id='$uid'");
            $rows = $user->numRows();
            $user = $user->fetchArray();

            if($rows==1){
                $cuname = $uniqstring[1];
                $uname = md5(strrev($user['email']."jil1r-<g%8"));
                if($uname == $cuname) {
                    $_SESSION['ui'] = $user['id'];
                    $user__name = $user['nev'];
                    $user__id = $user['id'];
                }
            }
        }
    }
} else if (isset($_SESSION["ui"])){
    $user__id = $_SESSION['ui'];
    $user = $db->query("SELECT nev FROM `gondviselo` WHERE id=".$user__id)->fetchArray();
    $user__name = $user['nev'];
}

$path = trim(explode("/",$_SERVER['REQUEST_URI'] )[1]);
if ($path != 'api') {
    if (isset($user__id) && $path != 'gyerekek' && $path != 'napkozi') {
        header("Location: /gyerekek/");
    }
    if (!isset($user__id) && $path != '' && $path != 'reg' && $path != 'login') {
        header("Location: /");
    }
}
?>