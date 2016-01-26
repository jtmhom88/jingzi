<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start(); 

$path = '/root/documentRoot';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

$hostname =  $_SERVER['MYSQL_IP'];
$databasename = "sentiment";

//Logged in

if (isset($_SESSION['Username1']) && isset($_SESSION['Password1'])) {
	$conn = new mysqli($hostname, $_SESSION['Username1'], $_SESSION['Password1'], $databasename, 3306);
	if ($conn->connect_errno) {
		echo "<font size='3' color='red'><strong>Failed to connect to MySQL: (" . $conn->connect_errno . ") </strong></font>" . $conn->connect_error;
	} else {
		mysqli_set_charset($conn,"utf8");
		//echo "config: You are connected.";
	}
}
else 
//Log in
{
	/* Redirect browser */
	header("Location: auth.php");
}


?>