<?php
//require_once 'key/config.php';
require_once 'key/db_connection.php';
require_once 'key/authorize4.php';
header("Content-Type: text/html; charset=utf-8");
// Получение идентификатора удаляемого пользователя
session_start();
$user_id = $_REQUEST['user_id'];

if (!isset($user_id)) {
  $user_id = $_SESSION['user_id'];
}
//Исправить!!!!!!! на заказы проверка ид заказчика и текущего пользователя
if (isset($_SESSION['user_id'])) {
		$nickname = $_SESSION["name"];
		$user_id = $_SESSION['user_id'];
		$select_query = "SELECT * FROM users1 WHERE user_id = " . $user_id;
		// Запуск запроса
		$result = mysql_query($select_query);

		if ($result) {
			$row = mysql_fetch_array($result);
			//$image_user_id = $row['imageuser_id'];
			$group_user_id = $row['usergroup_id'];
		} else {
			handle_error("there was a problem finding your information in our system.",
               "Error locating user with ID {$user_id}");
		}
	if ($user_id != $user_id ){
		$msg = "need more root!";
		 echo"<p>Недостаточно золота (ой, прав)!</p>";
		header("Location: infouser4.php");
		exit();
	}
}

echo <<<EOD
<body>
<div id="example">$title</div>
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
<html>
<head>
<link href="css/phpMM.css" rel="stylesheet" type="text/css" />
 <meta charset="UTF-8" > 
</head>
<body>
<div id="content">
<h1>Изменяйте</h1>

<form id="signup_form" action="info_update.php" method="POST" enctype="multipart/form-data">
<fieldset>
<label for="for_name">Имя:</label>
<input type="text" name="for_name" size="20" />
<br />
<label for="bio">О вас:</label>
<p><textarea rows="10" cols="45" name="bio" placeholder>
</textarea></p>
<br/>
<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
<label for="image_user">Загрузите фотографию:</label>
<input type="file" name="image_user" size="30"/>
<br/>
</fieldset>

<fieldset class="center">
<input type="image" src="image/update.png" value="go to hell" />
<input type="reset" value="Очистить и начать все сначала" />
</fieldset>
</form>
<?php
	include('key/footer.php');
?>