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
				if (isset($_REQUEST['no_fr'])) {
					$q = "DELETE FROM requests WHERE sender=".$_REQUEST['idf'];
					mysqli_query($link, $q) or die(mysqli_error($link));
					unset ($_REQUEST['no_fr']);
				}
					$q = "SELECT * FROM friends WHERE id1=".$_SESSION['id']." OR id2=".$_SESSION['id'];
					$res = 	mysqli_query($link, $q) or die(mysqli_error($link));
					$r = mysqli_fetch_assoc($res);
					$count = mysqli_num_rows($res);
					for ($i=0; $i<$count; $i++) {
						if ($r['id1'] != $_SESSION['id']) {
							$arr[]= $r['id1'];
						} else {
							$arr[]= $r['id2'];
						}
					}
					foreach ($arr as $k => $id) {
						$q = "SELECT * FROM users WHERE id=".$id;
						$resault = mysqli_query($link, $q) or die(mysqli_error($link));
						$user_f = mysqli_fetch_assoc($resault);
						echo "<div id='friend'><a href=page.php?id=".$user_f['id'].">";
						include "php/photo.php";
						echo "</a><div id='info_f'>
								<p><a href=page.php?id=".$user_f['id'].">Login: ".$user_f['login']."</a></p>
								<p>".$user_f['name']." ".$user_f['surname']."</p>
								<p><form action='friends_requests.php?idf=".$user_f['id']."' method='POST'>
								<input type='submit' name='no_fr' value='DELETE'>
								</form></p>
							</div>";
						echo	"</div>";
					}
			?>
		</div>
		<div id="footer">by @Bogdan Skuba</div>
	</div>
</body>