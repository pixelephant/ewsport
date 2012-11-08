<?php 
$tmp_cikk = gsql_numassoc ("SELECT * FROM nmTexts WHERE url=\"{$params [2]}\"");
$text = __gettext($tmp_cikk [0] ['id']);
//var_dump($text);
?>
		<!-- CONTENT SIDE -->
		<div class="content_side clearfix">
		
			<div class="box_data"><div class="bgr_top"><div class="bgr_bot clearfix">
				<div class="ful_hirek">Hírek</div>
				<div class="clear"></div>
				<div class="news_cont clearfix">
					<div class="title"><?php echo $text ['name']; ?></div>
					<div class="date"><?php echo $text ['activefromdate']; ?></div>
					<div class="clear"></div>
					<?php if (file_exists("uploads/text/{$text ['id']}/leads.jpg")) { ?>
					<div class="pic"><img src="<?php echo "uploads/text/{$text ['id']}/leads.jpg"; ?>" alt="" /><br /><!-- <a href="">további képek</a> --></div>
					<?php } ?>
					<div class="text">
						<?php echo $text ['text']; ?>
						<div class="clear10"></div>
						<div class="button_more"><a href="sport/hirek">Vissza a hírekhez</a></div>
					</div>
				</div>
			</div></div></div>
			
		</div>
		<!-- CONTENT SIDE -->