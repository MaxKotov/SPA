<?php
require_once 'connect_db.php';
$pagetitle = "Вход" ;
require_once 'header.php';
require_once 'functions.php';

if ( isset($_SERVER[ 'PHP_AUTH_USER' ]) &&
     isset($_SERVER[ 'PHP_AUTH_PW' ]) )
{
    $un_temp = sanitise($pdo, $_SERVER[ 'PHP_AUTH_USER' ]);
    $pw_temp = sanitise($pdo, $_SERVER[ 'PHP_AUTH_PW' ]);
    $query = "SELECT * FROM users WHERE username=$un_temp";
    $result = $pdo->query($query);

    if ( !$result->rowCount() )
    {
        destroy_session_and_data();
        die("Пользователь не найден!");
    }

    $row = $result->fetch();
    $fn = $row[ 'forename' ];
    $sn = $row[ 'surname' ];
    $un = $row[ 'username' ];
    $pw = $row[ 'password' ];

    if ( password_verify(str_replace("'", "", $pw_temp), $pw) )
    {
        session_start();

        $_SESSION[ 'forename' ] = $fn;
        $_SESSION[ 'surname' ] = $sn;
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

        echo htmlspecialchars("$fn $sn : Привет! $fn, Вы вошли как '$un'");
        die ("<p><a href='list_employees.php'>Нажми здесь, чтобы продолжить</a></p>");
    }
    else die("Неправильно указан логин или пароль!");
}
else
{
    header('WWW-Authenticate: Basic realm="Restricted Area"');
    header('HTTP/1.0 401 Unauthorized');
    die ("Пожалуйста, введите свои имя пользователя и пароль!");
}

function sanitise($pdo, $str)
{
    $str = htmlentities($str);
    return $pdo->quote($str);
}

