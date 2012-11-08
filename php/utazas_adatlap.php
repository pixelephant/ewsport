<?php 
$tmp_adatlap = gsql_numassoc("SELECT * FROM utazasok WHERE webcim=\"$param\"");
if (count($tmp_adatlap) != 1) {
	die();
} else {
	$adatlap = $tmp_adatlap [0];
	$tmp_galeria = gsql_numassoc ("SELECT * FROM nmTextpics WHERE textid={$adatlap ['id']} ORDER BY number ASC");
}
?>
<?php 
include ('php/_searchbox.php');
?>		
<?php
/*
$to      = 'peat@me.com';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: bihari.peter@blan.hu' . "\r\n" .
    'Reply-To: bihari.peter@blan.hu' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
*/
?>
		<!-- CONTENT SIDE -->
		<div class="content_side clearfix">
		
			<div class="box_data"><div class="bgr_top"><div class="bgr_bot clearfix">
				<div class="data_sheet clearfix">
					<div class="cont clearfix">
						<div class="title clearfix">
							<span class="city"><?php echo $tmp_orszag [$adatlap ['utazas_orszag']]; ?> - <?php echo $tmp_varos [$adatlap ['utazas_varos']]; ?></span>
							<span class="name"><?php echo $adatlap ['utazas_hotel']; ?></span>
						<?php 
						if ($adatlap ['utazas_csillag'] > 0) {
						?>
						<span class="stars">
						<?php for ($i=0; $i<$adatlap ['utazas_csillag']; $i++) { ?>
							<span class="star_act">*</span>
						<?php }?>
						</span>
						<?php 
						} 
						?>
						</div>
						<div class="price"><?php echo $adatlap ['utazas_ar']; ?> Ft-tól<?=($adatlap['utazas_euro']!=0?' / '.$adatlap['utazas_euro'].' Euro-tól':'');?><?=($adatlap['utazas_dollar']!=0?' / '.$adatlap['utazas_dollar'].' Dollar-tól':'');?><br /><br />
						</div>
						<div class="clear"></div>
						<?php if (file_exists("uploads/utazasok/{$adatlap ['id']}/s.jpg")) { ?>
						<div class="pic"><a href="<?php echo "uploads/utazasok/{$adatlap ['id']}/b.jpg"; ?>" rel="lightbox"><img src="<?php echo "uploads/utazasok/{$adatlap ['id']}/s.jpg"; ?>" alt="" /></a><br />
						<?php 
						if (count($tmp_galeria) > 0) { 
							echo '<a href="' . $tmp_galeria [0] ['path'] . 'b.jpg" rel="lightbox-Gallery" title="' . $tmp_galeria [0] ['name'] . '">További képek</a>';
						}
						?>
						</div>
						<?php 
						if (count($tmp_galeria) > 0) {
							//var_dump($tmp_galeria); 
							echo '<div style="display:none">';
							$tmp_galeria = array_slice($tmp_galeria, 1);
							foreach ($tmp_galeria as $row_gal) {
								echo '<a href="' . $row_gal ['path'] . 'b.jpg" rel="lightbox-Gallery" title="' . $row_gal ['name'] . '"><img src="' . $row_gal ['path'] . 'b.jpg"' . ' /></a>';
							}
							echo '</div>';
						?>
						
						<?php 
						} 
						}
						?>
						<div class="text">
							<div class="text-header-content-left">
							<h5 class="date"><?php echo $adatlap ['utazas_start']; ?> - <?php echo $adatlap ['utazas_vege']; ?></h5>
							<h5><?php echo $adatlap ['utazas_ejszakak']; ?> éjszaka, <?php echo $tmp_ellatas [$adatlap ['utazas_ellatas']]; ?><!-- , <?php echo $adatlap ['utazas_szemelyek']; ?> fő, repülővel --></h5>
							</div>
							<div class="text-header-content-right">
							<iframe src="http://www.facebook.com/widgets/like.php?href=<?=(!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?>?utm_source=fblike" allowtransparency="true" style="border: medium none; width: 220px; height: 30px;" scrolling="no" frameborder="0"></iframe>
							</div>
							<div class="clear"></div>
							<?php echo $adatlap ['utazas_leiras']; ?>
						</div>
					</div>
				</div>
				<div class="clear20"></div>
				<div class="reservation_box">
				<?php
				if (count ($errors) > 0) { 
					foreach ($errors as $key => $value) {
						echo '<font color="red">' . $value . '</font><br />';
					}
				}
				?>
				<form name="adatlap_ajanlat" method="post" action="<?php echo $_SERVER ['REQUEST_URI']; ?>">
				<input type="hidden" name="SAVE" value="2" />
				<input type="hidden" name="ajanlat_url" value="<?php echo $param; ?>" />
					<div class="col_left">
						<div class="text">Név<span>*</span></div>
						<div class="input"><input type="text" name="ajanlat_neve" value="<?php echo $_POST ['ajanlat_neve']; ?>" /></div>
						<div class="clear"></div>
						<div class="text">E-mail<span>*</span></div>
						<div class="input"><input type="text" name="ajanlat_email" value="<?php echo $_POST ['ajanlat_email']; ?>" /></div>
						<div class="clear"></div>
						<div class="text">Telefon<span>*</span></div>
						<div class="input"><input type="text" name="ajanlat_telefon" value="<?php echo $_POST ['ajanlat_telefon']; ?>" /></div>
					</div>
					<div class="col_right">
						<div class="text_2">A “<span>*</span>”-gal JELÖLT mezők kitöltése kötelező!</div>
						<div class="button_reservation"><input type="submit" name="" value="" /></div>
					</div>
				</form>
				</div>
				<div class="back">
					vissza a keresési eredményekhez
					<div class="button_back"><a href="javascript:history.back();">&laquo; Vissza</a></div>
				</div>
				<div class="clear20"></div>
			</div></div></div>
			
		</div>
		<!-- CONTENT SIDE -->
		