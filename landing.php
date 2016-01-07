<?php 
# $Id$

error_reporting(E_ALL);
ini_set('display_errors', '1');

$path = '/root/documentRoot';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

session_start(); 

if(isset($_SESSION['Username1']) && $_SESSION['Password1']) {
	echo "You are logged in!<br>";
} else {
	/* Redirect browser */
	header("Location: auth.php");
}

include_once("config.php");
if (isset($conn))
{
	echo "YAYY";
} else {
	echo "YUUUK";
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

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

	//##### send add record Ajax request to response.php #########
	$("#Logout").click(function (e) {
		alert("Logging Out");
			//var myData = 'content_txt='+ $("#contentText").val(); //build a post data structure
			var myData = '1';
			jQuery.ajax({
			type: "POST", // HTTP method POST or GET
			url: "logout.php", //Where to make Ajax calls
			dataType:"text", // Data type, HTML, json etc.
			data:myData, //Form variables
			success:function(response){
				alert("Successfully Logged Out");
				window.location.href = 'auth.php' ;
			},
			error:function (xhr, ajaxOptions, thrownError){
				alert(thrownError);
			}
			});
	});

});
</script>


</head>

<body>

<div align="right">
<input id="Logout" type="button" value="Logout" />
</div>

<img class="displayed" src="jingmei.jpg" >
<div  align='center' style='color:#0000FF'>
<p>Welcome to Jingmei!</p>
<a href="http://<?php echo $_SERVER['MYSQL_IP'];?>:80/table.php">table example</a>
<br>
<a href="http://<?php echo $_SERVER['MYSQL_IP'];?>:80/select.php">select tag example</a>
<br>
<a href="http://<?php echo $_SERVER['MYSQL_IP'];?>:80/onclick.php">on click example</a>
<br>
<a href="http://<?php echo $_SERVER['MYSQL_IP'];?>:80/sentreader.php">Sentiment Reader</a>
<br>
</div>

</body>
</html>