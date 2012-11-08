<?php
foreach ($_GET as $k => $v) {
    $$k = &$_GET[$k];
}
foreach ($_POST as $k => $v) {
    $$k = &$_POST[$k];
}
foreach ($_FILES as $k => $v) {
    $$k = &$_FILES[$k];
}
$REQUEST_URI = getenv("REQUEST_URI");

$dirpref = "";
if (strstr(getenv("REQUEST_URI"), "admin/ajax/")) {
    $dirpref = "../../";
} else
    if (strstr(getenv("REQUEST_URI"), "admin/php/")) {
        $dirpref = "../../";
    } else
        if (strstr(getenv("REQUEST_URI"), "admin/export/")) {
            $dirpref = "../../";
        } else
            if (strstr(getenv("REQUEST_URI"), "admin/remote")) {
                $dirpref = "../../";
            } else
                if (strstr(getenv("REQUEST_URI"), "xml/server/")) {
                    $dirpref = "../../";
                } else
                    if (strstr(getenv("REQUEST_URI"), "admin")) {
                        $dirpref = "../";
                    } else
                    if (strstr(getenv("REQUEST_URI"), "ajax")) {
                        $dirpref = "../";
                    }
$most = date('Y-m-d H:i:s');
$ideiEv = date('Y');
$SiteId = 1;
$HTTP_HOST = $_SERVER['HTTP_HOST'];
$httplink = "http://" . $HTTP_HOST . "/";
define('WEBCIM', "http://futurefund.blan.hu/");
define ('GYOKER', "/home/www/norman.hu/html/");
//require_once "$dirpref" . "admin/_ekezettelenit.php";

/**
 * kepfeltoltes konyvtarai
 */
$certDir = $dirpref . "uploads/certification/";

define("DIRLOG", $dirpref . "log/");

define("DIRUTAZAS", $dirpref . "uploads/utazasok/");
define("DIRTEXT", $dirpref . "uploads/text/");
define("DIRMENU", $dirpref . "uploads/menu/");
define("DIRAJANLAT", $dirpref . "uploads/ajanlat/");
define("DIRGAL", $dirpref . "uploads/galeria/");
define("DIRKAT", $dirpref . "uploads/termekkategoria/");

define("DIRGALERIA", $dirpref . "uploads/galery/");
define("DIRJELENTKEZES", $dirpref . "uploads/jelentkezes/");
define("DIRUSER", $dirpref . "uploads/userpic/");
define("DIRTERMEKPIC", $dirpref . "uploads/termekek/");


define("BIGPICWIDTH", 1000);
define("BIGPICHEIGHT", 800);
define("MEDIUMPICWIDTH", 600);
define("MEDIUMPICHEIGHT", 400);
define("SMALLPICWIDTH", 150);
define("SMALLPICHEIGHT", 150);


define("TEXTLEADPICWIDTH", 90);
define("TEXTLEADPICHEIGHT", 60);

define("TEXTSMALLPICWIDTH", 150);
define("TEXTSMALLPICHEIGHT", 150);
define("TEXTBIGPICWIDTH", 1000);
define("TEXTBIGPICHEIGHT", 800);

define("GALERIANAGYSZELES", "360");
define("GALERIANAGYMAGAS", "240");
define("GALERIAKISSZELES", "99999");
define("GALERIAKISMAGAS", "74");

/**
 * KEPMERETEK BEALLITASA
 */
$config["text"]["pic"] = array("b,jpg,max,400,800" => array("s,jpg,max,120,240",
    "m,jpg,max,260,520", "lead,jpg,fixcut,124,124", "akcios,jpg,fixcut,89,101",
    "thumb,jpg,fixcut,172,192", "c,jpg,fixcut,64,64" => "a,gif,fixcut,102,80"));

$config["text"]["leadpic"] = array("leadb,jpg,max,1000,1000" => array("leads,jpg,fixcut,162,93",
    "leadm,jpg,max,64,64", "leadc,jpg,max,425,9999" => "leada,gif,fixcut,102,80"));

$config["text"]["leadpicminositesek"] = array("leadb,jpg,max,560,1000" => array
    ("leads,jpg,max,180,9999", "leadc,jpg,max,425,9999" => "leada,gif,fixcut,102,80"));

$config["text"]["galery"] = array("b,jpg,max,800,600" => array("s,jpg,fixcut,251,125", "admin,jpg,max,120,120"));

$config["text"]["termekpic"] = array("b,jpg,max,592,400" => array("s,jpg,fixcut,286,165",
    "fixcut,jpg,fixcut,162,93"));

$config["text"]["termekkat"] = array("leadb,jpg,max,600,400" => array("leads,jpg,max,56,9999"));


/**
 * CACHE KONYVTARAK
 */

$cachedir = $dirpref . "Cache/";
$cachedirJelentkezes = $dirpref . "Cache/jelentkezesek/";
$cachedirUser = $dirpref . "Cache/user/";



/**
 * ADATBAZIS KAPCSOLODAS
 */

require_once "$dirpref" . "Database/MySQL.php";

$host = 'localhost'; // Host neve
$dbUser = 'root'; // User
//$dbPass = 'Aeyiep5ayo'; // Jelszo
$dbPass = ''; // Jelszo
$dbName = 'ewutazas_hu'; // Adatbazis neve
// 353ae90f
// MySQL kapcsolodas
$db = &new MySQL($host, $dbUser, $dbPass, $dbName);
mysql_query("SET NAMES utf8");
//mysql_query("SET CHARACTER SET utf8");


// a fo be�ll�t�sok mind a publikushoz, mind az adminhoz
$mainsett = array();
$er_sett = mysql_query("select kulcs, ertek from nmSettings");
while($row = mysql_fetch_array($er_sett))$mainsett[$row["kulcs"]] = $row["ertek"];


?>