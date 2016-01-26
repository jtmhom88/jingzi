<?php

function quote_colorize($line) {
	$fixed_line = $line;

	$patterns = array("/said/");
	array_push($patterns, "/\"/");
	array_push($patterns, "/\'/");
	array_push($patterns, "/told/");
	array_push($patterns, "/says/");
	array_push($patterns, "/repeat/");
	array_push($patterns, "/agreed/");
	array_push($patterns, "/declare/");
	array_push($patterns, "/affirm/");
	array_push($patterns, "/assert/");
	array_push($patterns, "/argu/");
	array_push($patterns, "/state/");
	array_push($patterns, "/announce/");
	array_push($patterns, "/believes/");
	array_push($patterns, "/reiterate/");
	array_push($patterns, "/predict/");
	array_push($patterns, "/warn/");
	array_push($patterns, "/wrote/");
	array_push($patterns, "/danger/");
	array_push($patterns, "/according/");
	array_push($patterns, "/note/");
	array_push($patterns, "/suggest/");
	array_push($patterns, "/impl/");
	array_push($patterns, "/claim/");
	array_push($patterns, "/expect/");
	array_push($patterns, "/guess/");
	array_push($patterns, "/estimate/");
	array_push($patterns, "/recommend/");
	array_push($patterns, "/affirm/");
	array_push($patterns, "/comment/");
	array_push($patterns, "/quote/");
	array_push($patterns, "/technical/");
	array_push($patterns, "/fear/");
	array_push($patterns, "/ugly/");
	array_push($patterns, "/hope/");
	array_push($patterns, "/hoping/");
	array_push($patterns, "/desp/");
	array_push($patterns, "/depress/");
	array_push($patterns, "/negative/");
	array_push($patterns, "/cautio/");
	array_push($patterns, "/positive/");
	array_push($patterns, "/encourag/");
	array_push($patterns, "/bear/");
	array_push($patterns, "/bull/");
	array_push($patterns, "/sentiment/");
	array_push($patterns, "/mood/");
	array_push($patterns, "/bottom/");

	$teststring = strtolower($line);
	foreach ($patterns as $regex) {	
		if (preg_match($regex, $teststring)) {
	    // Indeed, the expression "[a-zA-Z]+ \d+" matches the date string
	    echo $teststring. " ". $regex . "Found a match!";
	    $fixed_line = '<font color="blue">' . $line . '</font>' ;
		} 
	}
	return $fixed_line;
}

?>