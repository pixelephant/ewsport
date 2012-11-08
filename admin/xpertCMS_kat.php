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
    if ((int)$parentid == -1) {
        $process["error"]["warnings"][] = "Nincs megadva a menü főmenüje!";
    }
    if ($name == "") {
        $process["error"]["warnings"][] = "Nincs megadva a menü neve!";
    }

    $active = ($active == "y") ? "y" : "n";
	//if($tipus != "lista" && $tipus != "cikk")$tipus = "x";
    $visible = ($visible == "y") ? "y" : "y";
    $skin = (int)$skin;
    $number = (int)$number;
    $gyorsmenu = (int)$gyorsmenu;

    if (count($process["error"]["warnings"]) == 0) {

        $p = "number='$number'";
        $p .= ", parentid='$parentid'";
        $p .= ", active='$active'";
        $p .= ", visible='$visible'";
        $p .= ", skin='$skin'";
        $p .= ", name='$name'";
        $p .= ", tipus='$tipus'";

        if ($id == 0) {
            $p = "INSERT INTO nmTermekKat SET $p";
        } else {
            $p = "UPDATE nmTermekKat SET $p WHERE id='$id'";
        }

        gsql_parancs($p);
		//updateMenuXML(); // a publikus oldalhoz frissíti az xml-t
        if ($id == 0) {
            $id = mysql_insert_id();
        }
        $t = gsql_numassoc ( "SELECT * FROM nmTermekKat WHERE id=$id" );
		$url = make_url($katnames [$id], 255);
		//echo $katnames [$id];
		//die();
		if (strlen ( $url ) > 200)
			$url = substr ( $url, 0, 200 );
		$s = "";
		while ( true ) {
			$tmp = gsql_numassoc ( "SELECT * FROM nmTermekKat WHERE url='$url$s' AND id<>$id" );
			if (count ( $tmp ) == 0) {
				break;
			}
			$s ++;
		}
		
		$textpath = DIRKAT . $id;
		if (!is_dir(DIRKAT . $id)) {
	    	mkdir(DIRKAT . $id, 0777);
		}
		@chmod(DIRKAT . $id, 0777);
		$textpath .= "/";
		
        clearstatcache();
    	if (is_uploaded_file($_FILES["thumbnailfile"]["tmp_name"])) {
        	kepeloallito($_FILES["thumbnailfile"]["tmp_name"], $textpath . $i, $config["text"]["termekkat"]);
    	}
		
		gsql_parancs ("UPDATE nmTermekKat SET url=\"$url\" WHERE id=$id");
        Header("Location: xpertCMS_lista.php?mit=nmTermekKat&szuromezo=parentid&szuroid=$parentid&".session_name()."=".session_id());
        die();
    }
} elseif ($id == 0) {

} else {
    $tmp = gsql_numassoc("SELECT * FROM nmTermekKat WHERE id='$id'");
    $tmp = $tmp[0];
    $parentid = $tmp["parentid"];
    $name = $tmp["name"];
    $number = $tmp["number"];
    $active = $tmp["active"];
    $visible = $tmp["visible"];
    $skin = $tmp["skin"];
    $tipus = $tmp["tipus"];
    $number = $tmp["number"];
    $boxid = $tmp["boxid"];
    $idezet = $tmp["idezet"];
    $idezetala1 = $tmp["idezetala1"];
    $idezetala2 = $tmp["idezetala2"];
    $gyorsmenu = $tmp["gyorsmenu"];
    
	$textpath = DIRKAT . $id;
	if (!is_dir(DIRKAT . $id)) {
	    mkdir(DIRKAT . $id, 0777);
	}
	@chmod(DIRKAT . $id, 0777);
	$textpath .= "/";
}
?>
	<div id="container2">
	<form action="xpertCMS_kat.php" name="form2" id="form2" method="post" enctype="multipart/form-data" onsubmit="return submitForm();">
   <input name="id" type="hidden" value="<? echo $id; ?>">
	<input type="hidden" name="urlap" value="1">
	<div class="form form_bgr">
		<div class="text"><label for="fomenu">Főkategóriája:</label></div>
		<div class="input">
<select name="parentid" size='1' id="fomenu" title="Nincs megadva a főkategória">
  <option value="-1">--- válassz ---</option>
  <option value="0" <? if ($parentid == 0)
    echo " selected=\"selected\""; ?>>--- Főkategória ---</option>
<?
$kats = gsql_2assoc("select id, name from nmTermekKat where parentid=0");
foreach ($kats as $k => $v) {
?>
    <option value="<? echo $k ?>"<? if ($k == $parentid)
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
		<div class="input2"><input id="name" name="name" type="text" value="<?= $name; ?>" /></div>
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
	</div-->
    
	<div class="form">
		<div class="text"><label for="name">Pozíció:</label></div>
		<div class="input2"><input id="number" name="number" type="text" value="<?= $number; ?>" /></div>
	<div class="clear"></div>
	</div>

	<div class="form">
		<div class="text">Kategória aktív:</label></div>
		<div class="input"><input class="check" type="checkbox" name="active" value="y" <? if ($active ==
"y")
    echo "checked=\"checked\""; ?>></div>
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
