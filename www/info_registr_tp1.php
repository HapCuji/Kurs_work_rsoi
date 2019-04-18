<?php
//require_once 'key/config.php';
require_once 'key/db_connection.php';
//session_start();
header("Content-Type: text/html; charset=utf-8");

$upload_dir = SITE_ROOT . "image/profile_pics/";
$image_fieldname = "image_user";

// Потенциальные PHP-ошибки отправки файлов
$php_errors = array(1 => 'Превышен макс. размер файла, указанный в php.ini',
2 => 'Превышен макс. размер файла, указанный в форме HTML',
3 => 'Была отправлена только часть файла',
4 => 'Файл для отправки не был выбран.');
//---------------------time
$tp_dat = trim($_REQUEST['tp_dat']);
//tp_descriptio-----------------------------------------------------------
$tp_descriptio=trim($_POST['tp_descriptio']);

//******************* tp_nam
if(!preg_match("/^([йцукенгшщзхъфывапролджэячсмитьбюёЁЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЯЧСМИТЬБЮЖЭa-z0-9A-Z_-]+){3,30}$/",$_REQUEST['tp_nam'])) 
{
handle_error($fat_error = "i am don't ready you tp_nam! please only english word and about 3 to 30 simvol and ohne probel!","Да да!";
}
$tp_nam = trim($_REQUEST['tp_nam']);
/*
$result = mysql_query("SELECT id FROM `tp` WHERE  tp_nam='$tp_nam';",$db);           
 $myrow = mysql_fetch_array($result);            
 if (!empty($myrow['id'])) {handle_error($fat_error = "Возьмите другой ник!","ye ye!");
}
*/
///////////////////////*
 $select_query = "SELECT * FROM `tp` WHERE tp_nam ='$tp_nam';";
 //mysql_query($select_query) or die ("owibka".mysql_error());
 $result = mysql_query($select_query);
 if(isset($result)){
	$num = @mysql_num_rows($result);
	if (!($num == 0)){
		handle_error($fat_error = "Возьмите другой tp!","ye ye!");
		exit();
	}
}
//---resp
$tp_responsible_id = trim($_POST['tp_responsible_id']);
$select_query = "SELECT `name` FROM `users1` WHERE user_id ='$tp_responsible_id';";
 mysql_query($select_query) 
	or die ("owibka".mysql_error());
 $result = mysql_query($select_query);
 if(isset($result)){
	$row = mysql_fetch_object($result);
	$tp_responsible_nam=$row->name; 
 }

 // **** images ****
 // Проверка отсутствия ошибки при отправке изображения
 if(!empty($_FILES["image_user"]['name'])) {
 //
	($_FILES[$image_fieldname]['error'] == 0)
	or handle_error("сервер не может получить выбранное вами изображение.", $php_errors[$_FILES[$image_fieldname]['error']]);

	// Является ли этот файл результатом нормальной отправки?
	is_uploaded_file($_FILES[$image_fieldname]['tmp_name'])
	or handle_error("вы попытались совершить безнравственный поступок. Позор!", "Запрос на отправку: файл назывался '{$_FILES[$image_fieldname]['tmp_name']}'");
	// Действительно ли это изображение?
	GetImageSize($_FILES[$image_fieldname]['tmp_name'])
	or handle_error("вы выбрали файл для своего фото, который не является изображением.", "{$_FILES[$image_fieldname]['tmp_name']} не является настоящим файлом изображения.");

	// Присваивание файлу уникального имени
	$now = time();
	while (file_exists($upload_filename = $upload_dir . $now .
	'-' .
	$_FILES[$image_fieldname]['name'])) {
	$now++;
	};

	// не самая лучшая часть кода осталась выше..

	// Вставка изображения в таблицу images
	$image = $_FILES[$image_fieldname];
	$image_filename = $image['name'];
	$image_info = getimagesize($image['tmp_name']);
	$image_mime_type = $image_info['mime'];
	$image_size = $image['size'];
	$image_data = file_get_contents($image['tmp_name']);
	//
	$insert_image_sql = sprintf("INSERT INTO images " .
		"(filename, mime_type, file_size, image_data) " .
	"VALUES ('%s', '%s', %d, '%s');",
		mysql_real_escape_string($image_filename),
		mysql_real_escape_string($image_mime_type),
		mysql_real_escape_string($image_size),
		mysql_real_escape_string($image_data)
	);
	//
	mysql_query($insert_image_sql);
	$image_id_new = mysql_insert_id();
}else{
		 if(isset($_POST['image_tp_id'])){
			$image_id_new = $_POST['image_tp_id'];
			
			/* $update_sql = sprintf(" UPDATE users1 SET imageuser_id = '%d' WHERE user_id = '%s';",
				$image_id_new, $user_id_change );
			mysql_query($update_sql) or die("owibka".mysql_error()); */
		 }
	}
  // if (mysql_query){
	// echo"<p>Ура, photos send!</p>";
 // } else {echo"You last luzer!!! ahahahahhahahahaha";}
 
// Обработка запроса пользователя
$insert_sql = sprintf("INSERT INTO `tp` (`tp_date`
										, `tp_name`
										, `tp_description`
										, `tp_image_id`
										, `tp_responsible_id`
										, `tp_responsible_name`) 
						VALUES ( '%d'
								, '%s'
								, '%s'
								, '%d'
								,'%d'
								,'%s');",
	mysql_real_escape_string($tp_dat),
	mysql_real_escape_string($tp_nam),
	mysql_real_escape_string($tp_descriptio),
	$image_id_new,
	$tp_responsible_id,
	mysql_real_escape_string($tp_responsible_nam)
);
// Вставка данных о пользователе в базу данных
mysql_query($insert_sql);
/* INSERT INTO ``tp``(`user_id`
					, `for_name`
					, `tp_nam`
					, `password`
					, `email`
					, `facebook`
					, `tp_descriptio`
					, `imageuser_id`
					, `usergroup_id`
					)  */
/*   if (mysql_query){
	 echo"<p>Ура, tp ready!</p>";
	 echo'<p><a href="show_tp1.php">Ваш кабинет</a></p>';
 } else {
	 echo"You last luzer!!! ahahahahhahahahaha";
	} */
 
// 
// Перенаправление пользователя на страницу, показывающую информацию
// о пользователе
header("Location: show_tp1.php");
exit();


/* 
  if (mysql_query){
 echo"<p>Ура, вы зарегестрированы!</p>";
 echo'<p><a href="infouser2.php">Ваш кабинет</a></p>';
 } else {echo"You last luzer!!! ahahahahhahahahaha";}
 */

?>