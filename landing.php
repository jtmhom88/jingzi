<?php 
# $Id$
// session_start(); 
// if(isset($_SESSION['username']) && $_SESSION['password']) {
// 	# echo "You are logged in!<br>";
// } else {
// 	/* Redirect browser */
// 	header("Location: auth.php");
// }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="en-us" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>New Test Orgs</title>
<style type="text/css">

IMG.displayed {
    display: block;
    margin-left: auto;
    margin-right: auto 
}
</style>
</head>

<body>
<img class="displayed" src="cancun-20905.jpg" >
<div  align='center' style='color:#0000FF'>
<p>Welcome to Jingmei!</p>
<a href="http://<?php echo getenv(MYSQL_IP);?>:80/index.php">Update Test Orgs</a>
<br>
</div>

</body>
</html>