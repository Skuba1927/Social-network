<?php 
$q = "UPDATE messages SET value=1 WHERE sender=".$_REQUEST['id']." AND taker = ".$_SESSION['id'];
 mysqli_query($link, $q) or die (mysqli_error($link));
 if (isset($_REQUEST['new_message'])) {
	 $q = "INSERT INTO messages (sender, taker, message) VALUES 
	 ('".$_SESSION['id']."', '".$_REQUEST['id']."', '".$_REQUEST['new_message']."')";
	  mysqli_query($link, $q) or die (mysqli_error($link));
	header ('Location: message.php?id='.$_REQUEST['id']);
	exit;
 }
?>
<div id="write_message">
	<form action = "" method="POST">
		<p><textarea name="new_message" placeholder="Write new message" rows="8" autofocus=""></textarea></p>
		<input type="submit" value="SEND<?php echo " to ".strtoupper(give_login($_REQUEST['id']));?>">
	</form>
</div>
<div id="all_messages">
	<?php
		$q = "SELECT * FROM messages WHERE ( sender = ".$_SESSION['id']." AND taker = ".$_REQUEST['id'].") OR 
		( sender = ".$_REQUEST['id']." AND taker = ".$_SESSION['id'].")
		ORDER BY date DESC";
		$res = mysqli_query($link, $q) or die (mysqli_error($link));
		$row = mysqli_fetch_assoc($res);
		if (!empty($row)) {
		for ($array = []; $row = mysqli_fetch_assoc($res); $array[]=$row);				
		foreach ($array as $val) {
			echo "<div class='show'><p><span class='date'>".give_login($val['sender'])." </span>
			<span class='date'>".$val['date']."</span></p>";
			echo "<p>".$val['message']."</p></div>";
				}
			} else {
				echo "<h4>You do not have messages yet</h4>";
			}
	?>
</div>
