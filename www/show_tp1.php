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
			$group_user_id = $row['usergroup_id'];
		};
} else {
	// Обработка случая, когда not зарегистрировавшийся пользователь
	header("Location: signin4.php");
}

// Создание инструкции SELECT
$select_users = "SELECT * FROM tp";
// Запуск запроса
$result_r = mysql_query($select_users);

// Отображение представления пользователям
$delete_tp_script = <<<EOD
function delete_tp(tp_id, tp_name) {
	if (confirm("Вы уверены, что хотите удалить - "
				+ tp_name 
				+ " #" 
				+ tp_id
				+ "? Вернуть ее уже не удастся!")) 
	{
		window.location = "delete_TP.php?tp_id=" + tp_id;
	}
}

EOD;
page_start("Технологические операции", $delete_tp_script,
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
			<td> Название </td>
			<td> Фото </td>
			<td> Время выполнения</td>
			<td> Описание </td>
			<td> ИД: Ответственный  </td>
			";
			if ($group_user_id != 0 and !empty($group_user_id)){
				echo "	<td> Обновить операцию (for root) </td>
						<td> Удалить (for root) </td>";
			}		
	echo " </tr>";
	$i = 0;
	while ($tp = mysql_fetch_array($result_r)) {
		if ($i % 2 == 0)
			{
			$color = '#FFFFE0';
		}
		else
			{
			$color = "#FFE4E1";
		}
		$i++;
		//$tp_name = $tp['name'];
		//echo "var user_name = 'Маша';";
	/* 	$tp_row = sprintf(
			"<li type=1><a href='infouser4.php?tp_id=%d'>%s %s</a> " .
			"(<a href='mailto:%s'>%s</a>) " .
			"<a href='javascript:delete_tp(%d);'><img " .
			"class='delete_user' src='../image/delete.png' " .
			"width='15' /></a></li>",
			$tp['tp_id'], $tp['name'], $tp['for_name'],
			$tp['email'], $tp['email'], $tp['tp_id']
		); */
		echo '<tr bgcolor='.$color.'> 	<td>'.$tp['tp_id'].' </td>
							<td> '.$tp['tp_name'].'</td>
							<td>';
								if (!empty($tp['tp_image_id']) && !($tp['tp_image_id'] == 0)) {
										echo '<img src="show_image.php?images_id='. $tp['tp_image_id'].'" class="user_pic" width=150/>';
										} else{
										echo '<img src="image/profile_pics/xxx.jpg" class="user_pic" width=150/> ';
								};
							echo '</td>
							<td> '.$tp['tp_date'].'</td>
							<td> '.$tp['tp_description'].'</td>
							<td> <a title="Ответственный" href="infouser4.php?user_id='.$tp['tp_responsible_id'].'">
								#'.$tp['tp_responsible_id'].' '.$tp['tp_responsible_name'].'</a> 
							</td>';
							if ($group_user_id != 0 and !empty($group_user_id)){
								echo '<td> Обновить '.$tp['tp_name'].' </td>
								<td><a href="javascript:  delete_tp('.$tp['tp_id'].', \''.$tp['tp_name'].'\');">
									<img class="delete_user" src="../image/delete.png" width="15" />
									Delet: '.$tp['tp_name'].'</a> 
								</td>';
							}
		echo '</tr>';
		//echo $tp_row;
	}
	echo "</table>";
?>

	
</ul>
<?php 
	if ($group_user_id != 0 and !empty($group_user_id)){
		echo <<<EOD
		<h1>Создавайте операции ТП</h1>

		<p>Пожалуйста, введите ниже данные:</p>
		<p>Обязательные поля - Название, время выполнения.</p>
		<form id="signup_form" action="info_registr_tp1.php" method="POST" enctype="multipart/form-data">
			<fieldset>
				<label for="tp_nam">Название:</label>
					<input type="text" name="tp_nam" size="20" />
					<br />
				<label for="tp_descriptio">Описание:</label>
					<p><textarea rows="10" cols="45" name="tp_descriptio" placeholder>
					Изначально readonly </textarea></p>
				<br/>
				<label for="tp_dat">Время выполнения:</label>
					<input type="time" name="tp_dat" size="20" value="00:10:10"/>
					<br />
				<label for="tp_responsible_id">Ответственный:</label>
EOD;
					$select_query = "SELECT * FROM `users1`";
					// Запуск запроса
					$result = mysql_query($select_query)
						or die('Incorrect query.');
					
					echo "
						<select id='img' name = 'tp_responsible_id' >
							<option value=''>Select...</option>
						";
					while($row = mysql_fetch_object($result)){						
						if ($row->usergroup_id != 0 and !empty($row->usergroup_id)){
							
							if ($row->usergroup_id == 2){
								$user_job = "Технолог";
							}else{
								if ($row->usergroup_id == 1){
									$user_job = "Админ";
								}
							} 
							echo "
							<option title=\"$row->user_id\"  value = '$row->user_id'> 
								$user_job - $row->name</option>";
						}
					}		
					echo "	</select>

					<br/>";
		echo <<<EOD
				<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
				<label for="image_user">Загрузите фотографию:</label>
					<input type="file" name="image_user" size="30"/>
					<br/>
				<label for=\"image_tp_id\">Можете выбрать фото с сайта:</label>
EOD;
					$select_query = "SELECT * FROM `images`";
					// Запуск запроса
					$result = mysql_query($select_query)
						or die('Incorrect query.');
					
					echo "
						<select id='img' name = 'image_tp_id' size='5'>
							<option value=''>Select...</option>
						";
					while($row = mysql_fetch_object($result)){
						echo "
						<option title=\"$row->images_id\"  value = '$row->images_id'> 
							$row->filename</option>";
					}		
					echo "	</select>

					<br/>";
		echo <<<EOD
				<input type="submit" value="Создать операцию" />
				<input type="reset" value="Очистить и начать все сначала" />
			</fieldset>
		</form>
EOD;
	}
	include('key/footer.php');
?>