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
				if (isset($_REQUEST['add_fr'])) {
					$q = "INSERT INTO friends (id1, id2) VALUES (".$_SESSION['id'].", ".$_REQUEST['idf'];
					mysqli_query($link, $q) or die(mysqli_error($link));
					$q = "UPDATE requests SET accept=1 WHERE sender=".$_REQUEST['idf']." AND taker=".$_SESSION['id'];
					mysqli_query($link, $q) or die(mysqli_error($link));
					unset($_REQUEST['add_fr']);
				}
				$count_requests = number_of_applications($_SESSION['id']);
				if ($count_requests > 0) {
					$q = "SELECT sender FROM requests WHERE taker=".$_SESSION['id'];
					$res = 	mysqli_query($link, $q) or die(mysqli_error($link));
					$r = mysqli_fetch_assoc($res);
					foreach ($r as $k => $id) {
						$q = "SELECT * FROM users WHERE id=".$id;
						$resault = mysqli_query($link, $q) or die(mysqli_error($link));
						$user_f = mysqli_fetch_assoc($resault);
						echo "<div id='friend'>";
						include "php/photo.php";
						echo "<div id='info_f'>
								<p>.Login: ".$user_f['login']."</p>
								<p>.".$user_f['name']." ".$user_f['surname']."</p>
								<p><form action='friends_requests.php?idf=".$user_f['id']."' method='POST'>
								<input type='submit' name='add_fr' value='ADD'>
								<input type='submit' name='no_fr' value='DELETE'>
								</form></p>
							</div>";
						echo	"</div>";
					}
				} else {
					echo "<h3>You do not have any new friend requests</h3>";
				}
			?>
		</div>
		<div id="footer">by @Bogdan Skuba</div>
	</div>
</body>