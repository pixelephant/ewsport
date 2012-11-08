<body>
<div id="wrapper">
	<div id="container">
<?php
if ($_GET ['menu_type'] == 1) {
	include ('includes/html_elements/utazas_menu.php');
}
else if ($_GET ['menu_type'] == 2) {
	include ('includes/html_elements/sport_menu.php');
}
?>