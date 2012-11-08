<?php
include 'config.php';
include '_sql.php';
include '_kodok.php';
include "template/_start.php";
$oldalnev = 'Doboz módosítása / felvitele';
$oldalleiras = 'Doboz módosítása / felvitele.';
include 'template/_fejlecszerkeszto.php';


include 'config.php';

if ($_POST["urlap"] == 1) 
{
	foreach($_POST["items"] as $k => $v)
	{
		gsql_parancs("update nmSettings set ertek='".$v."' where kulcs='".$k."'");
	}
	$process["error"]["warnings"][] = "Sikeres mentés!";
}


$settings = gsql_numassoc("select * from nmSettings order by sorrend asc");
?>
<h2>Beállítások</h2>

	<div id="container2">
	
	<form name="settingsForm" method="post" action="xpertCMS_settings.php">
	<input type="hidden" name="urlap" value="1" />
	<div>

		<?
		$i = 0;
		foreach($settings as $s)
		{
			$i++;
		?>
		<div class="form<? echo ($i%2) ? "" : " form_bgr"?>">
			<div class="text"><label for="fokat"><?=$s["leiras"]?></label></div>
			<div class="input">
			<textarea name="items[<?=$s["kulcs"]?>]" rows="3" cols="" style="width:100%; overflow:auto;"><?=$s["ertek"]?></textarea>
			</div>
		</div>
		<div class="clear"></div>
		<?
		}
		?>
		
	</div>
	<div class="form" align="center">
		<input type="submit" name="" value="Rögzít" class="fobutton" />
	</div>
	</form>
	
	</div>
<?php
include 'template/_sugo.php';
?>
