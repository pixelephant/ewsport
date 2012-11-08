<?php
header("Content-Type: text/html; charset=utf-8");
session_start();
require_once ('config.php');
include ('../functions/functions.php');
if ($_POST['username'] != '' && $_POST['password'] != '')
{
    //az username es password inputot osszeveti 'adminUsers' tablaval
    $query = mysql_query('SELECT ID, Username, Active, Name FROM nmAdminUsers WHERE Username = "' .
        mysql_real_escape_string($_POST['username']) . '" AND Password = "' .
        mysql_real_escape_string(md5($_POST['password'])) . '"');

    if (mysql_num_rows($query) == 1)
    {
        $row = mysql_fetch_assoc($query);
        if ($row['Active'] == 1)
        {
            $_SESSION['user_id'] = $row['ID'];
            $_SESSION['user_name'] = $row['Name'];
            $_SESSION['logged_in'] = true;
            header("Location: index.php");
        }
        else {
            $error = 'Nem aktiv';
        }
    }
    else {
        $error = 'Hibás felhasználó név és/vagy hibás jelszó';
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/admin.css" />
<title>Publications Administration Tool &raquo; Login</title>
<script type="text/javascript" src="../js/mootools.js"></script>
</head>

<body class="belepes">
<div id="index">
	<div class="logo"></div>
	<div class="belepes_box">
		<div class="clear65"></div>
		<form action="<?=$_SERVER['PHP_SELF']?>" id="loginForm" method="post">
			<? echo "<div class='error_text'>" . $error . "</div>";?>
		    <div class="text"><label for="username">Felhasználónév</label></div>
	 	    <div class="mezo"><input type="text" id="username" name="username" value="" /></div>
		    <div class="text"><label for="password">Jelszó</label></div>
		    <div class="mezo"><input type="password" id="password" name="password" value="" /></div>
		    <div class="button"><input type="submit" name="Login" value="Belép" title="submit" /></div>
		</form>
	</div>
</div>
</body>
</html>
