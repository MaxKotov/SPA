<?php

function clear_string($str)
{
    $str = strip_tags($str);
    $str = htmlentities($str);
    $str = stripslashes($str);
    return $str;
}

function destroy_session()
{
    session_start();
    $_SESSION = array();
    setcookie(session_name(), '', time() - 2592000, '/');
    session_destroy();
}

function add_supervisors($username, $sup_name, $password)
{
    global $pdo;

    $stmt = $pdo->prepare('SELECT * FROM supervisors WHERE username=?');

    $stmt->bindParam(1, $username, PDO::PARAM_STR, 32);

    $stmt->execute([$username]);

    if ( $stmt->rowCount() )
    {
        echo "Имя пользователя не уникально!";
    }
    else
    {
        $stmt = $pdo->prepare('INSERT INTO supervisors(username, sup_name, password) VALUES(?,?,?)');

        $stmt->bindParam(1, $username, PDO::PARAM_STR, 32);
        $stmt->bindParam(2, $sup_name, PDO::PARAM_STR, 65);
        $stmt->bindParam(3, $password, PDO::PARAM_STR, 255);

        $stmt->execute([$username, $sup_name, $password]);
    }
}

function add_employee($empl_id, $empl_name, $position_id, $sup_id)
{
    global $pdo;

    $stmt = $pdo->prepare('SELECT * FROM employees WHERE empl_id=?');

    $stmt->bindParam(1, $empl_id, PDO::PARAM_STR, 4);

    $stmt->execute([$empl_id]);

    if ( $stmt->rowCount() )
    {
        echo "Номер сотрудника не уникальный!";
    }
    else
    {
        $stmt = $pdo->prepare('INSERT INTO employees (empl_id,empl_name,position_id,sup_id) VALUES(?,?,?,?)');

        $stmt->bindParam(1, $empl_id, PDO::PARAM_INT, 4);
        $stmt->bindParam(2, $empl_name, PDO::PARAM_STR, 65);
        $stmt->bindParam(3, $position_id, PDO::PARAM_INT, 4);
        $stmt->bindParam(4, $sup_id, PDO::PARAM_INT, 4);

        $stmt->execute([$empl_id, $empl_name, $position_id, $sup_id]);
        echo "Сотрудник добавлен в базу!";
    }
}

function add_position($position_id, $position_title)
{
    global $pdo;

    $stmt = $pdo->prepare('INSERT INTO positions VALUES(?,?)');

    $stmt->bindParam(1, $position_id, PDO::PARAM_INT, 4);
    $stmt->bindParam(2, $position_title, PDO::PARAM_STR, 128);

    $stmt->execute([$position_id, $position_title]);
    echo "Должность добавлена в базу!";
}

function drop_position($position_id)
{
    global $pdo;

    $stmt = $pdo->prepare('DELETE FROM positions WHERE position_id =?');

    $stmt->bindParam(1, $position_id, PDO::PARAM_INT, 4);

    $stmt->execute([$position_id]);
}
function drop_employee ($empl_id)
{
    global $pdo;

    $stmt = $pdo->prepare('DELETE FROM employees WHERE empl_id =?');

    $stmt->bindParam(1, $empl_id, PDO::PARAM_INT, 4);

    $stmt->execute([$empl_id]);
}
?>


