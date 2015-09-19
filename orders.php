<?php
//let the party begin!
require 'dbconnection.php';
require 'constants.php';
require 'functions.php';


//functions

//отмена добавления или редактирования
if (isset($_POST['cancel_button'])) 
{
    header("Location: /subjects.php");
}


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

        <title>Заявки - <?php echo PRODUCT_NAME; ?></title>
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
                    <form action="/orders.php" method="post" name="orders_form" >
                    <a class="btn btn-primary myoffset" href="/orders/zayavlenie_ot_prepodavatelya_na_pochasovuyu_oplatu.pdf">Скачать бланк заявления от преподавателя на почасовую оплату</a>
                    <br>
                    <a class="btn btn-primary myoffset" href="/orders/zayavlenie_ot_prepodavatelya_na_pochasovuyu_oplatu.pdf">Скачать бланк карточки учета педагогической работы</a>
                    <br>
                    <a class="btn btn-primary myoffset" href="/orders/zayavlenie_ot_prepodavatelya_na_pochasovuyu_oplatu.pdf">Скачать бланк заявления на возврат денежных средств</a>
                    </form>
                </div>

            </div>
        </div>

        <?php footer(); ?>

    </body>
</html>