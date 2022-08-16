<?php
echo <<<_END
<!DOCTYPE html>
<html lang="ru">
<meta charset="UTF-8"/>
<!-- body -->
<body style="font-family: Cursive,serif">
_END;
echo "<h1>$pagetitle</h1><hr>\n";
echo " | ";
echo "<a href = 'edit_positions.php'>Должности</a> | \n";
echo "<a href = 'edit_emloyees.php'>Сотрудники</a> | \n";
echo "<a href = 'db_settings.php'>Настройки доступа в базу данных</a><br>\n";
echo "<hr>";
?>