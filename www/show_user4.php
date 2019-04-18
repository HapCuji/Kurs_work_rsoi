<?php
session_start();
require_once 'key/db_connection.php';
require_once 'key/viewNomy3.php';
require_once 'key/authorize4.php';
header("Content-Type: text/html; charset=utf-8");

if (isset($_SESSION['user_id'])) {
		$nickname = $_SESSION["name"];
		$user_id = $_SESSION['user_id'];
		$select_query = "SELECT * FROM users1 WHERE user_id = " . $user_id;
		// Запуск запроса
		$result = mysql_query($select_query);

		if ($result) {
			$row = mysql_fetch_array($result);
			$image_id = $row['imageuser_id'];
			$group_user_id = $row['usergroup_id'];
		};
} else {
	// Обработка случая, когда not зарегистрировавшийся пользователь
	header("Location: signin4.php");
}
if ($group_user_id != 1){
	header("Location: signin4.php");
}
// Создание инструкции SELECT
$select_users = "SELECT * FROM users1";
// Запуск запроса
$result = mysql_query($select_users);

// Отображение представления пользователям
$delete_user_script = <<<EOD
function delete_user(user_id, user_name, user_job) {
	if (confirm("Вы уверены, что хотите удалить "
				+ user_job
				+ " - "
				+ user_name 
				+ " #" 
				+ user_id
				+ "? Вернуть его уже не удастся!")) 
	{
		window.location = "delete_user.php?user_id=" + user_id;
	}
}

EOD;
page_start(" Пользователи системы", $delete_user_script,
			$_REQUEST['success_message'], $_REQUEST['error_message'], $group_user_id);
//page_start("Профиль");
?>

<!--<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link  rel="stylesheet" type="text/css" href="../css/phpMM.css"/>
		<title>Пользователи</title>
	 <script type='text/javascript'>function delete_user(user_id) {
	if (confirm("Вы уверены, что хотите удалить этого пользователя?" +
	"Вернуть его уже не удастся!")) {
	window.location = "delete_user.php?user_id=" + user_id;
	}
	}</script>
	->
</head>
 <body>
 
 
<div id="content">
-->

<ul>

<?php
echo '<table  border="1" cellpadding="5" cellspacing="1">';
echo "	<tr> ".//-- new rows
			"<td> ID </td>". //new column
		"
			<td> Nickname </td>
			<td> Avatar </td>
			<td> Name </td>
			<td> Email </td>
			<td> HwoIS </td>
			<td> Удалить страницу </td>
		</tr>";
$i = 0;
while ($user = mysql_fetch_array($result)) {
	if ($i % 2 == 0)
		{
		$color = '#FFFFE0';
	}
	else
		{
		$color = "#F0E68C";
	}
	$i++;
	if ($user['usergroup_id'] == NULL) {
		$user_job = 'Пользователь';
	} else{
		if ($user['usergroup_id'] == 2){
			$user_job = 'Технолог';
		}else{
			if ($user['usergroup_id'] == 1){
				$user_job = 'Админ';
			}
		}
	};
	//$user_name = $user['name'];
	//echo "var user_name = 'Маша';";
	/* $user_row = sprintf(
		"<li type=1><a href='infouser4.php?user_id=%d'>%s %s</a> " .
		"(<a href='mailto:%s'>%s</a>) " .
		"<a href='javascript:delete_user(%d);'><img " .
		"class='delete_user' src='../image/delete.png' " .
		"width='15' /></a></li>",
		$user['user_id'], $user['name'], $user['for_name'],
		$user['email'], $user['email'], $user['user_id']
	); */
	echo '<tr bgcolor='.$color.'> 	<td>'.$user['user_id'].' </td>
							<td> <a title="Посмотреть информацию" href="infouser4.php?user_id='.$user['user_id'].'">'.$user['name'].'</a> </td>
							<td>';
								if (!empty($user['imageuser_id']) && !($user['imageuser_id'] == 0)) {
										echo '<img src="show_image.php?images_id='. $user['imageuser_id'].'" class="user_pic" width=150/>';
										} else{
										echo '<img src="image/profile_pics/xxx.jpg" class="user_pic" width=150/> ';
								};
							echo '</td>
							<td> '.$user['for_name'].'</td>
							<td><a href="mailto:'.$user['email'].'">'.$user['email'].'</a> </td>
							<td> '.$user['usergroup_id'].' '. $user_job.'</td>
							<td><a href="javascript:  delete_user('.$user['user_id'].', \''.$user['name'].'\', \''.$user_job.'\');">
								<img class="delete_user" src="../image/delete.png" width="15" />
								Delet: '.$user['name'].'</a> 
							</td>
			</tr>';
	//echo $user_row;
}
echo "</table>";
?>
</ul>
<?php
	include('key/footer.php');
?>