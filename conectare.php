<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$db = 'proiect1';

$mysqli = new mysqli($hostname, $username, $password, $db);

if ($mysqli->connect_error) {
	die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
?>