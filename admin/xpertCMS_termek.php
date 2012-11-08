<?php
include 'config.php';
include '_sql.php';
include '_kodok.php';
include "template/_start.php";
$oldalnev = 'Doboz módosítása / felvitele';
$oldalleiras = 'Doboz módosítása / felvitele.';
include 'template/_fejlecszerkeszto.php';

$id = (int)$id;
if ($urlap == 1) {
    $process["error"]["warnings"] = array();
    if ($name == "") {
        $process["error"]["warnings"][] = "Nincs megadva a menü neve!";
    }
    $number = (int)$number;

    if (count($process["error"]["warnings"]) == 0) {

        $p = "title='$title'";
        $p .= ", keywords='$keywords'";
        $p .= ", description='$description'";
        $p .= ", kategoria='$kategoria'";
        $p .= ", name='$name'";
        $p .= ", number='$number'";
        $p .= ", gyarto='$gyarto'";

        if ($id == 0) {
            $p = "INSERT INTO nmTermekek SET $p";
        } else {
            $p = "UPDATE nmTermekek SET $p WHERE id='$id'";
        }
		//echo $p;
        gsql_parancs($p);
		//updateMenuXML(); // a publikus oldalhoz frissíti az xml-t
        if ($id == 0) {
            $id = mysql_insert_id();
        }

        Header("Location: xpertCMS_lista.php?mit=nmTermekek&szuromezo=kategoria&szuroid=".$kategoria);
        die();
    }
} elseif ($id == 0) {

} else {
    $tmp = gsql_numassoc("SELECT * FROM nmTermekek WHERE id='$id'");
    $tmp = extract($tmp[0]);
}
$query_gyartok = gsql_2assoc("SELECT id, name FROM nmParameterek WHERE parentid=1");
?>
	<div id="container2">
	<form action="xpertCMS_termek.php" name="form2" id="form2" method="post" onsubmit="return submitForm();">
   <input name="id" type="hidden" value="<? echo $id; ?>">
	<input type="hidden" name="urlap" value="1">
	<!--div class="form">
		<div class="text"><label for="metaTitle">Title:</label></div>
		<div class="input"><input type="text" value="<?= $title; ?>" name="title" /></div>
	<div class="clear"></div>
	</div>
	<div class="form form_bgr">
		<div class="text"><label for="metaKeywords">Meta keywords:</label></div>
		<div class="input"><input type="text" value="<?= $keywords; ?>" name="keywords" /></div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text"><label for="metaKeywords">Meta description:</label></div>
		<div class="input"><input type="text" value="<?= $description; ?>" name="description" /></div>
	<div class="clear"></div>
	</div-->
	<div class="form">
		<div class="text"><label for="kategoria">Kategória:</label></div>
		<div class="input">
<select name="kategoria" size='1' id="kategoria" title="Nincs megadva a főkategória">
  <option value="0">--- válassz ---</option>
<?
$kats = gsql_2assoc("select id, name from nmTermekKat as ntk where ntk.parentid<>0 and (select count(id) from nmTermekKat where id=ntk.parentid)>0");
foreach ($kats as $k => $v) {
?>
    <option value="<? echo $k ?>"<? if ($k == $kategoria)
        echo " selected=\"selected\""; ?>><? echo
$v ?></option>
<?
}
?>
       </select>
        </div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text"><label for="name">Név:</label></div>
		<div class="input"><input id="name" name="name" type="text" value="<?= $name; ?>" /></div>
	<div class="clear"></div>
	</div>
    
	<div class="form">
		<div class="text"><label for="name">Pozíció:</label></div>
		<div class="input2"><input id="number" name="number" type="text" value="<?= $number; ?>" /></div>
	<div class="clear"></div>
	</div>

	<!--div class="form form_bgr">
		<div class="text"><label for="ismerteto_kep">Ismertető kép:</label>
<?
if (file_exists($textpath . "leads.jpg")) {
    echo " <a href=\"" . $textpath . "leads.jpg" . "\" rel=\"clearbox\">néz</a>";
}
?>
	</div>
		<div class="input">
		  <input name="thumbnailfile" type="file" />&nbsp;
<?
if (file_exists($textpath . "leads.jpg")) {
?>
		<input type="hidden" name="ismpic_del" id="ismpic_del" value="0" />
		<input type="submit" value="töröl" onclick="document.getElementById('ismpic_del').value='1';" class="fobutton" />
<?
}
?>
		</div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text"><label for="metaKeywords">Gyártók:</label></div>
		<div class="input"><?php FormSelect('gyarto', $query_gyartok, array(), '', '--Valassz--'); ?></div>
	<div class="clear"></div>
	</div>
	
	<div class="form">
		<div class="text"><label for="elm1">Termékjellemzők:</label></div>
		<div class="szovegmezo"><textarea name="termekjellemzok" id="elm1" rows="5" cols="25" style="width: 100%" class="mcelead_editor"><?=$termekjellemzok;?></textarea></div>
	<div class="clear"></div>
	</div-->
	<div class="form" align="center">
		<input type="submit" name="" value="Rögzít" class="fobutton" />
	</div>
	</form>

	</div>
<?php
include 'template/_sugo.php';
?>
