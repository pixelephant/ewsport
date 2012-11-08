		<!-- CONTENT SIDE -->
		<div class="content_side clearfix">
		
			<div class="box_data"><div class="bgr_top"><div class="bgr_bot clearfix">
				<div class="ful_kapcsolat">Kapcsolat</div>
				<div class="clear"></div>
				<div class="article">
					<div class="contact_box">
						<div class="text">
							<h6>EW Utazási és Sport Iroda Kft.</h6>
							
							1126. Budapest, Dolgos utca 2/2.<br />
							( MOM PARK melletti sétány )<br />
							<br />
							<div class="clear"></div>
							<span class="left_text">Fax:</span>
							<span class="right_text">+ 36 / 1 / 225 13 46</span>
							<div class="clear"></div>
							<br />
							<span class="left_text">Mobil:</span>
							<span class="right_text">+ 36 / 30 / 9 147 157</span>
							<div class="clear"></div>
							<span class="left_text">&nbsp;</span>
							<span class="right_text">+ 36 / 30 / 9 400 679</span>
							<div class="clear"></div>
							<br />
							e-mail:	east-westsport@t-online.hu
						</div>
						<div class="pic clearfix"><a href="/img/ew_iroda.jpg" rel="lightbox-kapcsolat"><img src="/img/contact.box.pic.jpg" alt="" /></a></div>
						<div class="map clearfix"><a href="/img/map.jpg" rel="lightbox-kapcsolat"><img src="/img/contact.box.map.jpg" alt="" /></a></div>
					<div class="clear25"></div><div class="clear20"></div>
					</div>
					
					<div class="clear25"></div>
					<div class="clear15"></div>
					
					<div class="contact_form clearfix">
						<form name="kapcsolat_form" method="post" action="<?php echo $_SERVER ['REQUEST_URI']; ?>">
						<input type="hidden" name="SAVE" value="3" />
						<div class="col_left">
							<h6>Kérjük, vegye fel velünk a kapcsolatot.</h6>
							A “<span>*</span>”-gal JELÖLT mezők kitöltése kötelező!
							<?php
							if (count ($errors) > 0) { 
								echo '<br />';
								foreach ($errors as $key => $value) {
									echo '<font color="red">' . $value . '</font><br />';
								}
							}
							?>
							<div class="clear30"></div><div class="clear30"></div>
							<div class="text">Név<span>*</span></div>
							<div class="input">
							<?php echo FormInput ('kapcsolat_nev'); ?>
							</div>
							<div class="clear"></div>
							<div class="text">E-mail<span>*</span></div>
							<div class="input"><?php echo FormInput ('kapcsolat_email'); ?></div>
							<div class="clear"></div>
							<div class="text">Telefon<span>*</span></div>
							<div class="input"><?php echo FormInput ('kapcsolat_telefon'); ?></div>
							<div class="clear"></div>
						</div>
						<div class="col_right">
							<div class="text">Üzenet</div>
							<div class="textarea"><textarea cols="" rows="" name="kapcsolat_uzenet"></textarea></div>
							<div class="clear"></div>
						</div>
						<div class="clear20"></div>
						<div class="button"><input type="submit" name="" value="" /></div>
						</form>
					</div>
					<div class="clear"></div>
				</div>
				
			</div></div></div>
			
		</div>
		<!-- CONTENT SIDE -->