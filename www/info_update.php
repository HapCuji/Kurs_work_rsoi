<?php
//require_once 'key/config.php';
require_once 'key/authorize4.php';
require_once 'key/db_connection.php';
//session_start();
$user_id = $_REQUEST['user_id'];
if (!isset($user_id)) {
  $user_id = $_SESSION['user_id'];
} 


if (!(trim($_REQUEST['for_name'] == "")) || !(trim($_POST['bio'] == "")) || !empty($_FILES["image_user"]['name']) || isset($_POST['image_user_id']))  {
	 // **** images ****
	
	 $upload_dir = SITE_ROOT . "image/profile_pics/";
	$image_fieldname = "image_user";

	// Потенциальные PHP-ошибки отправки файлов
	$php_errors = array(1 => 'Превышен макс. размер файла, указанный в php.ini',
	2 => 'Превышен макс. размер файла, указанный в форме HTML',
	3 => 'Была отправлена только часть файла',
	4 => 'Файл для отправки не был выбран.');

	 // Проверка отсутствия ошибки при отправке изображения
	 if    (!empty($_FILES["image_user"]['name'])) {
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
		mysql_query($insert_image_sql)or die("owibka img".mysql_error());

		// Обработка запроса пользователя

		 $update_sql = sprintf(" UPDATE users1 SET imageuser_id = '%d' WHERE user_id = '%s';",
		mysql_insert_id(), $user_id_change );

		mysql_query($update_sql) or die("owibka".mysql_error());

	}else{
		 if(isset($_POST['image_user_id'])){
			$image_id_new = $_POST['image_user_id'];
			
			$update_sql = sprintf(" UPDATE users1 SET imageuser_id = '%d' WHERE user_id = '%s';",
				$image_id_new, $user_id_change );
			mysql_query($update_sql) or die("owibka".mysql_error());
		 }
	}
	//**** for_name*****
	if (!(trim($_REQUEST['for_name'] == ""))) {

	if(!preg_match("/^([йцукенгшщзхъфывапролджэячсмитьбюЁёЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЯЧСМИТЬБЮЖЭa-z0-9A-Z_-]+){3,30}$/",$_REQUEST['for_name'])) 
	{
	handle_error("i am don't ready you name! Пожалуйста вводите имя без пробелов, от 3 до 30 символов.","Да да!");
	} else{
	$for_name = trim($_REQUEST['for_name']);
	}
	//UP
	 $update_sql = " UPDATE users1 SET for_name='$for_name' WHERE user_id='$user_id_change';
	";
	mysql_query($update_sql) or die ("owibka".mysql_error());
	}
	//*****bio*****
	if (!(trim($_POST['bio'] == ""))) {
		//o me
		$bio=trim($_POST['bio']);
		//UP
		 $update_sql = sprintf("UPDATE users1 SET bio = '%s' WHERE user_id = '%s';", mysql_real_escape_string($bio), $user_id_change);

		mysql_query($update_sql) or die ("owibka".mysql_error());
	}
	//********groupe***************
	if (!(trim($_POST['group_id'] == ""))) {
		//o me
		$group_id=trim($_POST['group_id']);
		//UP
		 $update_sql = sprintf("UPDATE users1 SET usergroup_id = '%d' WHERE user_id = '%s';", mysql_real_escape_string($group_id), $user_id_change);

		mysql_query($update_sql) or die ("owibka".mysql_error());
	}
	
	//-------------------------------------
	if ($group_user_id_session == 1 and $user_id_change != $user_id_session){
		header("Location: show_user4.php");
	}else{
		header("Location: infouser4.php");
	}
	exit();
}
/*
if (!(trim($_REQUEST['for_name'] == "")) || !(trim($_POST['bio'] == "")) || !empty($_FILES["image_user"]['name']))  {
	//*** forname имя

	 // **** images ****
	 $upload_dir = SITE_ROOT . "image/profile_pics/";
	$image_fieldname = "image_user";

	// Потенциальные PHP-ошибки отправки файлов
	$php_errors = array(1 => 'Превышен макс. размер файла, указанный в php.ini',
	2 => 'Превышен макс. размер файла, указанный в форме HTML',
	3 => 'Была отправлена только часть файла',
	4 => 'Файл для отправки не был выбран.');

	 // Проверка отсутствия ошибки при отправке изображения
	 if    (!empty($_FILES["image_user"]['name'])) {
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
	mysql_query($insert_image_sql)or die("owibka img".mysql_error());

	// Обработка запроса пользователя

	 $update_sql = sprintf(" UPDATE users1 SET imageuser_id = '%s' WHERE user_id = '%s';",
	mysql_insert_id(), $user_id);

	mysql_query($update_sql) or die("owibka".mysql_error());

	}
	//**** name*****
	if (!(trim($_REQUEST['for_name'] == ""))) {

	if(!preg_match("/^([йцукенгшщзхъфывапролджэячсмитьбюЁёЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЯЧСМИТЬБЮЖЭa-z0-9A-Z_-]+){3,30}$/",$_REQUEST['for_name'])) 
	{
	handle_error("i am don't ready you name! Пожалуйста вводите имя без пробелов, от 3 до 30 символов.","Да да!");
	} else{
	$for_name = trim($_REQUEST['for_name']);
	}
	//UP
	 $update_sql = " UPDATE users1 SET for_name='$for_name' WHERE user_id='$user_id';
	";
	mysql_query($update_sql) or die ("owibka".mysql_error());
	}
	//*****bio*****
	if (!(trim($_POST['bio'] == ""))) {
	//o me
	$bio=trim($_POST['bio']);
	//UP
	 $update_sql = sprintf("UPDATE users1 SET bio = '%s' WHERE user_id = '%s';", mysql_real_escape_string($bio), $user_id);

	mysql_query($update_sql) or die ("owibka".mysql_error());
	}

	
	header("Location: infouser4.php");
	exit();
} else{
header("Location: update_user.php");
exit();
}
?>
*/