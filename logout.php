<?php
session_start();
if (!empty($_SESSION['auth']) && $_SESSION['auth']) {
	session_destroy();
	setcookie('login', '', time());
	setcookie('key', '', time());
}
header ('Location: index.php');
exit;
?>