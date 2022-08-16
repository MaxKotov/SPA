<?php
$pagetitle = "Должности";
require_once 'header.php';
require_once 'connect_db.php';
/* @var $pdo */
require_once 'functions.php';

//добавление должности
if ( isset($_POST[ 'new_title' ]) )
{
    $new_title = clear_string($_POST[ 'new_title' ]);
    $new_id    = clear_string($_POST[ 'new_id' ]);
    add_position($new_id, $new_title);
}

//удаление должности
if ( isset($_POST[ 'del_id' ]) && isset($_POST[ 'del_title' ]) )
{
    $position_id = clear_string($_POST[ 'del_id' ]);
    drop_position($position_id);
    echo "Должность '" . clear_string($_POST[ 'del_title' ]) . "' удалена \n";
}

########## Вывод формы ##########
echo <<<_END
<form  action="positions.php" method="post"><pre>
<input type =   "hidden"    name    =   "new_id">
<input type =   "text"      name    =   "new_title"    maxlength="50"   size="25"  required="required">
<input type =   "submit"    value   =   "Добавить новую должность">
</pre></form>
_END;

########## Подгружаем данные для формы ##########
// получаем список должностей
$query = "SELECT * FROM positions order by position_title";
$res   = $pdo->query($query);

echo "\n<h3>Текущий список сотрудников:</h3>\n";
echo "<table border='1' cellspacing='0'><tr> <th>№</th> <th>Должность▼</th><th>Удалить!</th></tr>\n";
$i=1; //нумератор строчек, не привязан к ID
while ($row = $res->fetch()){
    $position_id    = clear_string($row[ 'position_id' ]);
    $position_title = clear_string($row[ 'position_title' ]);
    echo <<<_END
        <tr>
            <td>$i</td>
            <td>$position_title</td>
            <td>
                <form      action   =   "positions.php" method="post">
                    <input type     =   "hidden" name   =   "del_title"  value="$position_title">
                    <input type     =   "hidden" name   =   "del_id"     value="$position_id">
                    <input type     =   "submit" value  =   "Удалить!">
                </form>
            </td>
        </tr>
    _END;
    $i++;
}
echo "</table>";
echo "</body>";
?>