<?php 
	session_start();
?>
<?php
unset($_SESSION['userName']);

session_destroy(); //destroy the session

header ("Location: hot.php?signedout=true");
?>