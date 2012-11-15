		<!-- HEADER -->
		<?php $lang = ($_SESSION['lang'] == 'en' ? 'en/' : ''); ?>

		<?php 
			$current = implode('/', $params);
			if($_SESSION['lang'] == 'en'){
				$en = 'en/' . $current;
				$hu = str_replace('en/', '', $current);
			}else{
				$en = 'en/' . $current;
				$hu = $current;
			}
		?>

		<div class="header">
			<div class="">
			<ul class="lang">
				<li class=""><a href="/<?php echo $hu; ?>"><img src="img/hu.png" alt="HU"></a></li>
				<li class=""><a href="/<?php echo $en; ?>"><img src="img/en.png" alt="EN"></a></li>
			</ul>
			</div>
			<div class="clear"></div>
			<div class="logo">East-West - Utazási és Sport Iroda</div>
			<div class="h_menu">
			<ul>
				<li class="menu_1"><a href="/<?php echo $lang; ?>sport/hirek/"<?php if ($params [1] == 'hirek' || $params [1] == '') echo ' class="act"'; ?>><?php echo $_SESSION['lang'] == 'en' ? 'News' : 'Hírek'; ?></a></li>
				<li class="menu_2"><a href="/<?php echo $lang; ?>sport/rolunk/"<?php if ($params [1] == 'rolunk') echo ' class="act"'; ?>><?php echo $_SESSION['lang'] == 'en' ? 'About us' : 'Rólunk'; ?></a></li>
				<li class="menu_3"><a href="/<?php echo $lang; ?>sport/taborok/"<?php if ($params [1] == 'taborok') echo ' class="act"'; ?>><?php echo $_SESSION['lang'] == 'en' ? 'Camps' : 'Táborok'; ?></a></li>
				<li class="menu_4"><a href="/<?php echo $lang; ?>sport/galeria/"<?php if ($params [1] == 'galeria') echo ' class="act"'; ?>><?php echo $_SESSION['lang'] == 'en' ? 'Gallery' : 'Galéria'; ?></a></li>
				<li class="menu_5"><a href="/<?php echo $lang; ?>sport/referenciak/"<?php if ($params [1] == 'referenciak') echo ' class="act"'; ?>><?php echo $_SESSION['lang'] == 'en' ? 'References' : 'Referenciák'; ?></a></li>
				<li class="menu_6">
					<a href="/<?php echo $lang; ?>sport/reklam_es_szponzor/"<?php if ($params [1] == 'reklam_es_szponzor') echo ' class="act"'; ?>><?php echo $_SESSION['lang'] == 'en' ? 'Advertising & Sponsorship' : 'Reklám & Szponzor'; ?></a>
					<div>
						<ul>
							<li><a href="/<?php echo $lang; ?>sport/reklam_es_szponzor/fcbarcelona">FC Barcelona</a></li>
							<li><a href="/<?php echo $lang; ?>sport/reklam_es_szponzor/gyorietovip">Győri ETO VIP</a></li>
							<li><a href="/<?php echo $lang; ?>sport/reklam_es_szponzor/hungaroring">Hungaroring</a></li>
						</ul>
					</div>
				</li>
				<li class="menu_7"><a href="/<?php echo $lang; ?>sport/kapcsolat/"<?php if ($params [1] == 'kapcsolat') echo ' class="act"'; ?>><?php echo $_SESSION['lang'] == 'en' ? 'Contact' : 'Kapcsolat'; ?></a></li>
			</ul>
			</div>
		</div>
		<!-- HEADER -->
