<?php
session_start();
include ('../admin/config.php');
include ('../admin/_sql.php');
include ('../functions/functions.php');

	$o = (int)$_POST ['continent_id'];
	$c = (int)$_POST['city_id'];
	$selecthova = "sel_country_id";
	if ($o > 0) {
		$q = gsql_2assoc("SELECT id, neve FROM parameterek WHERE orszag=$o ORDER BY neve ASC");
		$output .= "$('$selecthova').options.length = 0;\n";
		if($c > 0) {
			foreach ( $q as $k1 => $v1 ) {
				if($k1 == $c) {
					$v1 = iso2utf ( $v1 );
					$output .= "AddSelectOption(\$('$selecthova'),'$v1','$k1');\n";
				}
			}
		}
		$output .= "AddSelectOption(\$('$selecthova'),'" . iso2utf ( "-- Válasszon --" ) . "',0);\n";
		foreach ( $q as $k => $v ) {
			$v = iso2utf ( $v );
			$output .= "AddSelectOption(\$('$selecthova'),'$v','$k');\n";
		}
		//$output .= "alert(GVSorvos);\n";
	} else {
		$selecthova = "sel_country_id";
		$output .= "$('$selecthova').options.length = 0;\n";
		$output .= "AddSelectOption(\$('$selecthova'),'" . iso2utf ( "-- Válasszon --" ) . "',0);\n";
		//$output .= "create_gvSelect('index_search');\n";
	}

header("Content-Type: text/html; charset=utf-8");
echo $output;

function iso2utf($v) {
	$v = addslashes ( $v );
	$v = str_replace("\n", "\\n", $v);
	$v = str_replace("\r", "", $v);
	$v = preg_replace("/ {2,}/","", $v);
	$v = preg_replace("/ {2,}|\t/","", $v);
	return $v;
}
?>