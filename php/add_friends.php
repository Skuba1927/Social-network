<?php 
include_once "php/function.php";
if (isset($_REQUEST['add_friend'])) {
	$q = "SELECT * FROM requests WHERE sender=".$_SESSION['id']." AND taker=".$_REQUEST['id'];
	$res = mysqli_query($link, $q) or die(mysqli_error($link));
	$result = mysqli_fetch_assoc($res);
	if (empty($result)) {
		$q = "INSERT INTO requests (sender, taker) VALUES (".$_SESSION['id'].", ".$_REQUEST['id'].")";
		mysqli_query($link, $q) or die(mysqli_error($link));
		unset($_REQUEST['add_friend']);
	}
}
if (isset($_REQUEST['cancel_f'])) {
	$q = "DELETE FROM requests WHERE sender=".$_SESSION['id']." AND taker=".$_REQUEST['id']; 
	mysqli_query($link, $q) or die(mysqli_error($link));
	unset($_REQUEST['cancel_f']);


}
if (isset($_REQUEST['delete_f'])) {
	$q = "DELETE FROM requests WHERE (sender='".$_SESSION['id']."' AND taker='".$_REQUEST['id']."') OR 
		(sender='".$_REQUEST['id']."' AND taker='".$_SESSION['id']."')";
	mysqli_query($link, $q) or die(mysqli_error($link));
	$q = "DELETE FROM friends WHERE (id1='".$_SESSION['id']."' AND id2='".$_REQUEST['id']."') OR 
		(id1='".$_REQUEST['id']."' AND id2='".$_SESSION['id']."')";
	mysqli_query($link, $q) or die(mysqli_error($link));
	unset($_REQUEST['delete_f']);

}
$q = "SELECT * FROM friends WHERE (id1='".$_SESSION['id']."' AND id2='".$_REQUEST['id']."') OR 
	(id1='".$_REQUEST['id']."' AND id2='".$_SESSION['id']."')";
$res = mysqli_query($link, $q) or die(mysqli_error($link));
$result = mysqli_fetch_assoc($res);
if (!empty($result)) {
	$add_f = 'is in the table friends';
} else {
	$q = "SELECT * FROM requests WHERE sender='".$_SESSION['id']."' AND taker='".$_REQUEST['id']."'";
	$res = mysqli_query($link, $q) or die(mysqli_error($link));
	$result = mysqli_fetch_assoc($res);
	if (empty($result)) {
		$add_f = "is not the tables";	
	} else {
		$add_f = 'is in the table requests';
	}
}


?>
<div id="add_friends">
	<form action="message.php?id=<?=$_REQUEST['id']?>" method="POST">
		<input type="submit" value="SEND MESSAGE" name="">
	</form>
	<p><form action="" method="POST">
		<input type="submit" 
		<?php
			if ($add_f == "is not the tables") {
			 echo "value='ADD AS FRIEND' name='add_friend'";
			} else if ($add_f == 'is in the table requests') {
				echo "value='CANCEL FILLING' name='cancel_f'";
			} else if ($add_f == 'is in the table friends') {
				echo "value='remove from friends' name='delete_f'";
			}
		?>>
	</form></p>
</div>