<?php 
if($_SESSION['lang'] == 'en'){
	$tmp_hirek = gsql_numassoc ("SELECT lead_en AS lead, name_en AS name, url, id, activefromdate FROM nmTexts WHERE menuid=9 ORDER BY activefromdate DESC");
}else{
	$tmp_hirek = gsql_numassoc ("SELECT * FROM nmTexts WHERE menuid=9 ORDER BY activefromdate DESC");
}
	
$lang = ($_SESSION['lang'] == 'en' ? 'en/' : '');
?>
		<!-- CONTENT SIDE -->
		<div class="content_side clearfix">
		
			<div class="box_data"><div class="bgr_top"><div class="bgr_bot clearfix">
				<div class="ful_hirek"><?php echo $_SESSION['lang'] == 'en' ? 'News' : 'Hírek'; ?></div>
				<div class="clear"></div>
				<div class="news_list clearfix">
					<?php 
					foreach ($tmp_hirek as $row) {
					?>
					<div class="box_border">
						<div class="cont clearfix">
							<div class="title"><a href="<?php echo $lang; ?>sport/hirek/<?php echo $row ['url']; ?>"><?php echo $row ['name']; ?></a></div>
							<div class="date"><?php echo $_SESSION['lang'] == 'en' ? date('j-m-y', strtotime($row['activefromdate'])) : $row ['activefromdate']; ?></div>
							<?php if (file_exists("uploads/text/{$row ['id']}/leads.jpg")) { ?>
							<div class="pic"><a href="<?php echo $lang; ?>sport/hirek/<?php echo $row ['url']; ?>"><img src="<?php echo "uploads/text/{$row ['id']}/leads.jpg"; ?>" alt="" /></a></div>
							<?php } ?>
							<div class="text">
								<?php echo $row ['lead']; ?>
								<div class="clear10"></div>
								<div class="button_more"><a href="<?php echo $lang; ?>sport/hirek/<?php echo $row ['url']; ?>"><?php echo $_SESSION['lang'] == 'en' ? 'More' : 'Tovább'; ?></a></div>
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
