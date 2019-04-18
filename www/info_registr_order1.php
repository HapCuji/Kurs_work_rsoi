<?php
//require_once 'key/config.php';
require_once 'key/db_connection.php';
session_start();
header("Content-Type: text/html; charset=utf-8");

$upload_dir = SITE_ROOT . "image/profile_pics/";
$image_fieldname = "image_user";

// Потенциальные PHP-ошибки отправки файлов
$php_errors = array(1 => 'Превышен макс. размер файла, указанный в php.ini',
2 => 'Превышен макс. размер файла, указанный в форме HTML',
3 => 'Была отправлена только часть файла',
4 => 'Файл для отправки не был выбран.');
//---------------------time begin
//$order_date_begin=date("Y-m-d", (time()+3600*24*7)); // current_data
//---------------------time end order
$order_date_close = trim($_POST['order_date_clos']);
//order num of tovar -----------------------------------------------------------
$order_value=trim($_POST['order_valu']);
//name of orderer - current user
if (isset($_SESSION['user_id'])) { //$_SESSION['user_id']
		// $result = mysql_query("SET NAMES UTF8");

		$orderer_nickname = $_SESSION["name"];
		$orderer_user_id = $_SESSION['user_id'];
		// $select_query = "SELECT * FROM users1 WHERE user_id = " . $user_id;
		// // Запуск запроса
		// $result = mysql_query($select_query);

		// if ($result) {
		// 	$row = mysql_fetch_array($result);
		// 	$image_id = $row['imageuser_id'];
		// 	$group_user_id = $row['usergroup_id'];
		// }	
	}

//---resp
$order_responsible_id = trim($_POST['order_responsible_id']);
	handle_error($user_error_message, $order_responsible_id);
$select_query = "SELECT `name` FROM `users1` WHERE `user_id` ='$order_responsible_id';";
 mysql_query($select_query) 
	or die ("owibka".mysql_error());
 $result = mysql_query($select_query);
 if(isset($result)){
	$row = mysql_fetch_object($result);
	$order_responsible_nam=$row->name; 
 }


// Обработка запроса пользователя
$insert_sql = sprintf("INSERT INTO `order` (`order_date_close`
										, `order_user_id`
										, `order_name_user`
										, `order_value`
										, `order_responsibe_id`
										, `order_responsible_name`) 
						VALUES ( '%s'
								,'%d'
								,'%s'
								,'%d'
								,'%d'
								,'%s');",
	mysql_real_escape_string($order_date_close),
	$orderer_user_id,
	mysql_real_escape_string($orderer_nickname),
	$order_value,
	$order_responsible_id,
	mysql_real_escape_string($order_responsible_nam)
);
// Вставка данных о пользователе в базу данных
mysql_query($insert_sql);
$error_mysql = mysql_error();
if($error_mysql != NULL)
	handle_error($user_error_message, $error_mysql);

// 
// Перенаправление пользователя на страницу, показывающую информацию
// о заказах
header("Location: look_on_order1.php");
exit();


/* 
  if (mysql_query){
 echo"<p>Ура, вы зарегестрированы!</p>";
 echo'<p><a href="infouser2.php">Ваш кабинет</a></p>';
 } else {echo"You last luzer!!! ahahahahhahahahaha";}
 */

?>