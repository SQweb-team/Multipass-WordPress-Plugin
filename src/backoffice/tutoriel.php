<div class="sqw-setting-box">
	<div id="step1">
		<div>text</div>
		<div class="sqweb-right sqweb-half-pipe">
			<button class="button-primary" onClick="document.getElementById('step1').style.display = 'none'; document.getElementById('step2a').style.display = 'initial';"><?php _e('Login with existing account', 'sqweb') ?></button>
		</div>
		<div class="sqweb-half-pipe">
			<button class="button-primary" onClick="document.getElementById('step1').style.display = 'none'; document.getElementById('step2b').style.display = 'initial';"><?php _e('I\'m a new user without account', 'sqweb') ?></button>
		</div>
		<div class="clear"></div>
	</div>
	<div id="step2a" style="display: none;">
		<form action="<?php echo remove_query_arg( 'success' ) ?>" method="post" name="sqw-auth">
			<div class="sqweb-signin-mail">
				<label for="email">
					<?php _e( 'Email', 'sqweb' ); ?>
				</label>
				<input class="sqweb-admin-auth-input" type="text" id="email" name="sqw-emailc" value="" placeholder="email" />
			</div>
			<div class="sqweb-signin-password">
				<label for="password">
					<?php _e( 'Password', 'sqweb' ); ?>
				</label>
				<input class="sqweb-admin-auth-input" type="password" id="password" name="sqw-passwordc" value="" placeholder="<?php _e( 'password', 'sqweb' ); ?>" />
			</div>
			<input class="button button-primary button-large sqweb-admin-auth-button" type="submit" name="Submit" value="<?php _e( 'Sign in', 'sqweb' ); ?>" />
		</form>
	</div>
	<div id="step2b" style="display: none;">
		<div class="sqweb-tiers-pipe sqweb-right">
			<button class="button-primary sqw-full-width" onClick="document.getElementById('step2b').style.display = 'none'; document.getElementById('step3a').style.display = 'initial';"><?php _e('I want to use SQweb subscription', 'sqweb') ?></button>
		</div>
		<div class="sqweb-tiers-pipe sqweb-right">
			<button class="button-primary sqw-full-width" onClick="document.getElementById('step2b').style.display = 'none'; document.getElementById('step3b').style.display = 'initial';"><?php _e('I want to measure adblock rate<br> and communicate with adblocker', 'sqweb') ?></button>
		</div>
		<div class="sqweb-tiers-pipe">
			<button class="button-primary sqw-full-width" onClick="document.getElementById('step2b').style.display = 'none'; document.getElementById('step3a').style.display = 'initial';"><span><?php _e('I want adblock analytics and SQweb subscription', 'sqweb') ?><span></button>
		</div>
		<div class="clear"></div>
		<div style="margin-top: 30px">
			<div class="sqweb-half-pipe sqweb-right">
				text sqweb
			</div>
			<div class="sqweb-half-pipe">
				text analytics and communicate
			</div>
		</div>
	</div>
	<div id="step3a" style="display: none;">
		<div class="sqweb-half-pipe sqweb-right">
			<button class="button-primary sqw-full-width" onClick="document.getElementById('step2b').style.display = 'none'; document.getElementById('step3c').style.display = 'initial';"><span><?php _e('I want adblock analytics and SQweb subscription', 'sqweb') ?><span></button>
		</div>
		<div class="sqweb-half-pipe sqweb-right">
			<button class="button-primary sqw-full-width" onClick="document.getElementById('step2b').style.display = 'none'; document.getElementById('step3c').style.display = 'initial';"><span><?php _e('I want adblock analytics and SQweb subscription', 'sqweb') ?><span></button>
		</div>
	</div>
	<div id="step3b" style="display: none;">
	</div>
</div>