<?php
error_reporting(E_ALL ^ E_NOTICE);

if (count($params) == 0) {
	include ('splash.html');
	die();
}

include ('admin/config.php');
include ('admin/_sql.php');
include ('functions/functions.php');
include ('functions/func_validation.php');
include ('functions/func_mail.php');


include ('includes/html_elements/_search_form.php');
include ('includes/html_elements/_htmlstart.php');
include ('includes/html_elements/_header.php');

$tmp_utazas_tip = gsql_2assoc ("SELECT id, neve FROM parameterek WHERE parentid=1 ORDER BY sorrend ASC");
$tmp_orszag = gsql_2assoc ("SELECT id, neve FROM parameterek WHERE parentid=2 ORDER BY neve ASC");
$tmp_ellatas = gsql_2assoc ("SELECT id, neve FROM parameterek WHERE parentid=5 ORDER BY sorrend ASC");
$tmp_varos = gsql_2assoc ("SELECT id, neve FROM parameterek WHERE parentid=3 ORDER BY sorrend ASC");
$tmp_szallas_tip = gsql_2assoc ("SELECT id, neve FROM parameterek WHERE parentid=4 ORDER BY sorrend ASC");

for ($ii = $ideiEv; $ii <= $ideiEv+1; $ii++) {
	$evek_arr [$ii] = $ii;
}

for ($ii = 1; $ii <= 12; $ii++) {
	$honapok_arr [$ii] = $ii;
}

for ($ii = 1; $ii <= 31; $ii++) {
	$napok_arr [$ii] = $ii;
}

for ($ii = 1; $ii <= 10; $ii++) {
	$felnottek_arr [$ii] = $ii;
}

for ($ii = 0; $ii <= 10; $ii++) {
	$gyerekek_arr [$ii] = $ii;
}
include $_GET ['page'];
//echo $_GET ['page'];
include ('includes/html_elements/_htmlend.php');

?>
