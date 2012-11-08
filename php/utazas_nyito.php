<?php 
include ('php/_searchbox.php');
?>

		<!-- CONTENT SIDE -->
		<div class="content_side clearfix">
<?php
if ($_GET ['SAVE'] != 1) { 
$tmp_akcios = gsql_numassoc ("SELECT * FROM utazasok WHERE utazas_flag=3 ORDER BY id DESC LIMIT 0,6");
?>		
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
						<div class="clear"></div>
						<span class="name"><?php echo levag_text($row ['utazas_hotel'], 23); ?></span>
						<?php 
						if ($row ['utazas_csillag'] > 0) {
						?>
						<span class="stars">
						<?php for ($i=0; $i<$row ['utazas_csillag']; $i++) { ?>
							<span class="star_act">*</span>
						<?php }?>
						</span>
						<?php 
						} 
						?>
						</a></div>
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
				<div class="button_tovabbi_akciok"><a href="utazas/akcios-utak">További akciók</a></div>
				<div class="clear10"></div>
			</div></div></div>
<?php 
//$tmp_lm = gsql_numassoc ("SELECT * FROM utazasok WHERE utazas_flag!=3 AND utazas_tip=1 ORDER BY id DESC LIMIT 0,6");
$tmp_lm = gsql_numassoc ("SELECT * FROM utazasok WHERE utazas_flag!=3 AND utazas_tip=1 AND utazas_orszag=18 ORDER BY id DESC LIMIT 0,6");
?>			
			<div class="box_default"><div class="bgr_top"><div class="bgr_bot clearfix">
				<div class="ful_kiemelt_ajanlataink">Kiemelt ajánlataink</div>
				<!--<div class="ful_utazasok">Utazások</div>-->
				<div class="clear"></div>
				<?php foreach ($tmp_lm as $row) { ?>
				<div class="box_border">
					<div class="cont">
						<div class="price"><a href="<?php echo $row ['webcim']; ?>"><?php echo $row ['utazas_ar']; ?> Ft-tól<?=($row['utazas_euro']!=0?' / '.$row['utazas_euro'].' Euro-tól':'');?><?=($row['utazas_dollar']!=0?' / '.$row['utazas_dollar'].' Dollar-tól':'');?></a></div>
						<div class="clear"></div>
						<div class="title clearfix">
						<a href="<?php echo $row ['webcim']; ?>" title="<?php echo $tmp_orszag [$row ['utazas_orszag']]; ?> - <?php echo $tmp_varos [$row ['utazas_varos']]; ?> <?php echo $row ['utazas_hotel']; ?>"><span class="city"><?php echo $tmp_orszag [$row ['utazas_orszag']]; ?> - <?php echo $tmp_varos [$row ['utazas_varos']]; ?></span>
						<div class="clear"></div>
						<span class="name"><?php echo levag_text($row ['utazas_hotel'], 23); ?></span>
						<?php 
						if ($row ['utazas_csillag'] > 0) {
						?>
						<span class="stars">
						<?php for ($i=0; $i<$row ['utazas_csillag']; $i++) { ?>
							<span class="star_act">*</span>
						<?php }?>
						</span>
						<?php 
						} 
						?>
						</a></div>
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
				<!--<div class="box_title">last minute</div>
				<div class="button_tovabbi_last_minute_ajanlatok"><a href="utazas/last-minute">További akciók</a></div>-->
				<div class="clear10"></div>
			</div></div></div>
<?php 
} else { 
?>
			<div class="box_default"><div class="bgr_top"><div class="bgr_bot clearfix">
			<div class="ful_kiemelt_ajanlataink">Kiemelt ajánlataink</div>
				<!-- <div class="ful_last_minute">Last Minute</div> -->
				<div class="clear"></div>
				<?php 
				if (count($tmp_search) > 0) {
					foreach ($tmp_search as $row) { 
				?>
				<div class="box_border">
					<div class="cont">
						<div class="price"><a href="<?php echo $row ['webcim']; ?>" title="<?php echo $tmp_orszag [$row ['utazas_orszag']]; ?> - <?php echo $tmp_varos [$row ['utazas_varos']]; ?> <?php echo $row ['utazas_hotel']; ?>"><?php echo $row ['utazas_ar']; ?> Ft-tól<?=($row['utazas_euro']!=0?' / '.$row['utazas_euro'].' Euro-tól':'');?><?=($row['utazas_dollar']!=0?' / '.$row['utazas_dollar'].' Dollar-tól':'');?></a></div>
						<div class="clear"></div>
						<div class="title clearfix">
						<a href="<?php echo $row ['webcim']; ?>"><span class="city"><?php echo $tmp_orszag [$row ['utazas_orszag']]; ?> - <?php echo $tmp_varos [$row ['utazas_varos']]; ?></span>
						<div class="clear"></div>
						<span class="name"><?php echo levag_text($row ['utazas_hotel'], 23); ?></span>
						<?php 
						if ($row ['utazas_csillag'] > 0) {
						?>
						<span class="stars">
						<?php for ($i=0; $i<$row ['utazas_csillag']; $i++) { ?>
							<span class="star_act">*</span>
						<?php }?>
						</span>
						<?php 
						} 
						?>
						</a></div>
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
				<?php 
					}
				} else {
				?>	
				<div class="article">	
				Az adott keresési feltételeknek megfelelő utazás nem található az adatbázisunkban. Kérjük más feltételek alapján keressen, vagy érdeklődjön az "<a href="utazas/ajanlatkeres">Ajánlatérés</a>" menüpont alatt.
				</div>
				<?php } ?>		
				<div class="clear"></div>
				<!-- <div class="box_title">last minute</div> -->
				
				<div class="clear10"></div>
			</div></div></div>


<?php } ?>
		</div>
		<!-- CONTENT SIDE -->
		