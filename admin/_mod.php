<?php
include 'config.php';
include '_sql.php';
include '_kodok.php';
include "template/_start.php";
$oldalnev = 'Doboz módosítása / felvitele';
$oldalleiras = 'Doboz módosítása / felvitele.';
include 'template/_fejlecszerkeszto.php';
?>
	<form action="/">
		<fieldset>
			<legend>Alternate styling: dashboard</legend>

			<label for="date2">Date</label>
			<input id="date2" name="date2" type="text" />
		</fieldset>
	</form>
	
	
	<div class="form" align="center">
		<input type="submit" name="" value="Rögzít" class="fobutton" />
	</div>
<?php
include 'template/_sugo.php';
?>
