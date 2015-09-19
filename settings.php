<?php
//let the party begin!
require 'dbconnection.php';
require 'constants.php';
require 'functions.php';


//functions

//отмена добавления или редактирования
cancel_button();


//если нажали "Добавить" на модальной форме
if (isset($_POST['add_button'])) 
{
    //галочка Активность поставлена или нет?
    if ($_POST['subject_activity'] == "on")
        $new_subject_activity = 1;
    else
        $new_subject_activity = 0;

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
        $add_new_subject_query = 'INSERT INTO `subjects` (`id`, `active`, `subject`) VALUES (NULL, \'' . $new_subject_activity . ' \',\'' . $new_subject . '\')';
        $add_new_subject_result = mysql_query($add_new_subject_query);

        //$sdw=false;//ПРОВЕРИТЬ ! нужно ли?
        //$sew=false;
        //далее спорная команда отправить себя самого к себе самому же
        header('Location: /subjects.php');
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

        <title>Настройки - <?php echo PRODUCT_NAME; ?></title>
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
  <form action="courses.php" method="post" name="courses_form" id="courses_form">
                                                
                        <!-- кнопка добавить новый курс -->
                        <input type="submit" name="add_new_course_button" class="btn btn-primary" value="Добавить сотрудника">

                        <br />
                        <br />
                        <table border="0" cellpadding="2" cellspacing="2" align="center" class="table table-hover">
                            
                            <tr class="success">
                                <td>
                                    <input type="checkbox" name="all_on_page"  onclick="checkAll(this)">Все
                                </td>
                                <td>
                                    ID
                                </td>
                                <td>
                                    Должность
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
                                    Доступ
                                </td>                                
                                <td>
                                    Редактировать
                                </td>                                
                            </tr>
                            
                            
                            <tr>
                                <td>
                                    <input type="checkbox" name="checkbox1">
                                </td>
                                <td>
                                    1
                                </td>
                                <td>
                                    Методист
                                </td>
                                <td>
                                    Сафаргалина
                                </td>
                                <td>
                                    Аида
                                </td>
                                <td>
                                    Ниловна
                                </td>
                                <td>
                                    +79056767890
                                </td>
                                <td>
                                    Администратор
                                </td>
                                <td>
                                    <input class="btn btn-primary" type="submit" value="..." name="x-key-edit1">
                                    <input type="hidden" name="edit_flag">
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <input type="checkbox" name="checkbox1">
                                </td>
                                <td>
                                    2
                                </td>
                                <td>
                                    Методист
                                </td>
                                <td>
                                    Иванов
                                </td>
                                <td>
                                    Иван
                                </td>
                                <td>
                                    Иванович
                                </td>
                                <td>
                                    +79056711890
                                </td>
                                <td>
                                    Пользователь
                                </td>
                                <td>
                                    <input class="btn btn-primary" type="submit" value="..." name="x-key-edit1">
                                    <input type="hidden" name="edit_flag">
                                </td>
                            </tr>

                            
                            <tr class="success">
                                <td>
                                    <input type="checkbox" name="all_on_page"  onclick="checkAll(this)">Все
                                </td>
                                <td>
                                    ID
                                </td>
                                <td>
                                    Должность
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
                                    Доступ
                                </td>
                                <td>
                                    Редактировать
                                </td>                                  
                            </tr>
                            <tr class="success">
                                <td colspan="12">
                                    <span style="margin: 5px 5px 0 0; float:left">Выделенные</span>	<input class="btn btn-warning" type="button" name="delete" 		value="Удалить">
                                    <!-- input class="btn btn-success" type="button" name="activate" 	value="Активировать">
                                    <input class="btn btn-inverse" type="button" name="deactivate" 	value="Деактивировать"-->
                                </td>
                            </tr>
                        </table>

                        <div style="float:left; margin-left: 0;">
                            <span style="margin: 5px 2px 0 0; float:left">Всего записей: 2</span>
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