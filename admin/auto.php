<?php
/**
 * This is just an example how to generate a proper content.
 *
 * When you give the variable "html=true" it returns a list
 * of choices as raw data, otherwise it will encode these
 * <li> items as json array. 
 */

$limit = 10;

$value = strtolower(@array_pop(@explode(' ', $_POST['value']) ) );

$data = array();

ini_set('memory_limit', '48M');

if (strlen($value) > 0)
{
	$source = file_get_contents('dic.txt');
	preg_match_all('/^'. preg_quote($value) .'(.*)$/mi', $source, $match);
	$data = array_slice(array_values(array_unique($match[0]) ), 0, $limit);
}

if (isset($_POST['html']) && $_POST['html'])
{
	foreach ($data as $choice)
	{
		echo "<li><span>$choice</span><a class=\"example-info\" target=\"_blank\" title=\"Dictonary Link\" href=\"http://www.spanishdict.com/AS.cfm?e=$choice\">[Dict]</a></li>";
	}
}
else
{
	header('Content-type: application/json');
	echo json_encode($data);
}

?>