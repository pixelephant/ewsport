<script type="text/javascript">		
//<![CDATA[
    window.addEvent('domready', function() {
	    $('registerForm').addEvent('submit', function(e) {
	            new Event(e).stop();
	            var log = $('log_res').empty().addClass('ajax-loading');
	            this.send({
	                update: log,
	                onComplete: function() {
	                    log.removeClass('ajax-loading');
	                }
	            });
	        });
	});
//]]>
</script>
	<div id="log">
		<div id="log_res">
		<!-- SPANNER -->
		</div>
	</div>
	<div id="container2">
	<form method="post" id="registerForm" action="register.php">
          <table align="center" cellpadding="2" cellspacing="0">
            <tr>
              <td style="width:120px"><div align="left"><strong><LABEL for="First_name">First name:</LABEL></strong></div></td>
              <td><div align="left" class="string">
                <input name="First_name" type="text" class="input" id="First_name" value="" size="32" /></div>
              </td>
            </tr>
            <tr>
              <td style="width:120px"><div align="left"><strong><LABEL for="Last_name">Last name:</LABEL></strong></div></td>
              <td><div align="left">
                <input name="Last_name" class="input" type="text" id="Last_name" value="" size="32" /></div></td>
            </tr>
            <tr>
              <td style="width:120px"><div align="left"><strong><LABEL for="Username">Username:</LABEL></strong></div></td>
              <td><div align="left">
                <input name="Username" type="text" class="input" id="Username" value="" size="32" /></div>
              </td>
            </tr>
            <tr>
              <td style="width:120px"><div align="left"><strong><LABEL for="Password">Password:</LABEL></strong></div></td>
              <td><div align="left">
              <input name="Password" type="password" class="input" id="Password" value="" size="32" /></div></td>
            </tr>
            <tr>

              <td style="width:120px"><div align="left"><strong><LABEL for="re_Password">Re-type Password:</LABEL></strong></div></td>
              <td><div align="left">
              <input name="re_Password" type="password" class="input" id="re_Password" value="" size="32" /></div></td>
            </tr>
            <tr>

              <td style="width:120px"><div align="left"><strong><LABEL for="Email">Email:</LABEL></strong></div></td>
              <td><div align="left">
              <input name="Email" type="text" class="input" id="Email" value="" size="32" /></div></td>
            </tr>
            <tr>
              <td colspan="2"><div align="right">
                  <input type="image" name="register" class="submit-btn" src="http://www.roscripts.com/images/btn.gif" alt="submit" title="submit" />
              </div></td>
            </tr>
          </table>
        </form>
        </div>