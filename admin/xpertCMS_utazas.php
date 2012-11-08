<?php
include 'config.php';
include '_sql.php';
include '_kodok.php';
include "template/_start.php";
$oldalnev = 'Doboz módosítása / felvitele';
$oldalleiras = 'Doboz módosítása / felvitele.';
include 'template/_fejlecszerkeszto.php';

$id = (int)$id;

$tmp_utazas_tip = gsql_2assoc ("SELECT id, neve FROM parameterek WHERE parentid=1");
$tmp_szallas_tip = gsql_2assoc ("SELECT id, neve FROM parameterek WHERE parentid=4");
$tmp_ellatas_tip = gsql_2assoc ("SELECT id, neve FROM parameterek WHERE parentid=5");
$tmp_orszag = gsql_2assoc("SELECT id, neve FROM parameterek WHERE parentid=2 ORDER BY neve ASC");
$tmp_varos = gsql_2assoc("SELECT id, neve FROM parameterek WHERE parentid=3");

if ($urlap == 1) {
    $process["error"]["warnings"] = array();
    
    if (count($process["error"]["warnings"]) == 0) {

        $p = "utazas_orszag=\"$utazas_orszag\"";
        $p .= ", utazas_varos=\"$utazas_varos\"";
        $p .= ", utazas_hotel=\"$utazas_hotel\"";
        $p .= ", utazas_tip=\"$utazas_tip\"";
        $p .= ", utazas_szallas=\"$utazas_szallas\"";
        $p .= ", utazas_ellatas=\"$utazas_ellatas\"";
        $p .= ", utazas_start=\"$utazas_start\"";
        $p .= ", utazas_vege=\"$utazas_vege\"";
        $p .= ", utazas_ejszakak=\"$utazas_ejszakak\"";
        $p .= ", utazas_szemelyek=\"$utazas_szemelyek\"";
        $p .= ", utazas_ar=\"$utazas_ar\"";
		$p .= ", utazas_euro=\"$utazas_euro\""; //royal fix code
		$p .= ", utazas_dollar=\"$utazas_dollar\""; //royal fix code
        $p .= ", utazas_leiras=\"$utazas_leiras\"";
        $p .= ", utazas_flag=\"$utazas_flag\"";
        $p .= ", utazas_csillag=\"$utazas_csillag\"";
        

        if ($id == 0) {
            $p = "INSERT INTO utazasok SET $p";
        } else {
            $p = "UPDATE utazasok SET $p WHERE id='$id'";
        }
		//echo $p;
        gsql_parancs($p);
        if ($id == 0) {
            $id = mysql_insert_id();
        }
        $t = gsql_numassoc ( "SELECT * FROM utazasok WHERE id=$id" );
		$url = 'utazas/' . make_url($tmp_orszag [$utazas_orszag], 255) . '/' . make_url($tmp_varos [$utazas_varos], 255) . '/' . 
		make_url($utazas_hotel, 255);
		if (strlen ( $url ) > 200)
			$url = substr ( $url, 0, 200 );
		$s = "";
		while ( true ) {
			$tmp = gsql_numassoc ( "SELECT * FROM utazasok WHERE webcim='$url$s' AND id<>$id" );
			if (count ( $tmp ) == 0) {
				$url .= $s;
				break;
			}
			$s = (int)$s + 1;
		}
		gsql_parancs ("UPDATE utazasok SET webcim=\"$url\" WHERE id=$id");
        
		$textpath = DIRUTAZAS . $id;
    	if (!is_dir(DIRUTAZAS . $id)) {
        	mkdir(DIRUTAZAS . $id, 0775);
    	}
    	@chmod(DIRUTAZAS . $id, 0775);
   	 	$textpath .= "/";
   	 	
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
	            kepeloallito($_FILES["kepfile" . $i]["tmp_name"], $kepelotag, $config["text"]["termekpic"]);
	
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
		
	    // text lead képe
	    clearstatcache();
	    if (is_uploaded_file($_FILES["thumbnailfile"]["tmp_name"])) {
	        kepeloallito($_FILES["thumbnailfile"]["tmp_name"], $textpath, $config["text"]["termekpic"]);
	    }
        Header("Location: xpertCMS_lista.php?mit=utazasok");
        die();
    }
} elseif ($id == 0) {

} else {
	$textpath = DIRUTAZAS . $id;
    if (!is_dir(DIRUTAZAS . $id)) {
       	mkdir(DIRUTAZAS . $id, 0775);
    }
    @chmod(DIRUTAZAS . $id, 0775);
   	$textpath .= "/";
    
   	$tmp = gsql_numassoc("SELECT * FROM utazasok WHERE id='$id'");
    $tmp = extract($tmp[0]);
    
    // a text képei: *** képek ***
    $tmp = gsql_selstart("SELECT * FROM nmTextpics WHERE textid=$id");
    $kepek = array();
    while ($kep = gsql_selnext($tmp)) {
        $i = $kep[number];
        $kepek[$i] = $kep;
    }
    
}

$utazas_tip_arr = array();
$utazas_tip_arr [1] = 'utazas';
$utazas_tip_arr [2] = 'last minute';
$utazas_tip_arr [3] = 'akcios';

$utazas_csillag_arr [1] = 1;
$utazas_csillag_arr [2] = 2;
$utazas_csillag_arr [3] = 3;
$utazas_csillag_arr [4] = 4;
$utazas_csillag_arr [5] = 5;
$utazas_csillag_arr [6] = 6;
$utazas_csillag_arr [7] = 7;
?>
<script type="text/javascript">	
    window.addEvent('domready', function() { 
		myCal2 = new Calendar({ date2: 'Y-m-d' }, { classes: ['dashboard'], direction: 0 });
		myCal3 = new Calendar({ date3: 'Y-m-d' }, { classes: ['dashboard'], direction: 0 });
		var orszag_sel = $('sel_continent_id');
		orszag_sel.addEvent('change', function()
		{			
			// input mezo ertek
			var sel_hotel_c = document.getElementById("sel_continent_id");
		    var i = sel_hotel_c.options[sel_hotel_c.selectedIndex].value;
			var pars = 'continent_id=' + i + '';
			//alert(i);
			// telepules ajaxbul		
			new Request({
				url: 'ajax/ajax_select.php',
				evalScripts: true,
				metod: 'post',
				onComplete: function(response) {
					eval(response);
					var t = $('sel_country_id');
					t.focus();
					}
				}).send(pars);
		});
	});
</script>
	<div id="container2">
	<form action="xpertCMS_utazas.php" name="form2" id="form2" method="post" enctype="multipart/form-data" onsubmit="return submitForm();">
    <input name="id" type="hidden" value="<? echo $id; ?>">
    <input name="parentid" type="hidden" value="<? echo $parentid; ?>">
	<input type="hidden" name="urlap" value="1">
	<div class="form">
		<div class="text"><label for="kategoria">Tipus:</label></div>
		<div class="input">
		<?php echo FormSelect("utazas_flag", $utazas_tip_arr, array(), 1, '-- valassz --'); ?>
        </div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text"><label for="kategoria">Utazas tipusa:</label></div>
		<div class="input">
		<?php echo FormSelect("utazas_tip", $tmp_utazas_tip, array(), 0, '-- valassz --'); ?>
        </div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text"><label for="kategoria">Orszag:</label></div>
		<div class="input">
		<?php echo FormSelect("utazas_orszag", $tmp_orszag, array('id' => 'sel_continent_id'), 0, '-- valassz --'); ?>
        </div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text"><label for="kategoria">Varos:</label></div>
		<div class="input">
		<?php 
		if ($utazas_varos != '') {
			$tmp_varos = gsql_2assoc ("SELECT id, neve FROM parameterek WHERE orszag=$utazas_orszag ORDER BY neve ASC");
		}
		echo FormSelect("utazas_varos", $tmp_varos, array('id' => 'sel_country_id'), 0, '-- valassz --'); 
		?>
        </div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text">Hotel neve:</div>
		<div class="input">
		<input name="utazas_hotel" type="text" value="<?= $utazas_hotel; ?>" />
        </div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text"><label for="kategoria">Csillagok szama:</label></div>
		<div class="input">
		<?php echo FormSelect("utazas_csillag", $utazas_csillag_arr, array(), 0, '-- valassz --'); ?>
        </div>
	<div class="clear"></div>
	</div>

	<div class="form">
		<div class="text"><label for="kategoria">Szallas tipusa:</label></div>
		<div class="input">
		<?php echo FormSelect("utazas_szallas", $tmp_szallas_tip, array(), 0, '-- valassz --'); ?>
        </div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text"><label for="kategoria">Ellatas:</label></div>
		<div class="input">
		<?php echo FormSelect("utazas_ellatas", $tmp_ellatas_tip, array(), 0, '-- valassz --'); ?>
        </div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text"><label for="fokat">Kezdo datum:</label></div>
		<div class="input2"><label for="date2"></label>
			<input id="date2" name="utazas_start" type="text" value="<?= $utazas_start;?>" /></div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text"><label for="fokat3">Vegso datum:</label></div>
		<div class="input2"><label for="date3"></label>
			<input id="date3" name="utazas_vege" type="text" value="<?= $utazas_vege;?>" /></div>
	<div class="clear"></div>
	</div>	
	<div class="form">
		<div class="text">Ejszakak szama:</div>
		<div class="input5">
		<input name="utazas_ejszakak" type="text" value="<?= $utazas_ejszakak; ?>" />
        </div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text">Szemelyek szama:</div>
		<div class="input5">
		<input name="utazas_szemelyek" type="text" value="<?= $utazas_szemelyek; ?>" />
        </div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text">Ar (Ft):</div>
		<div class="input5">
		<input name="utazas_ar" type="text" value="<?= $utazas_ar; ?>" /> -tol
        </div>
	<div class="clear"></div>
	</div>
	<!-- royalfix code -->
	<div class="form">
		<div class="text">Ar (Euro):</div>
		<div class="input5">
		<input name="utazas_euro" type="text" value="<?= $utazas_euro; ?>" /> -tol
        </div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text">Ar (Dollar):</div>
		<div class="input5">
		<input name="utazas_dollar" type="text" value="<?= $utazas_dollar; ?>" /> -tol
        </div>
	<div class="clear"></div>
	</div>
	<!-- royalfix code ends -->
	<div class="form form_bgr">
		<div class="text"><label for="ismerteto_kep">Ismertető kép:</label>
<?
if (file_exists($textpath . "b.jpg")) {
    echo " <a href=\"" . $textpath . "b.jpg" . "\" rel=\"clearbox\">néz</a>";
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
		<div class="text"><label for="fokat">Leiras:</label></div>
		<div class="szovegmezo">
		  <textarea name="utazas_leiras" rows="5" cols="25" style="width: 100%" class="mcelead_editor"><?=$utazas_leiras;?></textarea><br />
		</div>
		<br />
		<table cellpadding="2" cellspacing="0" border="0" style="margin-left:10px;">
<?php
if (is_array($kepek))
    $max = count($kepek) + 2;
if ($max < 10)
    $max = 10;
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
kep <? echo $i; ?><?
	$actkep = $dirpref.$kepek[$i]["path"] . "b.jpg";
    if (file_exists($actkep)) {
        echo " <a href=\"" . $actkep."\" rel=\"clearbox\">néz</a>";
    }
?>
	</td>
	<td><input name="kepfile<? echo $i; ?>" type="file" size="26" /></td>
	<td>Aláírás: <textarea name="kepek[<? echo $i; ?>][name]" rows="" cols="" style="width:300px; height:24px; line-height:12px; font-size:11px; overflow:auto;"><? echo $kepek[$i]["name"]; ?></textarea></td>
	<!--td>Méretez: <input name="kepek[<? echo $i; ?>][meretez]" type="checkbox" value="1" <? if($kepek[$i]["meretez"] == 1)echo "checked"; ?> /></td-->
	<!--td>Keret: <input name="kepek[<? echo $i; ?>][keret]" type="checkbox" value="1" <? if($kepek[$i]["keret"] == 1)echo "checked"; ?> /></td-->
		
  </tr>
<?
}
?>
</table>
<div style="margin-left:160px;"><input type="submit" value="Bejelölt képek törlése" class="fobutton2" /></div>
<br /><br />		
		
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
