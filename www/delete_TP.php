<?php
//require_once 'key/config.php';
require_once 'key/db_connection.php';
require_once 'key/authorize4.php';
// Получение идентификатора удаляемого пользователя
$tp_id = $_REQUEST['tp_id'];
// Создание инструкции DELETE
$delete_query = sprintf("DELETE FROM tp WHERE tp_id = %d",
$tp_id);
// Удаление пользователя из базы данных
mysql_query($delete_query);
$ERR_DB = mysql_error() ;
if ($ERR_DB != NULL)
	handle_error($user_error_message, mysql_error());
// Перенаправление на show_tps для повторного показа processos
// (без удаленного пользователя)
$msg = "The tp you specified has been deleted!";
header("Location: show_tp1.php?success_message={$msg}");
exit();
?>