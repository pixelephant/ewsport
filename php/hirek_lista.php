<?php 
$tmp_hirek = gsql_numassoc ("SELECT * FROM nmTexts WHERE menuid=9 ORDER BY activefromdate DESC");
?>
		<!-- CONTENT SIDE -->
		<div class="content_side clearfix">
		
			<div class="box_data"><div class="bgr_top"><div class="bgr_bot clearfix">
				<div class="ful_hirek">Hírek</div>
				<div class="clear"></div>
				<div class="news_list clearfix">
					<?php 
					foreach ($tmp_hirek as $row) {
					?>
					<div class="box_border">
						<div class="cont clearfix">
							<div class="title"><a href="sport/hirek/<?php echo $row ['url']; ?>"><?php echo $row ['name']; ?></a></div>
							<div class="date"><?php echo $row ['activefromdate']; ?></div>
							<?php if (file_exists("uploads/text/{$row ['id']}/leads.jpg")) { ?>
							<div class="pic"><a href="sport/hirek/<?php echo $row ['url']; ?>"><img src="<?php echo "uploads/text/{$row ['id']}/leads.jpg"; ?>" alt="" /></a></div>
							<?php } ?>
							<div class="text">
								<?php echo $row ['lead']; ?>
								<div class="clear10"></div>
								<div class="button_more"><a href="sport/hirek/<?php echo $row ['url']; ?>">Tovább</a></div>
							</div>
						</div>
					</div>
					
					<div class="clear20"></div>
					<?php 
					}
					?>					
					
				</div>
			</div></div></div>
			
		</div>
		<!-- CONTENT SIDE -->
