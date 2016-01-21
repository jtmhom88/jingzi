
<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$path = '/root/documentRoot';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

//include db configuration file
include_once("config.php");

$ary = json_decode($_POST['payload'], true);

$url_table = "article_urls";

if(isset($ary['id']) )
{
	// Update the table
	//echo "We can update<br>";
	$id = filter_var($ary['id'],FILTER_SANITIZE_STRING);
	// Update sanitize string in record
	$this_sql = "UPDATE IGNORE $databasename.$url_table set read_flag=1 where idx=".$id." ";
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

	// Get the article
	$article_table = "article_lines";
	$this_sql2 = "SELECT article_idx, article_line_no, article_text from $databasename.$article_table where  article_idx=".$id." order by article_line_no asc";
	//echo "$this_sql2 <br>";
	$result = $conn->query($this_sql2);


	if ($result->num_rows > 0) {
		// output data of each row
	    while($row = $result->fetch_assoc()) {
			$article_idx=$row["article_idx"];
			$article_line_no=$row["article_line_no"];
			$article_text=$row["article_text"];
			//echo "<tr><td>$article_idx</td> <td>$article_line_no</td> <td>$article_text</td> </tr>";
			echo "<tr>";
			echo "<TD class = 'Sentiment' id='Sentiment$article_line_no' >
				<div class= 'stock_score_picker'>
				<select class='stock_score_picker' name='sentstate$article_line_no' id='sentstate$article_line_no'>
				<option value='none'>None</option>
				<option value='joy'>Joy</option>
				<option value='joy_contentment'>Joy/Contentment</option>
				<option value='contentment'>Contentment</option>
				<option value='contentment_hope'>Contentment/Hope</option>
				<option value='hope'>Hope</option>
				<option value='hope_fear'>Hope/Fear</option>
				<option value='fear'>Fear</option>
				<option value='fear_despair'>Fear/Despair</option>
				<option value='despair'>Despair</option>
				<option value='despair_apathy'>Despair/Apathy</option>
				<option value='apathy'>Apathy</option>
				<option value='apathy_caution'>Apathy/Caution</option>
				<option value='caution'>Caution</option>
				<option value='caution_greed'>Caution/Greed</option>
				<option value='greed'>Greed</option>
				<option value='greed_joy'>Greed/Joy</option>
				</select>
				</div>
            </TD>";
			echo "<td class='IDX' id='IDX$article_line_no'>" . $article_idx . "</td>";
			echo "<td class='Line_no' id='Line_no$article_line_no'>" . $article_line_no . "</td>";
			echo "<td class='Text' id='Text$article_line_no'>" . $article_text . "</td>";
			echo "</tr>";
     	}

    } else {
     	echo "0 results";
    }


} else {
	echo "Unable to update mysql table $databasename.$this_table ";
	echo "<BR>";
};

?>
