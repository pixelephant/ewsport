<?php
header("Content-Type: application/octet-stream");
include 'config.php';
include '_sql.php';
include '_kodok.php';


header("Content-Length: " . strlen($csvdata));
$filename = "futurefund_felhasznalok.csv";
header("Content-Disposition: attachment; filename=\"" . $filename . "\"");
header("Content-Transfer-Encoding: binary");

//include "../kozos/settings.php";
//include "../kozos/adatbazis.php";
//include "gsql2.php";

//$sql = connectdb(DBHOST, DB, DBUSER, DBPASS);

$resQuery = mysql_query("SELECT email FROM nmHirlevelUsers");

if (mysql_num_rows($resQuery) != 0) {
    $elsosor = "Email\n";

    $elsosor = iconv("UTF-8", "ISO-8859-2//TRANSLIT", $elsosor);
    echo $elsosor;

    while ($sor = mysql_fetch_array($resQuery, MYSQL_ASSOC)) {

        $oszlopok = array();
        foreach ($sor as $k => $v) {
            //$v = iconv("ISO-8859-2//TRANSLIT", "UTF-8", $v);
            $oszlopok[] = "\"" . $v . "\"";
        }
        echo iconv("UTF-8", "ISO-8859-2//TRANSLIT", implode(";", $oszlopok)) . "\n";
    }
    //die();
}
?>
