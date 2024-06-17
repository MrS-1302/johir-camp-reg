<?php
require($_SERVER["DOCUMENT_ROOT"].'/core/db.manager.php');

$dbhost = '';
$dbuser = '';
$dbpass = '';
$dbname = '';

$db = new db($dbhost, $dbuser, $dbpass, $dbname);
?>