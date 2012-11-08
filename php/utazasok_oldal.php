<?php 
include ('php/_searchbox.php');
?>

<?php 
$tmp_akcios = gsql_numassoc ("SELECT * FROM utazasok WHERE utazas_flag=3 ORDER BY id DESC LIMIT 0,6");
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
						<a href="<?php echo $row ['webcim']; ?>"><span class="city"><?php echo $tmp_varos [$row ['utazas_varos']]; ?></span>
						<span class="name"><?php echo $row ['utazas_hotel']; ?></span>
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
							<?php echo $row ['utazas_szemelyek']; ?> fő
						</div>
					</div>
				</div>
				<?php } ?>
				<div class="clear"></div>
				<div class="box_title">akciós ajánlatok</div>
				<div class="button_tovabbi_akciok"><a href="">További akciók</a></div>
				<div class="clear10"></div>
			</div></div></div>
<?php 
$tmp_lm = gsql_numassoc ("SELECT * FROM utazasok WHERE utazas_flag=2 ORDER BY id DESC LIMIT 0,6");
?>			
			<div class="box_default"><div class="bgr_top"><div class="bgr_bot clearfix">
				<div class="ful_last_minute">Last Minute</div>
				<div class="clear"></div>
				<?php foreach ($tmp_lm as $row) { ?>
				<div class="box_border">
					<div class="cont">
						<div class="price"><a href="<?php echo $row ['webcim']; ?>"><?php echo $row ['utazas_ar']; ?> Ft-tól<?=($row['utazas_euro']!=0?' / '.$row['utazas_euro'].' Euro-tól':'');?><?=($row['utazas_dollar']!=0?' / '.$row['utazas_dollar'].' Dollar-tól':'');?></a></div>
						<div class="clear"></div>
						<div class="title clearfix">
						<a href="<?php echo $row ['webcim']; ?>"><span class="city"><?php echo $tmp_varos [$row ['utazas_varos']]; ?></span>
						<span class="name"><?php echo $row ['utazas_hotel']; ?></span>
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
							<?php echo $row ['utazas_szemelyek']; ?> fő
						</div>
					</div>
				</div>
				<?php } ?>				
				<div class="clear"></div>
				<div class="box_title">last minute</div>
				<div class="button_tovabbi_last_minute_ajanlatok"><a href="">További akciók</a></div>
				<div class="clear10"></div>
			</div></div></div>
			
		</div>
		<!-- CONTENT SIDE -->
		