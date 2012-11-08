<?php
ini_set('display_errors', '0');
include 'config.php';
include '_sql.php';
include '_kodok.php';
include "template/_start.php";
$oldalnev = 'Doboz módosítása / felvitele';
$oldalleiras = 'Doboz módosítása / felvitele.';
include 'template/_fejlecszerkeszto.php';
if ($laponkent < 25)
    $laponkent = 25;

$mezomodositva = "modositva";
$mezoazonosito = "id";
$keresomezok = array();
$mezojelolo = "";
$mezojelolotext = "publikus";
$mezo = "id";

$ujfelvitel = true;

switch ($mit) {
    case "utazasok":
        $oldalnev = "Utazasok";
//        $oldalleiras = "Keresett szavak.";
        $mezonevek = array("Hotel neve", "Orszag", "Varos");
        $tmp_orszag = gsql_2assoc("SELECT id, neve FROM parameterek");
        $mezowidths = array("25%", "25%", "25%");
        $mezok = array("utazas_hotel", "?><? echo \$tmp_orszag[\$sor['utazas_orszag']];?>", "?><? echo \$tmp_orszag[\$sor['utazas_varos']];?>");
        $phpmodosit = "xpertCMS_utazas.php";
        $keresomezok = array("utazas_hotel");
        $mezomodositva = "mdatum";
        $mezoazonosito = "id";
        break;
	case "parameterek":
        $oldalnev = "Parameterek";
//        $oldalleiras = "Keresett szavak.";
        $mezonevek = array("Neve");
        $mezowidths = array("60%");
        $mezok = array("neve");
        $phpmodosit = "xpertCMS_parameter.php";
        $keresomezok = array("neve");
        $mezomodositva = "mdatum";
        $mezoazonosito = "id";
        break;
	
    case "nmHirlevel_kikuldott":
    	$ujfelvitel = false;
    	$kellmodosit = false;
    	$kelltorol = false;
        $sqlLoginuser = gsql_2assoc("SELECT ID, UserName FROM nmAdminUsers");
        $sqlHirlevelNeve = gsql_2assoc("SELECT hirlevel_id, hirlevel_cime FROM nmHirlevel_texts");
        $sqlHirlevelTargy = gsql_2assoc("SELECT hirlevel_id, hirlevel_targy FROM nmHirlevel_texts");
        $oldalnev = "Keresett szavak";
        $oldalleiras = "Keresett szavak.";
        $mezonevek = array("Hírlevél címe", "Hírlevél tárgya", "Kiküldés dátuma",
            "Kiküldő neve", "Címzettek száma");
        $mezowidths = array("20%", "15%", "10%", "10%", "10%", "10%", "10%");
        $mezok = array("?><? echo \$sqlHirlevelNeve[\$sor['hirlevel_id']];?>",
            "?><? echo \$sqlHirlevelTargy[\$sor['hirlevel_id']];?>", "datum", "?><? echo \$sqlLoginuser[\$sor['ID']];?>",
            "darab");
        $phpmodosit = "xpertCMS_hirlevel.php";
        $keresomezok = array("hirlevel_cime", "hirlevel_targy", "hirlevel_plain_text");
        $mezomodositva = "";
        $mezoazonosito = "kuld_id";
        break;
    case "nmHirlevel_texts":
        $sqlLoginuser = gsql_2assoc("SELECT ID, UserName FROM nmAdminUsers");
        $oldalnev = "Keresett szavak";
        $oldalleiras = "Keresett szavak.";
        $mezonevek = array("Hírlevél címe", "Hírlevél tárgya", "Utoljára módosította",
            "Létrehozásának a dátuma");
        $mezowidths = array("25%", "25%", "15%", "15%");
        $mezok = array("hirlevel_cime", "hirlevel_targy", "?><? echo \$sqlLoginuser[\$sor['loginuser_id']];?>",
            "cDatum");
        $phpmodosit = "xpertCMS_hirlevel.php";
        $keresomezok = array("hirlevel_cime", "hirlevel_targy", "hirlevel_plain_text");
        $mezomodositva = "mDatum";
        $mezoazonosito = "hirlevel_id";
        break;
    case "nmGaleries":
        $oldalnev = "Galériák";
        $oldalleiras = "Galériák";
        $mezonevek = array("Galériacím", "Sorrend");
        $mezowidths = array("40%", "20%");
        $mezok = array("namehu","sorrend");
        $mezo = "id";
        $phpmodosit = "modgalery.php";
        $phpmodosit = "xpertCMS_listagalery.php";
        $keresomezok = array();
        $mezomodositva = "modified";
        $mezoazonosito = "id";
        $mezojelolo = "active";
        $mezojelolotext = "aktív";
        break;


    case "nmGalery":

        if ($ord == "")
            $ord = "parentid ASC,number ASC";

        $oldalnev = "Galériák";
        $szuromezo = "parentid";
        $p = '<form action="xpertCMS_lista.php">';
        $p .= "<input type=\"hidden\" name=\"mit\" value=\"$mit\">";
        $p .= "<input type=\"hidden\" name=\"szuromezo\" value=\"$szuromezo\">";
        $p .= "<input type=\"hidden\" name=\"laponkent\" value=\"$laponkent\">";
        $oldalnev .= $p;
        $p = '<select name="szuroid" onChange="form.submit()">';
        $p .= "<option value=\"\">- (összes) -</option>";
        foreach ($galerymenunames as $k => $v)
        {
            $p .= "<option value=\"" . $k . "\"";
            if ($szuroid == $k)
                $p .= " selected";
            $p .= ">" . $v . "</option>";
        }
        $p .= '</select>';
        $oldalleiras .= "A(z) $p főgaléria galériái.</form>";

        $mezonevek = array("Galéria", "Sor.", "Struktúra", "képei");
        $mezowidths = array("30%", "5%", "30%");
        $mezok = array("name", "number", "?><? echo \$galerymenunames[\$sor[id]]; ?>",
            "?><a href=\"xpertCMS_lista.php?mit=nmGalerypic&szuromezo=galeryid&szuroid=<? echo \$sor[id]; ?>\">képei</a>");
        $mezo = "id";
        $phpmodosit = "modgalery.php";
        $keresomezok = array("name");
        $mezomodositva = "";
        $mezoazonosito = "id";
        $mezojelolo = "active";
        $mezojelolotext = "aktív";
        break;

    case "galerypic":

        $oldalnev = "Galériaképek";
        $oldalleiras = "";

        $szuromezo = "galeryid";
        $p = '<form action="xpertCMS_lista.php">';
        $p .= "<input type=\"hidden\" name=\"mit\" value=\"$mit\">";
        $p .= "<input type=\"hidden\" name=\"szuromezo\" value=\"$szuromezo\">";
        $p .= "<input type=\"hidden\" name=\"laponkent\" value=\"$laponkent\">";
        $oldalnev .= $p;
        $p = '<select name="szuroid" onChange="form.submit()">';
        $p .= "<option value=\"\">- (összes) -</option>";
        foreach ($galerymenunames as $k => $v)
        {
            $p .= "<option value=\"" . $k . "\"";
            if ($szuroid == $k)
                $p .= " selected";
            $p .= ">" . $v . "</option>";
        }
        $p .= '</select>';
        $oldalleiras .= "A(z) $p főgaléria galériái.</form>";

        $mezonevek = array("Név", "Sor.");
        $mezowidths = array("50%", "5%");
        $mezok = array("name", "number");
        $mezo = "id";
        $phpmodosit = "modgalerypic.php";
        $keresomezok = array("name");
        $mezomodositva = "";
        $mezoazonosito = "id";
        $mezojelolo = "active";
        $mezojelolotext = "aktív";
        break;
    case "hirlevel_kikuldott":
        $sqlLoginuser = gsql_2assoc("SELECT ID, UserName FROM adminUsers");
        $sqlHirlevelNeve = gsql_2assoc("SELECT hirlevel_id, hirlevel_cime FROM hirlevel_texts");
        $sqlHirlevelTargy = gsql_2assoc("SELECT hirlevel_id, hirlevel_targy FROM hirlevel_texts");
        $oldalnev = "Keresett szavak";
        $oldalleiras = "Keresett szavak.";
        $mezonevek = array("Hírlevél címe", "Hírlevél tárgya", "Kiküldés dátuma", "Kiküldő neve", "Címzettek száma");
        $mezowidths = array("20%", "15%", "10%", "10%", "10%", "10%", "10%");
        $mezok = array("?><? echo \$sqlHirlevelNeve[\$sor['hirlevel_id']];?>", "?><? echo \$sqlHirlevelTargy[\$sor['hirlevel_id']];?>", "datum", "?><? echo \$sqlLoginuser[\$sor['ID']];?>", "darab");
        $phpmodosit = "xpertCMS_hirlevel.php";
        $keresomezok = array("hirlevel_cime", "hirlevel_targy", "hirlevel_plain_text");
        $mezomodositva = "";
        $mezoazonosito = "kuld_id";
        break;
    case "hirlevel_texts":
        $sqlLoginuser = gsql_2assoc("SELECT ID, UserName FROM adminUsers");
        $oldalnev = "Keresett szavak";
        $oldalleiras = "Keresett szavak.";
        $mezonevek = array("Hírlevél címe", "Hírlevél tárgya", "Utoljára módosította", "Létrehozásának a dátuma");
        $mezowidths = array("25%", "25%", "15%", "15%");
        $mezok = array("hirlevel_cime", "hirlevel_targy", "?><? echo \$sqlLoginuser[\$sor['loginuser_id']];?>", "cDatum");
        $phpmodosit = "xpertCMS_hirlevel.php";
        $keresomezok = array("hirlevel_cime", "hirlevel_targy", "hirlevel_plain_text");
        $mezomodositva = "mDatum";
        $mezoazonosito = "hirlevel_id";
        break;
    case "nmCikk":
        $oldalnev = "Cikkcsoportok";
        $mezonevek = array("ID", "Név", "Sorrend");
        $mezowidths = array("5%", "60%", "20%");
        $mezok = array("id", "name", "sorrend");
        $mezo = "id";
        $phpmodosit = "xpertCMS_listacikkcs.php";
        $keresomezok = array("name");
        $mezomodositva = "ts";
        $mezoazonosito = "id";
        $mezojelolo = "aktiv";
        $mezojelolotext = "aktív";
		$szuromezo = "termek_id";
        break;
    case "nmHirlevelUsers":
        $oldalnev = "Hírlevélre feliratkozottak";
        $mezonevek = array("E-mail");
        $mezowidths = array("80%");
        $mezok = array("email");
        $mezo = "id";
        $phpmodosit = "xpertCMS_hirlevelusers.php";
        $keresomezok = array("name");
        $mezomodositva = "ts";
        $mezoazonosito = "id";
        $mezojelolo = "aktiv";
        $mezojelolotext = "aktív";
        break;
    case "nmTermekek":
		//$termekkats = gsql_2assoc("select id, name from nmTermekKat order by id asc");
        $oldalnev = "Termekek";
        $mezonevek = array("ID", "Termek", "Kategoria", "Jellemzők", "Cikkcsoportok", "Másolat");
        $mezowidths = array("5%", "30%", "25%", "10%");
        $query_gyartok = gsql_2assoc("SELECT id, name FROM nmParameterek WHERE parentid=1");
        $mezok = array("id", "name", "kategoria", "?><a href=\"xpertCMS_listajellemzo.php?id=<? echo \$sor['id']; ?>\">Jellemzők</a>", "?><a href=\"xpertCMS_lista.php?mit=nmCikk&szuroid=<? echo \$sor['id']; ?>\">Cikkcsoportok</a>", "?><a href=\"xpertCMS_lista.php?mit=<? echo \$mit; ?>&lap=<? echo \$lap; ?>&masolatid=<? echo \$sor['id']; ?>\">másolat &raquo;</a>");
        $mezo = "id";
        $phpmodosit = "xpertCMS_termek.php";
        $keresomezok = array("name", "name", "termekjellemzok", "cikkcsoportok");
        $mezomodositva = "mdatum";
        $mezoazonosito = "id";
        $mezojelolo = "aktiv";
        $mezojelolotext = "aktív";
		
		// sor másolása
		if($masolatid)
		{
			// sor lemásolása
			$ctermek = gsql_numassoc("select * from nmTermekek where id=".$masolatid);
			$ctermek = $ctermek[0];
			gsql_parancs("insert into nmTermekek (title, description, keywords, name, kategoria, gyarto, number, aktiv) values 
			('".$ctermek["title"]."', '".$ctermek["description"]."', '".$ctermek["keywords"]."', '".$ctermek["name"]." másolat', '".$ctermek["kategoria"]."', '".$ctermek["gyarto"]."', '".$ctermek["number"]."', '".$ctermek["aktiv"]."')");
			$nid = mysql_insert_id();
			// jellemzők
			$cjellemzok = gsql_numassoc("select * from nmJellemzok where termek_id=".$masolatid." order by sorrend asc");
			foreach($cjellemzok as $k => $v)
			{
				gsql_parancs("insert into nmJellemzok (termek_id, name, aktiv, sorrend) values (".$nid.", '".$v["name"]."', '".$v["aktiv"]."', '".$v["sorrend"]."')");
			}
			// cikkcsoportok
			$ccsoportok = gsql_numassoc("select * from nmCikk where termek_id=".$masolatid);
			foreach($ccsoportok as $k => $v)
			{
				gsql_parancs("insert into nmCikk (termek_id, name, aktiv) values (".$nid.", '".$v["name"]."', '".$v["aktiv"]."')");
				$ncid = mysql_insert_id();
				// cikkek másolása
				$ccikkek = gsql_numassoc("select * from nmCikkek where cikkcs_id=".$v["id"]);
				foreach($ccikkek as $k2 => $v2)
				{
					gsql_parancs("insert into nmCikkek (cikkcs_id, name, csom, me, informacio, sorrend) values 
					(".$ncid.", '".$v2["name"]."', '".$v2["csom"]."', '".$v2["me"]."', '".$v2["informacio"]."', '".$v2["sorrend"]."')");
				}
			}
			header("location:?mit=".$mit."&lap=".$lap);
		}
		
        break;
    case "nmTermekKat":
		if($szuroid == 0) // főkategória
		{
			$mezonevek = array("Menü neve", "Sorrend", "Alkategóriái");
			$mezowidths = array("20%", "20%", "20%");
			$mezok = array("name", "number", "?><a href=\"xpertCMS_lista.php?mit=nmTermekKat&szuromezo=parentid&szuroid=<? echo \$sor[id]; ?>\">alkategóriái</a>");
			$mezo = "id";
			$phpmodosit = "xpertCMS_kat.php";
			$keresomezok = array("name");
			$mezomodositva = "modified";
			$mezoazonosito = "id";
			$mezojelolo = "active";
			$mezojelolotext = "aktív";
		}
		else // a termékeket listázzuk ki
		{
			$mezonevek = array("Menü neve", "Sorrend", "Termékek");
			$mezowidths = array("20%", "20%", "20%");
			$mezok = array("name", "number", "?><a href=\"xpertCMS_lista.php?mit=nmTermekek&szuromezo=kategoria&szuroid=<? echo \$sor[id]; ?>\">termékei</a>");
			$mezo = "id";
			$phpmodosit = "xpertCMS_kat.php";
			$keresomezok = array("name");
			$mezomodositva = "modified";
			$mezoazonosito = "id";
			$mezojelolo = "active";
			$mezojelolotext = "aktív";
		}
        break;

    case "nmTexts":
        $oldalnev = "Oldalak";

        $szuromezo = "menuid";
        $p = '<form action="xpertCMS_lista.php">';
        $p .= "<input type=\"hidden\" name=\"mit\" value=\"$mit\">";
        $p .= "<input type=\"hidden\" name=\"szuromezo\" value=\"$szuromezo\">";
        $p .= "<input type=\"hidden\" name=\"laponkent\" value=\"$laponkent\">";
        $oldalnev .= $p;

        $p = '<select name="szuroid" onChange="form.submit()">';
        $p .= "<option value=\"\">- (összes) -</option>";
        foreach ($menunames as $k => $v) {
            $p .= "<option value=\"" . $k . "\"";
            if ($szuroid == $k)
                $p .= " selected";
            $p .= ">" . $v . "</option>";
        }
        $p .= '</select>';
        $oldalleiras .= "A(z) $p almenü oldalai.</form>";

        $mezonevek = array("ID", "Oldalcím", "Almenü");
        $mezowidths = array("5%", "40%", "20%");
        $menus = gsql_2assoc("SELECT id,name FROM menus");
        $mezok = array("id", "name", "?><? echo \$menunames[\$sor[menuid]]; ?>");
        $mezo = "id";
        $phpmodosit = "xpertCMS_text.php";
        $keresomezok = array("name", "text");
        $mezomodositva = "modified";
        $mezoazonosito = "id";
        $mezojelolo = "active";
        $mezojelolotext = "aktív";
        break;
    case "nmMenus":

        if ($ord == "")
            $ord = "parentid ASC,number ASC";

        $oldalnev = "Menük";
        $szuromezo = "parentid";
        $p = '<form action="xpertCMS_lista.php">';
        $p .= "<input type=\"hidden\" name=\"mit\" value=\"$mit\">";
        $p .= "<input type=\"hidden\" name=\"szuromezo\" value=\"$szuromezo\">";
        $p .= "<input type=\"hidden\" name=\"laponkent\" value=\"$laponkent\">";
        $oldalnev .= $p;

        $p = '<select name="szuroid" onChange="form.submit()">';

        $p .= "<option value=\"0\"" . (($szuroid == "0") ? " selected" : "") .
            ">- (főmenük) -</option>";
        $p .= "<option value=\"\"" . (($szuroid === "") ? " selected" : "") .
            ">- (összes) -</option>";
        foreach ($menunames as $k => $v) {
            $p .= "<option value=\"" . $k . "\"";
            if ($szuroid == $k)
                $p .= " selected";
            $p .= ">" . $v . "</option>";
        }
        $p .= '</select>';
        $oldalleiras .= "A(z) $p menü almenüi.</form>";

        $mezonevek = array("Almenü", "Sor.", "Struktúra", "almenüi");
        $mezowidths = array("30%", "5%", "30%", "5%");
        //      $menus = gsql_2assoc("SELECT id,name FROM menus");
        $mezok = array("name", "number", "?><? echo \$menunames[\$sor[id]]; ?>",
            "?><a href=\"xpertCMS_lista.php?mit=nmMenus&szuromezo=menuid&szuroid=<? echo \$sor[id]; ?>\">almenüi</a>");
        $mezo = "id";
        $phpmodosit = "xpertCMS_menu.php";
        $keresomezok = array("name");
        $mezomodositva = "modified";
        $mezoazonosito = "id";
        $mezojelolo = "active";
        $mezojelolotext = "aktív";
        break;
    default:
        die();
}

$adattablamezok = gsql_numassoc("SHOW COLUMNS FROM " . $_GET['mit']);
foreach ($adattablamezok as $adattablamezo) {
    if (strstr($adattablamezo["Field"], "publikus")) {
        $mezojelolo = $adattablamezo["Field"];
    }
}
// jelölő a főoldalra ?
if ($mezojelolo != "") {
    if ($jelolesvalue != "") {
        switch ($mit) {
            case "szavazaskerdes":
                gsql_parancs("UPDATE $mit SET $mezojelolo='n';");
                break;
        }
        gsql_parancs("UPDATE {$_GET['mit']} SET $mezojelolo='$jelolesvalue' WHERE $mezoazonosito='$id';");
        switch ($mit) {
            case "a_public_cikk_lead":
                cikkcache($id);
                break;
            case "galeria":
            case "a_public_kep":
                cikkcache($id, 1);
                break;
            case "szavazaskerdes":
                szavazascache();
                break;
        }
    }
}

$linkalap = "id=$id&lap=$lap&kereses=$kereses";
$linkszuro = "";
if ($szuromezo != "") {
    if ($szuroid != "") {
        $linkszuro = $szuromezo . "=" . $szuroid;
    }
}

// jelöltek törlése

if (is_array($selected_ids)) {
    if (count($selected_ids) > 0) {
        switch ($mit) {
            case 'menupics':
                foreach ($selected_ids as $id) {
                    gsql_parancs("DELETE FROM menupics WHERE id='$id';");
                    @unlink("../uploads/flash/$id.jpg");
                }

                createmenupicsxml();

                break;

            case 'jelentkezes_diak':
                foreach ($selected_ids as $id) {
                	$diakTorol = gsql_numassoc("SELECT Uid FROM jelentkezes_diak WHERE diakId='$id'");
                	foreach ($diakTorol as $egyTorolId) {
                	    @unlink("../Cache/jelentkezesek/{$diakTorol[0]['Uid']}/diakmunka.inc");
                	    @unlink("../uploads/jelentkezes/$ideiEv/{$diakTorol[0]['Uid']}/_orig");
                	    @unlink("../uploads/jelentkezes/$ideiEv/{$diakTorol[0]['Uid']}/diak_b.jpg");
                	    @unlink("../uploads/jelentkezes/$ideiEv/{$diakTorol[0]['Uid']}/diak_s.jpg");
                	    //echo "../Cache/jelentkezesek/{$egyTorolId['Uid']}/diakmunka.inc";
                	    
                    }
						gsql_parancs("DELETE FROM jelentkezes_diak WHERE diakId='$id'");
                }
                break;
            case 'jelentkezes_sajto':
                foreach ($selected_ids as $id) {
                	$diakTorol = gsql_numassoc("SELECT Uid FROM jelentkezes_sajto WHERE sajtoId='$id'");
                	foreach ($diakTorol as $egyTorolId) {
                	    @unlink("../Cache/jelentkezesek/{$diakTorol[0]['Uid']}/sajto.inc");
                	    //@unlink("../uploads/jelentkezes/$ideiEv/{$diakTorol[0]['Uid']}/_orig");
                	    //@unlink("../uploads/jelentkezes/$ideiEv/{$diakTorol[0]['Uid']}/diak_b.jpg");
                	    //@unlink("../uploads/jelentkezes/$ideiEv/{$diakTorol[0]['Uid']}/diak_s.jpg");
                	    
                    }
						gsql_parancs("DELETE FROM jelentkezes_sajto WHERE sajtoId='$id'");
                }
                break;
			case 'f_post':
                foreach ($selected_ids as $id) {
                    list($tmpid, $tmpkepid) = explode(",", $id);
                    gsql_parancs("DELETE FROM f_post WHERE id='$tmpid' AND topic='$tmpkepid';");
                }
                break;

            default:
                foreach ($selected_ids as $id) {
                    gsql_parancs("DELETE FROM {$_GET['mit']} WHERE $mezoazonosito='$id';");
                }
        }
		updateMenuXML();
    }
}


// listában változtatások mentése
if($_POST["listachanged"] == "1")
{
	echo '<div style="display:none;">';
	foreach($_POST["listamod_value"]  as $rowid => $actrow)
	{
		$actsql = "update {$_GET['mit']} set ";
		$actmodfield = array();
		foreach($actrow as $fieldname => $actvalue)
		{
			$actmodfield[] = "{$fieldname}='{$actvalue}'";
		}
		$actsql .= implode(", ", $actmodfield);
		$actsql .= " where {$mezoazonosito}={$rowid};";
		//echo $actsql;
		gsql_parancs($actsql);
	}
	echo '</div>';
}


// státusz módosítása
/*
if (($id<>0) && ($statuszvalue)) {
gsql_parancs("UPDATE $mit SET statusz='$statuszvalue' WHERE $mezoazonosito='$id';");
}
*/

if ($ord == "") {
    $ord = "{$mezoazonosito} DESC";
    if (is_array($sorrendazonosito)) {
        $ord = "";
        foreach ($sorrendazonosito as $a) {
            if ($ord != "") {
                $ord .= ",$a ASC";
            } else {
                $ord = "$a DESC";
            }
        }
    }
}

$select = "SELECT * FROM {$_GET['mit']} ORDER BY $ord";

$p = "";
$tmp = "";
if ($kereses != "") {
    $tmp = array();
    foreach ($keresomezok as $mezo) {
        $tmp[] = "$mezo like '%$kereses%'";
    }
    $tmp = "(" . implode(" OR ", $tmp) . ")";
}

$negativselect = (substr($szuroid, 0, 1) == "!");


if (count($autoszurok) > 0) {
    if ($tmp != "")
        $tmp .= " AND ";
    $tmp .= "(" . implode(" OR ", $autoszurok) . ")";
}



if (($szuromezo != '') && ($szuroid != '')) {
    if (substr($szuroid, 0, 1) == "!") {
        $p .= " WHERE $szuromezo!='" . substr($szuroid, 1) . "'";
    } else {
        if ($_GET["archiv"] == '-1') {
            $archiv_ertek = " AND adatumtol <= '$maidatum' AND '$maidatum' > adatumig OR archiv=1";
        } else
            if ($_GET["archiv"] == '1') {
                $archiv_ertek = " AND adatumtol <= '$maidatum' AND '$maidatum' <= adatumig";
            }
        $p .= " WHERE $szuromezo='$szuroid' $archiv_ertek";
    }
    if ($tmp) {
        $p .= " AND $tmp";
    }
} else {
    if ($tmp != "") {
        $p .= " WHERE $tmp";
    }
}
$p .= " ORDER BY $ord";
//echo $p;


// lapozás
$talalatokszama = gsql_numassoc("SELECT count(*) as db FROM $mit $p");
$talalatokszama = (int)$talalatokszama[0]["db"];
$lapokszama = (int)(($talalatokszama - 1) / $laponkent) + 1;
// echo "Találatok: $talalatokszama";
// echo "Lapokszáma: $lapokszama";
$ettol = $lap * $laponkent;

$p = "SELECT * FROM $mit $p LIMIT $ettol,$laponkent";
//echo $p;



?>
<!--<div class="kereses_box">
	<div class="title">Keresés</div>
	<div class="text">Szó/részlet:</div>
	<div class="input_all"><input name="kereses" value=""></div>
	<div class="text">Találat/oldal:</div>
		<div class="input"><select name="laponkent" onchange="form.submit()">

           <option selected value="10">10</option> 
           <option value="20">20</option>
           <option value="50">50</option> 
           <option value="100">100</option></select></div>
	<div class="clear20"></div>
	<div class="button"><input class="inp_but" type="submit" value="Keresés" name="Submit4"></div>
</div>
<div class="clear"></div>

<div class="lapozas"><a href="" class="vissza">&laquo; előző</a> | 1 | 2 | <a href="/admin/xpertCMS_lista.php?mit=tulajdonsagok&szuromezo=tultipus&szuroid=1&PHPSESSID=25d037f4552630fb3cd86366a408908f&lap=1" class="tovabb">következő &raquo;</a></div>-->
<script type="text/javascript">
  window.addEvent('domready', function(){
var accordion = new Accordion('h3.atStart', 'div.atStart', {
	opacity: false,
	onActive: function(toggler, element){
		toggler.setStyle('color', '#ff3300');
	},
 
	onBackground: function(toggler, element){
		toggler.setStyle('color', '#222');
	}
}, $('accordion'));
 
 
var newTog = new Element('h3', {'class': 'toggler'}).setHTML('Common descent');
 
var newEl = new Element('div', {'class': 'element'}).setHTML('<p>A group of organisms is said to have common descent if they have a common ancestor. In biology, the theory of universal common descent proposes that all organisms on Earth are descended from a common ancestor or ancestral gene pool.</p><p>A theory of universal common descent based on evolutionary principles was proposed by Charles Darwin in his book The Origin of Species (1859), and later in The Descent of Man (1871). This theory is now generally accepted by biologists, and the last universal common ancestor (LUCA or LUA), that is, the most recent common ancestor of all currently living organisms, is believed to have appeared about 3.9 billion years ago. The theory of a common ancestor between all organisms is one of the principles of evolution, although for single cell organisms and viruses, single phylogeny is disputed</p>');
 
//accordion.addSection(newTog, newEl, 0);
  }); 
</script>
<a hre
<div id="accordion">
	<h3 class="toggler atStart">Keresés</h3>
	<div class="element atStart">
<?php
include ('template/_headerKereses.php');
?>
	</div>
	
<?php
switch ($mit) {
	case 'termekek':
      include ('template/termek_export.php');
      break;
	case 'jelentkezes_sajto':
      include ('template/accordion_csv_sajto.php');
      break;
	case 'jelentkezes_diak':
      include ('template/accordion_csv_diak.php');
      break;
	case 'jelentkezes_arus':
      include ('template/accordion_csv_arus.php');
      break;
}
?>
</div>

<?
if($mit == "termekek") echo $oldalnev.$oldalleiras;
?>

<div class="lapozas">
<?
if (($lapokszama > 0) && ($lap > 0)) {
    echo "<a href=\"" . URI_add_query_arg($REQUEST_URI, "lap", $lap - 1) . "\" class=\"vissza\">&laquo; előző</a>";
} else {
    echo "<strike>&laquo; előző</strike>";
}
?> | <? echo ($lap + 1) . " | $lapokszama"; ?> | <?
if (($lapokszama > 0) && ($lap < $lapokszama - 1)) {
    echo "<a href=\"" . URI_add_query_arg($REQUEST_URI, "lap", $lap + 1) . "\" class=\"tovabb\">következő &raquo;</a>";
} else {
    echo "<strike>következő &raquo;</strike>";
}
?>
</div>
<script language="JavaScript" type="text/javascript">
<!--

function statuszmodosit(id,value) {
  if ((value == "y") || (value == "n")) {
    value = (value == "n") ? "y" : "n";
  } else {
      value = (value == "0") ? "1" : "0";
    }
//  if (confirm('Biztos, hogy módosítja?')) {
    window.location = '<?
$tmp = URI_remove_query_arg($REQUEST_URI, "statuszvalue");
$tmp = URI_remove_query_arg($tmp, "id");
echo $tmp;
?>&id=' + id + '&statuszvalue='+value;
//  }
  return true;
}

function jelolesmodosit(id,value) {
  if ((value == "y") || (value == "n")) {
    value = (value == "n") ? "y" : "n";
  } else {
      value = (value == "0") ? "1" : "0";
    }
  window.location = '<? echo $tmp; ?>&id='+id+'&jelolesvalue='+value;
  return true;
}


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

<?
//  if (!$negativselect) {


?>

<? if($ujfelvitel):?>
<div class="button_red"><a href="<? echo $phpmodosit . "?" . $linkszuro; ?>">Új felvitele</a></div>
<? endif;?>

<?
//  }


?>



   <form id="form2" name="listaForm" method="post" action="<? echo $tmp; ?>">
   <input type="hidden" name="listachanged" id="listachanged" value="0" />
<?
if ($mezojelolo != "") {
?>
<table width="550" border="0" cellspacing="1" cellpadding="3">
 <tr align="left">
  <td class="even"><img src="pic/statusz_y.gif" /> <? echo $mezojelolotext; ?> &nbsp;&nbsp;&nbsp; <img src="pic/statusz_n.gif" /> nem <? echo
    $mezojelolotext; ?></td>
 </tr>
</table>
<?
}
?>
   <table width="100%" border="0" cellspacing="0" cellpadding="3" class="lista_table" id="lista_table">
<thead>
 <tr>
<?
//"Státusz",
//   <td class="even"><strong>Státusz</strong></td>
if ($mezomodositva != "")
    $mezonevek[] = "Módosítva";
$mezonevek[] = "Javít";
$mezonevek[] = "<img src=\"pic/check.gif\">";
if ($mezomodositva != "")
    $mezok[] = $mezomodositva;

foreach ($mezonevek as $k => $mezo) {
    $i++;
    if ($i == 1) {
        if ($mezojelolo != "") {
            echo "<td width=\"5%\" class=\"even\"><strong>" . ucfirst($mezojelolotext) .
                "</strong></td>";
        }
    }
?>

  <td class="even" width="<? echo $mezowidths[$k]; ?>" align="center"><strong>
   <?
    if ((substr($mezo, 0, 1) != "<") && (substr($mezok[$k], 0, 1) != "?")) {
        echo "<a href=\"xpertCMS_lista.php?mit=$mit&szuromezo=$szuromezo&szuroid=$szuroid&ord={$mezok[$k]}\"><strong>";
    }
    echo $mezo;
    if (substr($mezo, 0, 1) != "<") {
        echo "</strong></a>";
    }
?> 
     </td>

<?
}
?>
 </tr>
</thead>
<tbody>
<?
$tmp = gsql_selstart($p);
while ($sor = gsql_selnext($tmp)) {
?>
 <tr class="<? echo ((++$ii % 2) ? "even" : "odd"); ?>" align="center">
<?
    if ($mezojelolo != "") {
?>
  <td align="center"><input type="checkbox" href="#"
     onclick="jelolesmodosit('<? echo $sor[$mezoazonosito]; ?>','<? echo $sor[$mezojelolo]; ?>')"
     <? echo (($sor[$mezojelolo] == 1) || ($sor[$mezojelolo] == "y")) ?
        " checked" : ""; ?> class="check" /></td>
<?
    }
?>
<?
    $i = 0;
    foreach ($mezok as $k => $mezo) {
?>

<script type="text/javascript">
function changeToInputView(inputid, mezonev)
{
	var text = document.getElementById('listamod_text_' + inputid + '_' + mezonev);	
	var input = document.getElementById('listamod_input_' + inputid + '_' + mezonev);
	var submitbtn = document.getElementById('btnValtoztatasok');
	input.value = text.innerHTML;
	text.style.display = "none";
	input.style.display = "block";
	input.focus();
	submitbtn.style.display = "block";
}
function changeToTextView(inputid, mezonev)
{
	var text = document.getElementById('listamod_text_' + inputid + '_' + mezonev);	
	var input = document.getElementById('listamod_input_' + inputid + '_' + mezonev);
	text.innerHTML = input.value;
	text.style.display = "block";
	input.style.display = "none";
}
function submitListaChanged()
{
	document.getElementById('listachanged').value = '1';
}
</script>
  <td><?
        if ($k == 0)
            echo "<center>";
        if (substr($mezok[$k], 0, 1) == "?") {
            //      echo str_replace("\$", "", substr($mezok[$k],1,strlen($mezok[$k])));
            eval($mezok[$k]);
            //,1,strlen($mezok[$k])));
        } else {
            //        echo htmlspecialchars($sor[$mezok[$k]]);
			
			// módosítható a listában az adott mező
			if(in_array($mezo, $mezo_mod_listaban))
			{
				echo '<input type="text" name="listamod_value['.$sor[$mezoazonosito].']['.$mezo.']" value="'.$sor[$mezok[$k]].'" class="lista_hidden_input" id="listamod_input_'.$sor[$mezoazonosito].'_'.$mezo.'" onblur="changeToTextView(\''.$sor[$mezoazonosito].'\', \''.$mezo.'\')" />';
				echo '<span id="listamod_text_'.$sor[$mezoazonosito].'_'.$mezo.'" onclick="changeToInputView(\''.$sor[$mezoazonosito].'\', \''.$mezo.'\')">'.$sor[$mezok[$k]].'</span>';
			}
            else echo $sor[$mezok[$k]];
        }
        if ($k == 0)
            echo "</center>";
?></TD>
<?
    }
    if (is_array($mezoazonosito)) {
        $tmpp = array();
        foreach ($mezoazonosito as $az) {
            $tmpp[] = "$az" . "=" . $sor[$az];
        }
        $tmpp = implode("&", $tmpp);
    } else {
        $tmpp = "$mezoazonosito=" . $sor[$mezoazonosito];
    }
?>
  <td align="center"><a href="<? echo $phpmodosit; ?>?<? echo $tmpp; ?>">módosít</a></td>
  <td align="center"><input name="selected_ids[]" type="checkbox" value="<?

    if (is_array($mezoazonosito)) {
        $tmpp = "";
        foreach ($mezoazonosito as $a) {
            if ($tmpp != "") {
                $tmpp .= "," . $sor[$a];
            } else {
                $tmpp = $sor[$a];
            }
        }
        echo $tmpp;
    } elseif (isset($mezoazonositok)) {
        $tmpp = "";
        foreach ($mezoazonositok as $a) {
            if ($tmpp != "") {
                $tmpp .= "," . $sor[$a];
            } else {
                $tmpp = $sor[$a];
            }
        }
        echo $tmpp;
    } else {
        echo $sor[$mezoazonosito];
    }
?>" class="check" />
 </tr>

<?
}
?>
 <tr >
 </tbody>
</table>
<script language="JavaScript">
<!--
	tigra_tables('lista_table', 1, 0, '#e5e5e5', '#ffffff', '#dadada', '#c9c9c9');
	//páros sor, páratlan sor, hover, aktív
// -->
</script>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
 <tr>
  <td align="right" nowrap="nowrap">Összeset kijelöl&nbsp;
    <input type="checkbox" name="checkbox2" value="checkbox" onclick="setCheckboxes('listaForm', true); return false;" class="check"></td>
 </tr>
 <tr align="right" valign="top">
  <td>
  <div style="float:left;display:inline;margin-left:10px; display:none;" id="btnValtoztatasok">
    <input name="SubmitChange" type="submit" class="button_valtoztatas" value="Változtatások mentése" style="width:150px!important; margin-top:0px; cursor:pointer;" onclick="submitListaChanged()" />
  </div>

  <div style="float:right;display:inline;margin-left:10px;">
    <input name="Submit22" type="submit" class="inp_but" value="Kijelöltek törlése" style="width:120px!important; margin-top:0px; cursor:pointer;" />
  </div>
  <? if($ujfelvitel):?>
  <div class="button_red" style="float:right;">
    <a href="<? echo $phpmodosit ."?" . $linkszuro; ?>">Új felvitele</a>
  </div>
  <? endif;?>
  </td>
 </tr>
</table>

</form>
</form>

<?
include "template/_sugo.php";
?>