<html >

<head>
<meta content="en-us" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Enter Sentiment Parameters</title>
<style type="text/css">
.auto-style1 {
	background-color: #FFFFFF;
	background: #FFFFFF;
	margin-left: 40px;
}
.auto-style2 {
	margin-left: 40px;
	color: #0000FF;
}
</style>

<script>
function myFunction() {
    location.reload();
}
</script>

</head>

<body>

<body>
<form class='auto-style2' method='post'>
<strong>Enter Sentiment Parameters</strong>
</form>

<?php
session_start(); 

error_reporting(E_ALL);
ini_set('display_errors', '1');
date_default_timezone_set('UTC');
$path = '/root/documentRoot';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

//include db configuration file
include_once("config.php");

$landing_url = "http://".$hostname."/landing.php";

echo "
<div class='auto-style1' >
	<div style='width=300px; float:left; '>
		<form action='sentreader.php' method='post'>
	";	
$today = date('Y-m-d');
echo "Date     :<input type='text' name='datepicker' id='datepicker' value='". $today."'>" ; 
echo "Relevancy:<input type='text' name='relevancy' id='relevancy' value=1>
      Crypto:<input type='text' name='crypto' id='crypto' value=0>
      Read:<input type='text' name='read' id='read' value=0>
      Scored:<input type='text' name='scored' id='scored' value=0>
			<br><br>
			<input type='submit' name='submit' value='Run Reader'> 
		</form>
	<br><br>
	<button onclick='myFunction()'>Reload page</button>
	<br><br>
	<a href='$landing_url'>Go Back to Landing Page</a>
	</div>
</div>
";


?>

</body>

</html>

