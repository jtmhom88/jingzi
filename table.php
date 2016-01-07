<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="en-us" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Jing Mei Table</title>
<style type="text/css">

IMG.displayed {
    display: block;
    margin-left: auto;
    margin-right: auto 
}
</style>
</head>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

<body>

<?php
session_start(); 

error_reporting(E_ALL);
ini_set('display_errors', '1');

# get server
$hostname =  $_SERVER['MYSQL_IP'];
$databasename = 'sentiment';

if(isset($_SESSION['username']) && $_SESSION['password']) {
	$conn = new mysqli($hostname, $_SESSION['username'], $_SESSION['password'], $databasename, 3306);
	if ($conn->connect_errno) {
    	echo "<font size='3' color='red'><strong>Failed to connect to MySQL: (" . $conn->connect_errno . ") </strong></font>" . $conn->connect_error;
	}
} else {
	echo "<font size='3' color='red'><strong>You are NOT logged in!</strong></font>";
}

// $sent_ary = array('none','joy','joy_contentment','contentment','contentment_hope','hope','hope_fear', 'fear',
// 	'fear_despair','despair' ,'despair_apathy','apathy','apathy_caution' ,'caution','caution_greed' ,'greed', 'greed_joy'
// );

## Function
function sentiment_dropdown($ary){
	echo "<select>";
	foreach ($ary as $value) {
	 echo "<option value='$value'>$value</option>";
	};
	echo "</select>";
};

$sql = "SELECT id, content FROM sentiment.add_delete_record";
$result = $conn->query($sql);

echo "<div style='height: 210px; width: 350px; overflow: auto'>";
echo "<table border='1' >\n";
$line_id=0;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$line_id=$row["id"];
    	#echo "id: " . $row["id"]. " - Name: " . $row["content"]. " " . "<br>";
			echo "<tr>";
			echo "<td>" . $row["id"] . "</td>";
			echo "<td>" . $row["content"] . "</td>";
			echo '<TD class = "line_sentiment_state">
			  <div class="stock_score_picker">
			  	<span class="line_is_sentiment_label" style= "color: black;">S:</span>
	        <select class="stock_score_picker htm_edit" name="state$line_id" id="state$line_id">        
						<option value="none">None</option>
						<option value="joy">Joy</option>
						<option value="joy_contentment">Joy/Contentment</option>
						<option value="contentment">Contentment</option>
						<option value="contentment_hope">Contentment/Hope</option>
						<option value="hope">Hope</option>
						<option value="hope_fear">Hope/Fear</option>
						<option value="fear">Fear</option>
						<option value="fear_despair">Fear/Despair</option>
						<option value="despair">Despair</option>
						<option value="despair_apathy">Despair/Apathy</option>
						<option value="apathy">Apathy</option>
						<option value="apathy_caution">Apathy/Caution</option>
						<option value="caution">Caution</option>
						<option value="caution_greed">Caution/Greed</option>
						<option value="greed">Greed</option>
						<option value="greed_joy">Greed/Joy</option>
	        </select>
	        </div>
        </TD>';
     	echo "</tr>";
    }
} else {
    echo "0 results";
}
echo "</div>";

$conn->close();

$picked="state$line_id";

echo <<<EOD
<script type="text/javascript">
	$(document).ready( function() {
		$("#basic_button").click( function() {
			alert("Please enter some text! $picked");
		});
	});
</script>
EOD;

?>

<p>
<input id="basic_button" type="button" value="Show Basic Alert" />
</p>

</body>
</html>
