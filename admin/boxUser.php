<?php
include 'config.php';
include '_sql.php';
include '_kodok.php';
include "template/_startBox.php";
$oldalnev = 'Doboz módosítása / felvitele';
$oldalleiras = 'Doboz módosítása / felvitele.';


include 'config.php';

$Uid = (int)$Uid;

if ($Uid != 0) {
    $sql = "SELECT *
           FROM account
           WHERE
           Uid = $Uid";
    $result = $db->query($sql);
    $row = $result->fetch();
}
?>
	<div id="container2">
	<form method="post" id="myForm" action="xpertCMS_fokategoria.php">
	<input type="hidden" name="urlap" value="1">
	<input type="hidden" name="Uid" value="<?= $row['Uid']; ?>">
	<div class="form form_bgr">
		<div class="text">UID:</div>
		<div class="input"><?= $row['Uid']; ?></div>
	<div class="clear"></div>
	</div>
	
	<div class="form">
		<div class="text">Felhasználónév:</div>
		<div class="input"><?= $row['accnev']; ?></div>
	<div class="clear"></div>
	</div>
	
	<div class="form form_bgr">
		<div class="text">E-mail cím:</div>
		<div class="input"><?= $row['accemail']; ?></div>
	<div class="clear"></div>
	</div>
	
	<div class="form">
		<div class="text">Jelszó:</div>
		<div class="input"><?= $row['accpass']; ?></div>
	<div class="clear"></div>
	</div>
	
	<div class="form form_bgr">
		<div class="text">Hírlevelet kér:</div>
		<div class="input"><?= $row['hirlevel'] == 1 ? 'igen' : 'nem'; ?></div>
	<div class="clear"></div>
	</div>
	
	<div class="form">
		<div class="text">Neme:</div>
		<div class="input"><?= $row['accnem'] == 1 ? 'nő' : 'férfi'; ?></div>
	<div class="clear"></div>
	</div>
	
	<div class="form form_bgr">
		<div class="text">Születési évszám:</div>
		<div class="input"><?= $row['szuletesi_evszam']; ?></div>
	<div class="clear"></div>
	</div>
	
	<div class="form">
		<div class="text">Utolsó belépés:</div>
		<div class="input"><?= $row['lLogin'] != NULL ? $row['lLogin'] : 'még nem lépett be egyszer sem'; ?></div>
	<div class="clear"></div>
	</div>
	
	<div class="form form_bgr">
		<div class="text">Regisztráció dátuma:</div>
		<div class="input"><?= $row['regDatum']; ?></div>
	<div class="clear"></div>
	</div>
	
	<div class="form">
		<div class="text">Belépések száma:</div>
		<div class="input"><?= $row['loginNum'] != NULL ? $row['loginNum'] : '0'; ?></div>
	<div class="clear"></div>
	</div>
	
	<div class="form form_bgr">
		<div class="text">Kép:</div>
		<div class="input"></div>
	<div class="clear"></div>
	</div>
	
	<!--<div class="form" align="center">
		<input type="submit" name="" value="Rögzít" class="fobutton" />
	</div>-->
	</form>
	</div>
<?php
include 'template/_sugo.php';
?>
