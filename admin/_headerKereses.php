<?php

/**
 * @author peter
 * @copyright 2008
 */



?>
<form action="xpertCMS_lista.php" method="get">
<input type="hidden" name="mit" value="<? echo $mit; ?>">
<input type="hidden" name="kereses" value="<? echo $kereses; ?>">
<input type="hidden" name="szuromezo" value="<? echo $szuromezo; ?>">
<input type="hidden" name="szuroid" value="<? echo $szuroid; ?>">
<div class="kereses_box">

	<div class="title">Keresés</div>
	<div class="text">Szó/részletfffffffffff:</div>
	<div class="input_all"><input name="kereses" value="<? echo dtxt2txt($kereses); ?>" /></div>
	<div class="text">Találat/oldal:</div>
		<div class="input"><select name="laponkent" onchange="form.submit()">
           <option <? echo ($laponkent==10 || $laponkent == "")?"selected":""; ?> value="10">10</option> 
           <option <? echo ($laponkent==20)?"selected":""; ?> value="20">20</option>
           <option <? echo ($laponkent==50)?"selected":""; ?> value="50">50</option> 
           <option <? echo ($laponkent==100)?"selected":""; ?> value="100">100</option></select></div>
	<div class="clear20"></div>
	<div class="button"><input class="inp_but" type="submit" value="Keresés" name="Submit4"></div>
</div>
<div class="clear"></div>
</form>