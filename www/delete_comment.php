<?php
//require_once 'key/config.php';
require_once 'key/db_connection.php';
require_once 'key/authorize4.php';
// Получение идентификатора удаляемого пользователя
$comm_date = $_REQUEST['comm_date'];

if (isset($_SESSION['user_id']) && isset($comm_date)) {
	$nickname = $_SESSION["name"];
	$user_id = $_SESSION['user_id'];
	// Создание инструкции DELETE
	$delete_query = sprintf('DELETE FROM comments WHERE comm_date = "%s" AND name = "%s"',
		mysql_real_escape_string($comm_date), $nickname);
	// Удаление пользователя из базы данных
	mysql_query($delete_query) or handle_error("vse ploho", mysql_error());
	// Перенаправление на title2 для повторного показа comment
	// (без удаленного пользователя)
	$msg = "The comment you specified has been deleted!";
}
header("Location: title2.php");
exit();
?>