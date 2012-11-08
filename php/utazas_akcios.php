<?php 
include ('php/_searchbox.php');
?>

<?php 
$laponkent = 15;
$tmp_akcios = gsql_numassoc ("SELECT count(*) as db FROM utazasok WHERE utazas_flag=3 ORDER BY id DESC");
$talalatokszama = $tmp_akcios[0]["db"];
$lapokszama = (int)(($talalatokszama - 1) / $laponkent) + 1;
$start = $laponkent * $lap;

$tmp_akcios = gsql_numassoc ("SELECT * FROM utazasok WHERE utazas_flag=3 ORDER BY id DESC LIMIT $start,$laponkent");

?>
		<!-- CONTENT SIDE -->
		<div class="content_side clearfix">
		
			<div class="box_yellow"><div class="bgr_top"><div class="bgr_bot clearfix">
				<div class="ful_akcios">Akciók - akciós utazások</div>
				<div class="clear"></div>
				<?php foreach ($tmp_akcios as $row) { ?>
				<div class="box_border">
					<div class="cont">
						<div class="price"><a href="<?php echo $row ['webcim']; ?>"><?php echo $row ['utazas_ar']; ?> Ft-tól<?=($row['utazas_euro']!=0?' / '.$row['utazas_euro'].' Euro-tól':'');?><?=($row['utazas_dollar']!=0?' / '.$row['utazas_dollar'].' Dollar-tól':'');?></a></div>
						<div class="clear"></div>
						<div class="title clearfix">
						<a href="<?php echo $row ['webcim']; ?>" title="<?php echo $tmp_orszag [$row ['utazas_orszag']]; ?> - <?php echo $tmp_varos [$row ['utazas_varos']]; ?> <?php echo $row ['utazas_hotel']; ?>"><span class="city"><?php echo $tmp_orszag [$row ['utazas_orszag']]; ?> - <?php echo $tmp_varos [$row ['utazas_varos']]; ?></span>
						<span class="name"><?php echo levag_text($row ['utazas_hotel'], 23); ?></span>
						<span class="stars">
							<span class="star_act">*</span><span class="star_act">*</span><span class="star_act">*</span><span class="star">*</span><span class="star">*</span>
						</span></a></div>
						<?php if (file_exists("uploads/utazasok/{$row ['id']}/fixcut.jpg")) { ?>
						<div class="pic"><a href="<?php echo $row ['webcim']; ?>"><img src="<?php echo "uploads/utazasok/{$row ['id']}/fixcut.jpg"; ?>" alt="" /></a></div>
						<?php } ?>
						<div class="text">
							<span><?php echo $row ['utazas_start']; ?> -<br />
							<?php echo $row ['utazas_vege']; ?></span><br />
							<br />
							<?php echo $row ['utazas_ejszakak']; ?> éjszaka<br />
							<?php echo $tmp_ellatas[$row ['utazas_ellatas']]; ?><br />
							<!--<?php echo $row ['utazas_szemelyek']; ?> fő-->
						</div>
					</div>
				</div>
				<?php } ?>
				<div class="clear"></div>
				<div class="box_title">akciós ajánlatok</div>
				<!-- <div class="button_tovabbi_akciok"><a href="">További akciók</a></div> -->
				<div class="clear"></div>
				
<?
 if ($lapokszama>1) {
?>
  <div class="pager">
<?
  if ($lap>0) {
    ?><span class="prev">
<a href="<? echo URI_add_query_arg($REQUEST_URI,"lap",$lap-1)?>">&laquo; előző</a></span>
<?
  }

$min=$lap-2; if ($min<0) $min=0;
$max=$lap+4; if ($max>$lapokszama-1) $max=$lapokszama-1;
if ($min>0) echo "... ";
  $x=array();
  //echo "\n<span class=\"num\">";
  for ($i=$min;$i<=$max;$i++) {
    if ($i==$lap) {
      $x[]="<span class=\"num\"><span class=\"act\">".($i+1)."</span>\n";
    } else {
        $x[]="<span class=\"num\"><a href=\"".URI_add_query_arg($REQUEST_URI,"lap",$i)."\">".($i+1)."</a></span>\n";
      }
  }
  echo implode("",$x);
  //echo "</span>";
if ($max<$lapokszama-1) echo " ...";

  if ($lap+1<$lapokszama) {
    ?><span class="next"><a href="<? echo URI_add_query_arg($REQUEST_URI,"lap",$lap+1); ?>">következő &raquo;</a></span><?
  }
?>
  </div>
<?
 }
?>


<!-- 
				<div class="pager">
					<span class="prev"><a href="">&laquo; előző</a></span>
					<span class="num"><span class="act">1</span></span>
					<span class="num"><a href="">2</a></span>
					<span class="num"><a href="">3</a></span>
					<span class="num"><a href="">4</a></span>
					<span class="num"><a href="">5</a></span>
					<span class="num"><a href="">...</a></span>
					<span class="num"><a href="">100</a></span>
					<span class="next"><a href="">következő &raquo;</a></span>
				</div>
-->			
				<div class="clear10"></div>
			</div></div></div>
			
		</div>
		<!-- CONTENT SIDE -->
		