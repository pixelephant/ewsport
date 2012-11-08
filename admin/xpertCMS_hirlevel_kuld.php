<?php
include 'config.php';
include '_sql.php';
include '_kodok.php';
include "template/_start.php";

include '../functions/func_mail.php';

$oldalnev = 'Doboz módosítása / felvitele';
$oldalleiras = 'Doboz módosítása / felvitele.';
include 'template/_fejlecszerkeszto.php';


include 'config.php';
ini_set('display_errors', '1');

$sqlHirlevel = "SELECT * FROM nmHirlevel_texts";
$resultHirlevel = $db->query($sqlHirlevel);
?>
<script type="text/javascript">		
		window.addEvent('domready', function() {
			$('registerForm').addEvent('submit', function(e) {
				e.stop();
				var log_res = $('log');
				this.set('send', {evalScripts: true,onComplete: function(response) { 
					log_res.set('html', response);
				}});
				this.send();
			});
		});
</script>

	<div id="log">
		<div id="log_res">
		<!-- SPANNER -->
		</div>
	</div>
	<div id="container2">
<?
?>
	<form method="post" id="registerForm" action="ajax/hirlevel_kuld.php">
	<input type="hidden" name="urlap" value="1">
	<input type="hidden" name="hirlevel_id" value="<?= $hirlevel_id; ?>">
	<input type="hidden" name="l_userid" value="<?= $_SESSION['user_id']; ?>">
	<div class="form form_bgr">
		<div class="text"><label for="Name">Hírlevél:</label></div>
		<div class="input">
		<select class="required" name="hirlevel_select" id="hirlevel_select" title="Nem választottál hírlevelet">
	      <option value="">-- válassz --</option>
<?php
while ($rowHirlevel = $resultHirlevel->fetch()) {
?>
	      <option value="<?= $rowHirlevel['hirlevel_id']; ?>"><?= $rowHirlevel['hirlevel_cime']; ?> - <?= $rowHirlevel['hirlevel_targy']; ?></option>
<?
}
?>
        </select>
		</div>
	<div class="clear"></div>
	</div>

	<div class="form">
		<div class="text"><label for="Name">Címzettek:</label></div>
		<div class="input">
		  <input type="text" value="" name="teszt_cimzett" /><br />
		  A címzettek e-mail címét egymástól vesszővel elválasztva kell beírni
		</div>
	<div class="clear"></div>
	</div>

	<div class="form">
		<div class="text">Csoportok:</div>
		<div class="input4"><input type="checkbox" value="1" class="check" name="teszt" id="teszt"/> <label for="teszt">Teszt</label></div>
		<div class="input4"><input type="checkbox" value="kulso" class="check" name="csoport[]" id="kulso"/> <label for="kulso">Regisztraltak</label></div>
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
