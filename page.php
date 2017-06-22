<?php
include "php/mysqli_connect.php";
include "php/isset_cookie.php";
include "php/function.php";
if (!empty($_REQUEST['text_news'])) {
	$q = "INSERT INTO news (id, login, text) VALUES ('".$_SESSION['id']."', '".
	$_SESSION['login']."', '".$_REQUEST['text_news']."')";
	mysqli_query($link, $q) or die(mysqli_error($link));
	header ('Location: page.php?id='.$_SESSION['id']);
	exit;
}
$class = 'pages';
include "php/head.php";
?>
	<div class="main">
		<?php 
			include "php/header.php";
		?>
		<div id="content">
		<?php
			if (!empty($_REQUEST['id'])) {
				$q = "SELECT * FROM users WHERE id =".$_REQUEST['id'];
				$res = mysqli_query($link, $q) or die(mysqli_error($link));
				$user = mysqli_fetch_assoc($res);
				$name = $user['name'];
				$surname = $user['surname'];
				$email = $user['email'];
				$about_me = $user['about_me'];
			}
			include "php/photo.php";
			if ($_SESSION['id'] != $_REQUEST['id']) {
				include "php/add_friends.php";
			}
		?>
			<div id="info">
				<p><h4>
					<?php echo $name." ".$surname;?>
				</h4></p>
				<p>
					email: <?php echo $email ?>
				</p>
				<p>About me: <?php echo $about_me ?></p>
			</div>
			<div id="news">
				<div>
				<form action="" method="POST">
					<textarea name="text_news" placeholder="Anything new?"></textarea>
					<input type="submit" value="SEND">
				</form></div>
				<div class="news">
					<?php
						$q = "SELECT * FROM news WHERE id='".$_REQUEST['id']."' 
						ORDER BY date DESC";
						$res = mysqli_query($link, $q);
						if (!empty($res)) {
						for ($array = []; $row = mysqli_fetch_assoc($res); $array[]=$row);
						
						foreach ($array as $val) {
							echo "<div class='show'><p><span class='date'>".$val['date']."
							</span></p>";
							echo "<p>".$val['text']."</p></div>";
						}
						} else {
							echo "There are no entries yet";
						}
					?>
				</div>
			</div>
		</div>
		<div id="footer">by @Bogdan Skuba</div>
	</div>
</body>