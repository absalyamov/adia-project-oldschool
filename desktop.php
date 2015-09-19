<?php
//let the party begin!
require 'dbconnection.php';
require 'constants.php';
require 'functions.php';

//отмена добавления или редактирования
cancel_button();




//если нажали "Добавить" на модальной форме
if (isset($_POST['add_new_course_in_plan_button']))
{
    while (1) //как будто продолжать бесконечно
    {   
        //формируем запрос sql 
        if (isset($_POST['add_new_course_in_plan_button']))
            $my_query = 'INSERT INTO `plan` (`id`, `group-id`, `startdate`, `enddate`,`room`)
                VALUES (NULL, \''.$_POST['group_list'].'\',\''.$_POST['start_date'].'\',\''.$_POST['end_date'].'\',\''.$_POST['note'].'\')';

//        if (isset($_POST['update_button']))
//            $my_query = 'UPDATE  `courses` 
//                SET  `name` = \''.$_POST['name'].'\',`hours` =  \''.$_POST['hours'].'\',
//                     `moneyperhour` =  \''.$_POST['tax'].'\',`price`=\''.$_POST['price'].'\' 
//                     WHERE `id` = \''.$_POST['id'].'\'';
        
        //echo $add_new_course_query;
        $my_query_result = mysql_query($my_query);
        
        if (mysql_errno($link) == 0)//если без ошибок
        {
           // header('Location: /groups.php');                
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
    
    //header("Location: /desktop.php");    
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
        <link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="css/bootstrap/js/bootstrap.js"></script>
        <script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
        <link href="css/bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="css/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/additional-methods.js"></script>
        
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

        <title>Главная - <?php echo PRODUCT_NAME; ?></title>
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

        <div class="well well-small"> <!-- Выведет залогиненного -->
        <?php whoareyou($_COOKIE['my_cookie']); ?>
        </div>

        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span2">
                    <!--МЕНЮ СЛЕВА-->
                    <?php left_menu(); ?>
                </div>

                <div class="span10">

                    <!-- <form action -->
                    <!-- <form action -->
                    <!-- <form action -->
                    <!-- <form action -->
                    <!-- <form action -->
                    <!-- <form action -->

                    <form action="desktop.php" method="post" name="plan_form">
                        <?php
                        
                        //добавить новое юрлицо
                        if(isset($_POST['add_new_course_in_plan']))                        
                        {
                            $title='Добавление курса по программе ДО в расписание';
                            $addarray=array();
                            
                            $addarray[0][0]='Выберите группу ';
                            //создадим список групп
                            $list1='<select name="group_list" >';
                            $q1='SELECT `id` FROM `groups` WHERE 1';
                            $r1=mysql_query($q1);
                            while($r2 = mysql_fetch_row($r1))
                            {
                                $list1=$list1.'<option value='.$r2[0].'>'.$r2[0].'</option>';
                            }
                            $list1=$list1.'</select>';

                            $addarray[0][1]=$list1;
                            unset($r1);
                            unset($r2); 
                            unset($list1);
                            unset($q1);
                            $addarray[0][2]='';
                            
                            $addarray[1][0]='Укажите дату начала курса';
                            $addarray[1][1]='
                            <div id="datetimepicker1" class="input-append">
                                  <input id="start_date" data-format="dd-MM-yyyy" type="text" name="start_date"></input>
                                  <span class="add-on">
                                    <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                    </i>
                                  </span>
                            </div>
                            <script type="text/javascript">
                                $(function() {
                                  $(\'#datetimepicker1\').datetimepicker({
                                    pickTime: false
                                  });
                                });
                            </script>';
                            $addarray[1][2]='';

                            $addarray[2][0]='Укажите дату окончания курса';
                            $addarray[2][1]=' 
                            <div id="datetimepicker2" class="input-append">
                                                <input id="endt_date" data-format="dd-MM-yyyy" type="text" name="end_date"></input>
                                                <span class="add-on">
                                                  <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                                  </i>
                                                </span>
                            </div>
                            <script type="text/javascript">
                                              $(function() {
                                                $(\'#datetimepicker2\').datetimepicker({
                                                  pickTime: false
                                                });
                                              });
                            </script>';
                            $addarray[2][2]='';

                            $addarray[3][0]='Примечание';
                            $addarray[3][1]='<textarea name="note" cols="45" rows="5"></textarea>';
                            $addarray[3][2]='';
                            
                            $add = 'add_new_course_in_plan';//+
                            show_modal_form($title, $addarray, $add, ''); //при формировании страницы покажем модальную форму редактирования  
                            unset($_POST['edit_flag']);                            
                        }
                        
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
                            header("Location: /groups.php");
                        }



                        //если нажали "Добавить" модальной форме+
                        if(isset($_POST['add_new_group']))//+
                        {
                            $title='Добавление новой группы';//+
                            $addarray=array();
                            $addarray[0][0]='Выберите ';
                            $addarray[0][1]='<input type="text" name="new_subject" >';
                            $addarray[0][2]='';
                            $addarray[1][0]='Активность';
                            $addarray[1][1]='<input type="checkbox" name="subject_activity" checked>';
                            $addarray[1][2]='';
                            $add = 'add';//+
                            show_modal_form($addnews, $addarray, $add); //при формировании страницы покажем модальную форму редактирования
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

                        
                        
                        
                        
                        
                        
                        <!-- табы! -->
                        
                        
                        <div id="groups_TabbedPanels1" class="TabbedPanels">
                         
                          <ul class="TabbedPanelsTabGroup">
                            <li class="TabbedPanelsTab" tabindex="0">Сегодня</li>
                            <li class="TabbedPanelsTab" tabindex="0">Расписание</li>
                          </ul>

                         <div class="TabbedPanelsContentGroup">
                            <!--Заняитя сегодня-->    
                            <div class="TabbedPanelsContent">Cегодня <?php echo date('d-m-Y').', '.date('D');?>
                            <br>
                            <br>
                            <p>Сметное дело</p>
                            <p>Физика II</p>
                            </div>
                            
                            <!-- сетка расписания--->  
                            <div class="TabbedPanelsContent">
                                                    <input type="submit" name="add_new_course_in_plan" class="btn btn-primary myoffset" value="Добавить новый курс в расписание">
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
                                                                  Программа ДО
                                                              </td>
                                                              <td>
                                                                  Группа(ID)
                                                              </td>
                                                              <td>
                                                                  Преподаватель
                                                              </td>
                                                              <td>
                                                                  Дата начала
                                                              </td>
                                                              <td>
                                                                  Дата окончания
                                                              </td>
                                                              <td>
                                                                  Примечание
                                                              </td>
                                                              <td>
                                                                  Редактировать
                                                              </td>
                                                          </tr>';

                                                          echo $table_header_footer;
                                                          ?>

                                                          <?php
                              //-------выводим тело таблицы-------------------------                            
                                                          // формирование таблицы
                                                          $rowsperpage = 30;
                                                          //сколько всего записей?
                                                          $rowcount = mysql_result(mysql_query('SELECT COUNT(*) FROM `plan`'), 0);
                                                          $result = mysql_query("SELECT * FROM `plan` WHERE 1 LIMIT $rowsperpage");

                                                          if (!$result)
                                                              die('Error:' . mysql_error());
                                                          else
                                                                {
                                                                    while ($row = mysql_fetch_row($result)) {
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
                                                          unset($row);
                                                          unset($i);
                                                          echo $table_header_footer;
                                                          ?>

                                                          <tr class="success">
                                                              <td colspan="12">
                                                                  <span style="margin: 5px 5px 0 0; float:left">Выделенные</span>	
                                                                  <input class="btn btn-warning" type="submit" name="delete" 	onclick="return confirm('Вы действительно желаете удалить отмеченные записи?');" value="Удалить">
                                                                  <!-- input class="btn btn-success" type="button" name="activate" 	value="Активировать">
                                                                  <input class="btn btn-inverse" type="button" name="deactivate" 	value="Деактивировать"-->
                                                              </td>
                                                          </tr>
                                                      </table>

                                                      <div style="float:left; margin-left: 0;">
                                                          <span style="margin: 5px 2px 0 0; float:left">Всего записей: <?php echo $rowcount;?></span>
                                                          <span style="margin: 5px 2px 0 20px; float:left">На странице:</span>
                                                          <select class="input-small" name="rows_per_page">
                                                              <option>30</option>
                                                              <option>100</option>
                                                              <option>200</option>
                                                              <option>500</option>
                                                              <option>Все</option>
                                                          </select>
                                                      <input type="submit" name="show" class="btn btn-primary" value="Показать">
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
                                </div>
                          </div>

                        </div>                        
                        
                        <script type="text/javascript">
                            var TabbedPanels1 = new Spry.Widget.TabbedPanels("groups_TabbedPanels1", {defaultTab:0  });
                        </script>
                        


<!--                    </form>-->
                </div>
            </div>
        </div>

        <?php footer(); ?>

    </body>
</html>