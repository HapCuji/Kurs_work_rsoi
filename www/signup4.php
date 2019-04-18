<?php
header("Content-Type: text/html; charset=utf-8");
require_once "key/viewNomy3.php";
//require_once "key/config.php";
session_start();
//page_start("Вступайте в наш виртуальный клуб");
?>

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
		<li><a href='look_on_order1.php'>Заказы</a></li>
		<li><a href="show_tp1.php">Технологический процесс</a></li>
		</ul>
	</div>

<div id="content">
<h1>Вступайте в наш виртуальный клуб</h1>

<p>Пожалуйста, введите ниже свои данные для связи в Интернете:</p>
</br><p>Обязательные поля - пароль, ник, имя, email.</p>
<form id="signup_form" action="info_registr4.php" method="POST" enctype="multipart/form-data">
<fieldset>
<label for="name">Nick:</label>
<input type="text" name="name" size="20" />
<br />
<label for="for_name">Имя:</label>
<input type="text" name="for_name" size="20" />
<br />
<label for="email">Адрес электронной почты:</label>
<input type="text" name="email" size="50" />
<br />
<label for="facebook_url">URL-адрес в Facebook:</label>
<input type="text" name="facebook_url" size="50" /><br />
<label for="password1">Пароль:</label>
<input type="password" name="password1" size="30"/>
<br/>
<label for="password2">Повторите пароль:</label>
<input type="password" name="password2" size="30"/>
<br/>
<label for="bio">О вас:</label>
<p><textarea rows="10" cols="45" name="bio" placeholder>
изначально будет отображен в многострочном поле ввода и который  
нельзя изменять, т.к. указан атрибут readonly </textarea></p>
<br/>
<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
<label for="image_user">Загрузите фотографию:</label>
<input type="file" name="image_user" size="30"/>
<br/>
</fieldset>

<fieldset class="center">
<input title="Go to hell" type="image" src="image/helldoors.jpg" value="go to hell" />
<input type="reset" value="Очистить и начать все сначала" />
</fieldset>
</form>
<?php
	include('key/footer.php');
?>