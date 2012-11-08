<?php
include 'config.php';
include '_sql.php';
include '_kodok.php';
include "template/_start.php";
$oldalnev = 'Doboz módosítása / felvitele';
$oldalleiras = 'Doboz módosítása / felvitele.';
include 'template/_fejlecszerkeszto.php';



//$hirlevel_id = (int)$_GET['hirlevel_id'];
if ($_POST['urlap'] == 1) {
    $myQuery = "hirlevel_cime='" . safeEscapeString(htmlspecialchars($_POST['hirlevel_cime'])) . "'";
    $myQuery .= ", hirlevel_targy='" . safeEscapeString(htmlspecialchars($_POST['hirlevel_targy'])) . "'";
    $myQuery .= ", hirlevel_plain_text='" . safeEscapeString($_POST['hirlevel_plain_text']) . "'";
    $myQuery .= ", hirlevel_html_text='" . safeEscapeString($_POST['hirlevel_html_text']) . "'";
    $myQuery .= ", loginuser_id='" . safeEscapeString($_SESSION['user_id']) . "'";

    if ($hirlevel_id == 0) {
    	$myQuery .= ", cDatum='" . $most . "'";
        $sql = "INSERT INTO nmHirlevel_texts SET $myQuery";
    } else {
        $sql = "UPDATE nmHirlevel_texts SET $myQuery WHERE hirlevel_id = $hirlevel_id";
    }
    $result = $db->query($sql);
    if ($hirlevel_id == 0) {
        $hirlevel_id = mysql_insert_id();
    }
    header('Location: xpertCMS_lista.php?mit=nmHirlevel_texts');
    die();

} else
    if ($hirlevel_id != 0) {
        $sql = "SELECT *
           FROM nmHirlevel_texts
           WHERE
           hirlevel_id = $hirlevel_id";
        $result = $db->query($sql);
        $row = $result->fetch();
        $hirlevel_cime = $row['hirlevel_cime'];
        $hirlevel_targy = $row['hirlevel_targy'];
        $hirlevel_plain_text = $row['hirlevel_plain_text'];
        $hirlevel_html_text = $row['hirlevel_html_text'];
    }
?>
	<div id="container2">
	<form method="post" id="myForm" action="xpertCMS_hirlevel.php">
	<input type="hidden" name="urlap" value="1">
	<input type="hidden" name="hirlevel_id" value="<?= $hirlevel_id; ?>">
	<div class="form form_bgr">
		<div class="text"><label for="Name">Címe:</label></div>
		<div class="input"><input type="text" value="<?= $hirlevel_cime; ?>" name="hirlevel_cime" id="hirlevel_cime" title="Nem adtad meg a hírlevél címét" />
		</div>
	<div class="clear"></div>
	</div>

	<div class="form">
		<div class="text"><label for="Name">Tárgy:</label></div>
		<div class="input"><input type="text" value="<?= $hirlevel_targy; ?>" name="hirlevel_targy" id="hirlevel_targy" title="Nem adtad meg a hírlevél tárgyát" class="required" />
		</div>
	<div class="clear"></div>
	</div>
	
	<div class="form form_bgr">
		<div class="text"><label for="hirlevel_plain_text">Plain text:</label></div>
		<div class="input"><textarea name="hirlevel_plain_text" id="hirlevel_plain_text" style="width:100%; height:270px" ><?= $hirlevel_plain_text;?></textarea>
		</div>
	<div class="clear"></div>
	</div>
	
	<div class="form">
		<div class="text"><label for="Email">HTML:</label></div>
		<div class="input"><textarea id="hirlevel_html_text" name="hirlevel_html_text" class="mcefull_editor" style="width:635px; height:350px" ><?= $hirlevel_html_text; ?></textarea></div>
	<div class="clear"></div>
	</div>

	<div class="form" align="center">
		<input type="submit" name="" value="Rögzít" class="fobutton" />
	</div>
	</form>
	</div>
<?php
include 'template/_sugo.php';
?>
