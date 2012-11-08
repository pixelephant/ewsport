<?php
include 'config.php';
include '_sql.php';
include '_kodok.php';
include "template/_start.php";
$oldalnev = 'Doboz módosítása / felvitele';
$oldalleiras = 'Doboz módosítása / felvitele.';
include 'template/_fejlecszerkeszto.php';
if ($laponkent < 10)
    $laponkent = 10;

$mezomodositva = "modositva";
$mezoazonosito = "id";
$keresomezok = array();
$mezojelolo = "";
$mezojelolotext = "publikus";
$mezo = "id";
switch ($mit) {
    case "account":
        $oldalnev = "Regisztrált felhasználók";
        $oldalleiras = "Keresett szavak.";
        $mezonevek = array("Felhasználónév", "E-mail", "Aktvált", "Regisztráció dátuma");
        $mezowidths = array("20%", "20%", "5%", "15%");
        $mezok = array("accnev", "accemail", "", "regDatum");
        $mezo = "Uid";
        $phpmodosit = "xpertCMS_userek.php";
        $keresomezok = array("accnev", "accemail");
        $mezomodositva = "";
        $mezoazonosito = "Uid";
        break;
    default:
        die();
    case "companies":
        $oldalnev = "Keresett szavak";
        $oldalleiras = "Keresett szavak.";
        $mezonevek = array("Ceg neve");
        $mezowidths = array("80%");
        $mezok = array("companyName");
        $mezo = "companyId";
        $phpmodosit = "";
        $keresomezok = array("mitkeres");
        $mezomodositva = "mDate";
        $mezoazonosito = "companyId";
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

            case 'f_post':
                foreach ($selected_ids as $id) {
                    list($tmpid, $tmpkepid) = explode(",", $id);
                    gsql_parancs("DELETE FROM f_post WHERE id='$tmpid' AND topic='$tmpkepid';");
                }
                break;

            default:
                foreach ($selected_ids as $id) {
                    gsql_parancs("DELETE FROM $mit WHERE $mezoazonosito='$id';");
                }
        }
    }
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
$talalatokszama = gsql_numassoc("SELECT count(*) as db FROM $mit $p");
$talalatokszama = (int)$talalatokszama[0]["db"];
$lapokszama = (int)(($talalatokszama - 1) / $laponkent) + 1;
// echo "Találatok: $talalatokszama";
// echo "Lapokszáma: $lapokszama";
$ettol = $lap * $laponkent;

$p = "SELECT * FROM $mit $p LIMIT $ettol,$laponkent";
//echo $p;



?>
<div class="kereses_box">
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

<div class="lapozas"><a href="" class="vissza">&laquo; előző</a> | 1 | 2 | <a href="/admin/lista.php?mit=tulajdonsagok&szuromezo=tultipus&szuroid=1&PHPSESSID=25d037f4552630fb3cd86366a408908f&lap=1" class="tovabb">következő &raquo;</a></div>
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
<p>
  <img src="images/uj.gif"><a href="<? echo $phpmodosit . "?" . $linkszuro; ?>">Új felvitel.</a>
 </p>

<?
//  }


?>



   <form id="form2" name="listaForm" method="post" action="<? echo $tmp; ?>">
<?
if ($mezojelolo != "") {
?>
<table width="550" border="0" cellspacing="1" cellpadding="5">
 <tr align="left">
  <td class="bg_1"><input type="checkbox" checked name="aktivstatusz" onclick="document.all.aktivstatusz.checked=true"> <? echo
    $mezojelolotext; ?> &nbsp;&nbsp;&nbsp; <input type="checkbox" name="nemaktivstatusz" onclick="document.all.nemaktivstatusz.checked=false"> nem <? echo
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
//   <td class="bg_2"><strong>Státusz</strong></td>
if ($mezomodositva != "")
    $mezonevek[] = "Módosítva";
$mezonevek[] = "Javít";
$mezonevek[] = "<img src=\"images/check.gif\">";
if ($mezomodositva != "")
    $mezok[] = $mezomodositva;

foreach ($mezonevek as $k => $mezo) {
    $i++;
    if ($i == 1) {
        if ($mezojelolo != "") {
            echo "<td width=\"5%\" class=\"bg_2\"><strong>" . ucfirst($mezojelolotext) .
                "</strong></td>";
        }
    }
?>

  <td class="bg_2" width="<? echo $mezowidths[$k]; ?>" align="center"><strong>
   <?
    if ((substr($mezo, 0, 1) != "<") && (substr($mezok[$k], 0, 1) != "?")) {
        echo "<a href=\"lista.php?mit=$mit&szuromezo=$szuromezo&szuroid=$szuroid&ord={$mezok[$k]}\"><strong>";
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
 <tr class="bg_<? echo ((++$ii % 2) ? "v" : "s"); ?>">
<?
    if ($mezojelolo != "") {
?>
  <td align="center"><input type="checkbox" href="#"
     onclick="jelolesmodosit('<? echo $sor[$mezoazonosito]; ?>','<? echo $sor[$mezojelolo]; ?>')"
     <? echo (($sor[$mezojelolo] == 1) || ($sor[$mezojelolo] == "y")) ?
        " checked" : ""; ?> /></td>
<?
    }
?>
<?
    $i = 0;
    foreach ($mezok as $k => $mezo) {
?>
  <td><?
        if ($k == 0)
            echo "<strong>";
        if (substr($mezok[$k], 0, 1) == "?") {
            //      echo str_replace("\$", "", substr($mezok[$k],1,strlen($mezok[$k])));
            eval($mezok[$k]);
            //,1,strlen($mezok[$k])));
        } else {
            //        echo htmlspecialchars($sor[$mezok[$k]]);
            echo $sor[$mezok[$k]];
        }
        if ($k == 0)
            echo "</strong>";
?></TD>
<?
    }
?>
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
?>" />  <td align="center"><a href="<? echo $phpmodosit; ?>?<? echo $tmpp; ?>">módosít</a></td>
 </tr>

<?
}
?>
 <tr >
 </tbody>
</table>
<script language="JavaScript">
<!--
	tigra_tables('lista_table', 1, 0, '#f5efd5', '#fffbe9', '#e0d08c', '#c49133');
// -->
</script>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <td align="right" nowrap="nowrap">Összeset kijelöl
    <input type="checkbox" name="checkbox2" value="checkbox" onclick="setCheckboxes('listaForm', true); return false;"></td>
 </tr>
 <tr align="right">
  <td><input name="Submit22" type="submit" class="inp_but" value="Kijelöltek törlése" style="width:120px!important" /></td>
 </tr>
</table>

</form>
</form>
<p>
  <img src="images/uj.gif"><a href="<? echo $phpmodosit . "?" . $linkszuro; ?>">Új felvitel.</a>
 </p>
<?
include "template/_sugo.php";
?>