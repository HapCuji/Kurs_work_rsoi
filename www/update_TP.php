<?php
//require_once 'key/config.php';
require_once 'key/db_connection.php';
require_once 'key/authorize4.php';
header("Content-Type: text/html; charset=utf-8");
// Получение идентификатора удаляемого пользователя
// session_start();
require_once 'key/viewNomy3.php';

$tp_id = $_REQUEST['tp_id'];


if (isset($_SESSION['user_id'])) {
	$nickname = $_SESSION["name"];
	$user_id_session = $_SESSION['user_id'];
	$select_query = "SELECT * FROM users1 WHERE user_id = " . $user_id_session;
	// Запуск запроса
	$result = mysql_query($select_query);

	if ($result) {
		$row = mysql_fetch_array($result);
		//$image_id_session = $row['imageuser_id'];
		$group_user_id_session = $row['usergroup_id'];
	};
}
if ($group_user_id_session != 1 or $group_user_id_session != 2){
		header("Location: title2.php");
	}

$tp_id_change = $tp_id;
$select_query = "SELECT * FROM tp WHERE tp_id = " . $tp_id;
// Запуск запроса
$result = mysql_query($select_query);

if ($result) {
	$row = mysql_fetch_array($result);
	$name = $row['name'];
	$for_name = $row['for_name'];
	$bio =  $row['bio'];
	$email = $row['email'];
	$facebook_url = $row['facebook'];
	$password = $row['password'];
	$image_id = $row['imageuser_id'];
	$group_user_id = $row['usergroup_id'];
} else {
  handle_error("there was a problem finding your information in our system.",
               "Error locating user with ID {$tp_id}");
}
////////////////////////////////////////change
//----------------------------------------------------------------------------------------------------
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
	mysql_insert_id(), $user_id_change );

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

	if ($group_user_id_session == 1 or $group_user_id_session == 2){
		header("Location: show_tp1.php");
	}
	exit();
}
////////////////////////////////////////end change
//----------------------------------------------------------------------------------------------------


display_head("Обсуждение заказов");
?>
<h1>Изменяйте - <? echo "$name"; ?> </h1>

<form id="signup_form" action="update_user.php?user_id=<? echo "$tp_id_change"; ?>" method="POST" enctype="multipart/form-data">
<fieldset>
<label for="for_name">Имя:</label>
<input type="text" name="for_name" size="20" />
<br />
<label for="bio">О вас:</label>
<p><textarea rows="10" cols="45" name="bio" placeholder>
<? echo "$bio"; ?>
</textarea></p>
<br/>
<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
<label for="image_user">Загрузите фотографию:</label>
<input type="file" name="image_user" size="30"/>
<br/>
<?php
	if ($group_user_id_session == 1 ){
				/*Выпадающий список*/	
			echo "<label for=\"user_group_id\">Изменяйте права $name:</label>
				<select name = 'tp_user_responsible_id'>";
			if ($group_user_id == 1){
				echo "<option value = '$group_user_id' > Admin </option>";
				echo "<option value = 2 > Technolog </option>";
			}else{ if($group_user_id == 2){
					echo "<option value = '$group_user_id' > Technolog </option>";
					echo "<option value = 1 > Admin </option>";
				}else{
					echo "<option value=''>-- Выберите из списка --</option> ";
					echo "<option value = 2 > Technolog </option>";
					echo "<option value = 1 > Admin </option>";
				}
			}
			while($row = mysql_fetch_object($result)){
				echo "<option value = '$row->order_id' > #$row->order_id, заказчик $row->order_name_user, исполнитель $row->order_responsible_name</option>";
			}
			echo "</select><br/>";
				
		if ($group_user_id == 2){
			$select_query = "SELECT * FROM `order` WHERE 1";
			// Запуск запроса
			$result = mysql_query($select_query)
					or die('Incorrect query.');

			/*Выпадающий список*/
			echo "<label for=\"order_user_responsible_id\">Укажите, что должен(-на) сделать $name:</label>
			<select name = 'order_user_responsible_id'>
			<option value=''>-- Выберите из списка --</option> ";
			
			while($row = mysql_fetch_object($result)){
				echo "<option value = '$row->order_id' > #$row->order_id, заказчик $row->order_name_user, исполнитель $row->order_responsible_name</option>";
			}
			echo "</select><br/>";
			
			$select_query = "SELECT * FROM `tp` WHERE 1";
			// Запуск запроса
			$result = mysql_query($select_query)
					or die('Incorrect query.');

				/*Выпадающий список*/	
			echo "<label for=\"tp_user_responsible_id\">$name ответственен(-на) за операцию:</label>
				<select name = 'tp_user_responsible_id'>
				<option value=''>-- Выберите из списка --</option> ";
			
			while($row = mysql_fetch_object($result)){
				echo "<option value = '$row->tp_id' > $row->tp_name, делал $row->tp_responsible_name</option>";
			}
			echo "</select><br/>";
		}
	}
	
	
?>
</fieldset>

<fieldset class="center">
<input type="image" src="image/update.png" value="go to hell" />
<input type="reset" value="Очистить и начать все сначала" />
</fieldset>
</form>
<?php
	include('key/footer.php');
?>