<?php
// require 'key/db_connection.php'
require 'config.php';



// $conn = mysql_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD)
// or handle_error("возникла проблема, связанная с подключением к базе данных, " .
// "содержащей нужную информацию.",
// mysql_error());
// mysql_set_charset('utf8',$conn);


// mysql_select_db(DATABASE_NAME)
// or handle_error("возникла проблема с конфигурацией нашей базы данных.", mysql_error());

if (!($conn = mysql_connect(DATABASE_HOST,
	DATABASE_USERNAME, DATABASE_PASSWORD))) {
		$user_error_message = "возникла проблема, связанная с подключением к базе данных, содержащей нужную информацию.";
		handle_error($user_error_message, mysql_error());
		exit();
} 
else
{
	mysql_select_db(DATABASE_NAME)
		or handle_error("возникла проблема с конфигурацией нашей базы данных.", mysql_error());
	mysql_set_charset('utf8',$conn);

}
?>