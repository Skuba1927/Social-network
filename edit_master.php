<?php
include "php/mysqli_connect.php";
include "php/function.php";
$error = '';
$absent = 0;
$good_l = '';
$good_p = '';
if (isset($_REQUEST['pass_old'])) {
if (salt($_SESSION['login'],$_REQUEST['pass_old']) == $_SESSION['pass']) {
	if (isset($_REQUEST['login'])) {
		if ($_REQUEST['login'] != $_SESSION['login']) {
		if (!empty($_REQUEST['login'])) {
			if (coincidence($_REQUEST['login'])) {
				if (strlen($_REQUEST['login']) >= 4 && strlen($_REQUEST['login']) <= 12) {
				$q = "UPDATE users SET login='".$_REQUEST['login']."' WHERE id=".$_SESSION['id'];
				mysqli_query($link, $q) or die(mysqli_error($link));
				$q = "SELECT * FROM users WHERE id=".$_SESSION['id'];
				$res = mysqli_query($link, $q) or die(mysqli_error($link));
				$user = mysqli_fetch_assoc($res);
				$_SESSION['login'] = $user['login'];
				$q = "UPDATE users SET password='".salt($_SESSION['login'], $_SESSION['pass'])."' WHERE id=".$_SESSION['id'];
				$good_l =  "good_l";
			} else {
				$error = "log_ch";
			}
		} else {
			$error = "log_unique";
		}
	}
	}
	}
	if (isset($_REQUEST['pass1']) && isset($_REQUEST['pass1'])) {
	if (!empty($_REQUEST['pass1']) || !empty($_REQUEST['pass2'])) {
		if (!empty($_REQUEST['pass1']) && !empty($_REQUEST['pass2'])) {
			if ($_REQUEST['pass1'] == $_REQUEST['pass2']) {
				if (strlen($_REQUEST['pass1']) >= 4 && strlen($_REQUEST['pass1']) <= 8) {
					$pas = salt($_REQUEST['login'], $_REQUEST['pass1']);
					$q = "UPDATE users SET password='".$pas."' WHERE id=".$_SESSION['id'];
					mysqli_query($link, $q) or die(mysqli_error($link));
					$q = "SELECT * FROM users WHERE id=".$_SESSION['id'];
					$res = mysqli_query($link, $q) or die(mysqli_error($link));
					$user = mysqli_fetch_assoc($res);
					$_SESSION['pass'] = $user['password'];
					$good_p =  "good_p";
				} else {
					$error = "pass";
				}
			} else {
				$error = "pass_not_equal";
			}
		} else {
			if (empty($_REQUEST['pass1'])) $absent = 1;
			if (empty($_REQUEST['pass2'])) $absent = 2;
		}
	}
	}
} else {
	$error = 'pass_er';
}
}
include "php/isset_cookie.php";
$class = 'pages';
include "php/head.php";
?>
	<div class="main">
		<?php 
			include "php/header.php";
		?>
		<div id="content">
			<form action="" method="POST">
			<p><input type="text" name="login" value="<?=$_SESSION['login']?>" 
				<?php if ($error == "log_ch" ||  $error == "log_unique") echo " class='active' "; ?>> Login</p>
				<?php if ($error == "log_ch") echo "<p><span id='error'>Login must be from 4-12 characters</span></p>"; 
				if ($error == "log_unique") echo "<p><span id='error'>Name with such login already exists. Enter another.</span></p>";
				if ($good_l == "good_l") echo "<p><span>Login successfully changed.</span></p>";
				?>
			<p><input type="password" name="pass_old" <?php if ($error == "pass_er") echo " class='active' ";?>>
				 Old password</p>
				<?php if ($error == "pass_er") echo "<p><span id='error'>Incorrect password</span></p>"; ?>
			<p><input type="password" name="pass1" 
				<?php if ($absent > 0 || $error == "pass_not_equal" || $error == "pass") echo " class='active' "; ?>> New password</p>
				<?php if ($absent == 1) echo "<p><span id='error'>Enter password</span></p>";
				if ($error == "pass_not_equal") echo "<p><span id='error'>Password is incorrect.</span></p>";?>
			<p><input type="password" name="pass2" 
				<?php if ($absent > 0 || $error == "pass_not_equal" || $error == "pass") echo " class='active' "; ?>> Config new password</p>
				<?php if ($absent == 2) echo "<p><span id='error'>Enter password</span></p>"; 
				if ($error == "pass_not_equal") echo "<p><span id='error'>Password is incorrect.</span></p>";
				if ( $error == "pass") echo "<p><span id='error'>Password must be from 6-8 characters</span></p>";
				if ($good_p == 'good_p') echo "<p><span>Password successfully changed.</span></p>"; ?>
				<p><input type="submit" value="EDIT"></p>
			</form>
		</div>
	<div id="footer">by @Bogdan Skuba</div>
</div>
</body>	
				




				
