<?php
include "php/mysqli_connect.php";
if (isset($_SESSION['auth']) && $_SESSION['auth'] == true ) {
			header ("Location:page.php?id=".$_SESSION['id']);
			exit;
}
if (!isset($_SESSION['auth']) || $_SESSION['auth'] == false ) {
	if (!empty($_COOKIE['login']) && !empty($_COOKIE['key'])) {
		$log = $_COOKIE['login'];
		$key = $_COOKIE['key'];
		$q = "SELECT * FROM users WHERE login='".$log."' AND cookie='".$key."'";
		$res = mysqli_query($link, $q) or die(mysqli_error($link));
		$user = mysqli_fetch_assoc($res);
		if(!empty($user)) {
			$_SESSION['auth'] = true;
			$_SESSION['id'] = $user['id'];
			$_SESSION['login'] = $user['login'];
			header ("Location:page.php?id=".$_SESSION['id']);
			exit;
		} 
	} 
}
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>Main</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="auth">
		<h2>Sign in or register</h2>
		<p>
			<a href="auth.php">
				<input type="button" value="Authorization">
			</a>
			<a href="registr.php">
				<input type="button"value="Registration">
			</a>
		</p>
	</div>
</body>
</html>