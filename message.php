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
if (isset($_REQUEST['id'])) {
	include "php/messages_private.php";
} else {
	include "php/all_messages.php";
}
?>
			</div>
		<div id="footer">by @Bogdan Skuba</div>
	</div>
</body>