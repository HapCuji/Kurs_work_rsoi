<?php
header("Content-Type: text/html; charset=utf-8");
//<!--vchod kyk-->
// require_once 'key/db_connection.php';
require_once 'key/viewNomy3.php';
$error_message = $_REQUEST['error_message'];
// session_start();
// Если пользователь зарегистрировался, будет установлен cookie-файл user_id
if (!isset($_SESSION['user_id'])) {//to 62  || ($_SESSION['user_id'] == 0
  // Проверка отправки формы регистрации с username для входа в приложение
  if (isset($_POST['name'])) {
  // Попытка зарегистрировать пользователя
  	$username = mysql_real_escape_string(trim($_REQUEST['name']));
  	$password = mysql_real_escape_string(trim($_REQUEST['password']));
  	// Поиск пользователя
  	$query = sprintf("SELECT user_id, name FROM users1  WHERE name = '%s' AND  password = '%s';",
  	$username, crypt($password, $username));
  	$results = mysql_query($query);
    if (mysql_num_rows($results) == 1) {
      $result = mysql_fetch_array($results);
      $user_id = $result['user_id'];
      $_SESSION['user_id'] = $user_id;
      $_SESSION['name'] = $username;
      header("Location: infouser4.php");
      exit();
    } else {
        // If user not found, issue an error 
      $error_message = "Your username/password combination was invalid.";
	    echo"Забыли пароль?";
    }
  }
// Часть if, относящаяся к ситуации «Не вошел
// как зарегистрированный пользователь».
// Начало страницы. Мы знаем, что здесь нет сообщения об успехе
// или об ошибке, поскольку происходит всего лишь регистрация для входа
// в приложение.

//page_start("Регистрация", NULL, NULL, $error_message);
//phpMM.css title1.css
//<div id="example">Menu</div>
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
	<head>  
		<link rel="stylesheet" type="text/css" href="css/phpMM.css">
	  <title> Увлажнитель воздуха </a></title>
	   
	</head>
  <body>

 <?php
echo <<<EOD


<div id="menu">
<ul>
<li><a href="title2.php">Главная страница</a></li>
EOD;
if (isset($_SESSION['user_id'])) {
	echo "<li><a href='infouser4.php'>Мой профиль</a></li>";
	echo "<li><a href='signout4.php'>Exit my</a></li>";
} else {
	echo "<li><a href='signup4.php'>Регистрация</a></li>";
}
echo <<<EOD
</ul>
</div>
EOD;

?>
  <div id="content">
    <h2>Войдите</h2>
    <form id="signin_form" 
          action="<?php echo $_SERVER['PHP_SELF']; ?>" 
          method="POST">
      <fieldset>
        <label for="name">Ваш Nick:</label>
        <input type="text"  name="name" id="username" size="20" 
               value="<?php if (isset($username)) echo $username; ?>" />
        <br />
        <label for="password">Пароль:</label>
        <input type="password"  name="password" id="password" size="20" />
      </fieldset>
      <br />
      <fieldset class="center">
        <input type="submit" value="Sign In" />
      </fieldset>
    </form>
  </div>
  <div id="footer"></div>
 </body>
</html>
<?php
} else {
	// Обработка случая, когда зарегистрировавшийся пользователь
	header("Location: infouser4.php");
}
  include('key/footer.php');
?>