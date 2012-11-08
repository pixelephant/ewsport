<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<meta name="author" content="">
	<link rel="stylesheet" type="text/css" href="css/ajax.css" />
    <script type="text/javascript" src="../js/mootools.js"></script>
	<title>Untitled 1</title>
	<script type="text/javascript">
		window.addEvent('domready', function(){
			$('myForm').addEvent('submit', function(e) {
				/**
				 * Prevent the submit event
				 */
				new Event(e).stop();
			
				/**
				 * This empties the log and shows the spinning indicator
				 */
				var log = $('log_res').empty().addClass('ajax-loading');
			
				/**
				 * send takes care of encoding and returns the Ajax instance.
				 * onComplete removes the spinner from the log.
				 */
				this.send({
					update: log,
					onComplete: function() {
						log.removeClass('ajax-loading');
					}
				});
			});
		}); 
	</script>
</head>

<body>


<h3>Send a Form with Ajax</h3>
<p><a href="demos/Ajax.Form/ajax.form.phps">See ajax.form.phps</a></p>
 
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
			<p>File:</p>
			<input type="text" size="20" name="fajl">
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




</body>
</html>