<body>
<div id="wrapper">
<div class="seo_text seo_text_inner">EW Utazási és Sport Iroda Kft., 1126. Budapest, Dolgos utca 2/2., (MOM PARK melletti sétány)<br />
Tel.: + 36 / 1 / 225 13 45, Fax: + 36 / 1 / 225 13 46, Mobil: + 36 / 30 / 9 147 157, + 36 / 30 / 9 400 679</div>
	<div id="container">
<?php
if ($_GET ['menu_type'] == 1) {
	include ('includes/html_elements/utazas_menu.php');
}
else if ($_GET ['menu_type'] == 2) {
	include ('includes/html_elements/sport_menu.php');
}
?>