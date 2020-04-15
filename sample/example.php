<?php
/*
FancyFilter is licensed under the Apache License 2.0 license
https://github.com/TRP-Solutions/fancy-filter/blob/master/LICENSE
*/
require_once "../lib/FancyFilter.php";
$filter = FancyFilter::get('testfilter',null,$_GET,['key_e'], FancyFilter::UNSET_MISSING);
$filter = FancyFilter::get('testfilter',['key_b'=>'default_b'],$_GET,['key_a','key_b','key_c']);
?>
<!DOCTYPE html>
<html>
<head>
	<title>FancyFilter test</title>
</head>
<body>
<pre>
	Value A: <?=$filter->key_a?> 
	Value B: <?=$filter->key_b?> 
	Value C: <?=$filter->key_c?> 
	Value D: <?=$filter->key_d?> 
	Value E: <?=$filter->key_e?>
</pre>
<?php
// Getting the same filter with an empty list of defaults
$filter = FancyFilter::get('testfilter',[]);
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
	<li><a href="?key_a=a">Set a=a</a></li>
	<li><a href="?key_a">Unset a</a></li>
	<li><a href="?key_b=b">Set b=b</a></li>
	<li><a href="?key_b">Unset b</a></li>
	<li><a href="?key_c=c">Set c=c</a></li>
	<li><a href="?key_c">Unset c</a></li>
	<li><a href="?key_d=d">Set d=d (not allowed)</a></li>
	<li><a href="?key_d">Unset d (not allowed)</a></li>
	<li><form target="#">E: <input type='checkbox' name='key_e'><input type='submit'></form></li>
</ul>
</body>
</html>