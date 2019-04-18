<?php
//header("Content-Type: text/html; charset=utf-8");
require_once 'key/db_connection.php';
require_once 'config.php';
//require_once 'authorize4.php';

define("SUCCESS_MESSAGE", "success");
define("ERROR_MESSAGE", "error");

session_start();

function page_start($title, $javascript = NULL,
                    $success_message = NULL, $error_message = NULL, $group_user_id = NULL) {

  display_head($title, $javascript, $group_user_id);
  display_title($title, $success_message, $error_message);
}

function display_head($page_title = "Название страницы", $embedded_javascript = NULL, $embedded_group_user_id = NULL) {
echo <<<EOD
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
 <head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8" />
 <link rel="stylesheet" type="text/css" href="css/title1.css">
  
  	<title> {$page_title} </title>
	<!-- нужны библиотеки jquery, проверка и сss-->
EOD;
if (!is_null($embedded_javascript)) {
    echo "
		<script type='text/javascript'>
		" .
         $embedded_javascript .
         "</script>";
  }
echo <<<EOD
 </head>
 <body>
 <div class="block">

  <div id="header"><h1> Увлажнитель воздуха </h1></div>

  <div id="sidebar">
	<p><a href="title2.php">Главная</a></p>
	<p><a href="oWir1.php">О нас</a></p>
	<p><a href='look_on_order1.php'>Заказы</a></p>
	<p><a href='show_tp1.php'>Технологические операции</a></p>
	<p><a href="porodukt.php.">Виды услуг</a></p>
	<p><a href="vektor.php">Как найти</a></p> 
EOD;

 // <!-- <p><a href="show_tp1.php">Технологический процесс</a></p> -->
	if (isset($_SESSION['user_id'])) { //$_SESSION['user_id']
		$result = mysql_query("SET NAMES UTF8");

		$nickname = $_SESSION["name"];
		$user_id = $_SESSION['user_id'];
		$select_query = "SELECT * FROM users1 WHERE user_id = " . $user_id;
		// Запуск запроса
		$result = mysql_query($select_query);

		if ($result) {
			$row = mysql_fetch_array($result);
			$image_id = $row['imageuser_id'];
			$group_user_id = $row['usergroup_id'];
		}

		if ( $group_user_id == 1) { // $embedded_group_user_id
			echo <<<EOD
			<p><a href="key/cryptreload.php">Узнать пароль</a></p>
			<p><a href="show_user4.php">Управление пользователями</a></p>	
EOD;
		}
		echo <<<EOD
		<p><a href='signout4.php'>Exit my</a></p>
		<p><a href="infouser4.php">Личный кабинет {$nickname}</a></p>
		<p><a href="fpdf1.php">Отчет PDF</a></p>
EOD;
		
	} else {
	 	echo <<<EOD
	<p><a href='signup4.php'>Регистрация</a></p>
	<p><a href="infouser4.php">Личный кабинет</a></p>
EOD;
	 }
   
echo  '</div>
<div id="content">
  
    <h1>'.$page_title.'</h1>
	';
  
}

//menu------------------------
function display_title($title, $success_message = NULL, $error_message = NULL)
{
	display_messages($success_message, $error_message);
}

//-------------------
function display_messages($success_msg = NULL, $error_msg = NULL) {
  echo "<div id='messages'>\n";
  if (!is_null($success_msg) && (strlen($error_msg) > 0)) {
    display_message($success_msg, SUCCESS_MESSAGE);
  }
  if (!is_null($error_msg) && (strlen($error_msg) > 0)) {
    display_message($error_msg, ERROR_MESSAGE);
  }
  echo "</div>\n\n";
}

function display_message($msg, $msg_type) {
  echo " <div class='{$msg_type}'>\n";
  echo "  <p>{$msg}</p>\n";
  echo " </div>\n";
}

?>