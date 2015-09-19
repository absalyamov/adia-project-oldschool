<?php
//пагинацию, записей на страницу
//let the party begin!
require 'dbconnection.php';
require 'constants.php';
require 'functions.php';

//functions


//отмена добавления или редактирования
if (isset($_POST['cancel_button']))
{
    header("Location: /courses.php");
}

//Удаление 
if(isset($_POST['delete']))//+
{
    //подготовим данные (вытащим из $_POST checkboxX, где X == ID):
    $tmparray = array_keys($_POST); //array_keys — Возвращает все или некоторое подмножество ключей массива

    //найдем ключ ячейки x-key-editX:
    for ($i = 0; $i < count($tmparray); ++$i)
    {
       //если перебираемый ключ указывает нам на ячейку с 'x-key-edit', то
       if (substr($tmparray[$i], 0, 8) == 'checkbox')
       {
           //то данный ключ $i даст нам x-key-editX:
           $id_row = substr_replace($tmparray[$i], '', 0, 8); //"вытащили" из строки ID записи
           //break; //прекратить перебор массива
           $deletequery = 'DELETE FROM `courses` WHERE `id` = "'.$id_row.'"';
           mysql_query($deletequery);
       }
    }
    
    unset($tmparray);
    header("Location: /courses.php");
}


//если нажали "Добавить" на модальной форме
if (isset($_POST['add_button']) or isset($_POST['update_button']))
{
    //профильтруем название дисциплины
    $new_course_name = mysql_real_escape_string(htmlspecialchars(trim($_POST['name'])));

    //если в итоге это не пустой ввод
    while (1) //как будто продолжать бесконечно
    {   
        //формируем запрос sql 
        if (isset($_POST['add_button']))
            $my_query = 'INSERT INTO `courses` (`id`, `name`, `hours`, `moneyperhour`, `price`)
                VALUES (NULL, \''.$new_course_name.'\',\''.$_POST['hours'].'\',\''.$_POST['tax'].'\',\''.$_POST['price'].'\')';
        
        if (isset($_POST['update_button']))
            $my_query = 'UPDATE  `courses` 
                SET  `name` = \''.$_POST['name'].'\',`hours` =  \''.$_POST['hours'].'\',
                     `moneyperhour` =  \''.$_POST['tax'].'\',`price`=\''.$_POST['price'].'\' 
                     WHERE `id` = \''.$_POST['id'].'\'';
        
        //echo $add_new_course_query;
        $my_query_result = mysql_query($my_query);
        
        if (mysql_errno($link) == 0)//если без ошибок
        {
            header('Location: /courses.php');                
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

        <title>Программы ДО - <?php echo PRODUCT_NAME; ?></title>
    </head>
    <body>
     

    <?php

    df();

    //если не удалось соединиться с базой данных, то выведет на красном баре ошибку
    if (isset($dbce))
    {//db connection error
        die('<div align="center" class="well well-small alert-error">' .PRODUCT_NAME. ': ' . $dbce . '</div></body></html>');
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
                    <form action="courses.php" method="post" name="courses_form" id="courses_form">
                        <?php
//------------------php: подготовка к данным модального окна---------------------
                        
                        //если нажали "Добавить" на странице 

                        if(isset($_POST['add_new_course_button']) and !isset($warning))//+
                        {
                            $title='Добавление программы ДО';//+

                            $addarray=array();
                            $addarray[0][0]='<label for="name">Название</label>';
                            $addarray[0][1]='<span id="namespry"><input id="name" type="text" name="name"/><span class="textfieldRequiredMsg">Требуется значение</span></span>';
                            $addarray[0][2]='';
                           
                            $addarray[1][0]='<span id="hoursspry"><label for="hours">Кол-во часов</label>';
                            $addarray[1][1]='<span id="hoursspry"><input id="hours" type="text" name="hours"/><span class="textfieldRequiredMsg">Требуется значение</span><span class="textfieldInvalidFormatMsg">Неверный формат</span></span>';
                            $addarray[1][2]='';
                            
                            $addarray[2][0]='<label for="tax">Ставка(руб/час)</label>';
                            $addarray[2][1]='<span id="taxspry"><input id="tax" type="text" name="tax" onchange="price_multiple()"/><span class="textfieldRequiredMsg">Требуется значение</span><span class="textfieldInvalidFormatMsg">Неверный формат</span></span>';
                            $addarray[2][2]='';
                            
                            $addarray[3][0]='<label for="price">Цена курса(руб)</label>';
                            $addarray[3][1]='<input name="price" type="text" id="price" readonly="readonly">';
                            $addarray[3][2]='';

                            $command = 'add';//+
                            show_modal_form($title, $addarray, $command, ''); //при формировании страницы покажем модальную форму редактирования
                            unset($title);
                            unset($addarray);
                            unset($command);
                            unset($warning);
                            unset($_POST['edit_flag']);
                        }

                        //если возникла ошибка при добавлении

                        if(isset($_POST['add_button']) and isset($warning))//+
                        {
                            $title='Добавление программы ДО';//+
               
                            $addarray=array();
                            $addarray[0][0]='<label for="name">Название</label>';
                            $addarray[0][1]='<span id="namespry"><input id="name" type="text" name="name" value="'.$_POST['name'].'"/><span class="textfieldRequiredMsg">Требуется значение</span></span>';
                            $addarray[0][2]='';
                           
                            $addarray[1][0]='<span id="hoursspry"><label for="hours">Кол-во часов</label>';
                            $addarray[1][1]='<span id="hoursspry"><input id="hours" type="text" name="hours" value="'.$_POST['hours'].'"/><span class="textfieldRequiredMsg">Требуется значение</span><span class="textfieldInvalidFormatMsg">Неверный формат</span></span>';
                            $addarray[1][2]='';
                            
                            $addarray[2][0]='<label for="tax">Ставка(руб/час)</label>';
                            $addarray[2][1]='<span id="taxspry"><input id="tax" type="text" name="tax" onchange="price_multiple()"/ value="'.$_POST['tax'].'"><span class="textfieldRequiredMsg">Требуется значение</span><span class="textfieldInvalidFormatMsg">Неверный формат</span></span>';
                            $addarray[2][2]='';
                            
                            $addarray[3][0]='<label for="price" >Цена курса(руб)</label>';
                            $addarray[3][1]='<input name="price" type="text" id="price" readonly="readonly" value="'.$_POST['price'].'">';
                            $addarray[3][2]='';

                            $command = 'add';//+

                            show_modal_form($title, $addarray, $command, $warning); //при формировании страницы покажем модальную форму редактирования
                            unset($title);
                            unset($addarray);
                            unset($command);
                            unset($warning);
                            unset($_POST['edit_flag']);
                        }

                        //если нажали "..."(редактировать) на странице
                        if(isset($_POST['edit_flag']) and !isset($_POST['add_new_course_button']) and !isset($warning) and !isset($_POST['delete']))//+
                        {
                            //подготовим данные (вытащим из $_POST x-key-editX, где X == ID):
                            $tmparray = array_keys($_POST); //array_keys — Возвращает все или некоторое подмножество ключей массива

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
                            $qs = 'SELECT * FROM `courses` WHERE `ID`=\''. $id_row . '\'';
                            //qr = query row
                            $qr = mysql_query($qs);
                            //tr = temporary row
                            $tr = mysql_fetch_row($qr); //массив со всей строкой по ячейкам
                            print_r($tr);
                            
                            $title1='Редактирование программы ДО';//+
                            
                            $addarray=array();
                            $addarray[0][0]='<label for="name">Название</label>';
                            $addarray[0][1]='<span id="namespry"><input id="name" type="text" name="name" value="'.$tr[1].'"/><span class="textfieldRequiredMsg">Требуется значение</span></span>';
                            $addarray[0][2]='';

                            $addarray[1][0]='<span id="hoursspry"><label for="hours">Кол-во часов</label>';
                            $addarray[1][1]='<span id="hoursspry"><input id="hours" type="text" name="hours" value="'.$tr[2].'"/><span class="textfieldRequiredMsg">Требуется значение</span><span class="textfieldInvalidFormatMsg">Неверный формат</span></span>';
                            $addarray[1][2]='';
                            
                            $addarray[2][0]='<label for="tax">Ставка(руб/час)</label>';
                            $addarray[2][1]='<span id="taxspry"><input id="tax" type="text" name="tax"  value="'.$tr[3].'" onchange="price_multiple()"/><span class="textfieldRequiredMsg">Требуется значение</span><span class="textfieldInvalidFormatMsg">Неверный формат</span></span>';
                            $addarray[2][2]='';
                            
                            $addarray[3][0]='<label for="price">Цена курса(руб)</label>';
                            $addarray[3][1]='<input name="price" type="text" id="price" readonly="readonly"  value="'.$tr[4].'">';
                            $addarray[3][2]='';
                            
                            $addarray[4][0]='';
                            $addarray[4][1]='<input name="id" type="hidden"  value="'.$tr[0].'">';
                            $addarray[4][2]='';
                            

                            $command = 'update';//+
                            show_modal_form($title1, $addarray, $command,''); //при формировании страницы покажем модальную форму редактирования
                            unset($warning);
                            unset($_POST['edit_flag']);
                            unset($addarray);
                            unset($tmparray);
                        }
                        
                        //если ошибка при редактировании
                        if(isset($_POST['edit_flag']) and isset($warning)  and !isset($_POST['delete']))//+
                        {
                            $title1='Редактирование программы ДО';//+
                            
                            $addarray=array();
                            $addarray[0][0]='<label for="name">Название</label>';
                            $addarray[0][1]='<span id="namespry"><input id="name" type="text" name="name" value="'.$_POST['name'].'"/><span class="textfieldRequiredMsg">Требуется значение</span></span>';
                            $addarray[0][2]='';

                            $addarray[1][0]='<span id="hoursspry"><label for="hours">Кол-во часов</label>';
                            $addarray[1][1]='<span id="hoursspry"><input id="hours" type="text" name="hours" value="'.$_POST['hours'].'"/><span class="textfieldRequiredMsg">Требуется значение</span><span class="textfieldInvalidFormatMsg">Неверный формат</span></span>';
                            $addarray[1][2]='';
                            
                            $addarray[2][0]='<label for="tax">Ставка(руб/час)</label>';
                            $addarray[2][1]='<span id="taxspry"><input id="tax" type="text" name="tax"  value="'.$_POST['tax'].'" onchange="price_multiple()"/><span class="textfieldRequiredMsg">Требуется значение</span><span class="textfieldInvalidFormatMsg">Неверный формат</span></span>';
                            $addarray[2][2]='';
                            
                            $addarray[3][0]='<label for="price">Цена курса(руб)</label>';
                            $addarray[3][1]='<input name="price" type="text" id="price" readonly="readonly"  value="'.$_POST['price'].'">';
                            $addarray[3][2]='';
                            
                            $addarray[4][0]='';
                            $addarray[4][1]='<input name="id" type="hidden"  value="'.$_POST['id'].'">';
                            $addarray[4][2]='';
                            

                            $command = 'update';//+
                            show_modal_form($title1, $addarray, $command, $warning); //при формировании страницы покажем модальную форму редактирования
                            unset($warning);
                            unset($_POST['edit_flag']);
                            unset($addarray);
                            unset($tmparray);                            
                        }
//------------------php закрылся: подготовка к данным модального окна---------------------                        
                        ?>
                        
                        <!-- кнопка добавить новый курс -->
                        <input type="submit" name="add_new_course_button" class="btn btn-primary" value="Добавить программу ДО">

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
                                    Название
                                </td>
                                <td>
                                    Кол-во часов
                                </td>
                                <td>
                                    Ставка<br>(руб/час)
                                </td>
                                <td>
                                    Цена курса<br>(руб)
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
                            $rowcount = mysql_result(mysql_query('SELECT COUNT(*) FROM courses'), 0);
                            $result = mysql_query("SELECT * FROM `courses` WHERE 1 LIMIT $rowsperpage");

                            if (!$result)
                                die('Error:' . mysql_error());
                            else
                                tablebodygenerator($result);

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

                    </form>
                </div>
            </div>
        </div>

        <?php footer(); ?>

    </body>
</html>