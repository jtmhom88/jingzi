<!DOCTYPE html>
<html>
<head>
	<title>Select Example</title>
</head>
<body>

<?php
session_start(); 
$sent_ary = array(
'none' => 'None', 
'joy' => 'Joy',
'joy_contentment' => 'Joy/Contentment',
'contentment' => 'Contentment',
'contentment_hope' => 'Contentment/Hope',
'hope' => 'Hope',
'hope_fear' => 'Hope/Fear',
'fear' => 'Fear',
'fear_despair' => 'Fear/Despair',
'despair' => 'Despair',
'despair_apathy' => 'Despair/Apathy',
'apathy' => 'Apathy',
'apathy_caution' => 'Apathy/Caution',
'caution' => 'Caution',
'caution_greed' => 'Caution/Greed',
'greed' => 'Greed',
'greed_joy' => 'Greed/Joy'
);

$sent_ary2 = array('none','joy','joy_contentment','contentment','contentment_hope','hope','hope_fear', 'fear',
	'fear_despair','despair' ,'despair_apathy','apathy','apathy_caution' ,'caution','caution_greed' ,'greed', 'greed_joy'
);


function sentiment_dropdown($ary){
	echo "<select>";
	foreach ($ary as $value) {
	 echo "<option value='$value'>$value</option>";
	};
	echo "</select>";
};

sentiment_dropdown($sent_ary2);
echo "<br>";
sentiment_dropdown($sent_ary2);


?>

<div class="mylist">
<select>
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
</div>


</body>
</html>

