<?php
include 'config.php';
include '_sql.php';
include '_kodok.php';
$auth_level = '1';
include 'template/_start.php';
$oldalnev = 'Doboz módosítása / felvitele';
$oldalleiras = 'Doboz módosítása / felvitele.';
include 'template/_fejlecszerkeszto.php';
?>
<h3>Send a Form with Ajax</h3>
<p><a href="ajax.form.phps">See ajax.form.phps</a></p>
 
<form id="myForm" action="ajax.form.php" method="get">
	<div id="form_box">
		<div>
			<p>First Name:</p>
			<input type="text" name="first_name" value="John" />
		</div>
		<div>
			<p>Last Name:</p>
			<input type="text" name="last_name" value="Q" />
		</div>
		<div>
			<p>E-Mail:</p>
			<input type="text" name="e_mail" value="john.q@mootools.net" />
		</div>
		<div>
			<p>MooTooler:</p>
			 <input type="checkbox" name="mootooler" value="yes" checked="checked" />
		</div>
		<div>
			<p>New to Mootools:</p>
	        <select name="new">
	          <option value="yes" selected="selected">yes</option>
	          <option value="no">no</option>
	        </select>
		</div>
		<div class="hr"><!-- spanner --></div>
		<input type="submit" name="button" id="submitter" />
	<span class="clr"><!-- spanner --></span>
	</div>
</form>
<div id="log">
	<h3>Ajax Response</h3>
	<div id="log_res"><!-- spanner --></div>
</div>
<span class="clr"><!-- spanner --></span>


	<div class="form form_bgr">
		<div class="text">Termék neve:</div>
		<div class="input"><input type="text" name="" value="" /></div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text">Termék érvényessége:</div>
		<div class="valasztas">
			<input type="radio" name="" value="" class="check" />raktáron&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="" value="" class="check" />rendelés&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="" value="" class="check" />nem
		</div>				
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text">&nbsp;</div>
		<div class="valasztas">
	
			<div class="ikon_naptar"><a href=""></a></div>
			 <input id="date" name="date" type="text" />-tól/től
		</div>				
	<div class="clear"></div>
	</div>
	<div class="form">

			<label for="date2">Date</label>
			<input id="date2" name="date2" type="text" />
		<div class="text">&nbsp;</div>
		<div class="valasztas">
			<div class="ikon_naptar"><a href=""></a></div>
			<input type="text" name="" value=""  />-ig
		</div>				
	<div class="clear10"></div>
	</div>
	<div class="form form_bgr">
		<div class="text">Termékismertető:</div>
		<div class="textarea"><textarea name="" rows="20" cols="" class="editor1"></textarea></div>
	<div class="clear"></div>
	</div>
	<div class="form form_bgr">
		<div class="text">Termékismertető:</div>
		<div class="input"><input type="file" name="" value="" class="file" /></div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text">Termék nettó ára:</div>
		<div class="input2"><input type="text" name="" value="" />&nbsp;&nbsp;&nbsp;Ft</div>
		<div class="input2"><strong>Áfa:&nbsp;&nbsp;</strong><select name="">
		<option></option>
		</select></div>
	<div class="clear"></div>
	</div>
	<div class="error_form_text">A Termék súlya nincs kitöltve!</div>
	<div class="form form_bgr form_error">
		<div class="text">Termék súlya:</div>
		<div class="input2"><input type="text" name="" value="" />&nbsp;&nbsp;&nbsp;Kg</div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text">Szállítási költség számítás módja:</div>
		<div class="input2"><select name="">
		<option></option>
		</select></div>
	<div class="clear"></div>
	</div>
	<div class="form form_bgr">
		<div class="text">Termék kategóriája:</div>
		<div class="input2"><select name="">
		<option></option>
		</select></div>
		<div class="input2"><strong>pozíció:</strong>&nbsp;&nbsp;<input type="text" name="" value="" class="w50" /></div>
	<div class="clear"></div>
	</div>
	<div class="form form_bgr">
		<div class="text">&nbsp;</div>
		<div class="input2"><select name="">
		<option></option>
		</select></div>
		<div class="input2"><strong>pozíció:</strong>&nbsp;&nbsp;<input type="text" name="" value="" class="w50" /></div>
	<div class="clear"></div>
	</div>
	<div class="form form_bgr">
		<div class="text">&nbsp;</div>
		<div class="input2"><select name="">
		<option></option>
		</select></div>
		<div class="input2"><strong>pozíció:</strong>&nbsp;&nbsp;<input type="text" name="" value="" class="w50" /></div>
	<div class="clear"></div>
	</div>
	<div class="form form_bgr">
		<div class="text">&nbsp;</div>
		<div class="input2"><select name="">
		<option></option>
		</select></div>
		<div class="input2"><strong>pozíció:</strong>&nbsp;&nbsp;<input type="text" name="" value="" class="w50" /></div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text">Akció besorolás »</div>
		<div class="input2"><select name="">
		<option></option>
		</select></div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text">&nbsp;</div>
		<div class="input"><select name="" class="ev">
		<option></option>
		</select>
		<select name="" class="honap">
		<option></option>
		</select>
		<select name="" class="nap">
		<option></option>
		</select>&nbsp;&nbsp;-tól/től</div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text">&nbsp;</div>
		<div class="input"><select name="" class="ev">
		<option></option>
		</select>
		<select name="" class="honap">
		<option></option>
		</select>
		<select name="" class="nap">
		<option></option>
		</select>&nbsp;&nbsp;-ig</div>
		<div class="button1"><input type="submit" name="" value="Hozzádas" /></div>
	<div class="clear"></div>
	</div>
	<div class="form">
		<div class="text">&nbsp;</div>
		<div class="input">Nyári végkiárusítási akció 2007. 08. 01-2007.08.10.</div>
		<div class="button1"><input type="submit" name="" value="Töröl" /></div>
		<div class="input">Valentin-napi akármi akció 2007. 08. 01-2007.08.10.</div>
		<div class="button1"><input type="submit" name="" value="Töröl" /></div>
	<div class="clear5"></div>
	</div>
	<div class="form form_bgr">
		<div class="text">Kapcsolódó linkek »</div>
		<div class="input">&nbsp;</div>
	<div class="clear"></div>
	</div>
	<div class="form form_bgr">
		<div class="text"><span>http://</span></div>
		<div class="input3"><input type="text" name="" value="" /></div>
	<div class="clear"></div>
	</div>
	<div class="form form_bgr">
		<div class="text"><span>szöveg</span></div>
		<div class="input3"><input type="text" name="" value="" /></div>
		<div class="input_button1"><input type="submit" name="" value="Hozzádas" class="button" /></div>
	<div class="clear"></div>
	</div>
	<div class="form form_bgr">
		<div class="text2">Webáruházak Szövetsége</div>
		<div class="input_button1"><input type="submit" name="" value="Töröl" class="button" /></div>
	<div class="clear"></div>
	</div>
	<div class="form form_bgr">
		<div class="text2">Kosárlabdások Egyesülete</div>
		<div class="input_button1"><input type="submit" name="" value="Töröl" class="button" /></div>
	<div class="clear"></div>
	</div>
	<div class="form form_bgr">
		<div class="text2">Magyar Ebtenyésztők Országos Szövetsége</div>
		<div class="input_button1"><input type="submit" name="" value="Töröl" class="button" /></div>
	<div class="clear"></div>
	</div>
	
	<div class="form">
		<div class="text_all"><a href="">Kapcsolódó dokumentumok »</a></div>
	<div class="clear"></div>
	</div>
	<div class="form form_bgr">
		<div class="text_all"><a href="">Kapcsolódó termékek »</a></div>
	<div class="clear"></div>
	</div>
	
	
	<div class="form" align="center">
		<input type="submit" name="" value="Rögzít" class="fobutton" />
	</div>
<?php
include 'template/_sugo.php';
?>