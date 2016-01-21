<!DOCTYPE html>

<html>

<head>

<link rel="stylesheet" href="css/style.css" type="text/css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script> -->

<script type="text/javascript">

$(document).ready(function() {
  console.log( "ready!" );
  // Make DataTable
  var url_table = $('#url_table').DataTable();
  var this_article_id = '-999';
  var this_article_line_no = '-999';
  var sentstate = 'NIRVANA';

  //$( "#datepicker" ).on('click', function() {
  //    $("#datepicker").datepicker();
  //});

  // Clear article_table
  function clearArticles() {
    $("#article_table > tbody").html("");
  }

  $('#url_table tbody').on( 'click', 'tr', function () {
      if ( $(this).hasClass('selected') ) {
          $(this).removeClass('selected');
      }
      else {
          url_table.$('tr.selected').removeClass('selected');
          $(this).addClass('selected');
      }
      $('tr').removeClass('highlighted');
      $(this).addClass('highlighted');
    });

  $('#article_table tbody').on( 'click', 'tr', function () {
      if ( $(this).hasClass('selected') ) {
        $(this).removeClass('selected');
      }
      else {
        $(this).removeClass('selected');
        $(this).addClass('selected');
      }
      $('tr').removeClass('highlighted');
      $(this).addClass('highlighted');
      $(this).addClass('selected');
      this_article_id=$(this).find('td:eq(1)').html();
      this_article_line_no=$(this).find('td:eq(2)').html();
      var this_sentiment_id = "sentstate" + this_article_line_no ;
      console.log(this_sentiment_id);
      var e = document.getElementById(this_sentiment_id);
      sentstate = e.options[e.selectedIndex].value;
      console.log(sentstate + ':' + this_article_id + ':' + this_article_line_no);
      //alert(sentstate + ':' + this_article_id + ':' + this_article_line_no);  
    });

  $('#button1').click(function () {
      // Toggle select a row
      if (url_table.row('.selected').data() !== undefined) {
        var rowdata = url_table.row('.selected').data();
      } else {
        alert("You must select a row!");
      }
      // Get the rowdata
      console.log(rowdata);
      var this_id = rowdata[0];
      var this_read_flag = "Read_flag"+this_id;
      console.log(this_read_flag);
      var flag_value = document.getElementById(this_read_flag).innerHTML;
      console.log(flag_value);
      document.getElementById(this_read_flag).innerHTML="1";

      var myjsonObject = {id:this_id, read_flag:"1"};
      console.log(myjsonObject);
      // Post request like url?key1=value1&key2=value2
      // use payload as the key and json string as a value
      var datapayload = "payload=" + JSON.stringify(myjsonObject);
      console.log(datapayload);
      
      // Ajax Mysql request
      jQuery.ajax({
        type: "POST", // HTTP method POST or GET
        url: "fetch_article.php", //Where to make Ajax calls
        dataType:"text",
        data: datapayload,
        success:function(response){
          clearArticles();
          $("#article_table >tbody:first").append(response);
          //alert(response);
          //alert("Fetch success");
          //console.log(response);
          console.log('Fetch success');
        },
        error:function (xhr, ajaxOptions, thrownError){
          //On error, we alert user
          alert(thrownError);
        }
      });

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

  $('#button2').click(function() {
    if ( $('#article_table tr').hasClass('selected') ) {
      if (sentstate == 'none') {
        alert('Please select a Sentiment state from dropdown')
      } else {
        //alert(sentstate + ':' + this_article_id + ':' + this_article_line_no);
        var myjsonObject = {article_id:this_article_id, article_line_no:this_article_line_no, sentiment:sentstate};
        console.log(myjsonObject);
        // Post request like url?key1=value1&key2=value2
        // use payload as the key and json string as a value
        var datapayload = "payload=" + JSON.stringify(myjsonObject);
        console.log(datapayload);

        // Ajax Mysql request
        jQuery.ajax({
          type: "POST", // HTTP method POST or GET
          url: "update_table.php", //Where to make Ajax calls
          dataType:"text",
          data: datapayload,
          success:function(response){
            //alert(response);
            //alert("Update success");
            console.log('Update success');
          },
          error:function (xhr, ajaxOptions, thrownError){
            //On error, we alert user
            alert(thrownError);
          }
        });
      }
    } else {
      alert('Please select article_table row selected');
    }
  });

  $('#button3').click(function() {
    clearArticles();
  });

});
</script>

</head>

<body>

<p>Date: <input type="text" id="datepicker" value="<?php echo date('Y-m-d'); ?>" ></p>
<div class= 'controlbuttons'>
<input id="Logout" type="button" value="Logout" /> <br><br>
<button id="button1">Fetch</button><br><br>
<button id="button2">Update</button><br><br>
<button id="button3">Clear</button><br><br>
</div>


<ul id="responds"></ul>

<?php
session_start(); 

error_reporting(E_ALL);
ini_set('display_errors', '1');

$path = '/root/documentRoot';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

//include db configuration file
include_once("config.php");
$this_table='article_urls';

$sql = "SELECT idx, url, title, datasource, read_flag, DATE(dt_modified) as mydate FROM $databasename.$this_table where read_flag=0 and DATE(dt_modified)=CURDATE() limit 2000";
$result = $conn->query($sql);

// Display Table
echo "<table class= 'url_table' border='1' id='url_table' >\n";
echo "<thead>";
echo "<tr>";
echo "<th>Id</th>";
echo "<th>Url</th>";
echo "<th>Title</th>";
echo "<th>Source</th>";
echo "<th>Read</th>";
echo "<th>Date</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

$line_id=0;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $line_id=$row["idx"];
        //$line_id++;
        #echo "id: " . $row["id"]. " - Name: " . $row["content"]. " " . "<br>";
        echo "<tr>";
        echo "<td class='ID' id='ID$line_id'>" . $row["idx"] . "</td>";
        //echo "<td class='Url' id='Url$line_id'>" . $row["url"] . "<a href='" . $row["url"] . "'a> </td>";
        //echo "<td class='Url' id='Url$line_id'> <a href='http://www.google.com/'>Cell 1</a></td>";
        $url_trunc = substr($row['url'], 0, 80);
        echo "<td class='Url' id='Url$line_id'> <a href='" . $row["url"] . "'>" . $url_trunc . "</a></td>";
        $title_trunc = substr($row['title'], 0, 60);
        echo "<td class='Title' id='Title$line_id'>" . $title_trunc . "</td>";
        echo "<td class='Datasource' id='Datasource$line_id'>" . $row["datasource"] . "</td>";        
        echo "<td class='Read_flag' id='Read_flag$line_id'>" . $row["read_flag"] . "</td>";
        echo "<td class='Date' id='Date$line_id'>" . $row["mydate"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "0 results";
}
echo "</tbody>";


$conn->close();

$picked="state$line_id";

?>

<table class= 'article_table' border='1' id='article_table' >
<thead>
<tr>
<th>Sentiment</th>
<th>Id</th>
<th>Line</th>
<th>Article Text</th>
</tr>
</thead>
<tbody>
<tr><td>Euphoria</td><td>999</td><td>0</td><td>Mary Had a Little Lamb</td><tr>
</tbody>
</table>


</body>


</html>
