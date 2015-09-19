<?php
//spry, едактирование переделать, так как дупликат прикидывается добавлением, удаление, пагинацию, записей на страницу
//let the party begin!
require 'dbconnection.php';
require 'constants.php';
require 'functions.php';

//functions

//отмена добавления или редактирования
if (isset($_POST['cancel_button'])) 
{
    header("Location: /teachers.php");
}
//если нажали "Добавить" на модальной форме

function insert($table, $tablearray, $formarray)
{
    $cnt = count($formarray);    
    
    for($i = 0; $i < $cnt; ++$i)//профильтруем ввод
        $formarray[$i] = mysql_real_escape_string(htmlspecialchars(trim( $formarray[$i] )));
    
    $query1 = 'INSERT INTO `'.$table.'` ';
    $query2 = '(';
    $query3 = '';
    
    $cnt = count($tablearray);  
    for($i = 0; $i < $cnt; ++$i)
        $query3 = $query3.'`'.$tablearray[$i].'`,';
    $query3 = substr($query3,0, strlen($query3)-1 );//убрали запятую последнюю
        
    $query4 = ')';    
    
    $query5 = ' VALUES ( NULL, ';
    $query6 = '';

    $cnt = count($formarray);     
    for($i = 0; $i < $cnt; ++$i)
        $query6 = $query6.'\''.$formarray[$i].'\',';    

    $query6 = substr($query6,0, strlen($query6)-1 );//убрали запятую последнюю    
    
    $query7 = ')';
    $query = $query1.$query2.$query3.$query4.$query5.$query6.$query7;
    
    return $query;
}

function update($table, $tablearray, $formarray, $id)
{
    echo '<pre>';
    print_r($formarray);
    echo '</pre>';
    $cnt = count($formarray);    
    
    for($i = 0; $i < $cnt; ++$i)//профильтруем ввод
        $formarray[$i] = mysql_real_escape_string(htmlspecialchars(trim( $formarray[$i] )));
                
    $query1 = 'UPDATE `'.$table.'` SET ';
    $query2 = '';
    
    $cnt = count($tablearray);  
    for($i = 1; $i < $cnt; ++$i)
        $query2 = $query2.'`'.$tablearray[$i].'` = \''.$formarray[$i-0].'\',';
    
    $query2 = substr($query2,0, strlen($query2)-1 );//убрали запятую последнюю
        
    $query3 = ' WHERE `id` = \''.$id.'\'';    

    $query = $query1.$query2.$query3;
    
    return $query;
}

if (isset($_POST['add_button']) or isset($_POST['update_button']))
{
    while (1) //как будто продолжать бесконечно
    {   
        //формируем запрос sql 
        if (isset($_POST['add_button']))
            $my_query = insert(
                              'teachers',
                              array('id','lastname','firstname','patronymic','phone','subject-id'),
                              array($_POST['lastname'],$_POST['firstname'],$_POST['patronymic'],$_POST['phone'],$_POST['subject_list'])
                              );
//    echo '<pre>';
//    print_r($_POST);
//    echo '</pre>';
        if (isset($_POST['update_button']))
            $my_query = update(
                        'teachers',
                        array('id','lastname','firstname','patronymic','phone','subjects'),
                        array($_POST['lastname'],$_POST['firstname'],$_POST['patronymic'],$_POST['phone'],$_POST['subjects']),
                        $_POST['id']
                        );
        
        $my_query_result = mysql_query($my_query);
        
        if (mysql_errno($link) == 0)//если без ошибок
        {
            header('Location: /teachers.php');                
            break;
        }
        
        if (mysql_errno($link) == 1062)//если дупликат
        {
            $warning = 'Такая запись уже имеется';
            break;
        }

        if (mysql_errno($link) != 0)
        {
            $warning = 'Ошибка при добавлении записи в БД';//флаг прочих ошибок при добавлении в дб
            break;
        }
        break;
    }
}


?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <link href="css/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="css/mycss.css" rel="stylesheet" type="text/css">
        <link href="css/bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
        <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="css/bootstrap/js/bootstrap.js"></script>
        <script type="text/javascript" src="css/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/additional-methods.js"></script>
        <script src="js/jsfunctions.js" type="text/javascript"></script>
        
        <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

        <!-- если у нас проблемный IE-- >
        <!--[if lt IE 9]>
          <script src="js/html5.js"></script>
        <![endif]-->

        <title>Преподаватели - <?php echo PRODUCT_NAME; ?></title>
    </head>
    <body>
        

        
    <?php
    df();
    
    //если не удалось соединиться с базой данных, то выведет на красном баре ошибку
    if (isset($dbce)) 
    {//db connection error
        die('<div align="center" class="well well-small alert-error">' . PRODUCT_NAME . ': ' . $dbce . '</div></body></html>');
    }
    
    ?>

        <div class="well well-small">
            <h5>
            <?php
            echo_product_name() //выведет константу, задающую название всей системы или просто желаемую надпись
            ?>
            </h5>
        </div>

        <div class="well well-small">
        <?php whoareyou($_COOKIE['my_cookie']); ?>
        </div>

        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span2">
                    <!--Sidebar content-->
                    <?php left_menu(); ?>
                </div>

                <div class="span10">
                    
                    <!-- форма -->
                    <form action="teachers.php" method="post" name="teachers_form">
                        <?php

                        //если нажали "Добавить" на странице
                        if(isset($_POST['add_new_teacher_button'])  or isset($warning))
                        {
                            $title='Добавление нового преподавателя';

                            $addarray=array();
                            
                            $addarray[0][0]='Фамилия';
                            $addarray[0][1]='<input type="text" name="lastname">';
                            $addarray[0][2]='';
                            
                            $addarray[1][0]='Имя';
                            $addarray[1][1]='<input type="text" name="firstname">';
                            $addarray[1][2]='';
                            
                            $addarray[2][0]='Отчество';
                            $addarray[2][1]='<input type="text" name="patronymic">';
                            $addarray[2][2]='';
                            
                            $addarray[3][0]='Телефон';
                            $addarray[3][1]='<input type="text" name="phone">';
                            $addarray[3][2]='';
                            
                            $addarray[4][0]='Дисциплины';
                            //создадим список дисциплин
$list1='<select name="subject_list" >';
$q1='SELECT 
    *
    FROM 
    `subjects` 
    WHERE 
    1';

                            $r1=mysql_query($q1);
                            while($r2 = mysql_fetch_row($r1))
                            {
                                $list1=$list1.'<option value='.$r2[0].'>'.$r2[1].'</option>';
                            }
                            $list1=$list1.'</select>';
                            $addarray[4][1]=$list1;
                            unset($r1);
                            unset($r2); 
                            unset($list1);
                            unset($q1); 
                            
                            $addarray[4][2]='';
                            
                            $command = 'add';
                            show_modal_form($title, $addarray, $command, $warning); //при формировании страницы покажем модальную форму редактирования
                            unset($title);
                            unset($addarray);
                            unset($command);
                            unset($warning);
                            unset($_POST['edit_flag']);
                        }

                        //если нажали "..."(редактировать) на странице
                        if(isset($_POST['edit_flag']) && !isset($_POST['add_new_teacher_button'])  )//+
                        {
                            //подготовим данные (вытащим из $_POST x-key-editX, где X == ID):
                            $tmparray = array_keys($_POST); //array_keys — Возвращает все или некоторое подмножество ключей массива
                                                               //    print_r($tmparray);
                            //найдем ключ ячейки x-key-editX:
                            for ($i = 0; $i < count($tmparray); ++$i) 
                            {
                               //если перебираемый ключ указывает нам на ячейку с 'x-key-edit', то
                               if (substr($tmparray[$i], 0, 10) == 'x-key-edit') 
                               {
                                   //то данный ключ $i даст нам x-key-editX:	
                                   $id_row = substr_replace($tmparray[$i], '', 0, 10); //"вытащили" из строки ID записи
                                   echo $id_row;
                                   break; //прекратить перебор массива
                               }
                            }

                            //подготовим данные:
                            //qs = query string
                            $qs = 'SELECT * FROM `teachers` WHERE `ID`=\'' . $id_row . '\'';
                            //qr = query row
                            $qr = mysql_query($qs);
                            //tr = temporary row
                            $tr = mysql_fetch_row($qr); //массив со всей строкой по ячейкам
                            //print_r($tr);
                            
                            $title='Редактирование данных преподавателя';

                            $addarray=array();
                            
                            $addarray[0][0]='Фамилия';
                            $addarray[0][1]='<input type="text" name="lastname" value="'.$tr[1].'">';
                            $addarray[0][2]='';
                            
                            $addarray[1][0]='Имя';
                            $addarray[1][1]='<input type="text" name="firstname" value="'.$tr[2].'">';
                            $addarray[1][2]='';
                            
                            $addarray[2][0]='Отчество';
                            $addarray[2][1]='<input type="text" name="patronymic" value="'.$tr[3].'">';
                            $addarray[2][2]='';
                            
                            $addarray[3][0]='Телефон';
                            $addarray[3][1]='<input type="text" name="phone" value="'.$tr[4].'">';
                            $addarray[3][2]='';
                            
                            $addarray[4][0]='Дисциплины';
                            $addarray[4][1]='<input type="text" name="subjects" value="'.$tr[5].'">';
                            $addarray[4][2]='';

                            $addarray[5][0]='';
                            $addarray[5][1]='<input type="hidden" name="id" value="'.$id_row.'">';
                            $addarray[5][2]='';
                            
                            $command = 'update';
                            show_modal_form($title, $addarray, $command, $warning); //при формировании страницы покажем модальную форму редактирования

                            unset($title);
                            unset($addarray);
                            unset($command);
                            unset($warning);
                            unset($_POST['edit_flag']);
                        }
                        ?>
                        
                        <!-- кнопка добавить нового преподавателя -->
                        <input type="submit" name="add_new_teacher_button" class="btn btn-primary" value="Добавить нового преподавателя">

                        <!-- бывшее место закрытия form. теперь тут br-->
                        <br />
                        <br />
                        <table border="0" cellpadding="2" cellspacing="2" align="center" class="table table-hover">
                            <?php
                            $table_header_footer = '
                            <tr class="success">
                                <td>
                                    <input type="checkbox" name="all_on_page"  onclick="checkAll(this)">Все
                                </td>
                                <td>
                                    ID
                                </td>
                                <td>
                                    Фамилия
                                </td>
                                <td>
                                    Имя
                                </td>
                                <td>
                                    Отчество
                                </td>
                                <td>
                                    Телефон
                                </td>
                                <td>
                                    Дисциплины
                                </td>
                                <td>
                                    Редактировать
                                </td>
                            </tr>';
                            
                            echo $table_header_footer;
                            ?>

                            <?php
                            // формирование таблицы
                            $rowsperpage = 30;
                            //сколько всего записей?
                            $rowcount = mysql_result(mysql_query('SELECT COUNT(*) FROM teachers'), 0);
                            $result = mysql_query("
SELECT
`teachers`.`id`, 
`teachers`.`lastname`, 
`teachers`.`firstname`, 
`teachers`.`patronymic`, 
`teachers`.`phone`,
`subjects`.`subject`
FROM
`teachers`,`subjects`
WHERE `teachers`.`subject-id` = `subjects`.`id`
LIMIT 
$rowsperpage"
                                    );

                            if (!$result)
                                die('Error:' . mysql_error());
                            else 
                                tablebodygenerator($result);
                            
                            echo $table_header_footer;
                            ?>


                            <tr class="success">
                                <td colspan="8">
                                    <span style="margin: 5px 5px 0 0; float:left">Выделенные</span>	<input class="btn btn-warning" type="button" name="delete" 		value="Удалить">
                                    <!-- 
                                    <input class="btn btn-success" type="button" name="activate" 	value="Активировать">
                                    <input class="btn btn-inverse" type="button" name="deactivate" 	value="Деактивировать">
                                    -->
                                </td>
                            </tr>						
                        </table>

                        <div style="float:left; margin-left: 0;">
                            <span style="margin: 5px 2px 0 0; float:left">Всего записей: <?php echo $rowcount;?></span>
                            <span style="margin: 5px 2px 0 20px; float:left">Показать на странице:</span>
                            <select class="input-small" name="rows_per_page">
                                <option>30</option>
                                <option>100</option>
                                <option>200</option>
                                <option>500</option>
                                <option>Все</option>
                            </select>
                        </div>

                        <span style="margin: 5px 4px 0 20px; float:left">Страница</span>
                        <div class="pagination">		
                            <ul>
                                <li><a href="#">Предыдущая</a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">Следующая</a></li>
                            </ul>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <?php footer(); ?>

    </body>
</html>