<?php
// ellenőrzés: ne GET és ne POST legyen a

$kapcsolat = SQL_indul();
mysql_query("SET NAMES utf8");
mysql_query("SET CHARACTER SET utf8");

/**
 * gsql_numassoc()
 *
 * @param mixed $parancs
 * @return
 */
function gsql_numassoc($parancs)
{
    $Kereslista2 = array();
    $result = SQL_parancs($parancs);
    //echo $parancs;
    while ($line = mysql_fetch_assoc($result))
    {
        $Kereslista2[] = $line;
    }
    return $Kereslista2;
}

/**
 * gsql_selstart()
 *
 * @param mixed $lekerdezes
 * @return
 */
function gsql_selstart($lekerdezes)
{
    return mysql_query($lekerdezes);
}

/**
 * gsql_selnext()
 *
 * @param mixed $a
 * @return
 */
function gsql_selnext($a)
{
    return mysql_fetch_assoc($a);
}

/**
 * gsql_selnext2()
 *
 * @param mixed $a
 * @return
 */
function gsql_selnext2($a)
{
    return mysql_fetch_array($a);
}

/**
 * gsql_selend()
 *
 * @param mixed $a
 * @return
 */
function gsql_selend($a)
{
    mysql_free_result($a);
}


/**
 * gsql_2assoc()
 *
 * @param mixed $parancs
 * @return
 */
function gsql_2assoc($parancs)
{
    $Kereslista2 = array();
    $result = SQL_parancs($parancs);
    while ($line = mysql_fetch_row($result))
    {
        if (!isset($line[1]))
            $line[1] = "1";
        $Kereslista2[$line[0]] = $line[1];
    }
    return $Kereslista2;
}

/**
 * g_log()
 *
 * @param mixed $uzenet
 * @return
 */
function g_log($uzenet)
{
    global $process;

    error_log(date('Y-m-d H:i:s') . "\t" . $process["user"]["felh_nev"] . "\t" . $uzenet .
        "\n", 3, "log.log");
}



/**
 * gsql_parancs()
 *
 * @param mixed $parancs
 * @param integer $loggol
 * @return
 */
function gsql_parancs($parancs, $loggol = 0)
{
    global $process;

    $result = SQL_parancs($parancs);

    g_log($parancs);

    return $result;
}


/**
 * SQL_indul()
 *
 * @return
 */
function SQL_indul()
{
    global $host, $dbUser, $dbPass, $dbName;

    $kapcsolat = mysql_connect($host, $dbUser, $dbPass);
    if (!$kapcsolat)
    {
        die("Nem lehet csatlakozni a kiszolgálóhoz");
    }
    else
    {
        mysql_select_db($dbName);
    }

    return $kapcsolat;
}

/**
 * SQL_connect()
 *
 * @return
 */
function SQL_connect()
{
    global $host, $dbUser, $dbPass, $dbName;
    return mysql_connect($host, $dbUser, $dbPass);
}

/**
 * SQL_stop()
 *
 * @param mixed $kapcs
 * @return
 */
function SQL_stop($kapcs)
{

    mysql_close($kapcs);
}

/**
 * SQL_parancs()
 *
 * @param mixed $parancs
 * @return
 */
function SQL_parancs($parancs)
{
    $r = mysql_query($parancs);
    // or die("SQL hiba: ".$parancs.mysql_error());
    return $r;
}

// txt2savetxt :: csak a \\, \n, \r, \t karaktereket alakítja át
// ezt kell használni az uninstallnál, ill. mentésnél
/**
 * txt2savetxt()
 *
 * @param mixed $s
 * @return
 */
function txt2savetxt($s)
{
    return addcslashes($s, "\0\t\n\r\\");
}

// txt2dtxt :: csak a \\, \n, \r, \t karaktereket alakítja át
// ezt kell használni az adatbázis használatakor
/**
 * txt2utxt()
 *
 * @param mixed $s
 * @return
 */
function txt2utxt($s)
{
    $s = str_replace("?", "!3F", $s);
    $s = str_replace("&", "!22", $s);
    $s = str_replace("/", "!2F", $s);
    return $s;
}

/**
 * utxt2txt()
 *
 * @param mixed $s
 * @return
 */
function utxt2txt($s)
{
    $s = str_replace("!3F", "?", $s);
    $s = str_replace("!22", "&", $s);
    $s = str_replace("!2F", "/", $s);
    return $s;
}

/**
 * txt2urlap()
 *
 * @param mixed $s
 * @return
 */
function txt2urlap($s)
{
    return htmlspecialchars($s);
}

/**
 * gsql_mezonevek()
 *
 * @param mixed $SQLdatabase
 * @param mixed $adattablanev
 * @return
 */
function gsql_mezonevek($SQLdatabase, $adattablanev)
{
    $fields = mysql_list_fields($SQLdatabase, $adattablanev);
    $columns = mysql_num_fields($fields);
    $mezonev = array();
    for ($i = 0; $i < $columns; $i++)
        $mezonev[] = mysql_field_name($fields, $i);
    return $mezonev;
}


/**
 * gsql_globalselect1()
 *
 * @param mixed $select
 * @return
 */
function gsql_globalselect1($select)
{
    $tmp = gsql_numassoc($select);
    if (count($tmp) == 1)
    {
        $tmp = $tmp[0];
        foreach ($tmp as $k => $v)
        {
            $GLOBALS[$k] = $v;
        }
        return $tmp;
    }
    return false;
}

?>
