<?php
header("Content-Type: text/html; charset=utf-8");
require_once 'key/db_connection.php';
require_once 'key/viewNomy3.php';
//session_start();
	$search=trim($_POST["search"]);
	if (!empty($search)){
		$search_sql = "SELECT * FROM users1 WHERE name = '$search';";
		// 3anpoc
		 mysql_query($search_sql) or die ("owibka".mysql_error());
		 $result = mysql_query($search_sql);
		 // save DaHHbIx
		 if ($result) {
		$row = mysql_fetch_array($result);
		$name = $row['name'];
		$for_name = $row['for_name'];
		$bio =  $row['bio'];
		$email = $row['email'];
		$facebook_url = $row['facebook'];
		$image_id = $row['imageuser_id'];
		} else {
		  handle_error("there was a problem finding your information in our system.",
					   "Error locating user with ID {$user_id}");
		}
	}
if (isset($_SESSION['user_id'])) {
	require 'key/authorize4.php';
}
display_head(" Профиль пользователя ");
//page_start("Профиль");
?>
    <h2>Связь с нами </h2>

    <p>Телефон Лёхи:(46495)33666</p>
	

	<div class="search">
<form id="signup" action="vektor.php" method="POST" enctype="multipart/form-data">
<fieldset>
<p>Наши мастера(в скобках указана максимальная сложность работы для мастера) - имя и ник:</p></br>
<p>Майка - masha (определяется харизмой клиента)</p></br>
<p>Кризис - kriziss (много лит.)</p></br>
<p>Дядя'вова - auslender (просит валюту = 40%*лит.*сложность*часовой пояс)</p></br>
<p>Никита - Nick (=10лит.)</p></br>
<p>Михалывич - gleb (до 20лит.)</p></br>
<p>Леха - goodprofi (до бесконечности)</p></br>
<p>Киззяк - vopros (до 3лит.)</p></br>
<p>Красавчик - usak (до бесплатно)</p></br>
<p>kluch</p></br>
<label for="search">Ищите мастера по нику:</label>
<input type="text" name="search" size="33" />
</fieldset>
<fieldset>
<input type="submit"  value="Поиск" />
</fieldset>
</form>
</div>

<?php
	if (!empty($name)){
	if (!empty($image_id) && !($image_id == 0)) {
echo '<img src="show_image.php?images_id='. $image_id.'" class="pic" />';
} else{
echo '<img src="image/profile_pics/xxx.jpg" class="pic" /> ';
}
echo <<<EOD
<div class="vector">
	<p>
	Нашли: $name, его настоящее имя: $for_name 
	</p></br>
	<p>
	Биография: $bio
	
	</p></br>
	<p>
	Файсбук мастера:$facebook_url
	</p></br>
	<p>
	Майл мастера:
<a href="$email">по электронной почте</a>
	</p>
	</div>
EOD;
}
/*
masha
я единственная!! я божественная! я самовлюблённая и эгоистичная! я девушка автомеханик!!! я Майка. 
usak
Высшее образование по специальности (работа с машинами), 11 классов школы с хорошей успеваемостью. Также не пью и не курю. Принят в сервис (без опыта). 
kriz
Без образования. Опыт с 89. Телефон есть. Придумал красить в красивые узорчики машины клиентов (не бесплатно, конечно), также в тяжелые времена продавал за границей родной сервиз (не за бесценок, конечно)! (PS от Лехи:) Кстати, его настоящего имени никто незнает.. 
aus
10 классов старой школы (сегодня это 11). Опыт с 54. Но выгляжу на 50 (Всегда)! Телефон есть. (1PS от Лехи:)Если встретите его заграницей (а он бывает там часто) вы его запомните! Вообще при встрече любой рискует пополнить свой словарный запас.. 
nick
Образование 9 классов. В колледже присутствовал. Опыт с 2010. Ник и голова не болит. (PS от Лехи:)Никита - везде допито. 
gleb
Образование Все. Опыт Все. Телефон Все. Если че держатся будет.(PS от Лехи:)Все - значит никто непомнит. Все - значит \"чекушка\". 

*/
	?>
	
  </div>
<?php
	include('key/footer.php');
?>