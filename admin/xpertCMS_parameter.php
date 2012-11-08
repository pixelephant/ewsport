<?php
include 'config.php';
include '_sql.php';
include '_kodok.php';
include "template/_start.php";
$oldalnev = 'Doboz módosítása / felvitele';
$oldalleiras = 'Doboz módosítása / felvitele.';
include 'template/_fejlecszerkeszto.php';

$id = (int)$id;
$parentid = (int) $parentid;
if ($parentid == 0 && $id > 0) {
	$tmp_parentid = gsql_numassoc ("SELECT parentid FROM parameterek WHERE id=$id");
}
if ($urlap == 1) {
    $process["error"]["warnings"] = array();
    
    if (count($process["error"]["warnings"]) == 0) {

        $p = "neve=\"$neve\"";
        $p .= ", sorrend=\"$sorrend\"";
        $p .= ", parentid=\"$parentid\"";
        $p .= ", orszag=\"$orszag\"";

        if ($id == 0) {
            $p = "INSERT INTO parameterek SET $p";
        } else {
            $p = "UPDATE parameterek SET $p WHERE id='$id'";
        }
		//echo $p;
        gsql_parancs($p);
        if ($id == 0) {
            $id = mysql_insert_id();
        }

        Header("Location: xpertCMS_lista.php?mit=parameterek&szuromezo=parentid&szuroid=".$parentid);
        die();
    }
} elseif ($id == 0) {

} else {
    $tmp = gsql_numassoc("SELECT * FROM parameterek WHERE id='$id'");
    $tmp = extract($tmp[0]);
}
?>
	<div id="container2">
	<form action="xpertCMS_parameter.php" name="form2" id="form2" method="post" onsubmit="return submitForm();">
    <input name="id" type="hidden" value="<? echo $id; ?>">
    <input name="parentid" type="hidden" value="<? echo $parentid; ?>">
	<input type="hidden" name="urlap" value="1">
	<?php 
	if ($parentid == 3) { 
		$tmp_orszag = gsql_2assoc("SELECT id, neve FROM parameterek WHERE parentid=2");
	?>
	<div class="form">
		<div class="text"><label for="kategoria">Orszag:</label></div>
		<div class="input">
		<?php echo FormSelect("orszag", $tmp_orszag, array(), 0, '-- valassz --'); ?>
        </div>
	<div class="clear"></div>
	</div>
	<?php } ?>
	<div class="form">
		<div class="text"><label for="kategoria">Neve:</label></div>
		<div class="input">
		<input name="neve" type="text" value="<?= $neve; ?>" />
        </div>
	<div class="clear"></div>
	</div>    
	<div class="form">
		<div class="text"><label for="name">Pozíció:</label></div>
		<div class="input2"><input name="sorrend" type="text" value="<?= $sorrend; ?>" /></div>
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
