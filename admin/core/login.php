<?php
if(!isset($_SESSION["ai"])){
    if(isset($_COOKIE['am'])) {
        $uniqstring = $_COOKIE['am'];
        $uniqstring = explode("_", $uniqstring);
        if ($uniqstring != '0') {
            require_once($_SERVER["DOCUMENT_ROOT"]."/core/db.handle.php");
            $uid = $uniqstring[0];
            $uid = substr($uniqstring[0], 4);
            $uid = intval($uid);
            $user = $db->query("SELECT * FROM `admin` WHERE id='$uid'");
            $rows = $user->numRows();
            $user = $user->fetchArray();

            if($rows==1){
                $cuname = $uniqstring[1];
                $uname = md5(strrev($user['nev']."jil1r-<g%8"));
                if($uname == $cuname) {
                    $_SESSION['ai'] = $user['id'];
                    $user__name = $user['nev'];
                    $user__id = $user['id'];
                }
            }
        }
    }
} else if (isset($_SESSION["ai"])){
    $user__id = $_SESSION['ai'];
    $user = $db->query("SELECT nev FROM `admin` WHERE id=".$user__id)->fetchArray();
    $user__name = $user['nev'];
}

if (!isset($user__name) &&  $_SERVER['REQUEST_URI'] != '/admin/' && $_SERVER['REQUEST_URI'] != '/admin/index.php') {
    header("Location: /admin/");
}
?>