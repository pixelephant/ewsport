<?php
if ($_GET ['SAVE'] == 1) {
	if ($_GET ['utazas_tip'] != 0) {
		$feltetel [] = 'utazas_tip=' . $_GET ['utazas_tip'];
	}
	if ($_GET ['utazas_orszag'] != 0) {
		$feltetel [] = 'utazas_orszag=' . $_GET ['utazas_orszag'];
	}
	if ($_GET ['utazas_varos'] != 0) {
		$feltetel [] = 'utazas_varos=' . $_GET ['utazas_varos'];
	}
	if ($_GET ['utazas_szallas_tip'] != 0) {
		$feltetel [] = 'utazas_szallas=' . $_GET ['utazas_szallas_tip'];
	}
	if ($_GET ['utazas_ellatas'] != 0) {
		$feltetel [] = 'utazas_ellatas=' . $_GET ['utazas_ellatas'];
	}
	
	if (strlen($_GET ['utazas_date']) > 4) {
		$feltetel [] = "utazas_start>=\"{$_GET ['utazas_date']}-01\" AND utazas_vege<=\"{$_GET ['utazas_date']}-31\"";
	}
	
	
	if (count($feltetel) > 0) {
		$feltetel_kiir = 'WHERE ' . implode (' AND ', $feltetel);
		$tmp_search = "SELECT * FROM utazasok $feltetel_kiir";
		//echo $tmp_search;
		$tmp_search = gsql_numassoc ($tmp_search);
	}
	
}

if ($_POST ['SAVE'] == 2) {
	if (trim($_POST ['ajanlat_neve']) == '') {
		$errors [] = 'Kérem adja meg a nevét!';
	}
	if (trim($_POST ['ajanlat_telefon']) == '') {
		$errors [] = 'Kérem adja meg a telefonszámát!';
	}
	if (valid_email($_POST ['ajanlat_email']) == false) {
		$errors [] = 'Nem megfelelő az email cím formátuma';
	}
	
	if (count($errors) == 0) {
		$to      = 'info@ewutazas.hu';
		$subject = 'Foglalás';
		$message = "Arajanlat erkezett az alabbi hotelre: http://www.ewutazas.hu/" . $_POST ['ajanlat_url'];
		$headers = 'From: ';
		$headers .= $_POST ['ajanlat_email']; 
		$headers .= "\r\n";
		$headers .= 'Reply-To: ';
		$headers .= $_POST ['ajanlat_email'];
		$headers .= "\r\n";
		$headers .=  'X-Mailer: PHP/' . phpversion() . "\r\n";
		$headers .= "Content-type:text/html;charset=utf-8" . "\r\n";
		
		 
		mail($to, $subject, $message, $headers);
		$errors [] = "Ajánlatkérés elküldve!";
		//mail('peat@me.com', 'teszt', 'uzenet');
		//egyszeru_level($_POST ['ajanlat_email'], $_POST ['ajanlat_neve'], 'EW utazas', 'bihari.peter@blan.hu', 'teszt uzenet', 'targy', '');
	}
}

if ($_POST ['SAVE'] == 3) {
	if (trim($_POST ['kapcsolat_nev']) == '') {
		$errors [] = 'Kérem adja meg a nevét!';
	}
	if (trim($_POST ['kapcsolat_telefon']) == '') {
		$errors [] = 'Kérem adja meg a telefonszámát!';
	}
	if (valid_email($_POST ['kapcsolat_email']) == false) {
		$errors [] = 'Nem megfelelő az email cím formátuma';
	}
	if (trim($_POST ['kapcsolat_uzenet']) == '') {
		$errors [] = 'Kérem adja meg az üzenetet!';
	}
	
	if (count($errors) == 0) {
		//$to      = 'info@ewutazas.hu';
		$to      = 'boxer@webinform.hu';
		//$to2      = 'peat@me.com';
		$subject = 'East West foglalas';
		$message = $_POST ['kapcsolat_uzenet'];
		$headers = 'From: ';
		$headers .= $_POST ['kapcsolat_email']; 
		$headers .= "\r\n";
		$headers .= 'Reply-To: ';
		$headers .= $_POST ['kapcsolat_email'];
		$headers .= "\r\n";
		$headers .=  'X-Mailer: PHP/' . phpversion() . "\r\n";
		$headers .= "Content-type:text/html;charset=utf-8" . "\r\n";
		 
		mail($to, $subject, $message, $headers);
		//mail($to2, $subject, $message, $headers);
		$errors [] = "Üzenet elküldve!";
		//mail('peat@me.com', 'teszt', 'uzenet');
		//egyszeru_level($_POST ['ajanlat_email'], $_POST ['ajanlat_neve'], 'EW utazas', 'bihari.peter@blan.hu', 'teszt uzenet', 'targy', '');
	}
}

if ($_POST ['SAVE'] == 4) {
	if (trim($_POST ['ajanlat_neve']) == '') {
		$errors [] = 'Kérem adja meg a nevét!';
	}
	if (trim($_POST ['ajanlat_telefon']) == '') {
		$errors [] = 'Kérem adja meg a telefonszámát!';
	}
	if (valid_email($_POST ['ajanlat_email']) == false) {
		$errors [] = 'Nem megfelelő az email cím formátuma';
	}
	
	if (count($errors) == 0) {
		$to      = 'info@ewutazas.hu';
		$subject = 'ajanlatkeres';
		$message = 'Ajánlatkérés érkezett' . "\n";
		$message .= 'Úticél: ' . $_POST ['utazas_orszag'] . "\n";
		$message .= 'Város: ' . $_POST ['utazas_varos'] . "\n";
		$message .= 'Utazás típusa: ' . $_POST ['utazas_tipusa'] . "\n";
		$message .= 'Szállás típusa: ' . $_POST ['utazas_szallas'] . "\n";
		$message .= 'Ellátás: ' . $_POST ['utazas_ellatas'] . "\n";
		$message .= 'Felnőttek száma: ' . $_POST ['utazas_felnottek'] . "\n";
		$message .= 'Gyerekek száma: ' . $_POST ['utazas_gyerekek'] . "\n";
		$message .= 'Utazás kezdete: ' . $_POST ['utazas_ev_tol'] . '-' . $_POST ['utazas_honap_tol']  . '-' . $_POST ['utazas_nap_tol'] . "\n";
		$message .= 'Utazás vége: ' . $_POST ['utazas_ev_ig'] . '-' . $_POST ['utazas_honap_ig']  . '-' . $_POST ['utazas_nap_ig'] . "\n";
		$message .= 'Megjegyzés: ' . $_POST ['ajanlat_megjegyzes'] . "\n";
		$headers = 'From: ';
		$headers .= $_POST ['ajanlat_email']; 
		$headers .= "\r\n";
		$headers .= 'Reply-To: ';
		$headers .= $_POST ['ajanlat_email'];
		$headers .= "\r\n";
		$headers .=  'X-Mailer: PHP/' . phpversion() . "\r\n";
		$headers .= "Content-type:text/html;charset=utf-8" . "\r\n";
		
		
				 
		mail($to, $subject, $message, $headers);
		$errors [] = "Ajánlatkérés elküldve!";
		//mail('peat@me.com', 'teszt', 'uzenet');
		//egyszeru_level($_POST ['ajanlat_email'], $_POST ['ajanlat_neve'], 'EW utazas', 'bihari.peter@blan.hu', 'teszt uzenet', 'targy', '');
	}
}
?>