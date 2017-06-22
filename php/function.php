<?php
function isV($name) {
	if (!empty($name) && $name != '') {
		echo "value = '".$name."'";
	}
}
function salt($l, $p) {
	$p = md5(md5($l).md5($p));
	return $p;
}
function coincidence($log) {
	global $link;
	$q = "SELECT * FROM users WHERE login='".$log."'";
	$res = mysqli_query($link, $q);
	$user = mysqli_fetch_assoc($res);
	if ($user != NULL) {
		return false;
	} else {
		return true;
	}
}
function generateKey() {
	for ($i=1, $a = ''; $i<=6; $i++) {
		$a .= chr(mt_rand(97, 122));
	}
	return $a;
}
function number_of_applications($taker) {
	global $link;
	$q = "SELECT * FROM requests WHERE taker=".$taker." AND accept=0";
	$res = mysqli_query($link, $q) or die(mysqli_error($link));
	$r = mysqli_num_rows($res);
	return $r;
}
function give_login ($id) {
	global $link;
	$q = "SELECT * FROM users WHERE id=".$id;
	$res = mysqli_query($link, $q);
	$login = mysqli_fetch_assoc($res);
	$log = $login['login'];
	return $log;
}

?>