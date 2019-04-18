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

//замена орг. на ком. + удаление пробелов
$facebook_url = str_replace("facebook.org", "facebook.com",trim($_REQUEST['facebook_url']));
$position = strpos($facebook_url, "facebook.com/");

if ($position === false) {
$facebook_url = "http://www.facebook.com/" . $facebook_url;
}

$bio=trim($_POST['bio']);
 
$password1 = trim($_REQUEST['password1']);
$password2 = trim($_REQUEST['password2']);

//******************* nick
if(!preg_match("/^[a-z0-9A-Z_-]{3,30}$/",$_REQUEST['name'])) 
{
handle_error($fat_error = "i am don't understand you Nick! please only english word and about 3 to 30 simvol and ohne probel!","Да да!");
}
$name = trim($_REQUEST['name']);
/*
$result = mysql_query("SELECT id FROM users1 WHERE  name='$name';",$db);           
 $myrow = mysql_fetch_array($result);            
 if (!empty($myrow['id'])) {handle_error($fat_error = "Возьмите другой ник!","ye ye!");
}
*/
///////////////////////*
 $select_query = "SELECT * FROM users1 WHERE name ='$name';";
 mysql_query($select_query) or die ("owibka".mysql_error());
 $result = mysql_query($select_query);
 if(isset($result)){
 $num = @mysql_num_rows($result);

	if (!($num == 0)){
handle_error($fat_error = "Возьмите другой ник!","ye ye!");
}

}
/////////////////////////
//*** forname имя
if(!preg_match("/^([йцукенгшщзхъфывапролджэячсмитьбюёЁЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЯЧСМИТЬБЮЖЭa-z0-9A-Z_-]+){3,30}$/",$_REQUEST['for_name'])) 
{
handle_error("i am don't ready you name! Пожалуйста вводите имя без пробелов, от 3 до 30 символов.","Да да!");
} else{$for_name = trim($_REQUEST['for_name']);}
//*** mail
if(!preg_match("/^([a-z0-9A-Z_\.-]+)@([a-z0-9A-Z_\.-]+)\.([a-zA-Z\.]{2,6})$/",$_REQUEST['email'])) 
{
handle_error($fat_error = "i am don't ready you email! please only english norm email!","Да да!");
} else{$email = trim($_REQUEST['email']);}
//*** pass
if(($password2==$password1)&& (preg_match("/^[A-Za-z0-9-]{4,20}$/",$password1)>0)) {$password=$password1;} 
else { 
handle_error($fat_error = "нет совпадения паролей, введите пожалуйста на английском регистре от 4 до 20 символов!","Да да!");
}
// ************

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
mysql_real_escape_string($image_data));
//
mysql_query($insert_image_sql);
}
  if (mysql_query){
 echo"<p>Ура, photos send!</p>";
 } else {echo"You last luzer!!! ahahahahhahahahaha";}
 
// Обработка запроса пользователя
$insert_sql = sprintf("INSERT INTO users1 (
	name, for_name, 
	email, facebook, bio, password, 
	imageuser_id) VALUES (
	'%s', '%s', '%s', '%s', 
	'%s', '%s', %d);",
mysql_real_escape_string($name),
mysql_real_escape_string($for_name),
mysql_real_escape_string($email),
mysql_real_escape_string($facebook_url),
mysql_real_escape_string($bio),
mysql_real_escape_string(crypt($password,$name)),
mysql_insert_id());
// Вставка данных о пользователе в базу данных
mysql_query($insert_sql);
/* INSERT INTO `users1`(`user_id`
					, `for_name`
					, `name`
					, `password`
					, `email`
					, `facebook`
					, `bio`
					, `imageuser_id`
					, `usergroup_id`
					)  */
  if (mysql_query()){
	 echo"<p>Ура, вы зарегестрированы!</p>";
	 echo'<p><a href="infouser4.php">Ваш кабинет</a></p>';
 } else {echo"You last luzer!!! ahahahahhahahahaha";}
 
// 
session_start();
// Перенаправление пользователя на страницу, показывающую информацию
// о пользователе
$_SESSION['user_id'] = mysql_insert_id();
header("Location: infouser4.php");
exit();


/* 
  if (mysql_query){
 echo"<p>Ура, вы зарегестрированы!</p>";
 echo'<p><a href="infouser2.php">Ваш кабинет</a></p>';
 } else {echo"You last luzer!!! ahahahahhahahahaha";}
 */

?>