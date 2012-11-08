<?php
session_start();
require_once('config.php');
include('../functions/functions.php');
	if(isset($_POST['Login']))
	{
		if($_POST['username']!='' && $_POST['password']!='')
		{
			//az username es password inputot osszeveti 'adminUsers' tablaval
			$query = mysql_query('SELECT ID, Username, Active FROM adminUsers WHERE Username = "'.mysql_real_escape_string($_POST['username']).'" AND Password = "'.mysql_real_escape_string(md5($_POST['password'])).'"');

			if(mysql_num_rows($query) == 1)
			{
				$row = mysql_fetch_assoc($query);
				if($row['Active'] == 1)
				{
					$_SESSION['user_id'] = $row['ID'];
					$_SESSION['logged_in'] = TRUE;
					header("Location: members.php");
				}
				else {
					$error = 'nem aktivalt';
				}
			}
			else {
				$error = 'Hibas login !';
			}
		}
		else {
			$error = 'Add meg a usernevet es a jelszot';
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/admin.css" />
<title>Publications Administration Tool &raquo; Login</title>
</head>

<body class="belepes">
<div id="index">
	<div class="logo"></div>
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
	<div class="belepes_box">
		<div class="clear65"></div>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
		    <div class="text">Felhasználónév</div>
	 	    <div class="mezo"><input type="text" id="username" name="username" value="" /></div>
		    <div class="text">Jelszó</div>
		    <div class="mezo"><input type="password" id="password" name="password" value="" /></div>
		    <div class="button"><input type="submit" name="Login" value="Belépés" /></div>
		</form>
	</div>
</div>
</body>
</html>
