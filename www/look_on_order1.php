<?php
session_start();
require_once 'key/db_connection.php';
require_once 'key/viewNomy3.php';
require_once 'key/authorize4.php';
header("Content-Type: text/html; charset=utf-8");
//triger
//before.delet_user.delet_rasponsible_id.AND.delet_order


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
$select_users = "SELECT * FROM `order` WHERE 1";
// Запуск запроса
$result = mysql_query($select_users);

// Отображение представления пользователям
$delete_order_script = <<<EOD
function delete_order(order_id, order_name) {
	if (confirm("Вы уверены, что хотите отменить заказ - "
				+ order_name 
				+ " #" 
				+ order_id
				+ "? Вернуть его уже не удастся!")) 
	{
		window.location = "delete_order.php?order_id=" + order_id;
	}
}

EOD;
page_start("Заказы", $delete_order_script,
			$_REQUEST['success_message'], $_REQUEST['error_message'], $group_user_id);
//page_start("Профиль");
?>

<!--<html>
<head>
	<meta htorder-equiv="content-type" content="text/html; charset=utf-8" />
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
			"<td> Номер заказа </td>". //new column
		"
			<td> Дата заказа </td>
			<td> Дата поставки </td>
			<td> Идентификатор заказчика </td>
			<td> Количество Увлажнителей </td>
			<td> Ответственный </td>
			";
			if ($group_user_id != 0 and !empty($group_user_id)){
				echo "	<td> Изменить дату поставки (для заказчиков) </td>
						<td> Отменить заказ (для заказчика) </td>";
			}		
	echo "</tr>";
	$i = 0;	
	while ($order = mysql_fetch_array($result)) {

		if ($i % 2 == 0)
			{
			$color = '#ADD8E6';
		}
		else
			{
			$color = "#C0C0C0";
		}
		$i++;
		//$order_name = $order['name'];
		//echo "var user_name = 'Маша';";
	/* 	$order_row = sprintf(
			"<li type=1><a href='infouser4.php?order_id=%d'>%s %s</a> " .
			"(<a href='mailto:%s'>%s</a>) " .
			"<a href='javascript:delete_order(%d);'><img " .
			"class='delete_user' src='../image/delete.png' " .
			"width='15' /></a></li>",
			$order['order_id'], $order['name'], $order['for_name'],
			$order['email'], $order['email'], $order['order_id']
		); */
		echo '<tr bgcolor='.$color.'> 	<td>'.$order['order_id'].' </td>
							<td> '.$order['order_date_begin'].'</td>
							
							<td> - '.$order['order_date_close'].'</td>
							<td> <a title="Заказчик" href="infouser4.php?user_id='.$order['order_user_id'].'">
								#'.$order['order_user_id'].' '.$order['order_name_user'].'</a> 
							</td>
							<td> '.$order['order_value'].'</td>
							<td> <a title="Ответственный" href="infouser4.php?user_id='.$order['order_responsibe_id'].'">
								#'.$order['order_responsible_id'].' '.$order['order_responsible_name'].'</a> 
							</td>';
							if ($group_user_id != 0 and !empty($group_user_id)){
								echo '
									<td> Изменить №'.$order['order_id'].' </td>
									<td><a href="javascript:  delete_order('.$order['order_id'].', \''.$order['order_name_user'].'\');">
										<img class="delete_user" src="../image/delete.png" width="15" />
										Delet: '.$order['order_name'].'</a> 
									</td>';
							}
		echo '</tr>';
	//echo $order_row;
	}
	echo "</table>";
?>

</ul>

<?php 
		$current_date=date('Y-m-d'); //('Y-m-d', (time()+3600*24*7));
		echo <<<EOD
		<h1>Создавайте заказ</h1>

		<p>Пожалуйста, введите ниже данные:</p>
		<p>Обязательные поля - Количество товаров. Можете указать желаемоее время выполнения.</p>
		<form id="signup_form" action="info_registr_order1.php" method="POST" enctype="multipart/form-data">
			<fieldset>
				<label for="order_valu">Количество:</label>
					<input type="number" name="order_valu" size="20" value="1">
					<br />
				<label for="order_date_clos">Дата выполнения:</label>
					<input type="date" name="order_date_clos" size="20" value="$current_date"/>
					<br />
				<label for="order_responsibe_id">Ответственный:</label>
EOD;
					$select_query = "SELECT * FROM `users1`";
					// Запуск запроса
					$result = mysql_query($select_query)
						or die('Incorrect query.');
					
					echo "
						<select id='img' name = 'order_responsibe_id' >
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
				<input type="submit" value="Создать заказ" />
				<input type="reset" value="Очистить и начать все сначала" />
			</fieldset>
		</form>
EOD;

	include('key/footer.php');
?>
<?php 
/*

<?php
session_start();
require_once 'key/db_connection.php';
require_once 'key/viewNomy3.php';
require_once 'key/authorize4.php';
header("Content-Type: text/html; charset=utf-8");

// Создание инструкции SELECT
$select_orders = "SELECT * FROM order";
// Запуск запроса
$result = mysql_query($select_orders);

// Отображение представления пользователям
$delete_order_script = <<<EOD
function delete_order(order_id) {
if (confirm("Вы уверены, что хотите удалить этот заказ?" +
"Вернуть его уже не удастся!")) {
window.location = "delete_order.php?order_id=" + order_id;
}
}
EOD;
page_start("Current orders", $delete_order_script,
$_REQUEST['success_message'], $_REQUEST['error_message']);
page_start("Профиль");
?>

<html>
<head>
<title>Заказы</title>
<link href="../css/phpMM.css" rel="stylesheet" type="text/css" />
<!-- <script type='text/javascript'>function delete_order(order_id) {
if (confirm("Вы уверены, что хотите удалить этого пользователя?" +
"Вернуть его уже не удастся!")) {
window.location = "delete_order.php?order_id=" + order_id;
}
}</script>
-->

<div id="content">
<ul>

<?php
echo '<table  border="1" cellpadding="5" cellspacing="1">';
echo "	<tr> ".//-- new rows
			"<td> Номер заказа </td>". //new column
		"
			<td> Дата заказа </td>
			<td> Дата поставки </td>
			<td> Идентификатор заказчика </td>
			<td> Имя заказчика </td>
			<td> Количество товаров </td>
			<td> Ответственный </td>
			<td> Изменить дату поставки (для заказчиков) </td>
			<td> Отменить заказ (для заказчика) </td>
		</tr>";
while ($order = mysql_fetch_array($result)) {
	
	if ($order['ordergroup_id'] == NULL) {
		$order_job = 'Пользователь';
	} else{
		if ($order['ordergroup_id'] == 2){
			$order_job = 'Технолог';
		}else{
			if ($order['ordergroup_id'] == 1){
				$order_job = 'Админ';
			}
		}
	};
	$order_row = sprintf(
		"<li type=1><a href='infoorder4.php?order_id=%d'>%s %s</a> " .
		"(<a href='mailto:%s'>%s</a>) " .
		"<a href='javascript:delete_order(%d);'><img " .
		"class='delete_order' src='../image/delete.png' " .
		"width='15' /></a></li>",
		$order['order_id'], $order['name'], $order['for_name'],
		$order['email'], $order['email'], $order['order_id']
	);
	echo '<tr><li type=1> 	<td>'.$order['order_id'].' </td>
							<td> <a href="infoorder4.php?order_id='.$order['order_id'].'">'.$order['name'].'</a> </td>
							<td> '.$order['for_name'].'</td>
							<td><a href="mailto:'.$order['email'].'">'.$order['email'].'</a> </td>
							<td> '.$order['ordergroup_id'].' '. $order_job.'</td>
							<td><a href="javascript:delete_order('.$order['order_id'].');">
								<img class="delete_order" src="../image/delete.png" width="15" />
								</a> 
								<a href="delete_order.php?order_id='.$order['order_id'].'">
								
						<img class=delete_order src="image/delete.png" width=15 />
						Delet: '.$order['name'].' </a> </td>
			</li></tr>';
	//echo $order_row;
}
echo "</table>";
?>

	
</ul>
</div>
<div id="footer"></div>



</body>
</html>
*/ ?>