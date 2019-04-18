<?php
//require_once 'key/config.php';
require_once 'key/db_connection.php';
require_once 'key/authorize4.php';
// Получение идентификатора удаляемого пользователя
$order_id = $_REQUEST['order_id'];
// Создание инструкции DELETE
$delete_query = sprintf("DELETE FROM `order` WHERE `order_id` = %d;",
$order_id);
// Удаление пользователя из базы данных
mysql_query($delete_query);
$ERR_DB = mysql_error() ;
if ($ERR_DB != NULL)
	handle_error($user_error_message, $ERR_DB);
// Перенаправление на show_orders для повторного показа пользователей
// (без удаленного пользователя)
$msg = "The order you specified has been deleted!";
header("Location: look_on_order1.php?success_message={$msg}");
exit();
?>