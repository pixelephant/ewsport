<?php 
$tmp_galeria = gsql_numassoc ("SELECT * FROM nmGaleries WHERE type='s' ORDER BY sorrend ASC");
$lang = ($_SESSION['lang'] == 'en' ? 'en/' : '');
if ($_GET ['gid'] == '') {
?>
		<!-- CONTENT SIDE -->
		<div class="content_side clearfix">
		
			<div class="box_data"><div class="bgr_top"><div class="bgr_bot clearfix">
				<div class="ful_galeria"><?php echo $_SESSION['lang'] == 'en' ? 'Gallery' : 'Galéria'; ?></div>
				<div class="clear"></div>
				<div class="gallery_list clearfix">
				
				
				<?php 
				foreach ($tmp_galeria as $row) { 
					$tmp_elsokep = gsql_numassoc ("SELECT id, number FROM nmGalerypics WHERE galeryid={$row ['id']} ORDER BY number ASC LIMIT 0,1");
				?>
					<div class="box_border">
						<div class="cont clearfix">
							<div class="title"><a href="<?php echo $lang; ?>sport/galeria?gid=<?php echo $row ['id']; ?>"><?php echo $_SESSION['lang'] == 'en' ? $row ['nameen'] : $row ['namehu']; ?></a></div>
							<div class="pic"><a href="<?php echo $lang; ?>sport/galeria?gid=<?php echo $row ['id']; ?>"><img src="uploads/galery/<?php echo $row ['id']; ?>/<?php echo $tmp_elsokep [0] ['id']; ?>s.jpg" alt="" /></a></div>
						</div>
					</div>
				<?php } ?>

				</div>
		</div></div></div>
			
		</div>
		<!-- CONTENT SIDE -->
<?php 
} else { 
	$gid = (int) $_GET ['gid'];
	$tmp_galeria = gsql_numassoc ("SELECT * FROM nmGaleries WHERE id=$gid");
	$tmp_pics = gsql_numassoc ("SELECT * FROM nmGalerypics WHERE galeryid=$gid ORDER BY number ASC");
?>

		<!-- CONTENT SIDE -->
		<div class="content_side clearfix">
		
			<div class="box_data"><div class="bgr_top"><div class="bgr_bot clearfix">
				<div class="ful_galeria"><?php echo $_SESSION['lang'] == 'en' ? 'Gallery' : 'Galéria'; ?></div>
				<div class="clear"></div>
				<div class="gallery_list clearfix">
					<h4><?php echo $_SESSION['lang'] == 'en' ? $tmp_galeria [0] ['nameen'] : $tmp_galeria [0] ['namehu']; ?></h4>
					<?php foreach ($tmp_pics as $row) { ?>
					<div class="box_border">
						<div class="cont clearfix">
							<div class="pic"><a href="uploads/galery/<?php echo $row ['galeryid']; ?>/<?php echo $row ['id']; ?>b.jpg" rel="lightbox-<?php echo $tmp_galeria [0] ['namehu']; ?>]"><img src="uploads/galery/<?php echo $row ['galeryid']; ?>/<?php echo $row ['id']; ?>s.jpg" alt="" /></a></div>
							<div class="g_text"><?php echo $_SESSION['lang'] == 'en' ? $row ['nameen'] : $row ['namehu']; ?></div>
						</div>
					</div>
					<?php } ?>
					<div class="button_back"><a href="sport/galeria"><?php echo $_SESSION['lang'] == 'en' ? 'Back' : 'Vissza'; ?> &raquo;</a></div>
				</div>
			</div></div></div>
			
		</div>
		<!-- CONTENT SIDE -->


<?php } ?>