<?php
$class = 'indent';
include "php/head.php";
include "php/mysqli_connect.php";
include "php/function.php";
$error = "";


if (!empty($_REQUEST['login']) && !empty($_REQUEST['pass']) &&
	!empty($_REQUEST['pass_confirm']) && !empty($_REQUEST['name']) &&
	!empty($_REQUEST['surname']) && !empty($_REQUEST['email']) && !empty($_REQUEST['about_me'])) {
		if (coincidence($_REQUEST['login'])) {
			if (strlen($_REQUEST['login']) >= 4 && strlen($_REQUEST['login']) <= 12) {
				if (preg_match("/@/", $_REQUEST['email'])) {
					if (strlen($_REQUEST['about_me']) < 1000) {
						if ($_REQUEST['pass'] == $_REQUEST['pass_confirm']) {
							if (strlen($_REQUEST['pass']) >= 4 && strlen($_REQUEST['pass']) <= 8) {
								global $link;
								$pas = salt($_REQUEST['login'], $_REQUEST['pass']);
								$q = "INSERT INTO users (login, password, name, surname, email, about_me)
								VALUES ('".$_REQUEST['login']."', '".$pas."
								', '".$_REQUEST['name']."', '".$_REQUEST['surname']."', '".
								$_REQUEST['email']."', '".$_REQUEST['about_me']."')";
								$res = mysqli_query($link, $q);
								echo "<h3>Record successfully added.</h3>";
								echo "<p><a href='page.php'><input type='button' value='Next'></a></p>";
								exit;
							} else {
								$error = "pass";
								echo "<h3>Password must be from 6-8 characters</h3>";
							}
						} else {
							$error = "pass";
							echo "<h3>Password is incorrect.</h3>";
						}
					} else {
						$error = "about_me";
						echo "<h3>Text about yourself should not exceed 1000 characters.</h3>";
					}
				} else {
					$error = "email";
					echo "<h3>Email is incorrect.<h3>";
				}
			} else {
				$error = "log";
				echo "<h3>Login must be from 4-12 characters</h3>";
			}
		} else {
			$error = "log";
			echo "<h3>Name with such login already exists. Enter another.</h3>";
		}
	} else {
		echo "<h3>Fill in all the fields.</h3>";
		if (!isset($_REQUEST['login'])) $_REQUEST['login'] = '';
		if (!isset($_REQUEST['name'])) $_REQUEST['name'] = '';
		if (!isset($_REQUEST['surname']))$_REQUEST['surname'] = '';
		if (!isset($_REQUEST['email'])) $_REQUEST['email'] = '';
		if (!isset($_REQUEST['about_me'])) $_REQUEST['about_me'] = '';
	}
?>
<form action="" method="POST">
	<p><input type="text" name="login" 
		<?php isV($_REQUEST['login']);
			if ($error == "log") echo " class='active' ";
		?>>
	Login</p>
	<p><input type="password" name="pass"
		<?php if ($error == "pass") echo " class='active' "; ?>
	> Password</p>
	<p><input type="password" name="pass_confirm"
		<?php if ($error == "pass") echo " class='active' "; ?>
	> Confirm the password</p>
	<p><input type="text" name="name"<?=isV($_REQUEST['name'])?>> Name</p>
	<p><input type="text" name="surname"<?=isV($_REQUEST['surname'])?>> Surname</p>
	<p><input type="text" name="email"
		<?php isV($_REQUEST['email']);
			if ($error == "email") echo " class='active' ";
		?>> 
	Email</p>
	<p><textarea name="about_me" id="enter"
		<?php
		if ($error == "about_me") echo " class='active' ";
		?>><?php if(!empty($_REQUEST['about_me'])) echo  $_REQUEST['about_me']?></textarea> About me</p>
	<p><input type="submit" value="SEND">
	<a href="auth.php"><input class="aa" type="button" value="Entry"></a></p>
	</form>
</body>