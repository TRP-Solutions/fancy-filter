<?php
/*
FancyFilter is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/fancy-filter/blob/master/LICENSE
*/
require_once "../lib/FancyFilter.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>FancyFilter test</title>
	<script src="../../git_ufo-ajax/lib/ufo.js"></script>
	<script src="../lib/fancyfilter.js"></script>
</head>
<body>
<?php
// Getting the same filter with an empty list of defaults
$filter = FancyFilter::get('testfilter',[]);
if(isset($_GET['set_values'])){
	// Using both ->set and ->set_values here for example purposes
	// If there's more than one value, ->set_values is preferable, because it only stores the new cookie once
	$filter->set('key_a','Value a from PHP');
	$filter->set_values([
		'key_b'=>'Value b from PHP',
		'key_c'=>'Value c from PHP',
		'key_d'=>null
	]);
}
?>
<pre>
	No defaults:
	Value A: <?=$filter->key_a?> 
	Value B: <?=$filter->key_b?> 
	Value C: <?=$filter->key_c?> 
	Value D: <?=$filter->key_d?> 
	Value E: <?=$filter->key_e?>
</pre>
<ul>
	<li><button onclick="FancyFilter.set('testfilter','key_a','a');location = location.pathname;">Set a=a</button></li>
	<li><button onclick="FancyFilter.set('testfilter','key_b','b');location = location.pathname;">Set b=b</button></li>
	<li><button onclick="FancyFilter.set('testfilter','key_c','c');location = location.pathname;">Set c=c</button></li>
	<li><button onclick="FancyFilter.set('testfilter','key_d','d');location = location.pathname;">Set d=d</button></li>
	<li>E: <input type='checkbox' onchange="FancyFilter.set('testfilter','key_e',this.checked);location.reload();" <?if($filter->key_e) echo "checked";?>></li>
	<li><button onclick="
		FancyFilter.set('testfilter','key_a',undefined);
		FancyFilter.set('testfilter','key_b',undefined);
		FancyFilter.set('testfilter','key_c',undefined);
		FancyFilter.set('testfilter','key_d',undefined);
		FancyFilter.set('testfilter','key_e',undefined);
		location = location.pathname;
	">Reset</button></li>
	<li><a href="?set_values">Set values in PHP</a></li>
</ul>
</body>
</html>
