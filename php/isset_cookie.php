<?php
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
			$_SESSION['name'] = $user['name'];
			$_SESSION['surname'] = $user['surname'];
			$_SESSION['email'] = $user['email'];
			$_SESSION['about_me'] = $user['about_me'];			
		} else {
		header ('Location: index.php');
		exit;
	}
	} else {
		header ('Location: index.php');
		exit;
	}
}
 ?>
