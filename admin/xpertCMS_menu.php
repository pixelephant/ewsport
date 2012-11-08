<?php
include 'config.php';
include '_sql.php';
include '_kodok.php';
include "template/_start.php";
$oldalnev = 'Doboz módosítása / felvitele';
$oldalleiras = 'Doboz módosítása / felvitele.';
include 'template/_fejlecszerkeszto.php';


include 'config.php';

$id = (int)$id;
if ($urlap == 1) {
    $process["error"]["warnings"] = array();
    if ((int)$parentid == -1) {
        $process["error"]["warnings"][] = "Nincs megadva a menü főmenüje!";
    }
    if ($name == "") {
        $process["error"]["warnings"][] = "Nincs megadva a menü neve!";
    }

	// ismertető kép törlés
	if($ismpic_del)
	{
		@unlink(DIRMENU.$id."/leads.jpg");
		@unlink(DIRMENU.$id."/leada.gif");
		@unlink(DIRMENU.$id."/leadb.jpg");
		@unlink(DIRMENU.$id."/leadc.jpg");
		@unlink(DIRMENU.$id."/leadm.jpg");
		@unlink(DIRMENU.$id."/_orig.jpg");
	}

    $active = ($active == "y") ? "y" : "n";
	//if($tipus != "lista" && $tipus != "cikk")$tipus = "x";
    $visible = ($visible == "y") ? "y" : "y";
    $skin = (int)$skin;
    $number = (int)$number;
    $gyorsmenu = (int)$gyorsmenu;

    if (count($process["error"]["warnings"]) == 0) {
		
		$pic_visible = (int)$pic_visible;
		
        $p = "number='$number'";
        $p .= ", parentid='$parentid'";
        $p .= ", active='$active'";
        $p .= ", visible='$visible'";
        $p .= ", skin='$skin'";
        $p .= ", name='$name'";
        $p .= ", tipus='$tipus'";
        $p .= ", text='$text'";
        $p .= ", list_lead='$list_lead'";
        $p .= ", pic_visible='$pic_visible'";
		$p .= ",title='$title'";
		$p .= ",keywords='$keywords'";
		$p .= ",description='$description'";

        if ($id == 0) {
            $p = "INSERT INTO nmMenus SET $p";
        } else {
            $p = "UPDATE nmMenus SET $p WHERE id='$id'";
        }

        gsql_parancs($p);

        if ($id == 0) {
            $id = mysql_insert_id();
        }
		
		$t = gsql_numassoc("select url from nmMenus where id=".(int)$parentid);
		$turl = "";
		$url = make_url($name, 255);
		if (strlen ( $url ) > 200)
			$url = substr ( $url, 0, 200 );
		$s = 0;
		while ( true ) {
			$tmp = gsql_numassoc ( "SELECT * FROM nmMenus WHERE url='$url$s' AND id<>$id" );
			if (count ( $tmp ) == 0) {
				break;
			}
			$s ++;
		}
		if($t[0]["url"] != "")$turl = $t[0]["url"]."/";
		$url = $turl.$url;
		gsql_parancs ("UPDATE nmMenus SET url=\"$url\" WHERE id=$id");

		$textpath = DIRMENU . $id;
		if (!is_dir(DIRMENU . $id)) {
			mkdir(DIRMENU . $id, 0777);
		}
		@chmod(DIRMENU . $id, 0777);
		$textpath .= "/";
		
		// text lead képe
		clearstatcache();
		if (is_uploaded_file($_FILES["thumbnailfile"]["tmp_name"])) {
			kepeloallito($_FILES["thumbnailfile"]["tmp_name"], $textpath . $i, $config["text"]["leadpic"]);
		}

        Header("Location: xpertCMS_lista.php?mit=nmMenus&szuromezo=parentid&szuroid=$parentid&".session_name()."=".session_id());
        die();
    }
} elseif ($id == 0) {

} else {
    $tmp = gsql_numassoc("SELECT * FROM nmMenus WHERE id='$id'");
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
    $text = $tmp["text"];
    $list_lead = $tmp["list_lead"];
    $pic_visible = $tmp["pic_visible"];
    $title = $tmp["title"];
    $keywords = $tmp["keywords"];
    $description = $tmp["description"];
}

if(!$tipus)$tipus = "cikk";
if(!$active)$active = "y";
?>
	<div id="container2">
	<form action="xpertCMS_menu.php" name="form2" id="form2" method="post" enctype="multipart/form-data" onsubmit="return submitForm();">
   <input name="id" type="hidden" value="<? echo $id; ?>">
	<input type="hidden" name="urlap" value="1">
	<div class="form form_bgr">
		<div class="text"><label for="fomenu">Főmenüje:</label></div>
		<div class="input">
<select name="parentid" size='1' id="fomenu" title="Nincs megadva a főmenü">
  <option value="-1">--- válassz ---</option>
  <option value="0" <? if ($parentid == 0)
    echo " selected=\"selected\""; ?>>--- Főmenü ---</option>
<?
foreach ($menunames as $k => $v) {
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
    
	<div class="form">
		<div class="text"><label for="name">Pozíció:</label></div>
		<div class="input2"><input id="number" name="number" type="text" value="<?= $number; ?>" /></div>
	<div class="clear"></div>
	</div>

	<div class="form form_bgr">
		<div class="text"><label for="name">Tipus:</label></div>
		<div class="input5"><input type="radio" name="tipus" value="cikk" <? if($tipus == "cikk")echo "checked";?> /> cikk jellegű &nbsp;&nbsp;&nbsp; <input type="radio" name="tipus" value="lista" <? if($tipus == "lista")echo "checked";?> /> lista jellegű (több cikket tartalmaz) &nbsp;&nbsp;&nbsp; <input type="radio" name="tipus" value="x" <? if($tipus == "x")echo "checked";?> /> nincs tartalma &nbsp;&nbsp;&nbsp; <input type="radio" name="tipus" value="egyeb" <? if($tipus == "egyeb")echo "checked";?> /> egyéb (pl. alsó menüpont)</div>
	<div class="clear"></div>
	</div>

	<div class="form">
		<div class="text">Menü aktív:</label></div>
		<div class="input"><input class="check" type="checkbox" name="active" value="y" <? if ($active ==
"y")
    echo "checked=\"checked\""; ?>></div>
	<div class="clear"></div>
	</div>

	<div class="form form_bgr">
		<div class="text"><label for="fokat">Listaoldalon bevezető:</label></div>
		<div class="szovegmezo">Ha a menü listaoldal, ez jelenik meg felül<br /><textarea name="text" id="text" rows="5" cols="25" style="width: 100%" class="mcelead_editor"><?=$text;?></textarea></div>
	</div>
	<div class="clear"></div>

	<div class="form">
		<div class="text"><label for="fokat">Listában bevezető:</label></div>
		<div class="szovegmezo">A menü főmenüpontjában, az almenü listában jelenik meg<br /><textarea name="list_lead" id="list_lead" rows="5" cols="25" style="width: 100%" class="mcelead_editor"><?=$list_lead;?></textarea></div>
	</div>
	<div class="clear"></div>

	<div class="form form_bgr">
		<div class="text"><label for="ismerteto_kep">Listában kép:</label>
<?
$textpath = DIRMENU . $id;
$textpath .= "/";
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
		<div class="text"><label for="fokat">Kép listában megjelenik:</label></div>
		<div class="szovegmezo"><input type="checkbox" name="pic_visible" value="1" <? if($pic_visible == 1)echo "checked";?> /></div>
	</div>
	<div class="clear"></div>

	<div class="form form_bgr">
		<div class="text"><label for="metaTitle">Lista Title:</label></div>
		<div class="input"><input type="text" value="<?= $title; ?>" name="title" /></div>
	<div class="clear"></div>
	</div>

	<div class="form">
		<div class="text"><label for="metaKeywords">Lista keywords:</label></div>
		<div class="input"><input type="text" value="<?= $keywords; ?>" name="keywords" /></div>
	<div class="clear"></div>
	</div>

	<div class="form form_bgr">
		<div class="text"><label for="metaKeywords">Lista description:</label></div>
		<div class="input"><textarea name="description" rows="6" cols="60"><?= $description; ?></textarea></div>
	<div class="clear"></div>
	</div>

	<div class="form" align="center">
		<input type="submit" name="" value="Rögzít" class="fobutton" />
	</div>


	</form>
			<script type="text/javascript">
			window.addEvent('domready', function(){
				var myFormValidation = new Validate('myForm',{
					errorClass: 'red',
				});
			});
			</script>
	</div>
<?php
include 'template/_sugo.php';
?>
