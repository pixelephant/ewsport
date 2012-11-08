<?php

function makeThumb2( $scrFile, $dstFile, $dstW=0, $dstH=0, $vagas=false) {

  $im = @ImageCreateFromJPEG( $scrFile );
  $srcW = @ImageSX( $im );
  $srcH = @ImageSY( $im );
  if ($srcH==0) return FALSE;
  if ($srcW==0) return FALSE;

  if (($dstW==0) && ($dstH==0)) {
    $dstW=$srcW;
    $dstH=$srcH;
  }

//  if ($dstW>$srcW) $dstW=$srcW;
//  if ($dstH>$srcH) $dstH=$srcH;
  if ($dstW<1) $dstW=1;
  if ($dstH<1) $dstH=1;

  if ($dstW/$dstH>$srcW/$srcH) {
    $ujX=$srcW / $srcH*$dstH;
    $ujY=1*$dstH;
  } else {
      $ujY=$srcH/$srcW*$dstW;
      $ujX=1*$dstW;
    }

  $ujX = (int)$ujX;
  $ujY = (int)$ujY;
  $fx = 0;
  $fy = 0;

  if ($vagas) {
    if ($ujX != $dstW) {
      $fy = (((1-$ujX/$dstW)*$srcH)/2);
      $ujX = $dstW;
    } elseif ($ujY != $dstH) {
        $fx = (((1-$ujY/$dstH)*$srcW)/2);
        $ujY = $dstH;
      }
    $fx = (int)$fx;
    $fy = (int)$fy;
    $ujY = (int)$ujY;
    $ujX = (int)$ujX;
    $ujX = $dstW;
    $ujY = $dstH;
  }

  $ni = @ImageCreateTrueColor( $ujX, $ujY);
  @ImageCopyResampled( $ni, $im, 0, 0, $fx, $fy, $ujX, $ujY, ($srcW-$fx-$fx), ($srcH-$fy-$fy));
//  @ImageCopyResized(   $ni, $im, 0, 0, $fx, $fy, $ujX, $ujY, ($srcW-$fx-$fx), ($srcH-$fy-$fy));

  if ($dstFile!="") {
    @ImageJPEG( $ni, $dstFile);
  }

  return $ni;
}


/* ***************************************************
Funkcio:
Thumbnail generalasa
Input:
$kep - forras kep utvonala
$mibe - cel kep utvonala
$x - szelesseg
$y - magassag
Output:
Siker eseten TRUE
*************************************************** */
function thumbnail($kep, $mibe, $x, $y) {
  makeThumb2( $kep, $mibe, $x, $y, true);
}


/* ***************************************************
Funkcio:
Kep zsugoritasa
Input:
$kep - forras kep utvonala
$mibe - cel kep utvonala
$maxx - ennyi lehet a maximalis vizszintes kiterjedes
$maxy - ennyi lehet a maximalis fuggoleges kiterjedes
Output:
Hiba eseten false
*************************************************** */
function zsugorit($kep, $mibe, $maxx, $maxy) {
  makeThumb2( $kep, $mibe, $maxx, $maxy, false);
}

function zsugoritnemnagyit($kep, $mibe, $maxx, $maxy) {
  makeThumb2( $kep, $mibe, $maxx, $maxy, false);
}

/* ***************************************************
Funkcio:
Kep meretenek megallapitasa
Input:
$maxx uj vizszintes kiterjedes
$maxy uj fuggoleges kiterjedes
$x eredeti vizszintes kiterjedes
$y eredeti fuggoleges kiterjedes
Output:
Az uj meretek tombjet adja vissza
*************************************************** */
function meretezo($maxx, $maxy, $x, $y) {
	if (round($x*100/$maxx)>round($y*100/$maxy)) {
		// Inkabb szeles
		$y=round(($maxx*$y)/$x);
		$x=$maxx;
	} else {
		// Inkabb magas
		$x=round(($maxy*$x)/$y);
		$y=$maxy;
	}
	$tomb["x"]=$x;
	$tomb["y"]=$y;
	return	$tomb;
}

/* ***************************************************
Funkcio:
Kep meretenek megallapitasa
Input:
$path cel utvonala
$nev feltoltes ezen a neven tortent
Output:
Siker eseten a file nevet adja vissza
*************************************************** */
function feltoltes($nev, $path) {
	global $_FILES;
	//echo $_FILES[$nev]["tmp_name"];
	if (is_uploaded_file($_FILES[$nev]["tmp_name"])) {
		move_uploaded_file ($_FILES[$nev]["tmp_name"], $path);
		@chmod ($path, 0777);
		return $_FILES[$nev]["name"];
	} else {
		return false;
	}
}



function gabryKepez($ebbol,$ezt,$opcio,$x,$y) {
  switch ($opcio) {
    case "fixcut":
      return thumbnail($ebbol, $ezt, $x, $y);
    case "max":
      return zsugorit($ebbol, $ezt, $x, $y);
 }
}

function kepeloallito($eredetikep,$kepelotag,$kepez,$elso=true) {

  if ($elso) {
  	
    /*$handle = finfo_open(FILEINFO_MIME);
    $mime_type = finfo_file($handle,$eredetikep);*/
	$kepsize = getimagesize($eredetikep);
	$mime_type = $kepsize["mime"];
	$erkit = "";
	if($mime_type == "image/jpg" || $mime_type == "image/jpeg")$erkit = "jpg";
	elseif($mime_type == "image/gif")$erkit = "gif";
	elseif($mime_type == "image/png")$erkit = "png";
	
    $ide = $kepelotag."_orig.".$erkit;
    move_uploaded_file($eredetikep, $ide);
    @chmod($ide, 0777);
    $eredetikep = $ide;
  }

  if (is_array($kepez)) {
    foreach($kepez as $k=>$v) {
      if (eregi('[a-z]*,[a-z]*,[0-9]*,[0-9]*', $k)) {
        list($utotag,$kit,$tipus,$w,$h)=explode(",",$k);

        $ide=$kepelotag.$utotag.".".$kit;

        gabryKepez( $eredetikep, $ide, $tipus,$w,$h);
		kepeloallito( $ide, $kepelotag, $v, false);
      } else {
          list($utotag,$kit,$tipus,$w,$h)=explode(",",$v);
          $ide=$kepelotag.$utotag.".".$kit;
          gabryKepez( $eredetikep, $ide, $tipus,$w,$h);
        }
    }
  } else {
      if (eregi('[a-z]*,[a-z]*,[0-9]*,[0-9]*', $kepez)) {
        list($utotag,$kit,$tipus,$w,$h)=explode(",",$kepez);
        $ide=$kepelotag.$utotag.".".$kit;
        gabryKepez( $eredetikep, $ide, $tipus,$w,$h);
      }
    }
}

?>