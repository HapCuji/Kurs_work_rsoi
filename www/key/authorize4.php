<?php
// require_once 'db_connection.php';
// require_once 'config.php';

 session_start();
 
   // Если не создан cookie-файл, проверять группы не нужно
 if (!isset($_SESSION['user_id'])) { //|| (!strlen($_SESSION['user_id']) > 0) || ($_SESSION['user_id'] == 0)
    header('Location: ../signin4.php?' .
           'error_message=You must login to see this page.');
    exit;
  }

// don't have
 $nach_ok = false;
 
/*  if ( $_SESSION['usergroup_id'] == 1) {
	 $nash = $_SESSION['usergroup_id'];
	 $select_query = "SELECT * FROM group WHERE group_id = " . $nash;
	 $result = mysql_query($select_query);
	 $row = mysql_fetch_array($result);
	 if ($row['name'] == $_SESSION['name']) {
		$nash_ok = true;
	 }
 }
 */

 
?>