<?
function nevtourl($nev)
{
	$myString = $nev;

		$ekezetek1[] = "Á";
		$ekezetek1[] = "É";
		$ekezetek1[] = "Ü";
		$ekezetek1[] = "Ő";
		$ekezetek1[] = "Ű";
		//$ekezetek1[] = "?";
		$ekezetek1[] = "Ö";
		//$ekezetek1[] = "?";
		$ekezetek1[] = "Ú";
		$ekezetek1[] = "Ó";
		$ekezetek1[] = "Í";

		$ekezetek2[] = "á";
		$ekezetek2[] = "é";
		$ekezetek2[] = "ü";
		//$ekezetek2[] = "?";
		$ekezetek2[] = "ö";
		//$ekezetek2[] = "?";
		$ekezetek2[] = "ú";
		$ekezetek2[] = "ó";
		$ekezetek2[] = "í";
		$ekezetek2[] = "í";
	    
		$myString = str_replace($ekezetek1, $ekezetek2, $myString);
		$myString = strtolower($myString);
		$myString = str_replace(" ", "_", $myString);
	    
		$ekezetek[] = "á";
		$ekezetek[] = "é";
		$ekezetek[] = "ü";
		//$ekezetek[] = "?";
		$ekezetek[] = "ű";
		$ekezetek[] = "ö";
		//$ekezetek[] = "?";
		$ekezetek[] = "ő";
		$ekezetek[] = "ú";
		$ekezetek[] = "ó";
		$ekezetek[] = "í";
	    
		$ekezetek_n[] = "a";
		$ekezetek_n[] = "e";
		$ekezetek_n[] = "u";
		$ekezetek_n[] = "u";
		$ekezetek_n[] = "u";
		$ekezetek_n[] = "o";
		$ekezetek_n[] = "o";
		$ekezetek_n[] = "o";
		$ekezetek_n[] = "u";
		$ekezetek_n[] = "o";
		$ekezetek_n[] = "i";
	    
		$myString = str_replace($ekezetek, $ekezetek_n, $myString);
		$myString = str_replace(array(';','/','?',':','@','&','=','+','$',',','!'), '', $myString);
		$myString = preg_replace("/[^a-z0-9_-]/", "", $myString);
		
		
	return $myString;
}

?>