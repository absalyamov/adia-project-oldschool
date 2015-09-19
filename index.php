<?php
//let the party begin!
require 'dbconnection.php';
require 'constants.php';
require 'functions.php';


//начнем проверять присланные для авторизации данные
//session_start();//не забываем во всех файлах писать session_start
//print_r ($_POST);

//echo ($_POST['login']);
//echo ($_POST['password']);
if (isset($_POST['login']) && isset($_POST['password']))
{

    //немного профильтруем логин
	$login = mysql_real_escape_string(htmlspecialchars($_POST['login']));
    //хешируем пароль т.к. в базе именно хеш
	$password = md5(trim($_POST['password']));
     // проверяем введенные данные
    $query = 'SELECT `id`, `login`, `admin` FROM `users` WHERE `login`=\''.$login.'\' AND `password`=\''.$password.'\' LIMIT 1';
	//echo $query;
    $sql = mysql_query($query) or die(mysql_error());
    // если такой пользователь есть
    if (mysql_num_rows($sql) == 1) 
	{
		$row = mysql_fetch_assoc($sql);
		//ставим метку в сессии 
		$_SESSION['id'] = $row['id'];
		$_SESSION['login'] = $row['login'];
		$_SESSION['admin'] = $row['admin'];
		//ставим куки и время их хранения 10 дней
		setcookie("my_cookie", $row['login'], time()+60*60*24*10);
		header("Location: /desktop.php"); 
   	}
    else 
	{
        //если пользователя нет, то пусть пробует еще
		$autherror=1;
		header("Location: /index.php"); 
    }
}


//проверяем сессию, если она есть, то значит уже авторизовались
if (isset($_SESSION['id']))
{
//	echo htmlspecialchars($_SESSION['login'])." <br />"."Вы авторизованы <br />
//	Т.е. мы проверили сессию и можем открыть доступ к определенным данным";
    ;
}
else 
{
	$login = '';
	//проверяем куку, может он уже заходил сюда
	if (isset($_COOKIE['my_cookie']))
	{
		$login = htmlspecialchars($_COOKIE['my_cookie']);
	}

}
?>

<!doctype html>
<html>

<head>
<meta charset="utf-8">
<link href="css/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">

<title>Авторизация - <?php echo PRODUCT_NAME ?></title>
</head>

<body>
<?php
df();

if (isset($msg))//выведет на красном баре ошибку, если $msg установлена
{ 
    echo '<div align="center" class="well well-small alert-error">'.$msg.'</div>';
}
?>

<div class="well well-small">
<?php
echo_product_name() //выведет константу, задающую название всей системы или просто желаемую надпись
?>
</div>

<form action="index.php" method="post" class="form-horizontal">
<table width="50" border="0" align="center" cellpadding="4">
  <tr>
    <td colspan="2" align="center">Авторизация</td>
<?php
if(isset($autherror))
	echo '<div align="center" class="well well-small alert-error"> Неправильная пара логин-пароль! Авторизоваться не удалось.</div>'
?>
  </tr>
  <tr>
    <td><label class="control-label" for="inputLogin">Логин</label></td>
    <td><input type="text" id="inputLogin" placeholder="Логин" name="login"></td>
  </tr>
  <tr>
    <td><label class="control-label" for="inputPassword">Пароль</label></td>
    <td><input type="password" id="inputPassword" placeholder="Пароль" name="password"></td>
  </tr>
  <tr>
    <td align="right"><label> <input type="checkbox"> </label></td>
  	<td>Запомнить меня</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><button type="submit" class="btn">Войти</button></td>
  </tr>
</table>
</form>

</body>
</html>