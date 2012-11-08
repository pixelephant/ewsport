<?php
function alpha_numeric($str)
{
    return (!preg_match("/^([-a-z0-9])+$/i", $str)) ? false : true;
}

function valid_email($str)
{
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",
        $str)) ? false : true;
}

function valid_username($str)
{
	$errors = array();
    if (strlen($str) < 3) {
    	return false;
    }
    else {
    	return true;
    }
}

function string_exists($str, $tabla, $mezo)
{
	global $host;
	global $dbUser;
	global $dbPass;
	global $dbName;
	global $db;
	
	$sql = "SELECT Uid FROM $tabla WHERE $mezo = '$str'";
	$result = $db->query($sql);
    $row = $result->fetch();
    if ($result->size() > 0) {
    	return false;
    }
    else {
    	return true;
    }
}

function valid_pass($str)
{
    return (!preg_match("|^[-_@'+!%/=()0-9A-Za-z]{6,16}$|", $str)) ? false : true;
}

function valid_radio($str) {
	if ($str == '') {
		return false;
	}
	else {
		return true;
	}
}

?>