<?php
//require_once 'key/config.php';
require_once 'key/db_connection.php';
require_once 'key/authorize4.php';
header("Content-Type: text/html; charset=utf-8");
// Получение идентификатора удаляемого пользователя
//session_start();

$user_id = $_REQUEST['user_id'];
// if(!is_user_group(1)){}
if (!isset($user_id)) {
  $user_id = $_SESSION['user_id'];
} else{
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
		} else {
			handle_error("result errr!");
		}
	}
	if ($user_id != $_SESSION['user_id']){
		if ($group_user_id_session != 1){
			handle_error("Вы не можете изменять чужие данные! ");
		}
	}
}

$user_id_change = $user_id;
$select_query = "SELECT * FROM users1 WHERE user_id = " . $user_id;
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
               "Error locating user with ID {$user_id}");
}
////////////////////////////////////////change
//----------------------------------------------------------------------------------------------------

////////////////////////////////////////end change
//----------------------------------------------------------------------------------------------------

echo <<<EOD
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
	<head>
	<link href="css/phpMM.css" rel="stylesheet" type="text/css" />
	 <meta charset="UTF-8" > 
	</head>

<body>
<div id="example"></div>
<div id="menu">
<ul>
<li><a href="title2.php">Главная страница</a></li>
EOD;
echo "<li><a href='infouser4.php'>Мой профиль</a></li>";
echo "<li><a href='signout4.php'>Exit my</a></li>";
echo <<<EOD
</ul>
</div>
EOD;
?>

<div id="content">
<h1>Изменяйте - <? echo "$name"; ?> </h1>

<form id="signup_form" action="info_update.php?user_id=<? echo "$user_id_change"; ?>" method="POST" enctype="multipart/form-data"> 
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
	//------------------------------------image choose from site
	$select_query = "SELECT * FROM `images`";
			// Запуск запроса
	$result = mysql_query($select_query)
			or die('Incorrect query.');
	if (!empty($image_id ) && !($image_id  == 0)) {
		echo "		
				<label for=\"image_user_id\">Выбирите фото с сайта:</label>
				<select id='img' name = 'image_user_id' size='5'>
					<option title=\"$image_id\"  value = '$image_id'> 
					</option>	
				";
		while($row = mysql_fetch_object($result)){
			echo "
			<option title=\"$row->images_id\" value = '$row->images_id'> 
				<a href='show_image.php?images_id=$row->images_id'>$row->filename</a></option>";
		}		
		echo "	</select>
		<br/>";
	} else{
		echo "<label for=\"image_user_id\">Выбирите фото с сайта:</label>
				<select id='img' name = 'image_user_id' size='5'>
					<option value=''>Select...</option>
				";
		while($row = mysql_fetch_object($result)){
			echo "
			<option title=\"$row->images_id\"  src=\"show_image.php?images_id=$row->images_id\"  value = '$row->images_id'> 
				$row->images_id</option>";
		}		
		echo "	</select>

		<br/>";
	}
	
	//-------------------------------------------groupe
	if ($group_user_id_session == 1 ){
			/*Выпадающий список*/	
		echo "<label for=\"group_id\">Изменяйте права $name:</label>
			<select name = 'group_id'>";
		if ($group_user_id == 1){
			echo "<option value = '$group_user_id' > Admin </option>";
			echo "<option value = 2 > Technolog </option>";
			echo "<option value= 0>-- Nobody --</option> ";
		}else{ if($group_user_id == 2){
				echo "<option value = '$group_user_id' > Technolog </option>";
				echo "<option value = 1 > Admin </option>";
				echo "<option value= 0>-- Nobody --</option> ";
			}else{
				echo "<option value=''>-- Выбирите из списка --</option> ";
				echo "<option value = 2 > Technolog </option>";
				echo "<option value = 1 > Admin </option>";
			}
		}
		
		/* while($row = mysql_fetch_object($result)){
			echo "<option value = '$row->order_id' > #$row->order_id, заказчик $row->order_name_user, исполнитель $row->order_responsible_name</option>";
		} */
		echo "</select><br/>";
		//----------------------------------------------------	
		if ($group_user_id == 2){
			//----------------------------------------------------order	
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
			//----------------------------------------------------tp	
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
<input width=100 title="Update" type="image" src="image/update.png" value="go to hell" /> <br>
<input type="reset" value="Очистить и начать все сначала" />
</fieldset>
</form>
<?php
	include('key/footer.php');
?>