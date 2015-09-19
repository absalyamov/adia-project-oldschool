<?php
//let the party begin!
require 'dbconnection.php';
require 'constants.php';
require 'functions.php';
//functions


//отмена добавления или редактирования
cancel_button();


//добавление нового слушателя от юрлица
if (isset($_POST['add_new_office_people_button']))
{
    while (1) //как будто продолжать бесконечно
    {   
        //формируем запрос sql 
        if (isset($_POST['add_new_office_people_button']))
            $my_query = 'INSERT INTO `offices-people` (`id`, `lastname`, `firstname`, `patronymic`, `office-id`)
                VALUES (NULL, \''.$_POST['lastname'].'\',\''.$_POST['firstname'].'\',\''.$_POST['patronymic'].'\',\''.$_POST['office_list'].'\')';
                echo $my_query;
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
    
    header("Location: /groups.php");    
}

//добавление нового юрлица
if (isset($_POST['add_office']))
{
    //профильтруем название дисциплины
    $new_office = mysql_real_escape_string(htmlspecialchars(trim($_POST['name'])));

    //если в итоге это не пустой ввод
    while (1) //как будто продолжать бесконечно
    {   
        //формируем запрос sql 
        if (isset($_POST['add_office']))
            $my_query = 'INSERT INTO `offices` (`id`, `name`, `details`, `address`, `phone`)
                VALUES (NULL, \''.$new_office.'\',\''.$_POST['details'].'\',\''.$_POST['address'].'\',\''.$_POST['phone'].'\')';

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
    
    header("Location: /groups.php");    
}


//добавление нового физлица
if (isset($_POST['add_physic']))
{
    while (1) //как будто продолжать бесконечно
    {   
        //формируем запрос sql 
        if (isset($_POST['add_physic']))
            $my_query = 'INSERT INTO `physical` (`id`, `lastname`, `firstname`, `patronymic`,`passport`,`phone`)
                VALUES (NULL, \''.$_POST['lastname'].'\',\''.$_POST['firstname'].'\',\''.$_POST['patronymic'].'\',\''.$_POST['passport'].'\',\''.$_POST['phone'].'\')';

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
    
    header("Location: /groups.php");    
}


//добавление нового cтудента
if (isset($_POST['add_student']))
{
    while (1) //как будто продолжать бесконечно
    {   
        //формируем запрос sql 
        if (isset($_POST['add_student']))
            $my_query = '
                INSERT INTO 
                `students`
                (
                `id`,
                `lastname`,
                `firstname`,
                `patronymic`,
                `phone`,
                `facultet`,
                `group`
                ) 
                VALUES
                (
                NULL,
                \''.$_POST['lastname'].'\',
                \''.$_POST['name'].'\',
                \''.$_POST['patronymic'].'\',
                \''.$_POST['phone'].'\',
                \''.$_POST['faculty'].'\',
                \''.$_POST['group'].'\'
                )';
//echo $my_query;
//        if (isset($_POST['update_button']))
//            $my_query = 'UPDATE  `courses` 
//                SET  `name` = \''.$_POST['name'].'\',`hours` =  \''.$_POST['hours'].'\',
//                     `moneyperhour` =  \''.$_POST['tax'].'\',`price`=\''.$_POST['price'].'\' 
//                     WHERE `id` = \''.$_POST['id'].'\'';
        
        //echo $add_new_course_query;
        $my_query_result = mysql_query($my_query);
        echo $my_query_result;
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
    
    header("Location: /groups.php");    
}

//добавление новой группы
// пока что не реализованы списки слушателей
if (isset($_POST['add_group']))
{
    while (1) //как будто продолжать бесконечно
    {   
        //формируем запрос sql 
        if (isset($_POST['add_group']))
            $my_query = 'INSERT INTO `groups` (`id`, `clients-array`, `course-id`, `teacher-id`)
                VALUES (NULL, \'\',\''.$_POST['course_list'].'\',\''.$_POST['teacher_list'].'\')';
        echo $my_query;
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
    
    header("Location: /groups.php");    
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
        <script src="js/jsfunctions.js" type="text/javascript"></script>

        <!-- если у нас проблемный IE-- >
        <!--[if lt IE 9]>
          <script src="js/html5.js"></script>
        <![endif]-->

        <title>Слушатели - <?php echo PRODUCT_NAME; ?></title>
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

                    <form action="/groups.php" method="post" name="gorups_form">
                        <?php
                        
                        //добавить новое юрлицо
                        if(isset($_POST['add_new_office_people']))                        
                        {
                            $title='Добавление слушателя от организации (юридическое лицо)';//+
                            $addarray=array();
                            
                            $addarray[0][0]='Фамилия';
                            $addarray[0][1]='<input type="text" name="lastname" >';
                            $addarray[0][2]='';

                            $addarray[1][0]='Имя';
                            $addarray[1][1]='<input type="text" name="firstname" >';
                            $addarray[1][2]='';
                            
                            $addarray[2][0]='Отчество';
                            $addarray[2][1]='<input type="text" name="patronymic" >';
                            $addarray[2][2]='';
                            
                            $addarray[3][0]='Организация';
                            //создадим список программ ДО
                            $list1='<select name="office_list" >';
                            $q1='SELECT `id`,`name` FROM `offices` WHERE 1';
                            $r1=mysql_query($q1);
                            while($r2 = mysql_fetch_row($r1))
                            {
                                $list1=$list1.'<option value='.$r2[0].'>'.$r2[1].'</option>';
                            }
                            $list1=$list1.'</select>';

                            $addarray[3][1]=$list1;
                            unset($r1);
                            unset($r2); 
                            unset($list1);
                            unset($q1);
                            $addarray[3][2]='';
                            

                            
                            $add = 'add_new_office_people';//+
                            show_modal_form($title, $addarray, $add, ''); //при формировании страницы покажем модальную форму редактирования  
                            unset($_POST['edit_flag']);                            
                        }
                        
                        
                        //добавить новое юрлицо
                        if(isset($_POST['add_new_office']))                        
                        {
                            $title='Добавление нового юридического лица';//+
                            $addarray=array();
                            
                            $addarray[0][0]='Название ';
                            $addarray[0][1]='<input type="text" name="name" >';
                            $addarray[0][2]='';
                            
                            $addarray[1][0]='Реквизиты';
                            $addarray[1][1]='<textarea name="details" id="textarea" cols="45" rows="5"></textarea>';
                            $addarray[1][2]='';

                            $addarray[2][0]='Адрес';
                            $addarray[2][1]='<textarea name="address" id="textarea" cols="45" rows="5"></textarea>';
                            $addarray[2][2]='';

                            $addarray[3][0]='Телефон';
                            $addarray[3][1]='<input type="text" name="phone" >';
                            $addarray[3][2]='';
                            
                            $add = 'add_office';//+
                            show_modal_form($title, $addarray, $add, ''); //при формировании страницы покажем модальную форму редактирования  
                            unset($_POST['edit_flag']);                            
                        }

                        //добавить нового физика
                        if(isset($_POST['add_new_physic']))                        
                        {
                            $title='Добавление нового физического лица';//+
                            $addarray=array();
                            
                            $addarray[0][0]='Фамилия';
                            $addarray[0][1]='<input type="text" name="lastname" >';
                            $addarray[0][2]='';
                            
                            $addarray[1][0]='Имя';
                            $addarray[1][1]='<input type="text" name="firstname" >';
                            $addarray[1][2]='';

                            $addarray[2][0]='Отчество';
                            $addarray[2][1]='<input type="text" name="patronymic" >';
                            $addarray[2][2]='';

                            $addarray[3][0]='Паспорт';
                            $addarray[3][1]='<input type="text" name="passport" >';
                            $addarray[3][2]='';

                            $addarray[4][0]='Телефон';
                            $addarray[4][1]='<input type="text" name="phone" >';
                            $addarray[4][2]='';
                            
                            $add = 'add_physic';//+
                            show_modal_form($title, $addarray, $add, ''); //при формировании страницы покажем модальную форму редактирования 
                            unset($_POST['edit_flag']);                            
                        }

                        //добавить нового студента
                        if(isset($_POST['add_new_student']))                        
                        {
                            $title='Добавление слушателя-студента';//+
                            $addarray=array();
                            
                            $addarray[0][0]='Фамилия';
                            $addarray[0][1]='<input type="text" name="lastname" >';
                            $addarray[0][2]='';
                            
                            $addarray[1][0]='Имя';
                            $addarray[1][1]='<input type="text" name="name" >';
                            $addarray[1][2]='';

                            $addarray[2][0]='Отчество';
                            $addarray[2][1]='<input type="text" name="patronymic" >';
                            $addarray[2][2]='';

                            $addarray[3][0]='Факультет';
                            $addarray[3][1]='<input type="text" name="faculty" >';
                            $addarray[3][2]='';

                            $addarray[4][0]='Группа';
                            $addarray[4][1]='<input type="text" name="group" >';
                            $addarray[4][2]='';

                            $addarray[5][0]='Телефон';
                            $addarray[5][1]='<input type="text" name="phone" >';
                            $addarray[5][2]='';
                            
                            $add = 'add_student';//+
                            show_modal_form($title, $addarray, $add, ''); //при формировании страницы покажем модальную форму редактирования 
                            unset($_POST['edit_flag']);
                        }
                        
                        //если нажали "Добавить новую группу" 
                        if(isset($_POST['add_new_group']))//+
                        {
                            $title='Добавление новой группы';//+
                            $addarray=array();
                            //=====================================
                            $addarray[0][0]='Выберите программу ДО ';
                            //создадим список программ ДО
                            $list1='<select name="course_list" >';
                            $q1='SELECT `id`,`name` FROM `courses` WHERE 1';
                            $r1=mysql_query($q1);
                            while($r2 = mysql_fetch_row($r1))
                            {
                                $list1=$list1.'<option value='.$r2[0].'>'.$r2[1].'</option>';
                            }
                            $list1=$list1.'</select>';

                            $addarray[0][1]=$list1;
                            unset($r1);
                            unset($r2); 
                            unset($list1);
                            unset($q1);
                            
                            $addarray[0][2]='';
                            //======================================
                            $addarray[1][0]='Выберите преподавателя';
                            //создадим список преподов
                            $list1='<select name="teacher_list" >';
$q1='SELECT 
    `teachers`.`id`,
    `teachers`.`lastname`,
    `teachers`.`firstname`,
    `teachers`.`patronymic`,
    `subjects`.`subject`
    FROM 
    `teachers`,
    `subjects` 
    WHERE 
    `teachers`.`id` = `subjects`.`id`';

                            $r1=mysql_query($q1);
                            while($r2 = mysql_fetch_row($r1))
                            {
                                $list1=$list1.'<option value='.$r2[0].'>'.$r2[1].' '.$r2[2].' '.$r2[3].', дисциплина: '.$r2[4].'</option>';
                            }
                            $list1=$list1.'</select>';
                            $addarray[1][1]=$list1;
                            unset($r1);
                            unset($r2); 
                            unset($list1);
                            unset($q1);                            
                            $addarray[1][2]='';
                            
                            //======================================                            
                            $addarray[2][0]='Выберите слушателей курса<br>программы ДО<br>(ctrl, чтобы отметить несколько)';
                            //создадим список преподов
                            $list1='<select name="clients_list" multiple size="12">';
                            $q1='SELECT * FROM `physical` WHERE 1';
                            $r1=mysql_query($q1);
                            while($r2 = mysql_fetch_row($r1))
                            {
                                $list1=$list1.'<option value='.$r2[0].'>'.$r2[1].' '.$r2[2].' '.$r2[3].'</option>';
                            }
                            unset($r1);
                            unset($r2); 
                            unset($q1);                              

                            $q1='SELECT * FROM `offices-people` WHERE 1';
                            $r1=mysql_query($q1);
                            while($r2 = mysql_fetch_row($r1))
                            {
                                $list1=$list1.'<option value='.$r2[0].'>'.$r2[1].' '.$r2[2].' '.$r2[3].'</option>';
                            }
                            unset($r1);
                            unset($r2); 
                            unset($q1);                              

                            $q1='SELECT * FROM `students` WHERE 1';
                            $r1=mysql_query($q1);
                            while($r2 = mysql_fetch_row($r1))
                            {
                                $list1=$list1.'<option value='.$r2[0].'>'.$r2[1].' '.$r2[2].' '.$r2[3].'</option>';
                            }
                            unset($r1);
                            unset($r2); 
                            unset($q1);                              

                            $list1=$list1.'</select>';
                            $addarray[2][1]=$list1;
                            
                            unset($list1);
                            
                            
                            $addarray[2][2]='';
                            
                            $add = 'add_group';//+
                            
                            show_modal_form($title, $addarray, $add,''); //при формировании страницы покажем модальную форму редактирования
                            unset($_POST['edit_flag']);                            
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
                            <li class="TabbedPanelsTab" tabindex="0">Группы слушателей</li>
                            <li class="TabbedPanelsTab" tabindex="0">Юридические лица</li>
                            <li class="TabbedPanelsTab" tabindex="0">Физические лица</li>
                            <li class="TabbedPanelsTab" tabindex="0">Студенты</li>

                          </ul>
                          <div class="TabbedPanelsContentGroup">
                            
                            <div class="TabbedPanelsContent">      
                               <!-- форма для добавления групп -->
<!--                                <form id="groups" name="groups_form" method="post" action="">-->
                                      <!-- кнопка добавить новую группу-->
                                      <input type="submit" name="add_new_group" class="btn btn-primary myoffset" value="Добавить новую группу слушателей">

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
                                                  Слушатели
                                              </td>
                                              <td>
                                                  Программа ДО
                                              </td>
                                              <td>
                                                  Преподаватель
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
                                          $rowcount = mysql_result(mysql_query('SELECT COUNT(*) FROM `groups`'), 0);
                                          $result = mysql_query("SELECT 
                                                                 `groups`.`id`,
                                                                 `groups`.`clients-array`,
                                                                 `courses`.`name`,
                                                                 `teachers`.`lastname`,
                                                                 `teachers`.`firstname`,
                                                                 `teachers`.`patronymic`
                                                                 FROM 
                                                                 `groups`,
                                                                 `courses`,
                                                                 `teachers`
                                                                 WHERE 
                                                                 `courses`.`id`=`groups`.`course-id`
                                                                 AND
                                                                 `teachers`.`id`=`groups`.`teacher-id`
                                                                 LIMIT $rowsperpage");

                                          if (!$result)
                                              die('Error:' . mysql_error());
                                          else
                                                while ($row = mysql_fetch_row($result)) 
                                                {
                                                    echo '<tr>';
                                                    for ($i = 0; $i < count($row); $i++)
                                                    {
                                                        if ($i == 0)
                                                        {
                                                            echo "<td><input type=\"checkbox\" name=\"checkbox$row[0]\"></td>";
                                                            echo "<td>$row[$i]</td>";
                                                            continue;
                                                        }

                                                        
                                                        if ($i == 5) continue;
                                                        if ($i == 3)
                                                        {
                                                            echo "<td><pre>$row[3]<br>$row[4]<br>$row[5]</pre></td>";
                                                            continue;
                                                        }   
                                                        
                                                        if ($i == 4)
                                                        {
                                                            //echo "<td>$row[$i]</td>";
                                                            echo "<td><input class=\"btn btn-primary\" type=\"submit\" value=\"...\" name=\"x-key-edit$row[0]\"><input type=\"hidden\" name=\"edit_flag\"></td>";
                                                            continue;
                                                        }
                                                        echo "<td><pre>$row[$i]</pre></td>";
                                                    }
                                                    echo '</tr>';
                                                }

                                          echo $table_header_footer;
                                          ?>


                                          <tr class="success">
                                              <td colspan="6">
                                                  <span style="margin: 5px 5px 0 0; float:left">Выделенные</span>
                                                  <input class="btn btn-warning" type="submit" name="delete" 		value="Удалить" onclick="if(confirm('Желаете удалить выбранные записи?'))  ;   else return false;  ">
<!--                                                  <input class="btn btn-success" type="submit" name="activate" 	value="Активировать">
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
<!--                                </form>-->
                            </div>    
<!-- ЮРИКИ--->  

<!--                              -->
<!--              0               -->
<!--              0               -->
<!--              0               -->
<!--              0               -->
<!--              0               -->
<!--              0               -->
<!--              0               -->
<!--              0               -->
<!--              0               -->
<!--              0               -->
                            
                            <div class="TabbedPanelsContent">
                                   
                                    <div id="TabbedPanels2" class="TabbedPanels">
                                        
                                            <ul class="TabbedPanelsTabGroup">
                                              <li class="TabbedPanelsTab" tabindex="0">Юридические лица: слушатели</li>
                                              <li class="TabbedPanelsTab" tabindex="0">Юридические лица: компании</li>
                                            </ul>
                                        
                                            <div class="TabbedPanelsContentGroup">
                                                
                                              <div class="TabbedPanelsContent">
                                                <input type="submit" name="add_new_office_people" class="btn btn-primary myoffset" value="Добавить слушателя от организации (юридическое лицо)">
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
                                                              Организация
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
                                                      $rowcount = mysql_result(mysql_query('SELECT COUNT(*) FROM `offices-people`'), 0);
                                                      
                                                      $result = mysql_query("SELECT 
`offices-people`.`id`,`offices-people`.`lastname`,`offices-people`.`firstname`,`offices-people`.`patronymic`,`offices`.`name`
FROM `offices-people`,`offices` WHERE `offices-people`.`office-id` = `offices`.`id` LIMIT $rowsperpage");

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
                                              </div>
                                                <!---------------------------------------------------->
                                              <div class="TabbedPanelsContent">
                                                  <input type="submit" name="add_new_office" class="btn btn-primary myoffset" value="Добавить новое юридическое лицо">
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
                                                              Реквизиты
                                                          </td>
                                                          <td>
                                                              Адрес
                                                          </td>
                                                          <td>
                                                              Телефон
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
                                                      $rowcount = mysql_result(mysql_query('SELECT COUNT(*) FROM `offices`'), 0);
                                                      $result = mysql_query("SELECT * FROM `offices` WHERE 1 LIMIT $rowsperpage");

                                                      if (!$result)
                                                          die('Error:' . mysql_error());
                                                      else
                                                          tablebodygenerator2($result);

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

                            </div>
                            <!--ФИЗИКИ-->    
                            <div class="TabbedPanelsContent">
<!--                              <form id="legal_entity_form" name="legal_entity_form" method="post" action="">-->
                                                <input type="submit" name="add_new_physic" class="btn btn-primary myoffset" value="Добавить новое физическое лицо">
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
                                                              Паспорт
                                                          </td>
                                                          <td>
                                                              Телефон
                                                          </td>
                                                          <td>
                                                              Редактировать
                                                          </td>
                                                      </tr>';

                                                      echo $table_header_footer;
                                                      ?>

                                                      <?php
                          //-------выводим тело таблицы-----f--------------------                            
                                                      // формирование таблицы
                                                      $rowsperpage = 30;
                                                      //сколько всего записей?
                                                      $rowcount = mysql_result(mysql_query('SELECT COUNT(*) FROM `physical`'), 0);
                                                      $result = mysql_query("SELECT * FROM `physical` WHERE 1 LIMIT $rowsperpage");

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
<!--                              </form>-->
  
                            </div>
                            <!-- студенты -->
                            <div class="TabbedPanelsContent">
<!--                              <form id="legal_entity_form" name="legal_entity_form" method="post" action="">-->
                                                <input type="submit" name="add_new_student" class="btn btn-primary myoffset" value="Добавить слушателя-студента">
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
                                                              Факультет
                                                          </td>
                                                          <td>
                                                              Группа
                                                          </td>
                                                          <td>
                                                              Телефон
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
                                                      $rowcount = mysql_result(mysql_query('SELECT COUNT(*) FROM `students`'), 0);
                                                      $result = mysql_query("SELECT * FROM `students` WHERE 1 LIMIT $rowsperpage");

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

<!--                              </form>-->

                            </div>
                          </div>

                        </div>                        
                        
                        <script type="text/javascript">
                            var TabbedPanels1 = new Spry.Widget.TabbedPanels("groups_TabbedPanels1", {defaultTab:0});
                            var TabbedPanels2 = new Spry.Widget.TabbedPanels("TabbedPanels2");
                        </script>
                        


                    </form>
                </div>
            </div>
        </div>

        <?php footer(); ?>

    </body>
</html>