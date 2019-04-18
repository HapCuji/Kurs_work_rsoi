<?php
header("Content-Type: text/html; charset=utf-8");
// require_once 'key/db_connection.php';
require_once 'key/viewNomy3.php';
// session_start();
// $result = mysql_query("SET NAMES UTF8");
// if (isset($_SESSION['user_id'])) {
// 		$nickname = $_SESSION["name"];
// 		$user_id = $_SESSION['user_id'];
// 		$select_query = "SELECT * FROM users1 WHERE user_id = " . $user_id;
// 		// Запуск запроса
// 		$result = mysql_query($select_query);

// 		if ($result) {
// 			$row = mysql_fetch_array($result);
// 			$image_id = $row['imageuser_id'];
// 			$group_user_id = $row['usergroup_id'];
// 		};
// }
display_head("Обсуждение заказов");
?>

  
    <h2> <?php echo $nickname; ?>  оставте свои вопросы, пожелания. </h2>
    <p></p>
	
	<?
	if (isset($_SESSION['user_id'])) {
		$nickname = $_SESSION["name"];
		$user_id = $_SESSION['user_id'];
		$select_query = "SELECT * FROM users1 WHERE user_id = " . $user_id;
		// Запуск запроса
		$result = mysql_query($select_query);

		if ($result) {
			$row = mysql_fetch_array($result);
			$image_id = $row['imageuser_id'];
		}
		$comment = trim($_POST["comment"]);
		if ($comment != "") {
				$com_sql = sprintf("insert into comments (name, comments,imageuser_id) values('%s','%s','$image_id ');",
				mysql_real_escape_string($nickname),
				mysql_real_escape_string($comment)
			);
			// запрос
			mysql_query($com_sql) or die ("owibka".mysql_error());
		}
	}
	//остальной для всей
	$query = "select * from comments 
					order by  'comm_date';";
	$result = mysql_query($query) 
		or die('Incorrect query.');

	while ($row = mysql_fetch_assoc($result)) {
		$image_id = $row['imageuser_id'];	
		echo '<div class="comment">';
		if (!empty($image_id) && !($image_id == 0)) {
			echo '<img src="show_image.php?images_id='. $image_id.'" class="user_pic1" />';
		} else{
			echo '<img src="image/profile_pics/xxx.jpg" class="user_pic" /> ';
		}
		if ($_SESSION['name'] == $row["name"]){
			echo '<a href="delete_comment.php?comm_date='.$row["comm_date"].'"><img class="user_pic2" src="image/delete.png" /> Удалить комментарий </a>';
		}
			echo '<p class="1">';		
			echo $row["name"] ." отправлял: <br> время: ". $row["comm_date"]. ": ";
						
			echo '</p><p class="2">'.  $row["comments"]; 
			echo "</p></div>";		
	}
	if (isset($_SESSION['user_id'])) {
		echo <<<EOD
			<form id="signup" action="title2.php" method="POST" enctype="multipart/form-data">
			<fieldset>
			<p><label for="comment">Коментарий:</label>
			<textarea rows="10" cols="45" name="comment" placeholder>Добрый день!</textarea></p>
			<br/>
			</fieldset>
			<fieldset class="center">
			<input type="submit"  value="Отправить" />
			<input type="reset" value="Очистить и начать все сначала" />
			</fieldset>
			</form>
EOD;
	}
	//<div class="fieldset"> </div>
	
	
	include('key/footer.php');
?>
<!--     </div>
	<div id="footer">Сервис 2018 год. Мастерская изготовления.</div>
  </div>
  
 </body>
</html> -->