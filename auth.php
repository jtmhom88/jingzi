
<html>
<head>
<meta content="en-us" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Authentication Page</title>
</head>

<body>
<form method='post' >
User Name:&nbsp;&nbsp;<input name='Username1' type='test' title='Username' />
<br>
Password:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name='Password1' type='password' title='Password' />
<br>
<input type='submit' name='submit1' value='Login'>
</form>


<?php

#error_reporting(E_ALL);
#ini_set('display_errors', '1');
session_start(); 

$path = '/root/documentRoot';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

$hostname =  $_SERVER['MYSQL_IP'];

$username = $_POST['Username1'];
$password = $_POST['Password1'];
// store session data
$_SESSION['Username1']=$username;
$_SESSION['Password1']=$password;
#print_r($_SESSION);

# get server
$databasename = 'sentiment';

if(isset($_SESSION['Username1']) && $_SESSION['Password1']) {
	$conn = new mysqli($hostname, $username, $password, $databasename, 3306);
	if ($conn->connect_errno) {
    	echo "<font size='3' color='red'><strong>Failed to connect to MySQL: (" . $conn->connect_errno . ") </strong></font>" . $conn->connect_error;
	} else {
		# Set Connection Session Variable
		echo "<font size='3' color='green'><strong>LOGIN SUCCESS!</strong></font>";
		$landing_url = "http://" . $hostname . ":80/landing.php";
		/* redirect back to landing page */
		echo "<meta http-equiv='refresh' content='1;url=$landing_url'>";
	}
}
//$conn->close();

?>

</body>

</html>
