<?php
include ('../config.php');
include ('../_sql.php');
include ('../_kodok.php');
include ('../../functions/functions.php');
include ('../../functions/func_mail.php');

if ($_POST ['urlap'] == 1) {
	$hirlevelek_lista = gsql_numassoc ( "SELECT * FROM nmHirlevel_texts WHERE hirlevel_id = {$_POST['hirlevel_select']}" );
	
	$datum_kiir = explode(' ', $hirlevelek_lista [0] ['cDatum']);
	
	if ($_POST ['teszt'] != 1) {
		$sqlCimzettek = gsql_numassoc ( "SELECT * FROM nmHirlevelUsers where aktiv=1" );
		if (count ( $sqlSajtoCimzettek ) > 0) {
			for($i = 0; $i < count ( $sqlSajtoCimzettek ); $i ++) {
				$egy_cimzett = array ();
				$egy_cimzett ['Uid'] = $sqlSajtoCimzettek [$i] ['Uid'];
				$egy_cimzett ['accnev'] = $sqlSajtoCimzettek [$i] ['accnev'];
				$egy_cimzett ['accemail'] = $sqlSajtoCimzettek [$i] ['accemail'];
				
				$cimzettek_tomb [$egy_cimzett ['Uid']] [] = $egy_cimzett;
			}
		}
		
		$szamol = 0;
		function getmicrotime() {
			list ( $usec, $sec ) = explode ( " ", microtime () );
			return (( float ) $usec + ( float ) $sec);
		}
		$a = getmicrotime ();
		
		foreach ( $sqlCimzettek as $egy_level ) {
			
			hirlevel_send ($mainsett["email_hirlevel_from"], "Futurefund", $egy_level ['email'], $egy_level ['email'], $hirlevelek_lista [0] ['hirlevel_html_text'], $hirlevelek_lista [0] ['hirlevel_targy'], '../../', '' );
			
			$szamol ++;
			//p_log('----' . $egy_level[0]['accemail'] . "\n");
		

		}
		//var_dump($cimzettek_tomb);
		

		if ($_POST ['teszt'] != '1') {
			$myQuery = "hirlevel_id='" . $hirlevel_select . "'";
			$myQuery .= ", ID='" . $_POST ['l_userid'] . "'";
			$myQuery .= ", darab='" . $szamol . "'";
			
			$sqlInsert = "INSERT INTO nmHirlevel_kikuldott SET $myQuery";
			$resultInsert = $db->query ( $sqlInsert );
		}
echo "Elküldve: ";
printf ( "%0.5f másodperc", getmicrotime () - $a );
echo " alatt <br /><br />$szamol címre\n\n";
	
	} else {
		hirlevel_send ( $mainsett["email_hirlevel_from"], "Futurefund", $_POST ['teszt_cimzett'], $_POST ['teszt_cimzett'], $hirlevelek_lista [0] ['hirlevel_html_text'], $hirlevelek_lista [0] ['hirlevel_targy'], '../../', '' );
		echo 'TESZT LEVELEK ELULDVE';
	}
}

?>