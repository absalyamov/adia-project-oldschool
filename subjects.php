<?php
//let the party begin!
require 'dbconnection.php';
require 'constants.php';
require 'functions.php';
//functions

cancel_button();

//если нажали "Добавить" на модальной форме
if (isset($_POST['add_button']))
{

    //профильтруем название дисциплины
    $new_subject = mysql_real_escape_string(htmlspecialchars(trim($_POST['new_subject'])));

    //если в итоге это не пустой ввод
    while (1)
    {// как будто продолжать бесконечно
        //если после фильтрования выяснилось, что пользователь оплошал и натыкал нам пробелы или вообще просто нажал "добвавить", то
        if ($new_subject == '')
        {
            $sew = true; //sew = subject empty warning
            break; //если пустота, то расходимся.
        }

        //проверим наличие вводимой дисциплины:
        //qs = query string
        $qs = 'SELECT COUNT(*) FROM `subjects` WHERE `subject`=\'' . $new_subject . '\'';

        //qr = query row
        $qr = mysql_query($qs);

        //tr = temporary row
        $tr = mysql_fetch_row($qr);

        //если есть такая дисцплина, то
        if ($tr[0] == '1')
        {
            $sdw = true; //subject duplicate warning
            break; // продолжать бесконечно не получится, ибо... ну надо же как-то выйти из цикла. Тем более причина есть.
        }

        //если выше проверки прошли успешно, то
        //формируем запрос sql на добавление
        $add_new_subject_query = 'INSERT INTO `subjects` (`id`, `subject`) VALUES (NULL,\'' . $new_subject . '\')';
        $add_new_subject_result = mysql_query($add_new_subject_query);

        //$sdw=false;//ПРОВЕРИТЬ ! нужно ли?
        //$sew=false;
        //далее спорная команда отправить себя самого к себе самому же
        header('Location: /subjects.php');
        break;
    }
}


//УДАЛЕНИЕ
if(isset($_POST['delete']))
{
    ;
}

?>
<!--
                            HTML
                            HTML
                            HTML
                            HTML
                            HTML
                            HTML
                            HTML
                            HTML
                            HTML
-->
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <link href="css/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="css/mycss.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="css/bootstrap/js/bootstrap.js"></script>

        <script type="text/javascript">
        function checkAll(obj) {
          'use strict';
          // Получаем NodeList дочерних элементов input формы:
          var items = obj.form.getElementsByTagName("input"),
              len, i;
          // Здесь, увы цикл по элементам формы:
          for (i = 0, len = items.length; i < len; i += 1) {
            // Если текущий элемент является чекбоксом...
            if (items.item(i).type && items.item(i).type === "checkbox") {
              // Дальше логика простая: если checkbox "Выбрать всё" - отмечен
              if (obj.checked) {
                // Отмечаем все чекбоксы...
                items.item(i).checked = true;
              } else {
                // Иначе снимаем отметки со всех чекбоксов:
                items.item(i).checked = false;
              }
            }
          }
        }
        </script>

        <!-- если у нас проблемный IE-- >
        <!--[if lt IE 9]>
          <script src="js/html5.js"></script>
        <![endif]-->

        <title>Дисциплины - <?php echo PRODUCT_NAME; ?></title>
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

                    <!-- <form action -->
                    <!-- <form action -->
                    <!-- <form action -->
                    <!-- <form action -->
                    <!-- <form action -->
                    <!-- <form action -->

                    <form action="subjects.php" method="post" name="subjects_form">
                        <?php
                        //если под таблицей нажали УДАЛИТЬ
                        
                        if(isset($_POST['delete']))
                        {
                            //нужно выяснить, какие именно записи отмечены
                            //подготовим данные (вытащим из $_POST checkboxX, где X == ID):
                            $tmparray = array_keys($_POST);
                            for ($i = 0; $i < count($tmparray); ++$i)
                            {
                               //если перебираемый ключ указывает нам на ячейку с 'checkbox', то
                               if (substr($tmparray[$i], 0, 8) == 'checkbox')
                               {
                                   mysql_query("DELETE FROM `subjects` WHERE `subjects`.`id` = ".substr_replace($tmparray[$i], '', 0, 8)." LIMIT 1");
                               }
                            }
                            unset($tmparray);
                            header("Location: subjects.php");
                        }

                        //если под таблицей нажали АКТИВИРОВАТЬ+
                        if(isset($_POST['activate']))
                        {
                            //нужно выяснить, какие именно записи отмечены
                            //подготовим данные (вытащим из $_POST checkboxX, где X == ID):
                            $tmparray = array_keys($_POST);
                            for ($i = 0; $i < count($tmparray); ++$i)
                            {
                               //если перебираемый ключ указывает нам на ячейку с 'checkbox', то
                               if (substr($tmparray[$i], 0, 8) == 'checkbox')
                               {
                                   mysql_query("UPDATE  `subjects` SET  `active` =  '1' WHERE  `subjects`.`id` =".substr_replace($tmparray[$i], '', 0, 8));
                               }
                            }
                            unset($tmparray);
                            header("Location: subjects.php");
                        }

                        //если под таблицей нажали ДЕАКТИВИРОВАТЬ+
                        if(isset($_POST['deactivate']))
                        {
                            //нужно выяснить, какие именно записи отмечены
                            //подготовим данные (вытащим из $_POST checkboxX, где X == ID):
                            $tmparray = array_keys($_POST);
                            for ($i = 0; $i < count($tmparray); ++$i)
                            {
                               //если перебираемый ключ указывает нам на ячейку с 'checkbox', то
                               if (substr($tmparray[$i], 0, 8) == 'checkbox')
                               {
                                   mysql_query("UPDATE  `subjects` SET  `active` =  '0' WHERE  `subjects`.`id` =".substr_replace($tmparray[$i], '', 0, 8));
                               }
                            }
                            unset($tmparray);
                            header("Location: subjects.php");
                        }

                        //если нажали "Добавить" на странице+
                        if(isset($_POST['add_new_subject_button']))//+
                        {
                            $addnews='Добавление новой дисциплины';//+
                            $addarray=array();
                            $addarray[0][0]='Дисциплина';
                            $addarray[0][1]='<input type="text" name="new_subject" >';
                            $addarray[0][2]='';
                            $add = 'add';//+
                            show_modal_form($addnews, $addarray, $add,''); //при формировании страницы покажем модальную форму редактирования
                        }

                        //если нажали "..."(редактировать) на странице+
                        if(isset($_POST['edit_flag']) and !isset($_POST['add_new_subject_button']) and !isset($_POST['delete']) and !isset($_POST['activate']) and !isset($_POST['deactivate']))//+
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
                                   break; //прекратить перебор массива
                               }
                               //header("Location: subjects.php");
                               
                            }

                            //подготовим данные:
                            //qs = query string
                            $qs = 'SELECT * FROM `subjects` WHERE `ID`=\'' . $id_row . '\'';
                            //qr = query row
                            $qr = mysql_query($qs);
                            //tr = temporary row
                            $tr = mysql_fetch_row($qr); //массив со всей строкой по ячейкам
                            print_r($tr);
                            $editarray = array();//id,activity,subject
                            $editarray[0][0]='Дисциплина';
                            $editarray[0][1]='<input type="text"        name="new_subject"      value="'.$tr[2].'">';
                            $editarray[0][2]='';
                            $editarray[1][0]='Активность';
                            if($tr[1])
                                $editarray[1][1]='<input type="checkbox"    name="subject_activity" checked>';
                            else
                                $editarray[1][1]='<input type="checkbox"    name="subject_activity">';    
                            
                            $editarray[1][2]='';

                            $title1='Редактирование дисциплины';//+

                            $update = 'update';//+
                            show_modal_form($title1, $editarray, $update); //при формировании страницы покажем модальную форму редактирования;
                        }
                        ?>

                        <!-- кнопка добавить новую дисциплину-->
                        <input type="submit" name="add_new_subject_button" class="btn btn-primary" value="Добавить новую дисциплину">

                        <!-- бывшее место закрытия form. теперь тут br-->
                        <br />
                        <br />
                        <table border="0" cellpadding="2" cellspacing="2" align="center" class="table table-hover">
                            <?php
                            $table_header_footer = '
                                <tr class="success">
                                <td>
                                    <input type="checkbox" name="all_on_page" onclick="checkAll(this)"> Все
                                </td>
                                <td>
                                    ID
                                </td>
                                <td>
                                    Дисциплина
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
                            $rowcount = mysql_result(mysql_query('SELECT COUNT(*) FROM `subjects`'), 0);
                            $result = mysql_query("SELECT * FROM `subjects` WHERE 1 LIMIT $rowsperpage");

                            if (!$result)
                                die('Error:' . mysql_error());
                            else
                                tablebodygenerator($result);

                            echo $table_header_footer;
                            ?>


                            <tr class="success">
                                <td colspan="5">
                                    <span style="margin: 5px 5px 0 0; float:left">Выделенные</span>
                                    <input class="btn btn-warning" type="submit" name="delete" 		value="Удалить" onclick="if(confirm('Желаете удалить выбранные записи?'))  ;   else return false;  ">
<!--                                    <input class="btn btn-success" type="submit" name="activate" 	value="Активировать">
                                    <input class="btn btn-inverse" type="submit" name="deactivate" 	value="Деактивировать">-->
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