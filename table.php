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

$sent_ary = array('none','joy','joy_contentment','contentment','contentment_hope','hope','hope_fear', 'fear',
	'fear_despair','despair' ,'despair_apathy','apathy','apathy_caution' ,'caution','caution_greed' ,'greed', 'greed_joy'
);
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
$line_id=1234;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	#echo "id: " . $row["id"]. " - Name: " . $row["content"]. " " . "<br>";
			echo "<tr>";
			echo "<td>" . $row["id"] . "</td>";
			echo "<td>" . $row["content"] . "</td>";
			echo '<TD class = "line_sentiment_state">
			  <div class="stock_score_picker">
			  	<span class="line_is_sentiment_label" style= "color: black;">S:</span>
	        <select class="stock_score_picker htm_edit" name="$line_id">        
	                <option value="joy">Joy</option>
	                <option value="despair">Despair</option>
	        </select>
        <TD ALIGN="center"></TD>';
     	echo "</tr>";
    }
} else {
    echo "0 results";
}
echo "</div>";

$conn->close();

?>