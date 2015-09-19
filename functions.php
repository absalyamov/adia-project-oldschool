<?php

define("DEBUG", TRUE);


function cancel_button()
{
    if (isset($_POST['cancel_button']))
    {
        header("Location: ".$_SERVER['SCRIPT_NAME']);
    }
}


//---------show_modal_form()---------------
function show_modal_form($title, $field_array, $action_button, $warning='')
{
?>
    <!-- Модальное окно -->
    
    <div class="myoverlayer"><!-- теперь нельзя кликать под формой --></div>
    
    <div id="modal_form" class="modal" tabindex="-1" role="dialog"><!-- modal hide -->
        
        <div class="modal-header">
            <div align="center">
                <?php if($warning !='') echo '<div align="center" class="well well-small alert-error">'.$warning.'</div>';?>
                <h4><?php echo $title; ?></h4>
            </div>
        </div>
    
        <!-- body -->
        <div class="modal-body" align="center">
            <!-- Содержимое модального окна -->
            <table border="0" cellspacing="3" cellpadding="3" class="mytable">
                <?php
                for ($i = 0; $i < count($field_array); ++$i)
                {
                    echo '<tr>';    //начали строку
                    echo '<td>' .$field_array[$i][0]. '</td>';//строка-пояснение перед элементом формы
                    echo '<td>' .$field_array[$i][1]. '</td>';//тип инпута(прописывать руками!): <input ...>
                    echo '<td>';    //открыли столбик
                    if(trim($field_array[$i][2])  != '')        //если строка-предупреждение не пустая, то
                        echo '<span class="label label-important">'.$field_array[$i][2].'</span>'; //выведем ее
                    echo '</td>';   //закрыли столбик
                    echo '</tr>';   //закончили строку
                }
                /* образец
                <tr>
                    <td align="right">Дисциплина</td>
                    <td><input name="new_subject" type="text" size="50"></td>
                </tr>
                <tr>
                    <td align="right">Активность</td>
                    <td align="left"><input name="new_subject_activity" type="checkbox"  checked></td>
                </tr>
                */
                ?>
            </table>
        </div>

        <!-- нижние кнопки модального окна добавления -->
        <div  class="modal-footer">
            <?php
            //не забудь прочистку данных формы сделать!
            
            if($action_button == 'add')
                echo '<input class="btn btn-primary" type="submit"    name="add_button"    id="save_button"    value="Сохранить">';
            
            if($action_button == 'update')
                echo '<input class="btn btn-primary" type="submit"    name="update_button" id="save_button"    value="Сохранить">';
            
            if($action_button == 'add_office')
                echo '<input class="btn btn-primary" type="submit"    name="add_office" id="save_button"    value="Сохранить">';
            
            if($action_button == 'add_physic')
                echo '<input class="btn btn-primary" type="submit"    name="add_physic" id="save_button"    value="Сохранить">';
            
            if($action_button == 'add_student')
                echo '<input class="btn btn-primary" type="submit"    name="add_student" id="save_button"    value="Сохранить">';

            if($action_button == 'add_group')
                echo '<input class="btn btn-primary" type="submit"    name="add_group" id="save_button"    value="Сохранить">';

            if($action_button == 'add_new_course_in_plan')
                echo '<input class="btn btn-primary" type="submit"    name="add_new_course_in_plan_button"  value="Сохранить">';
            
            if($action_button == 'add_new_office_people')
                echo '<input class="btn btn-primary" type="submit"    name="add_new_office_people_button"  value="Сохранить">';
            
            
            ?>
            
            <input class="btn"  type="reset"    name="reset_button"     value="Очистить"    id="reset_button">
            <input class="btn"  type="submit"   name="cancel_button"    value="Отменить">
        </div>
    </div>

<?php
}
?>

<?php

//генератор таблицы 
function tablebodygenerator($link)
{
    while ($row = mysql_fetch_row($link)) {
        echo '<tr>';
        for ($i = 0; $i < count($row); $i++)
        {
            if ($i == 0)
            {
                echo "<td><input type=\"checkbox\" name=\"checkbox$row[0]\"></td>";
                echo "<td>$row[$i]</td>";
                continue;
            }
            if ($i == count($row) - 1)
            {
                echo "<td>$row[$i]</td>";
                echo "<td><input class=\"btn btn-primary\" type=\"submit\" value=\"...\" name=\"x-key-edit$row[0]\"><input type=\"hidden\" name=\"edit_flag\"></td>";
                continue;
            }
            echo "<td>$row[$i]</td>";
        }
        echo '</tr>';
    }
}

function tablebodygenerator2($link)
{
    while ($row = mysql_fetch_row($link)) {
        echo '<tr>';
        for ($i = 0; $i < count($row); $i++)
        {
            if ($i == 0)
            {
                echo "<td><input type=\"checkbox\" name=\"checkbox$row[0]\"></td>";
                echo "<td>$row[$i]</td>";
                continue;
            }
            if ($i == count($row) - 1)
            {
                echo "<td>$row[$i]</td>";
                echo "<td><input class=\"btn btn-primary\" type=\"submit\" value=\"...\" name=\"x-key-edit$row[0]\"><input type=\"hidden\" name=\"edit_flag\"></td>";
                continue;
            }
            echo "<td><pre>$row[$i]</pre></td>";
        }
        echo '</tr>';
    }
}


//логотип и название
function echo_product_name()
{
    echo '<div align="center"><img src="/images/logo.png"></div>';
    echo '<div align="center">'.PRODUCT_NAME.'</div>';
}

//футер
function footer()
{
    echo '<br><div class="well well-small" align="right">'.PRODUCT_NAME.' '.  date('Y').'</div>';
}

//Вывод сотрудника:
function whoareyou($coockiename) 
{
    $querystring = 'SELECT `lastname`,`firstname`,`patronymic`,`position` FROM `users` WHERE `login`=\'' . $coockiename . '\' LIMIT 1';
    $usertitlequery = mysql_query($querystring);
    $usertitlerow = mysql_fetch_row($usertitlequery);
    echo "Вы: $usertitlerow[0] $usertitlerow[1] $usertitlerow[2], $usertitlerow[3]";
}

//меню
function left_menu()
{
    echo '                    <ul class="nav nav-pills nav-stacked">';
    $menu=array();
    $menu[0][0]='/desktop.php';
    $menu[0][1]='Главная';

    $menu[1][0]='/groups.php';
    $menu[1][1]='Слушатели';
    
    $menu[2][0]='/courses.php';
    $menu[2][1]='Программы ДО';//курсы

    $menu[3][0]='/teachers.php';
    $menu[3][1]='Преподаватели';

    $menu[4][0]='/subjects.php';
    $menu[4][1]='Дисциплины';

    $menu[5][0]='/reports.php';
    $menu[5][1]='Отчеты';

    $menu[6][0]='/orders.php';
    $menu[6][1]='Заявки';

    $menu[7][0]='/settings.php';
    $menu[7][1]='Настройки';

    $menu[8][0]='/logout.php';
    $menu[8][1]='Выход';

    for($i=0; $i<count($menu); ++$i)
        if($menu[$i][0] == $_SERVER['SCRIPT_NAME'])
            echo '                       <li class="active">     <a>'.$menu[$i][1].'</a></li>';
        else
            echo '                       <li>                    <a href="'.$menu[$i][0].'">'.$menu[$i][1].'</a></li>';

    echo '                    </ul>';
}

function df()//debug
{
    //if (DEBUG) {  echo'<pre>';  if($_SERVER['SERVER_NAME'] == "localhost")  print_r($_POST); echo'</pre>';  }
}

?>