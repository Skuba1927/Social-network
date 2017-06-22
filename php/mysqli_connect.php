<?php
$link = mysqli_connect('localhost', 'root', '', 'test') or die(mysqli_error($link));
mysqli_query($link, "SET NAMES 'utf8'");
session_start();
?>