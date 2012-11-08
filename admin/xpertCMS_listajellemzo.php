<?php
include 'config.php';
include '_sql.php';
include '_kodok.php';
include "template/_start.php";
//$oldalnev = 'Doboz módosítása / felvitele';
//$oldalleiras = 'Doboz módosítása / felvitele.';
include 'template/_fejlecszerkeszto.php';

if(isset($urlap_kepfel))
{
        if($name != "")
		{
			$sql_kep = "INSERT INTO nmJellemzok (termek_id, name, sorrend) VALUES ('".$id."','".$name."','".$sorrend."')";
			//echo $sql_kep;
			gsql_parancs($sql_kep);
			
		}
}

//képtörlés és aláírás módosítás
if(isset($urlap_keptorol))
{
	//print_r($_FILES["pdfs"]);
	if(is_array($kepnevek))foreach($kepnevek as $i => $kepala)
	{
		$sql = "UPDATE nmJellemzok SET name='".$kepnevek[$i]."', sorrend=".(int)$kepsorrend[$i]." WHERE id=".$i;
		//echo $sql;
		gsql_parancs($sql);
	}
	if(is_array($torol_pic))foreach($torol_pic as $tor_pic)
	{
		$sql = "DELETE FROM nmJellemzok WHERE id=".$tor_pic;
		gsql_parancs($sql);
	}
}
//megnézzük, hogy vannak-e már képek feltöltve, ha igen, akkor egy tömbben eltároljuk az id-jukat
if(isset($id))
{
	$sql = "SELECT * FROM nmJellemzok WHERE termek_id=".$id." order by sorrend asc, id asc";
	$sorok = gsql_numassoc($sql);
	//echo $sql;
	foreach($sorok as $sor)
	{
		$gal_kepek[] = $sor;
	}
}

//lekérdezzük a termék nevét
$tomb_termek = gsql_numassoc("select * from nmTermekek where id=".$id);
$tomb_termek = $tomb_termek[0];

?>
<script language="JavaScript" type="text/javascript">
<!--

function setCheckboxes(the_form, do_check) {
    var elts = document.forms[the_form].elements['selected_ids[]'];

    var elts_cnt  = (typeof(elts.length) != 'undefined')
                  ? elts.length
                  : 0;

    if (elts_cnt) {
        for (var i = 0; i < elts_cnt; i++) {
            elts[i].checked = do_check;
        } // end for
    } else {
        elts.checked        = do_check;
    } // end if... else

    return true;
} // end of the 'setCheckboxes()' function

-->
</script>
	<div id="container2">

<h2>Jellemzők: <?=$tomb_termek["name"]?></h2>	
	

	<form method="post" id="myForm" action="xpertCMS_listajellemzo.php">
	<input type="hidden" name="urlap_kepfel" value="1" />
	<input type="hidden" name="id" value="<?=$id?>" />
	<div class="form form_bgr">
		<div class="text"><label for="galnamehu">Jellemző neve:</label></div>
		<div class="input3"><input type="text" value="" name="name" id="galnamehu" style="width:200px;" /> &nbsp;&nbsp;&nbsp;&nbsp; Sorrend: <input type="text" value="" name="sorrend" id="galnamehu" style="width:30px;" /></div>
		<div class="clear"></div>
		<div class="text">&nbsp;</div>
		<div class="input5"><input type="submit" name="" value="Felvitel" class="fobutton" /></div>
		
	<div class="clear"></div>
	</div>
	</form>


<?
//ez a rész akkor van, amikor már képek is vannak...
if(is_array($gal_kepek))
{
?>
<form name="keptorol_form" action="xpertCMS_listajellemzo.php" method="post" onsubmit="return submitForm();" enctype="multipart/form-data">
<input type="hidden" name="urlap_keptorol" value="1" />
<input type="hidden" name="id" value="<?=$id?>" />
<table cellpadding="3" cellspacing="0" border="0" width="100%" class="submit">
  <tr>
    <td width="100%" align="left"><br><strong>Feltöltött jellemzők:</strong><br /><br /></td>
  </tr>
<?
foreach($gal_kepek as $gal_kep)
{
	$kepnev = $gal_kep["name"];
	$kepsor = $gal_kep["sorrend"];
?>
  <tr>
    <td width="100%" align="left">
	Név: <input type="text" name="kepnevek[<?=$gal_kep["id"]?>]" value="<?=$kepnev?>" style="width:200px;" /> &nbsp;&nbsp;&nbsp;&nbsp; 
	Sorrend: <input type="text" name="kepsorrend[<?=$gal_kep["id"]?>]" value="<?=$kepsor?>" style="width:30px;" /> &nbsp;&nbsp;&nbsp;&nbsp; 
	Jellemző törlése &raquo; <input type="checkbox" name="torol_pic[<?=$gal_kep["id"]?>]" value="<?=$gal_kep["id"]?>" /><br><hr></td>
  </tr>
<?	
}
?>  
  <tr>
    <td width="100%" align="left"><br><input type="submit" value="kijelöltek törlése" />&nbsp;&nbsp;&nbsp;<input type="submit" value="jellemzők nevének módosítása" /></td>
  </tr>
</table>
</form>
<?
}
?>

	</div>
<?php
include 'includes/htmlelements/_sugo.php';
?>
