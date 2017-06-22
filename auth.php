<?php
$class = 'indent';
include "php/head.php";
if (!empty($_REQUEST['a_log']) && !empty($_REQUEST['a_pass'])) {
	$log = $_REQUEST['a_log'];
	$pass = $_REQUEST['a_pass'];
	include "php/mysqli_connect.php";
	include "php/function.php";
	$q = "SELECT * FROM users WHERE login='".$log."' AND password='".salt($log, $pass)."'";
	$res = mysqli_query($link, $q) or die(mysqli_error($link));
	$user = mysqli_fetch_assoc($res);
	if (!empty($user)) {
		$_SESSION['auth'] = true;
		$_SESSION['login'] = $log;
		$_SESSION['pass'] = $user['password'];
		$_SESSION['id'] = $user['id'];
		$_SESSION['name'] = $user['name'];
		$_SESSION['surname'] = $user['surname'];
		$_SESSION['email'] = $user['email'];
		$_SESSION['about_me'] = $user['about_me'];
		if (!empty($_REQUEST['remember']) && $_REQUEST['remember'] == 1) {
				$key = generateKey();
				setcookie('login', $user['login'], time()+3600*24*30);
				setcookie('key', $key, time()+3600*24*30);
				$q = "UPDATE users SET cookie='".$key."' WHERE login='".$user['login']."'";
				mysqli_query($link, $q) or die(mysqli_error($lint));
				unset($_REQUEST['remember']);
		}
		echo "<h3>Authorization was successful</h3>";
		echo "<p>Hello, ".$user['name']." ".$user['surname']."!";
		echo "<p><a href='page.php?id=".$user['id']."'><input type='button' value='Next'></a></p>";
		exit;
	} else {
		echo "<h3>Incorrect login or password</h3>";
	}	
} else {
	echo "<h3>Enter your details:</h3>";
}
?>
	<form action="" method="POST">
		<p><input type="text" name="a_log"> Login</p>
		<p><input type="password" name="a_pass"> Password</p>
		<p><input type="submit" value="SEND">
		<a href="index.php"><input type="button" value="Return to the main"></a></p>
		<p><input type="checkbox" value="1" name="remember" id="check">
		<label for="check"></label>Remember</p>
		
		
	</form>

</body>
</html>