<?php
include "php/mysqli_connect.php";
function update_users($n, $val, $id) {
		$q = "UPDATE users SET ".$n." = '".$val."' WHERE id=".$id;
		global $link;
		mysqli_query($link, $q) or die(mysqli_error($link));
		$q = "SELECT * FROM users WHERE id=".$id;
		$res = mysqli_query($link, $q) or die(mysqli_error($link));
		$user = mysqli_fetch_assoc($res);
		return $user["$n"];
}
$error = '';
if (!empty($_REQUEST['name'])) {
	$_SESSION['name'] = update_users('name', $_REQUEST['name'], $_SESSION['id']);
}
if (!empty($_REQUEST['surname'])) {
	$_SESSION['surname'] = update_users('surname', $_REQUEST['surname'], $_SESSION['id']);
}
if (!empty($_REQUEST['email'])) {
	if (preg_match("/@/", $_REQUEST['email'])) {
	$_SESSION['email'] = update_users('email', $_REQUEST['email'], $_SESSION['id']);
	} else {
		$error = "email";
	}
}
if (!empty($_REQUEST['about_me'])) {
	if (strlen($_REQUEST['about_me']) < 1000) {
	$_SESSION['about_me'] = update_users('about_me', $_REQUEST['about_me'], $_SESSION['id']);
	} else {
		$error = "about_me";
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
				<p><input type="text" name="name" value="<?=$_SESSION['name']?>"> Name</p>
				<p><input type="text" name="surname" value="<?=$_SESSION['surname']?>"> Surname</p>
				<?php if ($error == "email") echo "<p><span id='error'>Email is incorrect</span></p>"; ?>
				<p><input type="text" name="email" value="<?=$_SESSION['email']?>"> Email</p>
				<?php if ($error == 'about_me') echo "<p><span id='error'>Text about yourself should not exceed 1000 characters.</span></p>"; ?>
				<p><textarea id="enter"name="about_me"><?=$_SESSION['about_me']?></textarea> About me</p>
				<p><input type="submit" value="EDIT"></p>
			</form>
		</div>
		<div id="footer">by @Bogdan Skuba</div>
	</div>
</body>