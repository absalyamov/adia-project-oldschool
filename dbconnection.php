<?php
//основные настройки соединения с бд
$dbhostname='localhost';
$dbuser='root';
//$dbuser='poligont_qrwq';
$dbuserpassword='root';
//$dbuserpassword='C8hDS7CQ';
$dbname='coursesdb';
//$dbname='poligont_qwe';

$link = mysql_connect($dbhostname, $dbuser, $dbuserpassword);
if (!$link)
{
    $dbce = 'Ошибка соединения с БД: ' . mysql_error();
}
else
{
	$db_selected = mysql_select_db($dbname, $link);
	if (!$db_selected) 
	{
    	$dbce = 'Ошибка соединения с БД: ' . mysql_error();
	}
	else
	{
		mysql_query("SET NAMES utf8");
	}
}
?>