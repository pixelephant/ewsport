<?php
include 'config.php';
include '_sql.php';
include '_kodok.php';
include "template/_start.php";
$oldalnev = 'Doboz módosítása / felvitele';
$oldalleiras = 'Doboz módosítása / felvitele.';
include 'template/_fejlecszerkeszto.php';
?>
			<div id="myTabs">
				<ul class="mootabs_title">
					<li title="tab1">Alapadatok</li>
					<li title="tab2">Székhely</li>
					<li title="tab3">Telephely</li>
					<li title="tab4">Számlázási cím</li>
				</ul>

				
				<div id="tab1" class="mootabs_panel">
					
				</div>
				
				<div id="tab2" class="mootabs_panel">
					
				</div>
				<div id="tab3" class="mootabs_panel">
					
				</div>
				<div id="tab4" class="mootabs_panel">
					
				</div>
			</div>
			<a href="javascript:;" onclick="myTabs1.previous()" style="font-size:10px;">Vissza</a> | <a href="javascript:;" style="font-size: 10px" onclick="myTabs1.next()">Előre</a>

<?php
include 'template/_sugo.php';
?>
