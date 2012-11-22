<?php
$params = explode ( "/", $_GET ["param"] );

while ( (count ( $params ) > 0) && ($params [count ( $params ) - 1] == "") ) {
	unset ( $params [count ( $params ) - 1] );
}

$sitejs = array();
$sitecss = array();
$param = implode ( "/", $params );
/*
 * ide jonnek a default meta tag-ek, azoknal az oldalaknal ahol nincs megadva, ez fog megjelenni
 */
$metatitle = 'East-West - Utazási és Sport Iroda';
$metakeyword = 'keyword';
$metadescription = 'description';

/* nyelv */

if(count($params) > 0 && $params[0] == 'en'){
	$_SESSION['lang'] = 'en';
	$param = str_replace('en/', '', $param);
	array_shift($params);
}else{
	$_SESSION['lang'] = 'hu';
}

/*
 * utazas - sport nyito oldalak
 */
if (count($params) == 1) {
	switch ($params [0]) {
		case 'utazas':
			$metatitle = 'East-West - Utazási és Sport Iroda EW utazás, utazások, egyéni síutak, körutazás';
			$metakeyword = 'East West utazási és sport iroda, EW utazás, www.ewutazas.hu, utazások, egyéni, síutak, körutazás, hajós, autóbuszos, nászutak, párizs, egyiptom, usa, ciprus, dominika';
			$metadescription = '';
			$_GET ['menu_type'] = 1;
			$_GET ['page'] = 'php/utazas_nyito.php';
			include 'index.php';
			die();
		case 'sport':
			$metatitle = 'East-West - Utazási és Sport Iroda EW utazás, utazások, egyéni síutak, körutazás';
			$metakeyword = 'East West utazási és sport iroda, EW utazás, www.ewutazas.hu, utazások, egyéni, síutak, körutazás, hajós, autóbuszos, nászutak, párizs, egyiptom, usa, ciprus, dominika';
			$sitecss [] = 'sport';
			$_GET ['menu_type'] = 2;
			$_GET ['page'] = 'php/hirek_lista.php';
			include 'index.php';
			die();
	}
}

/*
 * utazas - sport belso oldalak
 */
if (count($params) == 2) {
	$metatitle = 'East-West - Utazási és Sport Iroda EW utazás, utazások, egyéni síutak, körutazás';
			$metakeyword = 'East West utazási és sport iroda, EW utazás, www.ewutazas.hu, utazások, egyéni, síutak, körutazás, hajós, autóbuszos, nászutak, párizs, egyiptom, usa, ciprus, dominika';
	switch ($params [0]) {
		case 'utazas':
			$_GET ['menu_type'] = 1;
			$_GET ['id'] = 1;
			switch ($params [1]) {
				case 'faszom':
					include 'index.php';
					die();
				case 'partnerek':
					$_GET ['id'] = 2;
					$_GET ['page'] = 'php/utazas_partnerek.php';
					include 'index.php';
					die();
				case 'utazasok':
					$_GET ['id'] = 2;
					$_GET ['page'] = 'php/utazas_nyito.php';
					include 'index.php';
					die();
				case 'last-minute':
					$_GET ['id'] = 2;
					$_GET ['page'] = 'php/utazasok_lm.php';
					include 'index.php';
					die();
				case 'akcios-utak':
					$_GET ['id'] = 2;
					$_GET ['page'] = 'php/utazas_akcios.php';
					include 'index.php';
					die();
				case 'ajanlatkeres':
					$_GET ['id'] = 2;
					$_GET ['page'] = 'php/utazas_ajanlatkeres.php';
					include 'index.php';
					die();
				case 'galeria':
					$_GET ['id'] = 2;
					$_GET ['page'] = 'php/utazas_galeria.php';
					include 'index.php';
					die();
				case 'partnerek':
					$_GET ['id'] = 2;
					$_GET ['page'] = 'php/utazas_partner.php';
					include 'index.php';
					die();
				case 'kapcsolat':
					$_GET ['id'] = 2;
					$_GET ['page'] = 'php/utazas_kapcs.php';
					include 'index.php';
					die();
			}
					
		case 'sport':
			$sitecss [] = 'sport';
			$_GET ['menu_type'] = 2;
			$_GET ['id'] = 2;
			switch ($params [1]) {
				case 'rolunk':
					$_GET ['id'] = 3;
					$_GET ['page'] = 'php/sport_rolunk.php';
					include 'index.php';
					die();
				case 'taborok':
					$_GET ['id'] = 4;
					$_GET ['page'] = 'php/taborok.php';
					include 'index.php';
					die();
				case 'hirek':
					$_GET ['id'] = 5;
					$_GET ['page'] = 'php/hirek_lista.php';
					include 'index.php';
					die();
				case 'referenciak':
					$_GET ['id'] = 6;
					$_GET ['page'] = 'php/sport_referenciak.php';
					include 'index.php';
					die();
				case 'galeria':
					$_GET ['id'] = 7;
					$_GET ['page'] = 'php/sport_galeria.php';
					include 'index.php';
					die();
				case 'reklam_es_szponzor':
					$_GET ['id'] = 8;
					$_GET ['page'] = 'php/sport_reklam_es_szponzor.php';
					include 'index.php';
					die();
				case 'kapcsolat':
					$_GET ['id'] = 9;
					$_GET ['page'] = 'php/sport_kapcsolat.php';
					include 'index.php';
					die();
				
			}
		default:
			$_GET ['id'] = -100;
			include 'index.html';
			die();
	}	
}
if (count($params) == 3) {
	$sitecss [] = 'sport';
	$metatitle = 'East-West - Utazási és Sport Iroda EW utazás, utazások, egyéni síutak, körutazás';
	$metakeyword = 'East West utazási és sport iroda, EW utazás, www.ewutazas.hu, utazások, egyéni, síutak, körutazás, hajós, autóbuszos, nászutak, párizs, egyiptom, usa, ciprus, dominika';
	if($params[0] == 'sport'){
		if($params[1] == 'hirek') {
			$_GET ['menu_type'] = 2;
			$_GET ['page'] = 'php/hirek_cikk.php';
			include 'index.php';
			die();
		}
		// if($params[2] == 'fcbarcelona'){
		// 	$_GET ['menu_type'] = 2;
		// 	$_GET ['page'] = 'php/fcbarcelona.php';
		// 	include 'index.php';
		// 	die();
		// }
		if($params[2] == 'gyorietovip'){
			$_GET ['menu_type'] = 2;
			$_GET ['page'] = 'php/gyorietovip.php';
			include 'index.php';
			die();
		}
		elseif($params[2] == 'hungaroring'){
			$_GET ['menu_type'] = 2;
			$_GET ['page'] = 'php/hungaroring.php';
			include 'index.php';
			die();
		}
	}
}
if (count($params) == 4) {
	$metatitle = 'East-West - Utazási és Sport Iroda EW utazás, utazások, egyéni síutak, körutazás';
	$metakeyword = 'East West utazási és sport iroda, EW utazás, www.ewutazas.hu, utazások, egyéni, síutak, körutazás, hajós, autóbuszos, nászutak, párizs, egyiptom, usa, ciprus, dominika';
	switch ($params [0]) {
		case 'utazas':
			$_GET ['menu_type'] = 1;
			$_GET ['page'] = 'php/utazas_adatlap.php';
			include 'index.php';
			die();
	}
}
echo $param;
//include ('404.html');
?>