<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Content-Type: text/html; charset=utf-8");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include "config.php";
include "_sql.php";
//include "_auth.php";
include "_kodok.php";
include_once('../functions/functions.php');

$menu = "";
$elotag = "";

/**
 * menuk()
 *
 * @param mixed $menuid
 * @param integer $melyseg
 * @param integer $sor
 * @return void
 */

function menuk($menuid, $melyseg = 0, $sor = 0)
{
    global $menu, $elotag;

    $tmpelotag = $elotag;
    $elotag .= "+";

    $t = gsql_numassoc("SELECT * FROM nmMenus WHERE parentid=$menuid AND visible='y' ORDER BY number,id");

    $db = 0;
    foreach ($t as $k => $v) {
        $darab = gsql_2assoc("SELECT count(*) FROM nmMenus WHERE parentid=$v[id]");
		//if($darab[0] == 0)$menu .= $elotag . $v[name] . "|\n";
        //else 
		//{
			if($v[tipus] == "cikk" || $v["tipus"] == "egyeb")
			{
				$mcikk = gsql_numassoc("SELECT id FROM nmTexts where menuid=".$v[id]." order by id desc");
				if(count($mcikk) > 0)
				{
					$menu .= $elotag . $v[name] . "|xpertCMS_text.php?id=".$mcikk[0][id]."\n";
				}
				else
				{
					gsql_parancs("INSERT INTO nmTexts (name, menuid, created, active) VALUES ('".$v[name]."', ".$v[id].", now(), 'y')");
					
					$nmid = mysql_insert_id();
					$url = make_url($v[name], 255);
					if (strlen ( $url ) > 200)
						$url = substr ( $url, 0, 200 );
					$s = "";
					while ( true ) {
						$tmp = gsql_numassoc ( "SELECT * FROM nmTexts WHERE url='$url$s' AND id<>$nmid" );
						if (count ( $tmp ) == 0) {
							break;
						}
						$s ++;
					}
					gsql_parancs ("UPDATE nmTexts SET url=\"$url\" WHERE id=$nmid");
					
					$menu .= $elotag . $v[name] . "|xpertCMS_text.php?id=".$nmid."\n";
				}
			}
			else $menu .= $elotag . $v[name] . "|xpertCMS_lista.php?mit=nmTexts&szuromezo=menuid&szuroid={$v[id]}\n";
		//}

        menuk($v[id], $melyseg + 1, $db);
        $db++;
    }
    $elotag = $tmpelotag;
}

$menu .= "Utazas|\n";
$menu .= "+parameterek|\n";
$menu .= "++utazas tipusa|xpertCMS_lista.php?mit=parameterek&szuromezo=parentid&szuroid=1\n";
$menu .= "++uticel - orszag|xpertCMS_lista.php?mit=parameterek&szuromezo=parentid&szuroid=2\n";
$menu .= "++uticel - varos|xpertCMS_lista.php?mit=parameterek&szuromezo=parentid&szuroid=3\n";
$menu .= "++szallas tipusa|xpertCMS_lista.php?mit=parameterek&szuromezo=parentid&szuroid=4\n";
$menu .= "++ellatas|xpertCMS_lista.php?mit=parameterek&szuromezo=parentid&szuroid=5\n";
$menu .= "+uj utazas|xpertCMS_utazas.php\n";
$menu .= "+utazasok|xpertCMS_lista.php?mit=utazasok\n";
//$menu .= "Menük|\n";
//$menu .= "+új almenü|xpertCMS_menu.php?id=0\n";
//$menu .= "+menü lista|xpertCMS_lista.php?mit=nmMenus&szuromezo=parentid&szuroid=0\n";


$menu .= "Tartalom|\n";
menuk(0);

//$menu .= "Termékek|\n";
//$menu .= "+új kategória|xpertCMS_kat.php?id=0\n";
//$menu .= "+kategória lista|xpertCMS_lista.php?mit=nmTermekKat&szuromezo=parentid&szuroid=0\n";
//$menu .= "+új termék|xpertCMS_termek.php?id=0\n";
//$menu .= "+termék lista|xpertCMS_lista.php?mit=nmTermekek\n";


$menu .= "Galéria|\n";
$menu .= "+Új galéria|xpertCMS_listagalery.php\n";
$menu .= "+Galéria lista|xpertCMS_lista.php?mit=nmGaleries\n";

/*
$menu .= "Hírlevél|\n";
$menu .= "+Hírlevél szerkesztése|xpertCMS_hirlevel.php\n";
$menu .= "+Hírlevelek listája|xpertCMS_lista.php?mit=nmHirlevel_texts\n";
$menu .= "+Hírlevél kiküldése|xpertCMS_hirlevel_kuld.php\n";
$menu .= "+Kiküldött hírlevelek|xpertCMS_lista.php?mit=nmHirlevel_kikuldott\n";
$menu .= "+Címek exportálása|csv_user.php\n";
$menu .= "+Feliratkozottak|xpertCMS_lista.php?mit=nmHirlevelUsers\n";
$menu .= "+Új feliratkozó|xpertCMS_hirlevelusers.php\n";

$menu .= "Settings|xpertCMS_settings.php\n";
*/
$menu = explode("\n", $menu);
$menuk = array();
$menuk[] = "sub0 = gFld('<b>&nbsp;</b>','javascript:undefined')";

$elozomelyseg = -1;

foreach ($menu as $menuitem) {
    if ($menuitem == "")
        continue;
    $menuitem = trim($menuitem);
    $menuitem = explode("|", $menuitem);
    if ($menuitem[1] == "") {
        $menuitem[1] = "javascript:undefined";
    } else {
        $menuitem[1] = $menuitem[1];
    }

    if ($menuitem[0] == "")
        continue;
    if ($menuitem[1] == "")
        continue;

    $melyseg = 0;
    for ($i = 0; $i < strlen($menuitem[0]); $i++) {
        if (substr($menuitem[0], $i, 1) == '+') {
            $melyseg++;
        }
    }
    $menuitem[0] = substr($menuitem[0], $melyseg, strlen($menuitem[0]));
    $melyseg++;
    $menuk[] = "insDoc(sub" . ($melyseg - 1) . ", gLnk('S', '{$menuitem[0]}', '{$menuitem[1]}'))";
    if (($melyseg > $elozomelyseg) && ($melyseg > 1)) {
        $menuk[count($menuk) - 2] = "sub" . $elozomelyseg . " = insFld(sub" . ($elozomelyseg -
            1) . ", gFld('{$elozomenuitem[0]}', '{$elozomenuitem[1]}'))";
    }
    $elozomelyseg = $melyseg;
    $elozomenuitem = $menuitem;
}
?>//Environment variables are usually set at the top of this file.
USETEXTLINKS = 1
STARTALLOPEN = 0
USEFRAMES = 0
USEICONS = 0
WRAPTEXT = 1
PRESERVESTATE = 1
ICONPATH = 'tvimages/'
HIGHLIGHT = 1
<?
foreach ($menuk as $v) {
    echo str_replace("sub0", "foldersTree", $v) . "\n\r";
}
?>