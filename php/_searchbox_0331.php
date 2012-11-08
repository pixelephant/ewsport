<?php 
$datum_array ['2011-01'] = '2011 Január';
$datum_array ['2011-02'] = '2011 Február';
$datum_array ['2011-03'] = '2011 Március';
$datum_array ['2011-04'] = '2011 Április';
$datum_array ['2011-05'] = '2011 Május';
$datum_array ['2011-06'] = '2011 Június';
$datum_array ['2011-07'] = '2011 Július';
$datum_array ['2011-08'] = '2011 Augusztus';
$datum_array ['2011-09'] = '2011 Szeptember';
$datum_array ['2011-10'] = '2011 Október';
$datum_array ['2011-11'] = '2011 November';
$datum_array ['2011-12'] = '2011 December';
?>
<!-- SEARCH BOX -->
		<div class="box_search"><div class="bgr_top"><div class="bgr_bot clearfix">
			<div class="ful_kereso">Kereső - keresés utak között</div>
			<div class="clear"></div>
			<div id="search_box">
			<form name="utazas_kereses" method="get" action="utazas/utazasok">
			    <input type="hidden" name="SAVE" value="1" />
			    
				<div class="col">
					Utazás típusa<br />
					<span class="gvSelect">
					<?php echo FormSelect('utazas_tip', $tmp_utazas_tip, array(), 0, '-- Válasszon --'); ?>
					</span>
				</div>
				<div class="col">
					Úticél<br />
					<div id="qs_country"><span class="gvSelect"><?php echo FormSelect('utazas_orszag', $tmp_orszag, array('id' => 'sel_continent_id'), 0, '-- Válasszon --'); ?></span></div>
				</div>
				<div class="col">
					Város<br />
					<div id="qs_city"><span class="gvSelect"><?php echo FormSelect('utazas_varos', $tmp_varos, array('id' => 'sel_country_id'), 0, '-- Válasszon --'); ?></span></div>
					<?
						if(isset($_GET['utazas_orszag'])) {
						?>
						<script language="javascript">
							countryChange(<?=$_GET['utazas_orszag']?>);
						</script>
						<?
						}
					?>
				</div>
				<div class="clear15"></div>
				<div class="col">
					Szállás típusa<br />
					<span class="gvSelect">
					<?php echo FormSelect('utazas_szallas_tip', $tmp_szallas_tip, array(), 0, '-- Válasszon --'); ?>
					</span>
				</div>
				<div class="col">
					Ellátás<br />
					<span class="gvSelect">
					<?php echo FormSelect('utazas_ellatas', $tmp_ellatas, array(), 0, '-- Válasszon --'); ?>
					</span>
				</div>
				<div class="col">
					Időpont<br />
					<span class="gvSelect">
					<?php echo FormSelect('utazas_date', $datum_array, array(), 0, '-- Válasszon --'); ?>
					</span>
				</div>
				<div class="button_kereses"><input type="submit" name="" value="" /></div>
				<div class="clear25"></div>
			</form>
			</div>
		</div></div></div>
		<!-- SEARCH BOX -->