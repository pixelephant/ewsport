<?php
include 'config.php';
include '_sql.php';
include '_kodok.php';
include "template/_start.php";
$oldalnev = 'Doboz módosítása / felvitele';
$oldalleiras = 'Doboz módosítása / felvitele.';
include 'template/_fejlecszerkeszto.php';


include 'config.php';

$id = (int)$id;
if ($urlap == 1) {
    $process["error"]["warnings"] = array();
    if ($email == "") {
        $process["error"]["warnings"][] = "Nincs megadva az e-mail cím!";
    }

    if (count($process["error"]["warnings"]) == 0) {

        $p = "email='$email'";
        if($id==0)$p .= ", aktiv=1";
        if($id==0)$p .= ", datum=now()";

        if ($id == 0) {
            $p = "INSERT INTO nmHirlevelUsers SET $p";
        } else {
            $p = "UPDATE nmHirlevelUsers SET $p WHERE id='$id'";
        }

        gsql_parancs($p);

        if ($id == 0) {
            $id = mysql_insert_id();
        }

        Header("Location: xpertCMS_lista.php?mit=nmHirlevelUsers&".session_name()."=".session_id());
        die();
    }
} elseif ($id == 0) {

} else {
    $tmp = gsql_numassoc("SELECT * FROM nmHirlevelUsers WHERE id='$id'");
	$tmp = $tmp[0];
    $email = $tmp["email"];
}

?>

	<div id="container2">
	<form action="xpertCMS_hirlevelusers.php" name="form2" id="form2" method="post" enctype="multipart/form-data" >
    <input name="id" type="hidden" value="<? echo $id; ?>">
	<input type="hidden" name="urlap" value="1">
	<div class="form">
		<div class="text"><label for="name">E-mail:</label></div>
		<div class="input2"><input id="email" name="email" type="text" value="<?= $email; ?>" /></div>
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
