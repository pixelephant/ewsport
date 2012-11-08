<?
include "_kepek.php";

/**
 * fomenu()
 *
 * @param mixed $id
 * @return
 */
 
function get_user_name($userid)
{
	$sql = gsql_numassoc("SELECT accnev FROM account WHERE Uid = $userid");
	return $sql[0]['accnev'];
}

function get_user_mail($userid)
{
	$sql = gsql_numassoc("SELECT accemail FROM account WHERE Uid = $userid");
	return $sql[0]['accemail'];
}

function fokat($id)
{
    return gsql_numassoc("SELECT * FROM nmTermekKat WHERE id=$id");
}

$katnames = array();
$katok = gsql_numassoc("SELECT * FROM nmTermekKat ORDER BY name");
foreach ($katok as $kat)
{
    $fk = fokat($kat["parentid"]);
    if (count($fk) > 0)
    {
        $kat["name"] = $fk[0]["name"] . "/" . $kat["name"];
        $fk = fokat($fk[0]["parentid"]);
        if (count($fk) > 0)
        {
            $kat["name"] = $fk[0]["name"] . "/" . $kat["name"];
        }
    }
    $katnames[$kat[id]] = $kat["name"];
}
asort($katnames);

function fomenu($id)
{
    return gsql_numassoc("SELECT * FROM nmMenus WHERE id=$id");
}

$menunames = array();
$menus = gsql_numassoc("SELECT * FROM nmMenus ORDER BY name");
foreach ($menus as $menu)
{
    $fm = fomenu($menu["parentid"]);
    if (count($fm) > 0)
    {
        $menu["name"] = $fm[0]["name"] . " / " . $menu["name"];
        $fm = fomenu($fm[0]["parentid"]);
        if (count($fm) > 0)
        {
            $menu["name"] = $fm[0]["name"] . " / " . $menu["name"];
        }
    }
    $menunames[$menu[id]] = $menu["name"];
}
asort($menunames);

//php example
/**
 * RTESafe()
 *
 * @param mixed $strText
 * @return
 */
function RTESafe($strText)
{
    //returns safe code for preloading in the RTE
    $tmpString = trim($strText);

    //convert all types of single quotes
    $tmpString = str_replace(chr(145), chr(39), $tmpString);
    $tmpString = str_replace(chr(146), chr(39), $tmpString);
    $tmpString = str_replace("'", "&#39;", $tmpString);

    //convert all types of double quotes
    $tmpString = str_replace(chr(147), chr(34), $tmpString);
    $tmpString = str_replace(chr(148), chr(34), $tmpString);
    //	$tmpString = str_replace("\"", "\"", $tmpString);

    //replace carriage returns & line feeds
    $tmpString = str_replace(chr(10), " ", $tmpString);
    $tmpString = str_replace(chr(13), " ", $tmpString);

    return $tmpString;
}

/*
function makeThumb( $scrFile, $dstFile, $dstW=0, $dstH=0) {

$im = @ImageCreateFromJPEG( $scrFile );
$srcW = @ImageSX( $im );
$srcH = @ImageSY( $im );
if ($srcH==0) return FALSE;
if ($srcW==0) return FALSE;

if (($dstW==0) && ($dstH==0)) {
$dstW=$srcW;
$dstH=$srcH;
}

if ($dstW>$srcW) $dstW=$srcW;
if ($dstH>$srcH) $dstH=$srcH;
if ($dstW<1) $dstW=1;
if ($dstH<1) $dstH=1;

if ($dstW/$dstH>$srcW/$srcH)
{
$ujX=$srcW / $srcH*$dstH;
$ujY=1*$dstH;
}
else
{
$ujY=$srcH/$srcW*$dstW;
$ujX=1*$dstW;
}

$ni = @ImageCreateTrueColor( $ujX, $ujY);
@ImageCopyResampled( $ni, $im, 0, 0, 0, 0, $ujX, $ujY, $srcW, $srcH );

if ($dstFile!="") {
@ImageJPEG( $ni, $dstFile);
}
return $ni;
}
*/

/**
 * makeThumb()
 *
 * @param mixed $scrFile
 * @param mixed $dstFile
 * @param integer $dstW
 * @param integer $dstH
 * @param bool $vagas
 * @return
 */
function makeThumb($scrFile, $dstFile, $dstW = 0, $dstH = 0, $vagas = false)
{

    $im = @ImageCreateFromJPEG($scrFile);
    $srcW = @ImageSX($im);
    $srcH = @ImageSY($im);
    if ($srcH == 0)
        return false;
    if ($srcW == 0)
        return false;

    if (($dstW == 0) && ($dstH == 0))
    {
        $dstW = $srcW;
        $dstH = $srcH;
    }

    //  if ($dstW>$srcW) $dstW=$srcW;
    //  if ($dstH>$srcH) $dstH=$srcH;
    if ($dstW < 1)
        $dstW = 1;
    if ($dstH < 1)
        $dstH = 1;

    if ($dstW / $dstH > $srcW / $srcH)
    {
        $ujX = $srcW / $srcH * $dstH;
        $ujY = 1 * $dstH;
    }
    else
    {
        $ujY = $srcH / $srcW * $dstW;
        $ujX = 1 * $dstW;
    }

    $ujX = (int)$ujX;
    $ujY = (int)$ujY;
    $fx = 0;
    $fy = 0;

    if ($vagas)
    {
        if ($ujX != $dstW)
        {
            $fy = (((1 - $ujX / $dstW) * $srcH) / 2);
            $ujX = $dstW;
        }
        elseif ($ujY != $dstH)
        {
            $fx = (((1 - $ujY / $dstH) * $srcW) / 2);
            $ujY = $dstH;
        }
        $fx = (int)$fx;
        $fy = (int)$fy;
        $ujY = (int)$ujY;
        $ujX = (int)$ujX;
        $ujX = $dstW;
        $ujY = $dstH;
    }

    $ni = @ImageCreateTrueColor($ujX, $ujY);
    @ImageCopyResampled($ni, $im, 0, 0, $fx, $fy, $ujX, $ujY, ($srcW - $fx - $fx), ($srcH -
        $fy - $fy));
    //  @ImageCopyResized(   $ni, $im, 0, 0, $fx, $fy, $ujX, $ujY, ($srcW-$fx-$fx), ($srcH-$fy-$fy));

    if ($dstFile != "")
    {
        @ImageJPEG($ni, $dstFile);
    }

    return $ni;
}

/**
 * dtxt2txt()
 *
 * @param mixed $str
 * @return
 */
function dtxt2txt($str)
{
    return stripslashes($str);
}

/**
 * txt2dtxt()
 *
 * @param mixed $str
 * @return
 */
function txt2dtxt($str)
{
    return addslashes($str);
}

function updateMenuXML()
{
	$xmlfile = "../pro_menu.xml";
	$cont = '<?xml version="1.0" encoding="utf-8" standalone="yes"?><menu>';
    $t = gsql_numassoc("SELECT * FROM nmMenus WHERE parentid=0 AND visible='y' AND tipus<>'egyeb' ORDER BY number,id");
	$i = 0;
	if(count($t))foreach($t as $v)
	{
		$i++;
		gsql_parancs("update nmMenus set flashnum='".$i.";0;0' where id=".$v["id"]);
		$tsub = gsql_numassoc("SELECT * FROM nmMenus WHERE parentid=".$v["id"]." AND visible='y' AND tipus<>'egyeb' ORDER BY number,id");
		$csub = (count($tsub)) ? "true" : "false";
		$ctag = ($v["tipus"] == 'x') ? '' : WEBCIM.'?m='.make_url($v[name]).'-'.$v[id];
		$cont .= '<item cname="'.$v["name"].'" ctag="'.$ctag.'" ctarget="_self" csub="'.$csub.'">';
			$ii = 0;
			if(count($tsub))foreach($tsub as $vsub)
			{
				$ii++;
				gsql_parancs("update nmMenus set flashnum='".$i.";".$ii.";0' where id=".$vsub["id"]);
				$tsubsub = gsql_numassoc("SELECT * FROM nmMenus WHERE parentid=".$vsub["id"]." AND visible='y' AND tipus<>'egyeb' ORDER BY number,id");
				$csub = (count($tsubsub)) ? "true" : "false";
				$ctag = ($vsub["tipus"] == 'x') ? '' : WEBCIM.'?m='.make_url($vsub[name]).'-'.$vsub[id];
				$cont .= '<sub cname="'.$vsub["name"].'" ctag="'.$ctag.'" ctarget="_self" csub="'.$csub.'">';
					$iii = 0;
					if(count($tsubsub))foreach($tsubsub as $vsubsub)
					{
						$iii++;
						gsql_parancs("update nmMenus set flashnum='".$i.";".$ii.";".$iii."' where id=".$vsubsub["id"]);
						$ctag = ($vsubsub["tipus"] == 'x') ? '' : WEBCIM.'?m='.make_url($vsubsub[name]).'-'.$vsubsub[id];
						$cont .= '<subsub cname="'.$vsubsub["name"].'" ctag="'.$ctag.'" ctarget="_self" csub="false">';
						$cont .= '</subsub>';
					}
				$cont .= '</sub>';
			}
		$cont .= '</item>';
	}
	$cont .= '</menu>';
	file_put_contents($xmlfile, $cont);
}

?>