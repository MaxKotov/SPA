<?php
$pagetitle = "Настройка учетной записи MySQL";
require_once 'header.php';
require_once 'connect_db.php';
require_once 'functions.php';


$text = file("connect_db.php");

echo <<<_END
<form  action="db_settings.php" method="post"><pre style="font-family: Cursive,serif">
<input type="text" name="host" value="$host"> Имя хоста пользователя
<input type="text" name="data" value="$data"> Имя базы данных
<input type="text" name="user" value="$user"> Имя пользователя
<input type="password" name="pass" placeholder="*****"> Пароль
<input type="submit" value="Установить">
</pre></form>
_END;


if ( isset($_POST[ 'host' ]) && $_POST[ 'host' ] > 0 )
{
    $host = '$host =    \'' . clear_string($_POST[ 'host' ]) . '\';'. "\n";
    $text[1]    =   $host ;
}

if ( isset($_POST[ 'data' ]) && $_POST[ 'data' ] > 0 )
{
    $data = '$data =    \'' . clear_string($_POST[ 'data' ]) . '\';'. "\n";
    $text[2]    =   $data ;
}

if ( isset($_POST[ 'user' ]) && $_POST[ 'user' ] > 0 )
{
    $user = '$user =    \'' . clear_string($_POST[ 'user' ]) . '\';'. "\n";
    $text[3]    =   $user ;
}

if ( isset($_POST[ 'pass' ]) && $_POST[ 'pass' ] > 0 )
{
    $pass = '$pass =    \'' . clear_string($_POST[ 'pass' ]) . '\';'. "\n";
    $text[4]    =   $pass ;
}

$login_db = fopen('connect_db.php', 'w');
foreach ( $text as $item )
{
    fwrite($login_db, $item);
}
fclose($login_db);


?>
