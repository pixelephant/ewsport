<?php
function alt_level($fromEmail, $fromName, $addrName, $addrEmail, $text, $subject, $dirpref, $templatename)
{
	if(file_exists($dirpref.'functions/class.phpmailer.php'))
	{
		include_once($dirpref.'functions/class.phpmailer.php');
		$mail = new PHPMailer();
	
		$mail->From = $fromEmail;
		$mail->FromName = $fromName;
	
		$level = file_get_contents($dirpref . "email/".$templatename);
		$level = str_replace("{###content###}", $text, $level);
		$level = str_replace("{###datum###}", '', $level);
	
		$body = $level;
		$body = eregi_replace("[\]", '', $body);
		$subject = eregi_replace("[\]", '', $subject);
		$mail->Subject = $subject;
	
		$text_body = strip_tags(nl2br($text));
	
		$mail->Body = $body;
		$mail->AltBody = $text_body;
		$mail->AddAddress($addrEmail, $addrName);
		//$mail->AddStringAttachment("photo", "email/letter/logo.jpg");
	
		if (!$mail->Send())
			echo "E-mail k�ld�si hiba: " . $addrEmail . "<br>";
	
		// Clear all addresses and attachments for next loop
		$mail->ClearAddresses();
		$mail->ClearAttachments();
	}
}

function hirlevel_send($fromEmail, $fromName, $addrName, $addrEmail, $text, $subject, $dirpref, $datum)
{
	if(file_exists($dirpref.'functions/class.phpmailer.php'))
	{
		include_once($dirpref.'functions/class.phpmailer.php');
		$mail = new PHPMailer();
	
		$mail->From = $fromEmail;
		$mail->FromName = $fromName;
	
		$level = file_get_contents($dirpref . "email/hirlevel.html");
		$level = str_replace("{###content###}", $text, $level);
	    $level = str_replace("{###datum###}", $datum, $level);
	    
		$body = $level;
		$body = eregi_replace("[\]", '', $body);
		$subject = eregi_replace("[\]", '', $subject);
		$mail->Subject = $subject;
	
		$text_body = strip_tags(nl2br($text));
	
		$mail->Body = $body;
		$mail->AltBody = $text_body;
		$mail->AddAddress($addrEmail, $addrName);
		//$mail->AddStringAttachment("photo", "email/letter/logo.jpg");
	
		if (!$mail->Send())
			echo "E-mail k�ld�si hiba: " . $addrEmail . "<br>";
	
		// Clear all addresses and attachments for next loop
		$mail->ClearAddresses();
		$mail->ClearAttachments();
	}
}

function egyszeru_level($fromEmail, $fromName, $addrName, $addrEmail, $text, $subject, $dirpref)
{
	if(file_exists($dirpref.'functions/class.phpmailer.php'))
	{
		include_once($dirpref.'functions/class.phpmailer.php');
		$mail = new PHPMailer();
	
		$mail->From = $fromEmail;
		$mail->FromName = $fromName;
	
		$level = $text;
	
		$body = $level;
		$body = eregi_replace("[\]", '', $body);
		$subject = eregi_replace("[\]", '', $subject);
		$mail->Subject = $subject;
	
		$text_body = strip_tags(nl2br($text));
	
		$mail->Body = $body;
		$mail->AltBody = $text_body;
		$mail->AddAddress($addrEmail, $addrName);
		//$mail->AddStringAttachment("photo", "levelpapir/bgr_header.jpg");
	
		if (!$mail->Send())
			echo "E-mail kuldesi hiba: " . $addrEmail . "<br>";
	
		// Clear all addresses and attachments for next loop
		$mail->ClearAddresses();
		$mail->ClearAttachments();
	}
}
?>