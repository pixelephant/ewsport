<?php 
$tmp_utazas_tip2 = gsql_2assoc ("SELECT neve, neve FROM parameterek WHERE parentid=1 ORDER BY sorrend ASC");
$tmp_ellatas2 = gsql_2assoc ("SELECT neve, neve FROM parameterek WHERE parentid=5 ORDER BY sorrend ASC");
$tmp_szallas_tip2 = gsql_2assoc ("SELECT neve, neve FROM parameterek WHERE parentid=4 ORDER BY sorrend ASC");

?>

		<!-- CONTENT SIDE -->
		<div class="content_side clearfix">
		
			<div class="box_data"><div class="bgr_top"><div class="bgr_bot clearfix">
				<div class="ful_ajanlatkeres">Ajánlatkérés</div>
				<div class="clear"></div>
				
				<div class="inquiry_form" id="inquiry_form">
				<form name="ajanlat_form" method="post" action="<?php echo $_SERVER ['REQUEST_URI']; ?>">
				<input type="hidden" name="SAVE" value="4" />
					<div class="clear5"></div>
					<div class="col_left">
						<div class="text">Hová utaznál?</div>
						<div class="clear10"></div>
						<div class="text">Úticél</div>
						<div class="input"><?php echo FormInput('utazas_orszag'); ?></div>
						<div class="clear"></div>
						<div class="text">Város</div>
						<div class="input"><?php echo FormInput('utazas_varos'); ?></div>
						<div class="sep"></div>
					</div>
					<div class="col_right">
						<div class="text">&nbsp;</div>
						<div class="clear10"></div>
						<div class="text">Utazás időpontja</div>
						<div class="select year"><span class="gvSelect">
						<?php echo FormSelect('utazas_ev_tol', $evek_arr, array(), 0, '')?>
						</span></div>
						<div class="select month"><span class="gvSelect">
						<?php echo FormSelect('utazas_honap_tol', $honapok_arr, array(), 0, '')?>
						</span></div>
						<div class="select day"><span class="gvSelect">
						<?php echo FormSelect('utazas_nap_tol', $napok_arr, array(), 0, '')?>
						</span></div>
						<div class="text_2">-tól</div>
						<div class="clear"></div>
						<div class="text">&nbsp;</div>
						<div class="select year"><span class="gvSelect">
						<?php echo FormSelect('utazas_ev_ig', $evek_arr, array(), 0, '')?>
						</span></div>
						<div class="select month"><span class="gvSelect">
						<?php echo FormSelect('utazas_honap_ig', $honapok_arr, array(), 0, '')?>
						</span></div>
						<div class="select day"><span class="gvSelect">
						<?php echo FormSelect('utazas_nap_ig', $napok_arr, array(), 0, '')?>
						</span></div>
						<div class="text_2">-ig</div>
						<div class="sep"></div>
					</div>
					<div class="clear"></div>
					<div class="col_left">
						<div class="text">utazás típusa</div>
						<div class="select"><span class="gvSelect">
						<?php echo FormSelect('utazas_tipusa', $tmp_utazas_tip2, array(), 0, 'Mindegy')?>
						</span></div>
						<div class="clear"></div>
						<div class="text">szállás típusa</div>
						<div class="select"><span class="gvSelect">
						<?php echo FormSelect('utazas_szallas', $tmp_szallas_tip2, array(), 0, 'Mindegy')?>
						</span></div>
						<div class="clear"></div>
						<div class="text">ellátás</div>
						<div class="select"><span class="gvSelect">
						<?php echo FormSelect('utazas_ellatas', $tmp_ellatas2, array(), 0, 'Mindegy')?>
						</span></div>
						<div class="clear"></div>
						<div class="sep"></div>
						<div class="text">felnőttek száma</div>
						<div class="select"><span class="gvSelect">
						<?php echo FormSelect('utazas_felnottek', $felnottek_arr, array(), 0, '')?>
						</span></div>
						<div class="clear"></div>
						<div class="text">gyerekek száma</div>
						<div class="select"><span class="gvSelect">
						<?php echo FormSelect('utazas_gyerekek', $gyerekek_arr, array(), 0, '')?>
						</span></div>
						<div class="clear"></div>
						<div class="sep"></div>
					</div>
					<div class="col_right">
						<div class="text">megjegyzés</div>
						<div class="textarea"><textarea name="ajanlat_megjegyzes" rows="" cols=""></textarea></div>
						<div class="sep"></div>
					</div>
					<div class="clear"></div>
					<div class="col_left">
						<div class="text">Név<span>*</span></div>
						<div class="input"><?php echo FormInput('ajanlat_neve'); ?></div>
						<div class="clear"></div>
						<div class="text">E-mail<span>*</span></div>
						<div class="input"><?php echo FormInput('ajanlat_email'); ?></div>
						<div class="clear"></div>
						<div class="text">Telefon<span>*</span></div>
						<div class="input"><?php echo FormInput('ajanlat_telefon'); ?></div>
					</div>
					<div class="col_right">
						<div class="text_3">A “<span>*</span>”-gal JELÖLT mezők kitöltése kötelező!</div>
						<?php
						if (count ($errors) > 0) { 
							foreach ($errors as $key => $value) {
							echo '<font color="red">' . $value . '</font><br />';
							}
						}
						?>
						<div class="button_inquiry_send"><input type="submit" name="" value="" /></div>
					</div>
					<div class="clear30"></div>
				</form>
				</div>
				
			</div></div></div>
			
		</div>
		<!-- CONTENT SIDE -->