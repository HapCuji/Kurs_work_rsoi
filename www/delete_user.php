<?php
//require_once 'key/config.php';
require_once 'key/db_connection.php';
require_once 'key/authorize4.php';
// Получение идентификатора удаляемого пользователя
$user_id = $_REQUEST['user_id'];
// Создание инструкции DELETE
$delete_query = sprintf("DELETE FROM users1 WHERE user_id = %d",
$user_id);
// Удаление пользователя из базы данных
mysql_query($delete_query);
$ERR_DB = mysql_error() ;
if ($ERR_DB != NULL)
	handle_error($user_error_message, mysql_error());
// Перенаправление на show_users для повторного показа пользователей
// (без удаленного пользователя)
$msg = "The user you specified has been deleted!";
header("Location: show_user4.php?success_message={$msg}");
exit();
?>