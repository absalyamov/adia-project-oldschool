<?php
//let the party begin!
require 'dbconnection.php';
require 'constants.php';
require 'functions.php';


//functions

//отмена добавления или редактирования
if (isset($_POST['cancel_button'])) 
{
    header("Location: /reports.php");
}


//если нажали "Добавить" на модальной форме
if (isset($_POST['add_button'])) 
{
    //галочка Активность поставлена или нет?
    if ($_POST['teacher_activity'] == "on")
        $new_teacher_activity = 1;
    else
        $new_teacher_activity = 0;

    //профильтруем название дисциплины
    $new_teacher = mysql_real_escape_string(htmlspecialchars(trim($_POST['new_teacher'])));

    //если в итоге это не пустой ввод
    while (1) 
    {// как будто продолжать бесконечно
        //если после фильтрования выяснилось, что пользователь оплошал и натыкал нам пробелы или вообще просто нажал "добвавить", то
        if ($new_teacher == '')
        {
            $sew = true; //sew = teacher empty warning
            break; //если пустота, то расходимся.
        }

        //проверим наличие вводимой дисциплины:
        //qs = query string
        $qs = 'SELECT COUNT(*) FROM `teachers` WHERE `teacher`=\'' . $new_teacher . '\'';

        //qr = query row
        $qr = mysql_query($qs);

        //tr = temporary row
        $tr = mysql_fetch_row($qr);

        //если есть такая дисцплина, то
        if ($tr[0] == '1') 
        {
            $sdw = true; //teacher duplicate warning
            break; // продолжать бесконечно не получится, ибо... ну надо же как-то выйти из цикла. Тем более причина есть.
        }

        //если выше проверки прошли успешно, то 
        //формируем запрос sql на добавление
        $add_new_teacher_query = 'INSERT INTO `teachers` (`id`, `active`, `teacher`) VALUES (NULL, \'' . $new_teacher_activity . ' \',\'' . $new_teacher . '\')';
        $add_new_teacher_result = mysql_query($add_new_teacher_query);

        //$sdw=false;//ПРОВЕРИТЬ ! нужно ли?
        //$sew=false;
        //далее спорная команда отправить себя самого к себе самому же
        header('Location: /reports.php');
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
        <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="css/bootstrap/js/bootstrap.js"></script>

        <!-- если у нас проблемный IE-- >
        <!--[if lt IE 9]>
          <script src="js/html5.js"></script>
        <![endif]-->

        <title>Отчеты - <?php echo PRODUCT_NAME; ?></title>
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
                    <form action="reports.php" method="post" name="reports_form">
                        <?php

                        //если нажали "Добавить" на странице
                        if(isset($_POST['course_report']))//+
                        {
                            $addnews='Отчет по курсам';//+
                            //$addarray = array(1, 1, 1, 1,  1, 8 => 1,  4 => 1, 19, 3 => 13);
                            $addarray=array();
                            $addarray[0][0]='Фамилия';
                            $addarray[0][1]='<input type="text" name="new_teacher">';
                            $addarray[0][2]='';
                            $addarray[1][0]='Имя';
                            $addarray[1][1]='<input type="text" name="new_teacher">';
                            $addarray[1][2]='';
                            $addarray[2][0]='Отчество';
                            $addarray[2][1]='<input type="text" name="new_teacher">';
                            $addarray[2][2]='';
                            $addarray[3][0]='Степень';
                            $addarray[3][1]='<input type="text" name="new_teacher">';
                            $addarray[3][2]='';
                            $addarray[4][0]='Дисциплина';
                            $addarray[4][1]='<input type="text" name="new_teacher">';
                            $addarray[4][2]='';
                            $add = 'add';//+
                            show_modal_form($addnews, $addarray, $add); //при формировании страницы покажем модальную форму редактирования
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
                            print_r($tr);
                            $editarray = array();//id,activity,teacher
                            $editarray[0][0]='Дисциплина';
                            $editarray[0][1]='<input type="text"        name="new_teacher"      value="'.$tr[2].'">';
                            $editarray[0][2]='';
                            $editarray[1][0]='Активность';
                            $editarray[1][1]='<input type="checkbox"    name="teacher_activity" value="'.$tr[0].'">';
                            $editarray[1][2]='';
                            
                            $title1='Редактирование данных преподавателя';//+

                            $update = 'update';//+
                            show_modal_form($title1, $editarray, $update); //при формировании страницы покажем модальную форму редактирования;
                        }
                        ?>
                        
                        <!-- кнопка добавить новую дисциплину
                        <input type="submit" name="add_new_teacher_button" class="btn btn-primary" value="Добавить нового преподавателя">
-->
                        <ul class="thumbnails">
                          
                          <li class="span3">
                            <a class="thumbnail">
                              <img src="images/report-image-buttons-260x180.jpg" alt="">
                              <br>
                              <input type="submit" value="Отчет по курсам" name="course_report" class="btn btn-primary  ">
                              <br>
                              <br>
                              <p>Воспользуйтесь этим мастером, чтобы получить отчет по проведенным курсам</p>
                            </a>
                          </li>
                          
                          <li class="span3">
                            <a class="thumbnail">
                              <img src="images/report-image-buttons-260x180.jpg" alt=""><br>
                              <input type="submit" value="Отчет по преподавателям" name="course_report" class="btn btn-primary  "><br><br>
                              <p>Мастер создания отчета по преподавателям на курсах</p>
                            </a>
                          </li>
                          
                          <li class="span3">
                            <a class="thumbnail">
                              <img src="images/report-image-buttons-260x180.jpg" alt=""><br>
                              <input type="submit" value="Отчет по слушателям" name="course_report" class="btn btn-primary  "><br><br>
                              <p>Отчет по слушателям курсов</p>
                            </a>
                          </li>
                          
                        </ul>

                        <!-- бывшее место закрытия form. теперь тут br-->
                        <br />
                        <br />
                        <!--<table border="0" cellpadding="2" cellspacing="2" align="center" class="table table-hover">-->
                            <?php
                            /*
                            $table_header_footer = '
                            <tr class="success">
                                <td>
                                    <input type="checkbox" name="all_on_page"> -выд. все
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
                                    Учёная степень
                                </td>
                                <td>
                                    Дисциплина
                                </td>
                                <td>
                                    Редактировать
                                </td>
                            </tr>';
                            
                            echo $table_header_footer;
                            */
                            ?>
                            

                            <?php
                            /*
                            // формирование таблицы
                            $rowsperpage = 30;
                            //сколько всего записей?
                            $rowcount = mysql_result(mysql_query('SELECT COUNT(*) FROM teachers'), 0);
                            $result = mysql_query("SELECT * FROM `teachers` WHERE 1 LIMIT $rowsperpage");

                            if (!$result)
                                die('Error:' . mysql_error());
                            else 
                                teachers_table_body_generator($result);
                            
                            echo $table_header_footer;
                            */
                            ?>
                            

                            <!--
                            <tr class="success">
                                <td colspan="8">
                                    <span style="margin: 5px 5px 0 0; float:left">Выделенные</span>	<input class="btn btn-warning" type="button" name="delete" 		value="Удалить">
                                    <input class="btn btn-success" type="button" name="activate" 	value="Активировать">
                                    <input class="btn btn-inverse" type="button" name="deactivate" 	value="Деактивировать"> 
                                </td>
                            </tr>						
                        </table>

                        <div style="float:left; margin-left: 0;">
                            <span style="margin: 5px 2px 0 0; float:left">Всего записей: <?php //echo $rowcount;?></span>
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
                        -->
                    </form>
                </div>
            </div>
        </div>

        <?php footer(); ?>

    </body>
</html>