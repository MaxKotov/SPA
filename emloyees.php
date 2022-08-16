<?php
$pagetitle = "Сотрудники";
require_once 'header.php';
require_once 'connect_db.php';
/* @var $pdo */
require_once 'functions.php';

//добавление сотрудника
if ( isset($_POST[ 'new_id' ]) )
{
    $new_id     = clear_string($_POST[ 'new_id' ]);
    $new_empl   = clear_string($_POST[ 'new_empl' ]);
    $new_pos    = clear_string($_POST[ 'new_pos' ]);
    $new_sup    = clear_string($_POST[ 'new_sup' ]);
    add_employee($new_id, $new_empl, $new_pos, $new_sup);
}
//удаление сотрудника
if ( isset($_POST[ 'empl_id' ]) )
{
    $empl_id    = clear_string($_POST[ 'empl_id' ]);
    drop_employee($empl_id);
    echo "Сотрудник '" . clear_string($_POST[ 'del_name' ]) . "' удален \n";
}

########## Подгружаем данные для формы ##########
// получаем список руководителей
$query = "select sup_id, sup_name, rights from supervisors";
$sup   = $pdo->query($query);

// получаем список должностей
$query = "select * from positions";
$pos   = $pdo->query($query);

########## Вывод формы ##########
echo <<<_END1
        <form  action   =   "emloyees.php"     method="post">
            <table border='1' cellspacing='0'>
            <!-- ID -->
            <tr>
                <td><label for  = "new_id">ID сотрудника</label></td>
                <td><input type = "number" name="new_id" required="required" min="0" max="9999" ></td>
            </tr>
            <!-- FIO -->
            <tr>
                <td><label for  = "new_empl">ФИО сотрудника</label></td>
                <td><input type = "text"    name="new_empl" maxlength="65"   size="25"  required="required"</td>
            </tr>
            <!-- Position -->
            <tr>
                <td><label for  ="new_pos">Должность нового сотрудника</label></td>
                <td><select name= "new_pos"  required="required">
                        <option value="">Выберете должность</option>
_END1;
########## Разрыв формы ##########
echo "\n";
//вывод строк в выпадающий список должностей
while ( $row_pos = $pos->fetch(PDO::FETCH_ASSOC) )
{
    //echo '<option value="' . $row_pos[ 'position_id' ] . '">' . $row_pos[ 'position_title' ] . '</option>';
    $value = $row_pos[ 'position_id' ];
    $name  = $row_pos[ 'position_title' ];
    echo <<<_ENDING
                                <option value="$value">$name</option>\n
        _ENDING;
}
########## Продолжение  формы ##########
echo <<<_END2
                    </select>
                </td>
            </tr>
        <!-- supervisors -->
            <tr>
                <td><label  for   = "new_sup" >Руководитель нового сотрудника</label></td>
                <td><select name  = "new_sup"  required="required">
                            
_END2;
########## Разрыв формы ##########
echo '<option value="">Выберете руководителя</option>' . "\n";

//вывод списка руководителей
while ( $row_sup = $sup->fetch(PDO::FETCH_ASSOC) )
{
    if ( $row_sup[ 'rights' ] != "admin" )
    {
        // echo '<option value="' . $row_sup[ 'sup_id' ] . '">' . $row_sup[ 'sup_name' ] . "</option>\n";
        $value = $row_sup[ 'sup_id' ];
        $name = $row_sup[ 'sup_name' ];
        echo <<<_ENDING
                                    <option value="$value">$name</option>\n
        _ENDING;
    }
}
########## Продолжение  формы ##########
echo <<<_END3
                    </select></td></tr>
        <tr><td align = 'center'><input type =   "submit"   value="Добавить нового сотрудника"></td></tr>
        </table>
        </form>
_END3;
########## Конец  формы ##########


$query = "select empl_id, empl_name, position_title, sup_name from employees as e, positions as p, supervisors as s where e.position_id=p.position_id and e.sup_id=s.sup_id order by empl_name";
$exist_empl = $pdo->query($query);
//шапка таблицы существующих сотрудников
echo "\n<h3>Текущий список сотрудников:</h3>\n";
echo "<table border='1' cellspacing='0'><tr> <th>ID</th> <th>ФИО▼</th> <th>Должность</th><th>Руководитель</th><th>Удалить!</th></tr>\n";
while ( $row = $exist_empl->fetch() )
{
    $empl_id = clear_string($row[ 'empl_id' ]);
    $empl_name = clear_string($row[ 'empl_name' ]);
    $position_title = clear_string($row[ 'position_title' ]);
    $sup_name = clear_string($row[ 'sup_name' ]);

    echo <<<_END4
        <tr>
            <td>$empl_id</td>
            <td>$empl_name</td>
            <td>$position_title</td>
            <td>$sup_name</td>
            <td>
                <form      action   =   "emloyees.php" method="post">
                    <input type     =   "hidden" name   =   "del_name"    value="$empl_name">
                    <input type     =   "hidden" name   =   "empl_id"   value="$empl_id">
                    <input type     =   "submit" value  =   "Удалить!">
                </form>
            </td>
        </tr>
    _END4;
}
?>