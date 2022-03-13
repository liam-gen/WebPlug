 <?php
session_start(); 
$_SESSION = array();
session_unset(); 
session_destroy(); 
?>
Destroy session ...
<meta http-equiv="refresh" content="0;url=login"/>