<?php
//session_start();
function FormRadio($name, $value, $other = array())
{
    echo "<input name=\"$name\" type=\"radio\" value=\"$value\"";
    foreach ($other as $k => $v) {
        echo " $k=\"$v\"";
    }
    if ($GLOBALS[$name] == $value)
        echo " checked=\"checked\"";
    echo " />";
}
function FormHidden($name, $other = array(), $value = null)
{
    if ($value == null)
        $value = $GLOBALS[$name];
    echo "<input name=\"$name\" type=\"hidden\"";
    foreach ($other as $k => $v) {
        echo " $k=\"$v\"";
    }
    echo " value=\"" . htmlspecialchars($value) . "\" />";
}
function FormPassword($name, $other = array(), $value = null)
{
    if ($value == null)
        $value = $GLOBALS[$name];
    echo "<input name=\"$name\" type=\"password\"";
    foreach ($other as $k => $v) {
        echo " $k=\"$v\"";
    }
    echo " value=\"" . htmlspecialchars($value) . "\" />";
}
function FormInput($name, $other = array(), $value = null)
{
    if ($value == null)
        $value = $GLOBALS[$name];
    echo "<input name=\"$name\" type=\"text\"";
    foreach ($other as $k => $v) {
        echo " $k=\"$v\"";
    }
    echo " value=\"" . htmlspecialchars($value) . "\" />";
}
function FormTextarea($name, $other = array())
{
    echo "<textarea name=\"$name\" type=\"text\"";
    foreach ($other as $k => $v) {
        echo " $k=\"$v\"";
    }
    echo ">";
    echo htmlspecialchars($GLOBALS[$name]);
    echo "</textarea>";
}
function checkLogin($levels)
{
    if (!$_SESSION['logged_in']) {
        $access = false;
    } else {
        $kt = split(' ', $levels);

        $query = mysql_query('SELECT Level_access FROM nmAdminUsers WHERE ID = "' .
            mysql_real_escape_string($_SESSION['user_id']) . '"');

        $row = mysql_fetch_assoc($query);

        $access = false;

        while (list($key, $val) = each($kt)) {
            if ($val == $row['Level_access']) { //ha van jogosultsaga
                $access = true;
                ;
            }
        }
    }
    if ($access == false) {
        header("Location: login.php");
    } else {
        //nem csinal semmit: continue
    }
}

function safeEscapeString($string)
{
    if (get_magic_quotes_gpc()) {
        return $string;
    } else {
        return mysql_real_escape_string($string);
    }
}

function safeAddSlashes($string)
{
    if (get_magic_quotes_gpc()) {
        return $string;
    } else {
        return addslashes($string);
    }
}
function FormSelect($name, $selarray = array(), $other = array(), $defvalue = 0, $deftext = "", $value = null)
{
    if ($value == null)
        $value = $GLOBALS[$name];

    echo "<select name=\"$name\"";
    foreach ($other as $k => $v) {
        echo " $k=\"$v\"";
    }

    echo ">";
    if ($deftext != "") {
        echo "<option value=\"$defvalue\"" . (($defvalue == $value) ? " selected=\"selected\"" :
            "") . ">$deftext</option>";
    }
    foreach ($selarray as $k => $v) {
        echo "<option value=\"$k\"" . (($k == $value) ? " selected=\"selected\"" : "") .
            ">$v</option>";
    }
    echo "</select>";
}

function formEvszamSelect($fStartd, $fEvStart, $selectNev)
{
    $startd = $fStartd;
    if ($evStart == '') {
        $evStart = $fEvStart;
    }
    echo "<select name=\"$selectNev\">";
    while ($fEvStart > $startd) {
        $startd += 1;
?>
                <option value="<?= $startd ?>"<?= $selectNev == $evStart ? " selected=\"selected\"" :
        "" ?>><?= $startd ?></option>
<?php
    }
    echo '</select>';
}

function formHonapSelect($formNev)
{
?>
                    <select name="<?= $formNev; ?>" id="kezdet_honap">
                <option value="01"<? if ($honapStart == "01")
        echo " selected=\"selected\""; ?>>január</option>
                <option value="02"<? if ($honapStart == "02")
        echo " selected=\"selected\""; ?>>február</option>
                <option value="03"<? if ($honapStart == "03")
        echo " selected=\"selected\""; ?>>március</option>
                <option value="04"<? if ($honapStart == "04")
        echo " selected=\"selected\""; ?>>április</option>
                <option value="05"<? if ($honapStart == "05")
        echo " selected=\"selected\""; ?>>május</option>
                <option value="06"<? if ($honapStart == "06")
        echo " selected=\"selected\""; ?>>június</option>
                <option value="07"<? if ($honapStart == "07")
        echo " selected=\"selected\""; ?>>július</option>
                <option value="08"<? if ($honapStart == "08")
        echo " selected=\"selected\""; ?>>augusztus</option>
                <option value="09"<? if ($honapStart == "09")
        echo " selected=\"selected\""; ?>>szeptember</option>
                <option value="10"<? if ($honapStart == "10")
        echo " selected=\"selected\""; ?>>október</option>
                <option value="11"<? if ($honapStart == "11")
        echo " selected=\"selected\""; ?>>november</option>
                <option value="12"<? if ($honapStart == "12")
        echo " selected=\"selected\""; ?>>december</option>
                </select>
<?php
}

function formNapSelect($formNev)
{
?>
    <select name="<?= $formNev; ?>">
<?php
    if ($napStart == "") {
        $napStart = 15;
    }
    for ($i = 1; $i < 32; $i++) {
        if ($i < 10) {
            $eloke = "0";
        } else {
            $eloke = "";
        }
?>
      <option value="<?= $eloke . $i ?>"<?= $napStart == $eloke . $i ? " selected" :
        "" ?>><?= $i ?></option>
    <?php
    }
?>
                </select>
<?php
}

function __gettext($textid)
{
    global $menus;

    $tmp = gsql_numassoc("SELECT * FROM nmTexts WHERE id=$textid");
    $tmp = $tmp[0];
    $keywords = $tmp["keywords"];
    $title = $tmp["title"];

    $tmppics = gsql_numassoc("SELECT * FROM nmTextpics WHERE textid=$textid ORDER BY number");

    $tmp["pics"] = array();

    foreach ($tmppics as $tmppic) {
        $tmp["pics"][$tmppic["number"]] = $tmppic;

        //if($tmppic["meretez"])$kep = $tmppic["path"]."m.jpg"; 
        //else $kep = $tmppic["path"]."_orig.jpg";
        $kep = $tmppic["path"].$tmppic["size"].".jpg";

        $tabla = kepecsketablacska($kep, $tmppic["align"], $tmppic["path"]."b.jpg",
            $tmppic["path"]."b.jpg')", //         "",
            //         "",
        $tmppic["name"], $tmppic["alt"], $tmppic["meretez"], $tmppic["keret"], $tmppic["link"]);

        $tmp["text"] = str_replace("\$kep" . $tmppic["number"] . "\$", $tabla, $tmp["text"]);

        $tabla = linkecske($tmppic[name], $tmppic["path"]."c.jpg");
        $tmp["text"] = str_replace("\$keplink" . $tmppic["number"] . "\$", $tabla, $tmp["text"]);
    }
    $tmpfiles = gsql_numassoc("SELECT * FROM nmTextfiles WHERE textid=$textid");
    foreach ($tmpfiles as $tmpfile) {
        $tmp["text"] = str_replace("\$file" . $tmpfile["number"] . "\$", "<a href=\"uploads/text/$textid/" .
            $tmpfile["path"] . "\" target=\"_blank\" />" . $tmpfile["text"] . "</a>", $tmp["text"]);

    }

    //  "http://menu/szám" típusú linkek => "?id=szám"
    //      $body=preg_replace("/(form action=\"\\/)([\\w\\s_]+)/","\\1{$directory}\\2.html",$body);

    $tmp["text"] = preg_replace("/http:\\/\\/menu\\/([0-9]*)([^0-9])/",
        "index.php?id=\\1\\2", $tmp["text"]);
    

    return $tmp;
}

function linkecske($linknev, $keplink)
{
    //$linknev="xxxxx";
    if (!file_exists($keplink))
        return "$linknev";
    return "<a href=\"$keplink\" target=\"_blank\" onclick=\"MM_openBrWindow('pic.php?pic=$keplink','','resizable=1,width=200,height=200'); return false;\">$linknev</a>";
}

function kepecsketablacska($url = "", $align = "", $ahref = "", $aonclick = "",
    $szoveg = "", $alt = "", $meretez="", $keret="", $linkk="")
{
    if (!file_exists($url))
        return "";
    $kmeret = getimagesize($url);
    $kw = $kmeret[0]+8;
    if ($alt == "")
        $alt = $szoveg;
    $alt = htmlspecialchars($alt, ENT_QUOTES);
    $szoveg = nl2br($szoveg);

    $pic = "";
    //  if ($align=="c")  $pic="<br clear=\"all\" />";
    
    if($keret)
    {
        switch ($align) {
            case "l":
                $irany = "left";
                break;
            case "r":
                $irany = "right";
                break;
            case "c":
                $irany = "center";
                break;
        }
    }
    else
    {
        switch ($align) {
            case "l":
                $irany = "left_wk";
                break;
            case "r":
                $irany = "right_wk";
                break;
            case "c":
                $irany = "center_wk";
                break;
        }
    }


    $pic .= '<div class="kepalairas_'.$irany.'"';
    if($align=="c")$pic .= ' style="width:'.$kw.'px"';
    $pic .= '>';
    $keplink = "uploads/text/$textid/{$tmppic[number]}b.jpg";
    if(!$linkk){ $aonclick=""; $ahref="";}
    if ($aonclick != "" || $ahref != "") {
        $pic .= "<a";
        if ($ahref != "") {
            $pic .= " href=\"$ahref\"";
        }
        if ($aonclick != "") {
            //$pic .= " onClick=\"$aonclick\"";
        }
        $pic .= " rel=\"lytebox\" title=\"$alt\">";
    }
    $pic .= '<img src="'.$url.'" alt="'.$alt.'" />';
    //$pic .= "<img src=\"$url\" alt=\"$alt\" title=\"$alt\" hspace=\"4\" vspace=\"2\" class=\"kepkeret\" align=\"$irany\" />";


    if ($aonclick != "" || $ahref != "") {
        $pic .= "</a>";
    }
    

    if ($szoveg != "") {
        //    $pic .= "<tr><td align=\"center\"><small>$szoveg</small></td></tr>";

        $pic .= "<br />&nbsp;$szoveg";
    }
    $pic .= "</div>";

    if ($align == "c")
        $pic .= '<div class="clear"></div>';

    return $pic;
}

function get_webcim($string, $tabla, $id, $category)
{
    global $host;
    global $dbUser;
    global $dbPass;
    global $dbName;
    global $db;

    if ($tabla == 'f_category') {
        $url = "forum" . "/" . nevtourl($string) . '-' . $id;
    } else
        if ($tabla == 'f_topic') {
            $sqlTopic = "SELECT id, webcim FROM f_category WHERE id = $category";
            $resultTopic = $db->query($sqlTopic);
            $row = $resultTopic->fetch();
            $url = $row['webcim'] . "/" . nevtourl($string) . '-' . $id;
        }
    $url = $url;
    return mysql_query("UPDATE $tabla SET webcim='$url' WHERE id=$id");
}
$honapoknevei [1] = "január";
$honapoknevei [2] = "február";
$honapoknevei [3] = "március";
$honapoknevei [4] = "április";
$honapoknevei [5] = "május";
$honapoknevei [6] = "június";
$honapoknevei [7] = "július";
$honapoknevei [8] = "augusztus";
$honapoknevei [9] = "szeptember";
$honapoknevei [10] = "október";
$honapoknevei [11] = "november";
$honapoknevei [12] = "december";
function date2datum($date) {
    global $honapoknevei;
    return substr ( $date, 0, 4 ) . ". " . $honapoknevei [( int ) substr ( $date, 5, 2 )] . " " . substr ( $date, 8, 2 ) . ".";
    //}
}
function make_url($text, $maxlen=64)
{
    // a nevbol lesz a kod
    $uw = trim($text);

    // tag nemkell
    $uw = strip_tags($uw);

    // rovid legyen
    $uw = substr($uw, 0, $maxlen);

    // ekezet csere
    $uw = str_replace("á", "a", $uw);
    $uw = str_replace("é", "e", $uw);
    $uw = str_replace("í", "i", $uw);
    $uw = str_replace("ó", "o", $uw);
    $uw = str_replace("ö", "o", $uw);
    $uw = str_replace("ő", "o", $uw);
    $uw = str_replace("ú", "u", $uw);
    $uw = str_replace("ü", "u", $uw);
    $uw = str_replace("ű", "u", $uw);
    $uw = str_replace(" ", "-", $uw);
    $uw = str_replace("Á", "a", $uw);
    $uw = str_replace("É", "e", $uw);
    $uw = str_replace("Í", "i", $uw);
    $uw = str_replace("Ó", "o", $uw);
    $uw = str_replace("Ö", "o", $uw);
    $uw = str_replace("Ő", "o", $uw);
    $uw = str_replace("Ú", "u", $uw);
    $uw = str_replace("Ü", "u", $uw);
    $uw = str_replace("Ű", "u", $uw);
    //
    $uw = str_replace("--", "-", $uw);
    $uw = str_replace("/", "-", $uw);

    // kisbetu
    $uw = strtolower($uw);

    // egyeb karaker csere
    $uw = ereg_replace('[^a-z0-9_-]', '', $uw);

    return $uw;
}

function getCatTree($pid = 0)
{
    $ret = array();
    $fokatok_er = mysql_query("select * from nmMenus where parentid=".$pid." and active='y' and visible='y' order by number asc");
    while($v = mysql_fetch_array($fokatok_er))
    {
        $ret[] = array("id" => $v["id"], "nev" => $v["name"], "tipus" => $v["tipus"], "sorrend" => $v["number"], "parentid" => $v["parentid"], "url" => $v["url"], "alkatok" => getCatTree($v["id"]));
    }
    return $ret;
}

function balmenuFromArray($arr, $ulid)
{
    if(!count($arr))return;
    $mclass = "";
    if($ulid == 0)$mclass = ' id="dropdown-menu"';
    echo '<ul'.$mclass.'>';
    foreach($arr as $k=>$v)
    {
        echo "<li>";
            echo '<a href="/'.$elozo.$v["url"].'">'.$v["nev"].'</a>';
            balmenuFromArray($v["alkatok"], $v["id"]);
        echo "</li>";
    }
    echo "</ul>";
}

function getTermekCatTree($pid = 0)
{
    $ret = array();
    $fokatok_er = mysql_query("select * from nmTermekKat where parentid=".$pid." and active='y' and visible='y' order by number asc");
    while($v = mysql_fetch_array($fokatok_er))
    {
        $ret[] = array("id" => $v["id"], "nev" => $v["name"], "tipus" => $v["tipus"], "sorrend" => $v["number"], "parentid" => $v["parentid"], "url" => $v["url"], "alkatok" => getTermekCatTree($v["id"]));
    }
    return $ret;
}

function aruhazmenuFromArray($arr, $ulid)
{
    if(!count($arr))return;
    $mclass = "";
    if($ulid == 0)$mclass = ' id="dropdown-webaruhaz"';
    echo '<ul'.$mclass.'>';
    foreach($arr as $k=>$v)
    {
        echo "<li>";
            echo '<a href="/webaruhaz/'.$v["url"].'">'.$v["nev"].'</a>';
            aruhazmenuFromArray($v["alkatok"], $v["id"]);
        echo "</li>";
    }
    echo "</ul>";
}

function getMenuEleres($katdata)
{
    $cat = mysql_fetch_array(mysql_query("select * from nmMenus where active='y' and id=".$katdata["parentid"]));
    if(!$cat)return;
    return getMenuEleres($cat)."/".$katdata["nev"];
}

function balmenuFromArraySitemap($arr, $ulid)
{
    if(!count($arr))return;
    echo '<ul>';
    foreach($arr as $k=>$v)
    {
        echo "<li>";
            echo '<a href="/'.$v["url"].'">'.$v["nev"].'</a>';
            if($v["tipus"] == "lista")
            {
                $cikks = gsql_numassoc("select * from nmTexts where menuid=".$v["id"]);
                if(count($cikks))
                {
                    echo '<ul>';
                    foreach($cikks as $cikk)
                    {
                        echo '<li><a href="/'.$v["url"]."/-".$cikk["url"].'">'.$cikk["name"].'</a></li>';
                    }
                    echo '</ul>';
                }
            }
            balmenuFromArraySitemap($v["alkatok"], $v["id"]);
        echo "</li>";
    }
    echo "</ul>";
}

function linkSlash($html)
{
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->loadHTML('<?xml encoding="UTF-8">' . $html);
    
    // dirty fix
    foreach ($dom->childNodes as $item)
        if ($item->nodeType == XML_PI_NODE)
            $dom->removeChild($item); // remove hack
    $dom->encoding = 'UTF-8'; // insert proper

    $anchors = $dom->getElementsByTagName('a');
    foreach($anchors as $a)
    {
        if($a->hasAttribute('href'))
        {
            if(!strpos($a->getAttribute('href'),"http://"))
            {
                $a->setAttribute("href", '/'.$a->getAttribute('href'));
            }
        }
    }
    return($dom->saveHTML());
}

function utf_substr($string, $start, $len, $byte = 3) {
    $str = "";
    $count = 0;
    $str_len = strlen ( $string );
    for($i = 0; $i < $str_len; $i ++) {
        if (($count + 1 - $start) > $len) {
            $str .= "...";
            break;
        } elseif ((ord ( substr ( $string, $i, 1 ) ) <= 128) && ($count 
< $start)) {
            $count ++;
        } elseif ((ord ( substr ( $string, $i, 1 ) ) > 128) && ($count < 
$start)) {
            $count = $count + 2;
            $i = $i + $byte - 1;
        } elseif ((ord ( substr ( $string, $i, 1 ) ) <= 128) && ($count 
 >= $start)) {
            $str .= substr ( $string, $i, 1 );
            $count ++;
        } elseif ((ord ( substr ( $string, $i, 1 ) ) > 128) && ($count 
 >= $start)) {
            $str .= substr ( $string, $i, $byte );
            $count = $count + 2;
            $i = $i + $byte - 1;
        }
    }
    return $str;
}

function levag_text($szoveg, $levag) {
    $szoveg = strip_tags ( $szoveg );
    if (strlen ( $szoveg ) > $levag) {
        $szoveg = utf_substr ( $szoveg, 0, $levag );
        $szoveg = preg_replace ( "|(\$kep[0-9]+\$)|", "", $szoveg );
    }
    return $szoveg;
}

function unparse_url($parts_arr) {
  if (strcmp($parts_arr['scheme'], '') != 0) {
    $ret_url = $parts_arr['scheme'] . '://';
  }
  $ret_url .= $parts_arr['user'];
  if (strcmp($parts_arr['pass'], '') != 0) {
    $ret_url .= ':' . $parts_arr['pass'];
  }
  if ((strcmp($parts_arr['user'], '') != 0) || (strcmp($parts_arr['pass'], '') != 0)) {
    $ret_url .= '@';
  }
  $ret_url .= $parts_arr['host'];
  if (strcmp($parts_arr['port'], '') != 0) {
    $ret_url .= ':' . $parts_arr['port'];
  }
  $ret_url .= $parts_arr['path'];
  if (strcmp($parts_arr['query'], '') != 0) {
    $ret_url .= '?' . $parts_arr['query'];
  }
  if (strcmp($parts_arr['fragment'], '') != 0) {
    $ret_url .= '#' . $parts_arr['fragment'];
  }
  
  return $ret_url;
}

function URI_remove_allquery($url) {
  $parts_arr = parse_url($url);
  $parts_arr['query'] = '';
  return unparse_url($parts_arr);
}

function URI_add_query_arg($url, $arg, $val) {
  $url=URI_remove_query_arg($url, $arg);
  $parts_arr = parse_url($url);
  
  if (strcmp($parts_arr['query'], '') != 0)
    $parts_arr['query'] .= '&';

  $parts_arr['query'] .= $arg . '=' . $val;
  
  return unparse_url($parts_arr);
}

function URI_remove_query_arg($url, $arg) {
  $parts_arr = parse_url($url);
  if (!strcmp($parts_arr['query'], '')) return $url;
  
  $query_arr = explode('&', $parts_arr['query']);
  foreach ($query_arr as $k => $v)
  {
    if ((preg_match('/^'.$arg.'=/', $v)) || (preg_match('/^'.$arg.'$/', $v)))
    {
      unset($query_arr[$k]);
    }
  }
  $parts_arr['query'] = implode('&', $query_arr);
  
  return unparse_url($parts_arr);
}

?>