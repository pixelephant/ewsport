<?php
include 'config.php';
include '_sql.php';
include '_kodok.php';
include "template/_start.php";
include 'template/_fejlecszerkeszto.php';

function makeDir($alap, $uj)
{
    $s = explode("/", $uj);
    $dr = $alap;
    for ($i = 0; $i < count($s); $i++) {
        if (($dr != "") && (substr($dr, strlen($dr) - 1, 1) != "/"))
            $dr .= "/";
        $dr .= $s[$i];
        if (!is_dir($dr)) {
            mkdir($dr, 0777);
        }
        @chmod($dr, 0777);
    }
}
$jelolve = (int)$jelolve;

$id = (int)$id;

if ($urlap == "galery") {
    $process["error"]["warnings"] = array();
    $process["error"]["notice"] = array();
    if ($galnamehu == "") {
        $process["error"]["warnings"][] = "Nincs megadva a galéria neve!";
    }
    if (count($process["error"]["warnings"]) == 0) {
        if ($id == 0) {
            $p2 = "INSERT INTO nmGaleries SET namehu='$galnamehu', sorrend='$sorrend', type='$type'";
        } else {
            $p2 = "UPDATE nmGaleries SET namehu='$galnamehu', sorrend='$sorrend', type='$type' WHERE id=$id";
        }
        gsql_parancs($p2);
        if ($id == 0) {
            $id = mysql_insert_id();
        }
        Header("Location: xpertCMS_listagalery.php?id=$id");
        die();
    }
}

$galid = $id = (int)$id;
$picid = (int)$picid;

if ($picid != 0) {
    $p = "SELECT * FROM nmGalerypics WHERE id='$picid';";
    $tmp = gsql_numassoc($p);
    if (count($tmp) != 1) {
        die();
    }
    $picture = $tmp[0];
    $id = $picture[galeryid];
    $number = $picture[number];
}

if ($id != 0) {
    $p = "SELECT * FROM nmGaleries WHERE id='$id';";
    $tmp = gsql_numassoc($p);
    if (count($tmp) != 1) {
        die();
    }
    $galeria = $tmp[0];
    $galnamehu = $galeria["namehu"];
    $sorrend = $galeria["sorrend"];
    $type = $galeria["type"];
} else {
}

$galid = $id = (int)$id;
$picid = (int)$picid;

$oldalnev = "Galéria";
$oldalleiras = "Galéria.";

// jelöltek törlése
if (is_array($selected_ids)) {
    if (count($selected_ids) > 0) {
        foreach ($selected_ids as $iid) {
            gsql_parancs("DELETE FROM nmGalerypics WHERE id='$iid';");
            $bigpic = DIRGALERIA . "$galid/{$iid}b.jpg";
            $mediumpic = DIRGALERIA . "$galid/{$iid}m.jpg";
            $smallpic = DIRGALERIA . "$galid/{$iid}s.jpg";
            @unlink($bigpic);
            @unlink($mediumpic);
            @unlink($smallpic);
        }
    }
}

if ($urlap == "kep") {
    $process["error"]["warnings"] = array();
    $process["error"]["notice"] = array();

    $van_file_feltoltes = is_uploaded_file($_FILES["kepfile"]["tmp_name"]);

    if (($picid == 0) && (!$van_file_feltoltes)) {
        $process["error"]["warnings"][] = "Töltse fel a képet is!";
    }

    /*
    if (count($process["error"]["warnings"])==0) {
    if ($van_file_feltoltes) {
    $randnum = mt_rand ( 123456, 654321 );
    makeThumb( $kepfile, "upload/images/$randnum", 200, 100);
    if (!is_file("upload/images/$randnum")) {
    $process["error"]["warnings"][] = "A feltölttött fájl nem képfile! Jpeg fájlt töltsön fel!";
    }
    }
    }
    */


    if (count($process["error"]["warnings"]) == 0) {
        if (($namehu == "")) { // || ($nameen == "") || ($namede == "")
            $process["error"]["notice"][] =
                "Nem adta meg a kép nevét! (Nem kötelező megadni)";
            //        $process["error"]["notice"][] = "Nem adta meg mindhárom nyelven a kép nevét!";
        }
        $p = "namehu='$namehu'";
        $p .= ",nameen='$nameen'";
        $p .= ",namede='$namede'";
        $p .= ",number='$number'";

        if ($picid == 0) {
            $p .= ",galeryid='" . $id . "'";
            $p = "INSERT INTO nmGalerypics SET $p";
        } else {
            $p = "UPDATE nmGalerypics SET $p WHERE id='$picid'";
        }
        gsql_parancs($p);
        if ($picid == 0) {
            $picid = mysql_insert_id();
        }

        if ($van_file_feltoltes) {
            makeDir(DIRGALERIA, $galid);

            kepeloallito($_FILES["kepfile"]["tmp_name"], DIRGALERIA . $galid . "/" . $picid,
                $config["text"]["galery"]);

            //	$mediumpic = DIRGALERIA."$galid/{$picid}m.jpg";
            //	$smallpic = DIRGALERIA."$galid/{$picid}s.jpg";
            //        zsugoritnemnagyit($kepfile, $bigpic, BIGPICWIDTH, BIGPICHEIGHT);
            //        @chmod($bigpic, 0777);
            //        zsugoritnemnagyit($bigpic, $mediumpic, MEDIUMPICWIDTH, MEDIUMPICHEIGHT);
            //        @chmod($mediumpic, 0777);

            /*
            thumbnailfix($bigpic,
            $smallpic,
            100, SMALLPICWIDTH, 
            100, SMALLPICHEIGHT);
            //        zsugoritnemnagyit($bigpic, $smallpic, SMALLPICWIDTH, SMALLPICHEIGHT);
            */
            //        @chmod($smallpic, 0777);
        }

        $picid = 0;
        $kepalairas = "";

        Header("Location: xpertCMS_listagalery.php?id=$id");
        die();
    }
} elseif ($picid != 0) {
    $namehu = $picture["namehu"];
    $nameen = $picture["nameen"];
    $namede = $picture["namede"];
    $number = $picture["number"];
}
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
	
<!-- Képek létrehozása -->

	<form method="post" id="myForm" action="xpertCMS_listagalery.php">
	<input name="id" type="hidden" value="<? echo $id; ?>" />
    <input name="urlap" type="hidden" value="galery" />
	<div class="form form_bgr">
		<div class="text"><label for="galnamehu">Galéria neve:</label></div>
		<div class="input3"><input type="text" value="<?= $galnamehu; ?>" name="galnamehu" id="galnamehu" title="Nem adtad meg a galéria nevét" class="required" /></div>
		<div class="clear"></div>
		<div class="text"><label for="galnamehu">Sorrend:</label></div>
		<div class="input3"><input type="text" value="<?= $sorrend; ?>" name="sorrend" id="sorrend" title="" /></div>
		<div class="clear"></div>
		<div class="text"><label for="galnamehu">Tipus:</label></div>
		<div class="input5"><?php echo FormRadio('type', 's'); ?> sport <?php echo FormRadio('type', 'u'); ?> utazas </div>
		<div class="clear"></div>
		<div class="text">&nbsp;</div>
		<div class="input5"><input type="submit" name="" value="<? echo ($id == 0) ?
"   Létrehoz   " : "   Módosít   "; ?>" class="fobutton" /></div>
		
	<div class="clear"></div>
	</div>
	</form>

<!-- Képek létrehozása -->





<!-- Kép feltöltése -->

	<form enctype="multipart/form-data" id="form2" method="post" action="xpertCMS_listagalery.php">
    <input name="picid" type="hidden" value="<? echo $picid; ?>" />
    <input name="id" type="hidden" value="<? echo $id; ?>" />
    <input name="urlap" type="hidden" value="kep" />
<?
if ($id!=0) {

?>
	<div class="form">
		<div class="text">Kép feltöltése: </div>
<?
      if ($picid != 0) {
?>
        <img src="<? echo DIRGALERIA.$galid."/".$picid; ?>admin.jpg?<? echo mt_rand( 0, 9999); ?>" /><br />
<?
      }
?>
		<div class="input2"><input name="kepfile" type="file" size="20" class="file_input" /></div>
		<div class="input6">Kép neve: </div>
		<div class="input8"><input name="namehu" value="<? echo
$namehu; ?>" type="text" size="15" /></div>
		<div class="input7">Pozíció: </div>
		<div class="input_poz"><select name="number" class="poz_select">
<?
$tmp = gsql_numassoc("SELECT count(*) as max FROM nmGalerypics WHERE galeryid='$id'");
$maxsorrend = (int)$tmp[0]["max"];
if ($picid == 0) {
    $maxsorrend++;
}

$kepsorrend = ($number == 0) ? $maxsorrend : $number;
for ($i = 1; $i <= $maxsorrend; $i++) {
?>
     <option value="<? echo $i; ?>"<? echo ($i == $kepsorrend) ? "selected" : ""; ?>><? echo
$i; ?></option>
    <?
}
?>
	</select>
	</div>
	<div class="clear"></div>
	<div class="text">&nbsp;</div>
	<div class="input5"><input type="submit" name="" value="<?
echo (($picid != 0) ? "   Módosít   " : "   Felvisz   "); ?>" class="fobutton" /></div>
	</div>
	</form>
	
<!-- Kép feltöltése -->




<!-- Képek admin -->
	
    <form action="xpertCMS_listagalery.php" name="listaForm">
      <input name="id" type="hidden" value="<? echo $id; ?>">
      <input name="mit" type="hidden" value="<? echo $mit; ?>">
      <input name="picid" type="hidden" value="<? echo $picid; ?>">	
	  <div class="form<? echo ((++$ii % 2) ? " form_bgr" : ""); ?>">
		<div class="text"><strong>Kép</strong></div>
		<div class="input2"><strong>Kép neve</strong></div>
		<div class="input12"><strong>Szerkeszt</strong></div>
		<div class="input11"><strong>Pozíció</strong></div>
        <div class="input9"><strong>Töröl</strong></div>
		<div class="clear"></div>
<?
$p = "SELECT * FROM nmGalerypics WHERE galeryid='$galid' ORDER BY number;";
$tmp = gsql_selstart($p);
while ($sor = gsql_selnext($tmp)) {
?>	
		<div class="text"><img src="<? echo DIRGALERIA . $sor["galeryid"] . "/" . $sor["id"]; ?>admin.jpg?<? echo
mt_rand(0, 9999); ?>"></div>
		<div class="input2"><? echo $sor["namehu"]; ?></div>
		<div class="input12"><a href="xpertCMS_listagalery.php?id=<? echo $id; ?>&picid=<? echo
$sor["id"]; ?>">módosít</a></div>
		<div class="input11"><? echo $sor["number"]; ?></div>
        <div class="kep_check"><input name="selected_ids[]" type="checkbox" value="<? echo
$sor["id"]; ?>" class="check" /></div>
	<div class="clear"></div>
<?
}
?>
	</div>
	
	<!-- Képek admin -->
	
	
	<div class="form">
		<div class="input10">Összeset kijelöl <input class="check" type="checkbox" name="checkbox2" value="checkbox" onclick="setCheckboxes('listaForm', true); return false;"></div>
		<div class="clear"></div>
		
		<div class="input10"><input type="submit" name="" value="Kijelöltek törlése" class="fobutton" /></div>
	<div class="clear"></div>
	</div>

	<!--<div class="form" align="center">
		<input type="submit" name="" value="Rögzít" class="fobutton" />
	</div>-->
<?
}

?>
	</form>

<!-- Képek admin -->


			<!--<script type="text/javascript">
			window.addEvent('domready', function(){
				var myFormValidation = new Validate('myForm',{
					errorClass: 'red'
				});
			});
			</script>-->
	</div>
<?php
//include 'includes/htmlelements/_sugo.php';
?>
