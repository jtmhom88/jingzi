
<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$path = '/root/documentRoot';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

//include db configuration file
include_once("config.php");

$ary = json_decode($_POST['payload'], true);

$articles_table = "article_lines";

$urls_table = "article_urls";

if(isset($ary['article_id']) && isset($ary['article_line_no']) )
{
	// Update the table
	//echo "We can update<br>";
	$id = filter_var($ary['article_id'],FILTER_SANITIZE_STRING);
	$line_no = filter_var($ary['article_line_no'],FILTER_SANITIZE_STRING);
	$sentiment = filter_var($ary['sentiment'],FILTER_SANITIZE_STRING);
	
	// Update sanitize string in record
	$this_sql = "UPDATE IGNORE $databasename.$articles_table set stock_sentiment='".$sentiment."' where article_idx=".$id." and article_line_no=".$line_no." ";
	//echo "$this_sql <br>";
	if ($conn->query($this_sql) === TRUE) {
	    //echo "Record updated successfully";
	    header("HTTP/1.1 200 OK");
	} else {
	    //echo "Error updating record: " . $conn->error;
	    header('HTTP/1.1 500 Could not update mysql!');
	}
	// Commit transaction
	mysqli_commit($conn);

	// Update sanitize string in record
	$this_sql = "UPDATE IGNORE $databasename.$urls_table set scored_flag=1 where idx=".$id." ";
	//echo "$this_sql <br>";
	if ($conn->query($this_sql) === TRUE) {
	    //echo "Record updated successfully";
	    header("HTTP/1.1 200 OK");
	} else {
	    //echo "Error updating record: " . $conn->error;
	    header('HTTP/1.1 500 Could not update mysql!');
	}
	// Commit transaction
	mysqli_commit($conn);


} else {
	echo "Unable to update mysql table $databasename.$this_table ";
	echo "<BR>";
};

?>
