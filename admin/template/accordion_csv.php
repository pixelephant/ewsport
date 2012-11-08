<?php

/**
 * @author peter
 * @copyright 2008
 */
?>
<h3 class="toggler atStart">Export CSV</h3>
<div class="element atStart">
	
<script type="text/javascript">
 //betoltes utan lefut
window.addEvent('domready', function()
{
	var export_plusz_datum_run = export_plusz_datum();

});
</script>
<form id="formAcc" action="export/export_user_csv.php" method="POST" name="export">
  <div class="kereses_box">
  	<div class="title">Export CSV</div>
	<div class="text">Delimiter:</div>
	<div class="input">
	<select size="1" name="delimiter">
	  <option value="1">pontosvessző</option>
	  <option value="2">vessző</option>
    </select></div>
	
    <div class="text">Státusz:</div>
	<div class="input">
	<select size="1" name="statusz">
	  <option value="1">aktivált felhasználók</option>
	  <option value="2">inaktív felhasználók</option>
	  <option value="3">minden felhasználó</option>
    </select></div>

    <div class="text">Fájl neve:</div>
    <div class="input">
	<input type="text" id="csv_fajlNeve" name="file_name" value="" /></div>

    <div class="text">+ Dátum:</div>
    <div class="input_datum">
	<input type="checkbox" id="csv_pluszDatum" name="file_datum" value="1" class="check" /></div>
    
    <div class="clear20"></div>
	<div class="button"><input class="inp_but" type="submit" value="Export" name="Submit4"></div>

  </div>
  <div class="clear"></div>
</form>
	</div>