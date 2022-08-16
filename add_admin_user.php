<?php //setupusers.php
require_once 'connect_db.php';
require_once 'functions.php';


$fio = 'Администратор';
$un = 'admin';
$pw = 'admin';
$hash     = password_hash($pw, PASSWORD_DEFAULT);
add_supervisors($fio, $un, $hash);
?>

