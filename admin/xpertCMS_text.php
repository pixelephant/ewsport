<?php
include 'config.php';
include '_sql.php';
include '_kodok.php';
include "template/_start.php";
$oldalnev = 'Doboz módosítása / felvitele';
$oldalleiras = 'Doboz módosítása / felvitele.';
include 'template/_fejlecszerkeszto.php';

$dirpref = "../";

if (($menuid > 0) || ($id > 0)) {
    if ($menuid == 0) {
        $menuid = gsql_numassoc("SELECT menuid FROM nmTexts WHERE id=$id");
        $menuid = $menuid[0][menuid];
    }
    $tmp = gsql_numassoc("SELECT * FROM nmMenus WHERE id=$menuid");
	$menutipus = $tmp[0]["tipus"];
    $akciok = ($tmp[0]["skin"] == 99);
    $aktual = ($tmp[0]["skin"] == 100);
}
$thumbpic = "thumb";

/**
 * strdate2time()
 *
 * @param mixed $datum
 * @param mixed $ido
 * @return
 */
function strdate2time($datum, $ido)
{
    list($ev, $ho, $nap) = explode(".", $datum);
    list($ora, $perc) = explode(":", $ido);
    if (((int)$ev != 0) && ((int)$ho != 0) && ((int)$nap != 0))
        return mktime($ora, $perc, 0, $ho, $nap, $ev);
    return 0;
}

$id = (int)$id;

/**
 * tag2kod()
 *
 * @param mixed $s
 * @param bool $torol
 * @return
 */
function tag2kod($s, $torol = false)
{
    // törli a <BR>-t, a <p> => \n
    /*
    $s = str_replace("\n","", $s);
    */
    if ($torol) {
        $s = str_replace("<br>", "", $s);
        $s = str_replace("<br />", "", $s);
        $s = str_replace("<BR>", "", $s);
        $s = str_replace("<BR />", "", $s);
        $s = str_replace("<P>", "", $s);
        $s = str_replace("<p>", "", $s);
        $s = str_replace("</P>", "", $s);
        $s = str_replace("</p>", "", $s);
        $s = str_replace("\n", "", $s);
    }
    return $s;
}

/**
 * kod2tag()
 *
 * @param mixed $s
 * @return
 */
function kod2tag($s)
{
    if ((stristr($s, '<br') === false) && (stristr($s, '<p>') === false)) {
        $s = str_replace("\n", "<BR>", $s);
    }

    return $s;
}

$number = (int)$number;

$galeryid = (int)$galeryid;
$galeryinline = ($galeryinline == "y") ? "y" : "n";

if ($_POST['urlap'] == 1) {
    $active = ((int)$active == "y") ? "y" : "n";
    $thumbalign = ($thumbalign == "l") ? "l" : "r";
	
	// ismertető kép törlés
	if($ismpic_del)@unlink(DIRTEXT.$id."/leads.jpg");
	
    /*echo $menuid;
    die();*/
	$kiemelt = $kiemelt ? 1 : 0;
	$lead_visible = $lead_visible ? 1 : 0;
	$url = 
	
	$p = "active='$active'";
	$p .= ",kiemelt='$kiemelt'";
    $p .= ",name='$name'";
    $p .= ",name_en='$name_en'";
    $p .= ",menuid='$menuid'";
    $p .= ",lead='$elm1'";
    $p .= ",lead_en='$elm1_en'";
    $p .= ",lead_visible='$lead_visible'";
    $p .= ",text='$elm2'";
    $p .= ",text_en='$elm2_en'";
    $p .= ",activefromdate='$date2'";
    $p .= ",thumbalign='$thumbalign'";
    $p .= ",thumbalt='$thumbalt'";
    $p .= ",thumbtext='$thumbtext'";
    $p .= ",title='$title'";
    $p .= ",keywords='$keywords'";
    $p .= ",description='$description'";
    $p .= ",number='$number'";
    $p .= ",galeryid='$galeryid'";
    $p .= ",galeryinline='$galeryinline'";

    if ($id == 0) {
        $p .= ",created='$most()'"; // csak létrehozáskor
        $p = "INSERT INTO nmTexts SET $p";
    } else {
        $p = "UPDATE nmTexts SET $p WHERE id='$id'";
    }
    gsql_parancs($p);

    if ($id == 0) {
        $id = mysql_insert_id();
    }

        $t = gsql_numassoc ( "SELECT * FROM nmTexts WHERE id=$id" );
		$url = make_url($name, 255);
		if (strlen ( $url ) > 200)
			$url = substr ( $url, 0, 200 );
		$s = "";
		while ( true ) {
			$tmp = gsql_numassoc ( "SELECT * FROM nmTexts WHERE url='$url$s' AND id<>$id" );
			if (count ( $tmp ) == 0) {
				$url .= $s;
				break;
			}
			$s = (int)$s + 1;
		}
		gsql_parancs ("UPDATE nmTexts SET url=\"$url\" WHERE id=$id");

    $textpath = DIRTEXT . $id;
    if (!is_dir(DIRTEXT . $id)) {
        mkdir(DIRTEXT . $id, 0775);
    }
    @chmod(DIRTEXT . $id, 0775);
    $textpath .= "/";

    
	//echo $textpath;
	//die();
	
	// text lead képe
    clearstatcache();
    if (is_uploaded_file($_FILES["thumbnailfile"]["tmp_name"])) {
        kepeloallito($_FILES["thumbnailfile"]["tmp_name"], $textpath . $i, $config["text"]["leadpic"]);
    }

    // text képei:
	$erkepek = gsql_2assoc("select number, path from nmTextpics where textid=".$id);
    gsql_parancs("DELETE FROM nmTextpics WHERE textid=$id");
    foreach ($kepek as $i => $kep) {
        // van kép?
        $kepfile = "kepfile" . $i;
		
		$smallpic = $dirpref.$erkepek[$i]."s.jpg";
		//echo $smallpic."<br />";
        if ($kep["del"] == 1) {
            @unlink($dirpref.$erkepek[$i] . "a.jpg");
            @unlink($dirpref.$erkepek[$i] . "b.jpg");
            @unlink($dirpref.$erkepek[$i] . "c.jpg");
            @unlink($dirpref.$erkepek[$i] . "m.jpg");
            @unlink($dirpref.$erkepek[$i] . "s.jpg");
            continue;
        }

        // ha nincs feltöltve kép és
        // most sem töltött fel és
        // nincs megadva sem a név, sem az alt ==> tovább
        if (((is_uploaded_file($_FILES["kepfile" . $i]["tmp_name"])) || (file_exists($smallpic)))) {
        } else {
            continue;
        }


        clearstatcache();
		$kepelotag = $erkepek[$i];
        if (is_uploaded_file($_FILES["kepfile" . $i]["tmp_name"])) {
			$kepelo = explode(".", $_FILES["kepfile" . $i]["name"]);
			$kepelotag = $textpath.make_url($kepelo[0])."-".$i;
            kepeloallito($_FILES["kepfile" . $i]["tmp_name"], $kepelotag, $config["text"]["pic"]);

            @chmod($smallpic, 0777);
            if (!file_exists($smallpic)) {
                $process["error"]["notice"][] = "A(z) $i. kép feltöltése nem sikerült! Valószínűleg nem képfile.";
            }
        }
		
		$kepelotag = str_replace("../", "", $kepelotag);
        // kép adatai
        $p = "INSERT INTO nmTextpics SET textid=$id";
        $p .= ",number=$i";
        $k = (($kep["align"] == "l") ? "l" : (($kep["align"] == "r") ? "r" : "c"));
        $p .= ",align='" . $k . "'";
        $p .= ",name='{$kep[name]}'";
        $p .= ",path='".$kepelotag."'";
        $p .= ",alt='{$kep[alt]}'";
		$meretez = ($kep["meretez"] == '1') ? 1 : 0;
        $p .= ",meretez=" . $meretez;
		$link = ($kep["link"] == '1') ? 1 : 0;
        $p .= ",link=" . $link;
		$keret = ($kep["keret"] == '1') ? 1 : 0;
        $p .= ",keret=" . $keret;
        $p .= ",size='" . $kep["size"]."'";
        gsql_parancs($p);
    }

    // text fájlai:
    $filekk = gsql_2assoc("SELECT number, path FROM nmTextfiles WHERE textid=$id");
    gsql_parancs("DELETE FROM nmTextfiles WHERE textid=$id");
	$filek = $_POST["filek"];
    foreach ($filek as $i => $file) {
        clearstatcache();
        // tovább, ha:
        //  most nem tölöttek fel és
        //  ezelőtt sem töltöttek fel és
        //  nincs szöveg megadva

        if ($file["del"] == 1) {
            @unlink($textpath . $i . $file[path]);
            continue;
        }
        if (is_uploaded_file($_FILES["file" . $i]["tmp_name"]) || (($filekk[$i] != "") &&
            (file_exists(DIRTEXT . $id . "/" . $filekk[$i]))) || ($file["text"] != "")) {
        } else {
            continue;
        }

        // van file:
        if (is_uploaded_file($_FILES["file" . $i]["tmp_name"])) {
           $filenev = "file" . $i . "_name";
            $filenev = $_FILES["file" . $i]["name"];

            $idementi = DIRTEXT . "$id/$filenev";
			
            // felülíráshoz
            $marvolt = file_exists($idementi);
            @unlink($idementi);

            // adott sorszámú fájl már létezik ? => ha igen, akkor töröljük a fájlt
            if ($filek[$i][path] != "") {
                @unlink(DIRTEXT . "$id/" . $filek[$i][path]);
            }


            feltoltes("file" . $i, $idementi);
            @chmod($idementi, 0777);

            if (($marvolt) && (is_file($idementi))) {
                $process["error"]["notice"][] = "A(z) $filenev nevű file felül lett írva!";
            }

            if (!is_file($idementi)) {
                $process["error"]["notice"][] = "A(z) $filenev nevű file feltöltése nem sikerült!";
            }

            $filekk[$i] = $filenev;
        }

        // fájl adatai ==> sql tábla
        $p = "INSERT INTO nmTextfiles SET textid=$id";
        $p .= ",number='$i'";
        $p .= ",text='" . $file["text"] . "'";
        $p .= ",path='" . txt2dtxt($filekk[$i]) . "'";
        gsql_parancs($p);
    }


    gsql_parancs("DELETE FROM nmTextjoints WHERE textid=$id");
    /*foreach ($textjoints as $i => $textid) {
        $textid = (int)$textid;
        if ($textid != 0) {
            gsql_parancs("INSERT INTO textjoints SET textid=$id, number=$i, jointedtextid=$textid");
        }
    }*/
	
	if($menutipus == "cikk" || $menutipus == "egyeb")
	{
    	Header("Location: xpertCMS_text.php?id=$id&sm=1&" .session_name() . "=" . session_id());
	}
	else
	{
    	Header("Location: xpertCMS_lista.php?mit=nmTexts&szuromezo=menuid&szuroid=$menuid&" .session_name() . "=" . session_id());
	}
    //echo $p;
    die();
} elseif ($id == 0) {
    // új felvitel:

    $active = "y";
    $activefromdate = date('Y.m.d');
    $thumbalign = "l";
    $textjoints = array();

} else {
    $tmp = gsql_numassoc("SELECT * FROM nmTexts WHERE id='$id'");
    $tmp = $tmp[0];

    $active = $tmp["active"];
    //      $created=$tmp["created"];
    //      $modified=$tmp["modified"];
    $name = $tmp["name"];
    $name_en = $tmp["name_en"];
    $menuid = $tmp["menuid"];
    $elm1 = $tmp["lead"];
    $elm1_en = $tmp["lead_en"];
    $lead_visible = $tmp["lead_visible"];
    $elm2 = $tmp["text"];
    $elm2_en = $tmp["text_en"];
    $activefromdate = $tmp["activefromdate"];
    $thumbalign = $tmp["thumbalign"];
    $thumbalt = $tmp["thumbalt"];
    $thumbtext = $tmp["thumbtext"];
    $title = $tmp["title"];
    $keywords = $tmp["keywords"];
    $description = $tmp["description"];
    $number = $tmp["number"];
    $galeryid = $tmp["galeryid"];
    $munkamegnevezes = $tmp["munkamegnevezes"];
	$galeryinline = $tmp["galeryinline"];
    $volumen = $tmp["volumen"];
    $foterulet = $tmp["foterulet"];
    $szegmens = $tmp["szegmens"];
    $ref_tevekenyseg = $tmp["ref_tevekenyseg"];
    $kiemelt = $tmp["kiemelt"];
    $zold = $tmp["zold"];
    

    // *** fájlok ***
    $tmp = gsql_selstart("SELECT * FROM nmTextfiles WHERE textid=$id");
    $filek = array();
    while ($file = gsql_selnext($tmp)) {
        $i = $file[number];
        $filek[$i] = $file;
    }
    $max = 0;

    // a text képei: *** képek ***
    $tmp = gsql_selstart("SELECT * FROM nmTextpics WHERE textid=$id");
    $kepek = array();
    while ($kep = gsql_selnext($tmp)) {
        $i = $kep[number];
        $kepek[$i] = $kep;
    }
	
    $textjoints = gsql_2assoc("SELECT number,jointedtextid FROM nmTextjoints WHERE textid=$id");
}

$textpath = DIRTEXT . $id;
if (!is_dir(DIRTEXT . $id)) {
    mkdir(DIRTEXT . $id, 0777);
}
@chmod(DIRTEXT . $id, 0777);
$textpath .= "/";


$cim = kod2tag($cim);
$elm1 = kod2tag($elm1);
$elm2 = kod2tag($elm2);
$elm1_en = kod2tag($elm1_en);
$elm2_en = kod2tag($elm2_en);
if ($activefromdate == '0000-00-00') {
	$activefromdate = '';
}
?>
<script type="text/javascript">	
    window.addEvent('domready', function() { 
		myCal2 = new Calendar({ date2: 'Y-m-d' }, { classes: ['dashboard'], direction: 0 });
	});
</script>
<?
if($sm == 1)echo '<div class="error_form_text">Sikeres mentés!</div>';
?>
	<div id="container2">
	<form method="post" id="myForm" action="xpertCMS_text.php" enctype="multipart/form-data">
	<input type="hidden" name="urlap" value="1">
	<input type="hidden" name="id" value="<? echo $id; ?>">
	<input type="hidden" name="menuid" value="<? echo $menuid; ?>">
	<div class="form form_bgr">
		<div class="text">Sorrend:</div>
		<div class="input"><input type="text" value="<?= $number; ?>" name="number" style="width:30px;" /></div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text"><label for="fokat">Dátum:</label></div>
		<div class="input2"><label for="date2"></label>
			<input id="date2" name="date2" type="text" value="<?= $activefromdate;?>" /></div>
	<div class="clear"></div>
	</div>
	<div class="form form_bgr">
		<div class="text"><label for="metaTitle">Title:</label></div>
		<div class="input"><input type="text" value="<?= $title; ?>" name="title" /></div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text"><label for="metaKeywords">Meta keywords:</label></div>
		<div class="input"><input type="text" value="<?= $keywords; ?>" name="keywords" /></div>
	<div class="clear"></div>
	</div>
	<div class="form form_bgr">
		<div class="text"><label for="metaKeywords">Meta description:</label></div>
		<div class="input"><textarea name="description" rows="6" cols="60"><?= $description; ?></textarea></div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text"><label for="name">Cím:</label></div>
		<div class="input"><input type="text" id="name" title="Nem adtad meg az oldal nevét" value="<?= $name; ?>" name="name" class="required" /></div>
	<div class="clear"></div>
	</div>
    <!-- angol -->
    <div class="form">
        <div class="text"><label for="name">Cím angolul:</label></div>
        <div class="input"><input type="text" id="name_en" title="Nem adtad meg az oldal nevét" value="<?= $name_en; ?>" name="name_en" class="required" /></div>
    <div class="clear"></div>
    </div>  
	<div class="form form_bgr">
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
		<div class="text"><label for="fokat">Bevezető:</label></div>
		<div class="szovegmezo">
		  <textarea name="elm1" id="elm1" rows="5" cols="25" style="width: 100%" class="mcelead_editor"><?=$elm1;?></textarea><br />
		  <input type="checkbox" name="lead_visible" value="1" <? if($lead_visible == 1)echo "checked";?> /> bevezető megjelenik
		</div>
	<div class="clear"></div>
	</div>
    <!-- angol -->
    <div class="form">
        <div class="text"><label for="fokat">Bevezető angolul:</label></div>
        <div class="szovegmezo">
          <textarea name="elm1_en" id="elm1_en" rows="5" cols="25" style="width: 100%" class="mcelead_editor"><?=$elm1_en;?></textarea><br />
        </div>
    <div class="clear"></div>
    </div>
	<div class="form form_bgr">
		<div class="text"><label for="fokat">Szöveg:</label></div>
		<div class="szovegmezo"><textarea name="elm2" id="elm2" rows="35" cols="25" style="width: 100%" class="mcefull_editor"><?=$elm2;?></textarea></div>
	</div>
    <div class="form form_bgr">
        <div class="text"><label for="fokat">Szöveg angolul:</label></div>
        <div class="szovegmezo"><textarea name="elm2_en" id="elm2_en" rows="35" cols="25" style="width: 100%" class="mcefull_editor"><?=$elm2_en;?></textarea></div>
    </div>
<table cellpadding="2" cellspacing="0" border="0" style="margin-left:10px;">
<?php
if (is_array($kepek))
    $max = count($kepek) + 2;
if ($max < 5)
    $max = 5;
for ($i = 1; $i <= $max; $i++) {
?>
  <tr>
    <td>
<?
    if (isset($kepek[$i]) || file_exists($textpath . $i . "b.jpg")) {
?>
    <input type="checkbox" name="kepek[<? echo $i; ?>][del]" value="1">
<?
    }
?>
	</td>
	<td>
$kep<? echo $i; ?>$<?
	$actkep = $dirpref.$kepek[$i]["path"] . "b.jpg";
    if (file_exists($actkep)) {
        echo " <a href=\"" . $actkep."\" rel=\"clearbox\">néz</a>";
    }
?>
	</td>
	<td><input name="kepfile<? echo $i; ?>" type="file" size="26" /></td>
    <td><select name="kepek[<? echo $i; ?>][align]">
          <option value="l" <? echo ($kepek[$i]["align"] == "l") ? " selected" : ""; ?>>balra</option>
          <option value="c" <? echo ($kepek[$i]["align"] == "c") ? " selected" : ""; ?>>középre</option>
          <option value="r" <? echo ($kepek[$i]["align"] == "r") ? " selected" : ""; ?>>jobbra</option>
        </select>
	</td>
	<td>Aláírás: <textarea name="kepek[<? echo $i; ?>][name]" rows="" cols="" style="width:100px; height:24px; line-height:12px; font-size:11px; overflow:auto;"><? echo $kepek[$i]["name"]; ?></textarea></td>
	<td>Alt: <input name="kepek[<? echo $i; ?>][alt]" type="text" size="11" value="<? echo htmlspecialchars($kepek[$i]["alt"]); ?>" /></td>
	<td>Link: <input name="kepek[<? echo $i; ?>][link]" type="checkbox" value="1" <? if($kepek[$i]["link"] == 1)echo "checked"; ?> /></td>
	<td style="white-space:nowrap;">Méret: 
	  <select name="kepek[<? echo $i; ?>][size]">
	    <option value="_orig"<? if($kepek[$i]["size"] == "_orig")echo " selected";?>>eredeti</option>
	    <option value="s"<? if($kepek[$i]["size"] == "s")echo " selected";?>>120 px</option>
	    <option value="m"<? if($kepek[$i]["size"] == "m")echo " selected";?>>260 px</option>
	    <option value="b"<? if($kepek[$i]["size"] == "b")echo " selected";?>>400 px</option>
	  </select>
	</td>
	<!--td>Méretez: <input name="kepek[<? echo $i; ?>][meretez]" type="checkbox" value="1" <? if($kepek[$i]["meretez"] == 1)echo "checked"; ?> /></td-->
	<!--td>Keret: <input name="kepek[<? echo $i; ?>][keret]" type="checkbox" value="1" <? if($kepek[$i]["keret"] == 1)echo "checked"; ?> /></td-->
		
  </tr>
<?
}
?>
</table>
<div style="margin-left:160px;"><input type="submit" value="Bejelölt képek törlése" class="fobutton2" /></div>
<br /><br />		

<?php
if (is_array($filek))
    $max = count($filek) + 2;
if ($max < 5)
    $max = 5;
for ($i = 1; $i <= $max; $i++) {
?>
	<div class="form form_bgr">
		<div class="text">&nbsp;</div>
		
<div class="kep_text">
<?
    if (($filek[$i][path] != "") && file_exists($textpath . $filek[$i][path])) {
?>
    <input type="checkbox" name="filek[<? echo $i; ?>][del]" value="1">
<?
    }
?>&nbsp;
</div>
<div class="kep_text">
$file<? echo $i; ?>$<?
    if (($filek[$i][path] != "") && file_exists($textpath . $filek[$i][path])) {
        echo " <a href=\"" . $textpath . $filek[$i][path] . "\" target=\"_blank\">letölt</a>";
    }
?></div>
        <div class="kep_file2"><input name="file<? echo $i; ?>" type="file"  size="45" /></div>
        <div class="kep_text3">Szöveg</div>
        <div class="kep_alairas2"><input name="filek[<? echo $i; ?>][text]" type="text"  size="30" value="<? echo
    htmlspecialchars($filek[$i][text]); ?>" />
        <input name="filek[<? echo $i; ?>][path]" type="hidden"  size="30" value="<? echo
    htmlspecialchars($filek[$i][path]); ?>" /></div>
		
	<div class="clear"></div>
	</div>
<?
}
?>
</div>

<div style="margin-left:160px;"><input type="submit" value="Bejelölt fájlok törlése" class="fobutton2" /></div>
<br /><br />		

<div class="clear10"></div>
	<div class="form" align="center">
		<input type="submit" name="" value="Rögzít" class="fobutton" />
	</div>
	</form>
			<script type="text/javascript">
			window.addEvent('domready', function(){
				var myFormValidation = new Validate('myForm',{
					errorClass: 'red'
				});
			});
			</script>
	</div>
<?php
include 'template/_sugo.php';
?>
