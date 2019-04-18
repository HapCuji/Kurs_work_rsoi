<?php
// Установка режима отладки
define("DEBUG_MODE", true);
// Корневой каталог сайта
define("SITE_ROOT", "");
// Константы подключения к базе данных 'config.php'
define("DATABASE_HOST", "localhost");
define("DATABASE_USERNAME", "vovan");
define("DATABASE_PASSWORD", "1234");
define("DATABASE_NAME", "kobetskiy");

define("SCHEMA_AUTH_NAME", "sch_auth");
define("SCHEMA_COMM_NAME", "sch_comment");
define("SCHEMA_TECH_NAME", "sch_tech");
define("SCHEMA_ORDER_NAME", "sch_order");
define("SCHEMA_CONTENT_NAME", "sch_order");
  
define('GATEWAY_URL', 'http://sever.agregator/');
define('AUTH_URL', 'http://sever.user/');
define('COMMENT_URL', 'http://sever.comment/');
define('ORDER_URL', 'http://sever.order/');
//define('TECH_URL', 'http://sever.tech/');



// Выдача отчетов об ошибках
if (DEBUG_MODE) { error_reporting(E_ALL& ~E_NOTICE);} else {
// Выключение выдачи отчетов об ошибках 
error_reporting(0);}

function debug_print($message) { if (DEBUG_MODE) {echo $message;}  }

function handle_error($user_error_message, $system_error_message) {
  session_start();
  $_SESSION['error_message'] = $user_error_message;
  $_SESSION['system_error_message'] = $system_error_message;
  header("Location: " . get_web_path(SITE_ROOT) . "key/show_error.php?error_message={$user_error_message}&system_error_message={$system_error_message}");
  //header("Location: " . get_web_path(SITE_ROOT) . "key/show_error.php");
  exit();
}

function get_web_path($file_system_path) {
  return str_replace($_SERVER['DOCUMENT_ROOT'], '', $file_system_path);
  $main_part =  str_replace('/home/mysite.ru/www', '', $file_system_path);
  $full = "{$main_part}";
  return $full;
}

?>