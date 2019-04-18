<?php
//header("Content-Type: text/html; charset=utf-8");
require_once 'config.php';
//require_once 'authorize4.php';

define("SUCCESS_MESSAGE", "success");
define("ERROR_MESSAGE", "error");

session_start();

function page_start($title, $javascript = NULL,
                    $success_message = NULL, $error_message = NULL) {

  display_head($title, $javascript);
  display_title($title, $success_message, $error_message);
}

function display_head($page_title = "ololo", $embedded_javascript = NULL) {
echo <<<EOD
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
 <head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link  rel="stylesheet" type="text/css" href="../css/phpMM.css"/>
	
	<title> {$page_title} </title>
	<!-- нужны библиотеки jquery, проверка и сss-->
EOD;
  if (!is_null($embedded_javascript)) {
    echo "
		<script type='text/javascript'>
		" .
         $embedded_javascript .
         "</script>";
  }
  echo " </head>
		  ";
}

//menu------------------------
function display_title($title, $success_message = NULL, $error_message = NULL)
{


display_messages($success_message, $error_message);
}

//-------------------
function display_messages($success_msg = NULL, $error_msg = NULL) {
  echo "<div id='messages'>\n";
  if (!is_null($success_msg) && (strlen($error_msg) > 0)) {
    display_message($success_msg, SUCCESS_MESSAGE);
  }
  if (!is_null($error_msg) && (strlen($error_msg) > 0)) {
    display_message($error_msg, ERROR_MESSAGE);
  }
  echo "</div>\n\n";
}

function display_message($msg, $msg_type) {
  echo " <div class='{$msg_type}'>\n";
  echo "  <p>{$msg}</p>\n";
  echo " </div>\n";
}

?>