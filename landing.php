<?php 
# $Id$

error_reporting(E_ALL);
ini_set('display_errors', '1');

$path = '/root/documentRoot';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

session_start(); 
if(isset($_SESSION['username']) && $_SESSION['password']) {
	# echo "You are logged in!<br>";
} else {
	/* Redirect browser */
	header("Location: auth.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="en-us" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Jing Mei!</title>
<style type="text/css">

IMG.displayed {
    display: block;
    margin-left: auto;
    margin-right: auto 
}
</style>
</head>

<body>
<img class="displayed" src="jingmei.jpg" >
<div  align='center' style='color:#0000FF'>
<p>Welcome to Jingmei!</p>
<a href="http://<?php echo $_SERVER['MYSQL_IP'];?>:80/table.php">table example</a>
<br>
<a href="http://<?php echo $_SERVER['MYSQL_IP'];?>:80/select.php">select tag example</a>
<br>
</div>

</body>
</html>