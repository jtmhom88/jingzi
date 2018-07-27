<!DOCTYPE html>

<html>

<head>

<link rel="stylesheet" href="css/style.css" type="text/css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/sl-1.2.4/datatables.min.js"></script>
<!--<script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script> -->
<!--<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script> -->

<script type="text/javascript">

function reloadFunction() {
    location.reload();
};

$(document).ready(function() {
  console.log( "ready!" );
  // Make DataTable
  var url_table = $('#url_table').DataTable( {
  "lengthMenu": [ 25, 50, 100 ]
  }
  );
  var this_article_id = '-999';
  var this_article_line_no = '-999';
  var sentstate = 'NIRVANA';


  //------------------------------------------------------------
  // jQuery for arrow keys and editing idea from here:
  var currRow = $('tr').first();

  // Clear article_table
  function clearArticles() {
    $("#article_table > tbody").html("");
  }

  // Clear url_table
  function clearUrls() {
    $("#url_table > tbody").html("");
  }

  // User navigates table using keyboard
  $('#url_table tbody tr').keydown(function (e) {

    var pageLength = url_table.page.len();
    //alert("pageLength-->"+pageLength);
    if (e.which == 38) {
      // Up Arrow
      // Get current prev and next rows
      //alert( 'Row index: '+ url_table.row( this ).index() );
      
      //Set the index based on the row that was clicked
      var CurItemIndex = url_table.row( this ).index();
      //Get the indexes 
      var CurTableIndexs = url_table.rows().indexes();
      var CountIndexes = CurTableIndexs.length;
      //alert( 'Rows Count-->> '+CountIndexes);
      // Get the array key for the current index we have
      var CurIndexArrayKey = CurTableIndexs.indexOf( CurItemIndex );
      //alert( 'Row CurIndexArrayKey: '+ CurIndexArrayKey );
      // Subtract 1 to the array key to get the prior index number
      // if top row, default to same top row
      var PrevItemIndex = (CurIndexArrayKey > 0 ) ? CurTableIndexs[ CurIndexArrayKey - 1] : CurTableIndexs[0] ;
      //alert( 'Row PrevItemIndex: '+ PrevItemIndex );
      // Add 1 to get the next index number
      // If bottom row, default to same bottom row
      //var NextItemIndex = CurTableIndexs[ CurIndexArrayKey + 1];
      var NextItemIndex = (CurIndexArrayKey == pageLength-1) ? CurTableIndexs[ CurIndexArrayKey ] : CurTableIndexs[ CurIndexArrayKey + 1];

      //alert( 'Row NextItemIndex: '+ NextItemIndex );
      //Create Previous Row object
      var PrevRow = url_table.row( PrevItemIndex );
      //alert( 'Row PrevRow: '+ PrevRow.data() );
      //Create Next Row object
      var NextRow =  url_table.row( NextItemIndex );
      //alert( 'Row NextRow: '+ NextRow.data() );

      currRow =  $(this).closest('tr').prev('tr');
      currRow.focus();
      $('tr').removeClass('highlighted');
      currRow.addClass('highlighted');
      ////////////////
      console.log('-->>logging');

      // Select prev row
      $(this).removeClass('selected');
      PrevRow.select();
      console.log('PrevRow-->>'+PrevRow.data());

      if (url_table.row('.selected').data() !== undefined) {
        var rowdata = url_table.row('.selected').data();
      } else {
        alert("You must select a row!");
      }
      // Get the rowdata
      console.log("Rowdata-->> " + rowdata);
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
      //alert("UP");
      
    } else if (e.which == 40) {
      // Down Arrow
      // Get current prev and next rows
      //alert( 'Row index: '+ url_table.row( this ).index() );

      //Set the index based on the row that was clicked
      var CurItemIndex = url_table.row( this ).index();
      //Get the indexes 
      var CurTableIndexs = url_table.rows().indexes();
      var CountIndexes = CurTableIndexs.length;
      //alert( 'Rows Count-->> '+CountIndexes);
      // Get the array key for the current index we have
      var CurIndexArrayKey = CurTableIndexs.indexOf( CurItemIndex );
      //alert( 'Row CurIndexArrayKey: '+ CurIndexArrayKey );
      // Subtract 1 to the array key to get the prior index number
      // if top row, default to same top row
      var PrevItemIndex = (CurIndexArrayKey > 0 ) ? CurTableIndexs[ CurIndexArrayKey - 1] : CurTableIndexs[0] ;
      //alert( 'Row PrevItemIndex: '+ PrevItemIndex );
      // Add 1 to get the next index number
      // If bottom row, default to same bottom row
      //var NextItemIndex = CurTableIndexs[ CurIndexArrayKey + 1];
      var NextItemIndex = (CurIndexArrayKey == pageLength-1) ? CurTableIndexs[ CurIndexArrayKey ] : CurTableIndexs[ CurIndexArrayKey + 1];
      //alert( 'Row NextItemIndex: '+ NextItemIndex );
      //Create Previous Row object
      var PrevRow = url_table.row( PrevItemIndex );
      //alert( 'Row PrevRow: '+ PrevRow.data() );
      //Create Next Row object
      var NextRow =  url_table.row( NextItemIndex );
      //alert( 'Row NextRow: '+ NextRow.data() );

      currRow =  $(this).closest('tr').next('tr');
      currRow.focus();
      $('tr').removeClass('highlighted');
      currRow.addClass('highlighted');
      ////////////////
      console.log('-->>logging');

      // Select prev row
      $(this).removeClass('selected');
      NextRow.select();
      console.log('NextRow-->>'+NextRow.data());

      if (url_table.row('.selected').data() !== undefined) {
        var rowdata = url_table.row('.selected').data();
      } else {
        alert("You must select a row!");
      }
      // Get the rowdata
      console.log("Rowdata-->> " + rowdata);
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
      //alert("DOWN");
      };

  });

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
      // Get article after click
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
    alert("Fetching not implemented...");
  });

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

  $('#button2').click(function() {
    if ( $('#article_table tr').hasClass('selected') ) {
      if (sentstate == 'none') {
        alert('Please select a Sentiment state from dropdown');
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
    clearUrls();
  });

  $(document).keypress(function(event){
      var keycode = (event.keyCode ? event.keyCode : event.which);
      if(keycode == '13'){
          //alert('You pressed a "enter" key in somewhere');
          console.log('You pressed a "enter" key in somewhere');
          if ( $('#article_table tr').hasClass('selected') ) {
            if (sentstate == 'none') {
              alert('Please select a Sentiment state from dropdown');
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
      }
  });

});
</script>

</head>

<body>

<?php
session_start(); 

error_reporting(E_ALL);
ini_set('display_errors', '1');

$path = '/root/documentRoot';
//$path =  '/Users/johnnyhom/documentRoot';

set_include_path(get_include_path() . PATH_SEPARATOR . $path);

//include db configuration file
include_once("config.php");
include_once("find_quotes.php");

// Mysql 
$this_table='article_urls';

// Get Session Parameters

if (isset($_POST['datepicker']) && isset($_POST['relevancy']) && isset($_POST['crypto']) && isset($_POST['read']) && isset($_POST['scored']) && isset($_POST['nbayes']) ) {
  $_SESSION['datepicker'] = $_POST['datepicker'];
  $_SESSION['relevancy'] = $_POST['relevancy'];
  $_SESSION['crypto'] = $_POST['crypto'];
  $_SESSION['read'] = $_POST['read'];
  $_SESSION['scored'] = $_POST['scored'];
  $_SESSION['nbayes'] = $_POST['nbayes'];
} else if(!isset($_SESSION['datepicker']) || !isset($_SESSION['relevancy']) || !isset($_SESSION['crypto']) ||  !isset($_POST['read']) ||  !isset($_POST['scored']) && isset($_POST['nbayes']) ) {
  echo "Set default datepicker and relevancy<br>";
  $_SESSION['datepicker'] = date('Y-m-d');
  $_SESSION['relevancy'] = 1;
  $_SESSION['crypto'] = 0;
  $_SESSION['read'] = 0;
  $_SESSION['scored'] = 0;
  $_SESSION['nbayes'] = 0;
} else {
  //echo "Error datepicker and relevancy not set!<br>";  
};

$sql = "SELECT idx, url, title, datasource, read_flag, DATE(insert_date) as mydate FROM sentiment.article_urls where relevancy_score>=".$_SESSION['relevancy']." and read_flag=".$_SESSION['read']." and crypto_flag=".$_SESSION['crypto']." and scored_flag=".$_SESSION['scored']." and nbayes_score>=".$_SESSION['nbayes']." and downloaded_flag = 1 and insert_date > DATE_SUB(DATE('".$_SESSION['datepicker']."'), INTERVAL 12 HOUR) and insert_date < DATE_ADD(DATE('".$_SESSION['datepicker']."'), INTERVAL 24 HOUR) limit 2000";

echo "$sql<br>";
$result = $conn->query($sql);

// Top of body
$landing_url = "http://" . $hostname . ":80/landing.php";
echo "
<a href='$landing_url'>Go Back to Landing Page</a>
<div class= 'controlbuttons'>
<input id='Logout' type='button' value='Logout' /> <br><br><br>
<button id='button2'>Update</button><br><br><br>
<button onclick='reloadFunction()'>Reload page</button> <br><br><br>
<button id='button3'>Clear</button><br><br><br>
</div>
<ul id='responds'></ul>
";

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
$idx=0;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $line_id=$row["idx"];
        echo "<tr tabindex='$idx'>";
        echo "<td class='ID' id='ID$line_id'>" . $row["idx"] . "</td>";
        $url_trunc = substr($row['url'], 0, 80);
        echo "<td class='Url' id='Url$line_id'> <a href='" . $row["url"] . "'>" . $url_trunc . "</a></td>";
        $title_trunc = substr($row['title'], 0, 60);
        echo "<td class='Title' id='Title$line_id'>" . $title_trunc . "</td>";
        echo "<td class='Datasource' id='Datasource$line_id'>" . $row["datasource"] . "</td>";        
        echo "<td class='Read_flag' id='Read_flag$line_id'>" . $row["read_flag"] . "</td>";
        echo "<td class='Date' id='Date$line_id'>" . $row["mydate"] . "</td>";
        echo "</tr>";
        $idx++;
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
<th>NB</th>
<th>Article Text</th>
</tr>
</thead>
<tbody>
<tr><td>Euphoria</td><td>999</td><td>0</td><td>Mary Had a Little Lamb</td><tr>
</tbody>
</table>


</body>


</html>
