<?php
include 'config.php';
include '_sql.php';
include '_kodok.php';
include "template/_start.php";
//$oldalnev = 'Doboz módosítása / felvitele';
//$oldalleiras = 'Doboz módosítása / felvitele.';
include 'template/_fejlecszerkeszto.php';

// új cikkcsoport
if($urlap == 1 && $name != "")
{
	$p = "name='$name'";
	$p .= ",info='$info'";
	$p .= ",termek_id='$termek_id'";
	$p .= ",sorrend='$sorr'";
	
	//echo $p;
    if ($id == 0) {
        $p = "INSERT INTO nmCikk SET $p";
    } else {
        $p = "UPDATE nmCikk SET $p WHERE id='$id'";
    }
	//echo $p;
    gsql_parancs($p);

    if ($id == 0) {
        $id = mysql_insert_id();
    }
	//header("location:xpertCMS_listacikkcs.php?id=".$id);
}


// új cikk feltöltése
if(isset($urlap_kepfel))
{
        if($name != "")
		{
			$sql_kep = "INSERT INTO nmCikkek (cikkcs_id, name, csom, me, informacio, sorrend) VALUES ('".$id."','".$name."','".$csom."','".$me."','".$informacio."','".$sorrend."')";
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
		$sql = "UPDATE nmCikkek SET name='".$kepnevek[$i]."', csom='".$kepcsom[$i]."', me='".$kepme[$i]."', informacio='".$kepinfo[$i]."', sorrend=".(int)$kepsorrend[$i]." WHERE id=".$i;
		//echo $sql;
		gsql_parancs($sql);
	}
	if(is_array($torol_pic))foreach($torol_pic as $tor_pic)
	{
		$sql = "DELETE FROM nmCikkek WHERE id=".$tor_pic;
		gsql_parancs($sql);
	}
}
//megnézzük, hogy vannak-e már képek feltöltve, ha igen, akkor egy tömbben eltároljuk az id-jukat
if(isset($id))
{
	$sql = "SELECT * FROM nmCikkek WHERE cikkcs_id=".$id." order by sorrend asc, id asc";
	$sorok = gsql_numassoc($sql);
	//echo $sql;
	foreach($sorok as $sor)
	{
		$gal_kepek[] = $sor;
	}
}

//lekérdezzük a termék nevét
$tomb_termek = gsql_numassoc("select * from nmCikk where id=".$id);
$tomb_termek = $tomb_termek[0];
$name = $tomb_termek["name"];
$info = $tomb_termek["info"];
$sorr = $tomb_termek["sorrend"];
if(!$termek_id)$termek_id = $tomb_termek["termek_id"];

?>
	<div id="container2">

<h2>Cikkek: <?=$tomb_termek["name"]?></h2>	

<form name="submitform" action="xpertCMS_listacikkcs.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="urlap" value="1" />
<input type="hidden" name="id" value="<?=$id?>" />
<input type="hidden" name="termek_id" value="<?=$termek_id?>" />
<?
if($error_message != "")echo '<span class="error">'.$error_message.'</span>';
?>
<h3>Cikkcsoport:</h3>
	<div class="form form_bgr">
		<div class="text"><label for="galnamehu">Név:</label></div>
		<div class="input3"><input type="text" name="name" value="<?=$name?>" /></div><br />
		<div class="clear"></div>
		<div class="text"><label for="galnamehu">Info:</label></div>
		<div class="input3"><textarea name="info" rows="3" cols="50"><?=$info?></textarea></div><br />
		<div class="clear"></div>
		<div class="text">Sorrend:</div>
		<div class="input3"><input type="text" name="sorr" value="<?=$sorr?>" /></div><br />
		<div class="clear"></div>
		<div class="text">&nbsp;</div>
		<div class="input5"><input type="submit" name="" value="Felvitel" class="fobutton" /></div>
		<div class="clear"></div>
	</div>
</form>
<br />

<?
if(isset($id))//ha nem új galéria feltöltés, ekkor jöhet a képfeltöltés
{
?>
	<h3>Új cikk feltöltése a cikkcsoporthoz:</h3>
	<form method="post" id="myForm" action="xpertCMS_listacikkcs.php">
	<input type="hidden" name="urlap_kepfel" value="1" />
	<input type="hidden" name="id" value="<?=$id?>" />
	<input type="hidden" name="termek_id" value="<?=$termek_id?>" />
	<div class="form form_bgr">
		<div class="text"><label for="galnamehu">Cikk neve:</label></div>
		<div class="input3"><input type="text" value="" name="name" id="" style="width:100px;" /> &nbsp;&nbsp;&nbsp;&nbsp; 
		Csomagolás: <input type="text" value="" name="csom" id="" style="width:60px;" /> &nbsp;&nbsp;&nbsp;&nbsp; 
		Mértékegység: <input type="text" value="" name="me" id="" style="width:60px;" /> &nbsp;&nbsp;&nbsp;&nbsp; 
		Sorrend: <input type="text" value="" name="sorrend" id="" style="width:30px;" /></div><br />
		<div class="clear"></div>
		<div class="text"><label for="galnamehu">Információ:</label></div>
		<div class="input3"><textarea name="informacio" rows="3" cols="30"></textarea></div><br />
		<div class="clear"></div>
		<div class="text">&nbsp;</div>
		<div class="input5"><input type="submit" name="" value="Felvitel" style="cursor:pointer;" /></div>
		<div class="clear"></div>
	</div>
	</form>
<?
}
?>


<?
//ez a rész akkor van, amikor már képek is vannak...
if(is_array($gal_kepek))
{
?>
	<h3>Feltöltött cikkek:</h3>
<form name="keptorol_form" action="xpertCMS_listacikkcs.php" method="post" onsubmit="return submitForm();" enctype="multipart/form-data">
<input type="hidden" name="urlap_keptorol" value="1" />
<input type="hidden" name="id" value="<?=$id?>" />
<input type="hidden" name="termek_id" value="<?=$termek_id?>" />
<table cellpadding="3" cellspacing="0" border="0" width="100%" class="submit">
<?
foreach($gal_kepek as $gal_kep)
{
	$kepnev = $gal_kep["name"];
	$kepsor = $gal_kep["sorrend"];
	$kepcsom = $gal_kep["csom"];
	$kepme = $gal_kep["me"];
	$kepinfo = $gal_kep["informacio"];
?>
  <tr>
    <td width="100%" align="left">
	Név: <input type="text" name="kepnevek[<?=$gal_kep["id"]?>]" value="<?=$kepnev?>" style="width:150px;" /> &nbsp;&nbsp;&nbsp;&nbsp; 
	Csomagolás: <input type="text" name="kepcsom[<?=$gal_kep["id"]?>]" value="<?=$kepcsom?>" style="width:60px;" /> &nbsp;&nbsp;&nbsp;&nbsp; 
	Mértékegység: <input type="text" name="kepme[<?=$gal_kep["id"]?>]" value="<?=$kepme?>" style="width:60px;" /> &nbsp;&nbsp;&nbsp;&nbsp; 
	Sorrend: <input type="text" name="kepsorrend[<?=$gal_kep["id"]?>]" value="<?=$kepsor?>" style="width:30px;" />
  </tr>
  <tr>
    <td width="100%" align="left">
	Információ: <textarea name="kepinfo[<?=$gal_kep["id"]?>]" rows="3" cols="30"><?=$kepinfo?></textarea><br>
	Cikk törlése &raquo; <input type="checkbox" name="torol_pic[<?=$gal_kep["id"]?>]" value="<?=$gal_kep["id"]?>" /><br><hr></td>
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
