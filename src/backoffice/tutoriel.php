<form action="<?php echo sqw_site_url() . $_SERVER['REQUEST_URI'] ?>&save=true" method="post">
	<div class="sqw-setting-box">
		<div id="step1">
			<div class="sqweb-right sqweb-half-pipe">
				<div class="text-center">
					<h4><?php _e( 'SQweb is a multisite membership plugin', 'sqweb' ); ?></h4>
					<p class="text-left sqw-p">
						<?php _e( 'Users subscribe to SQweb for a premium surf on partners websites.', 'sqweb' ); ?>
						<?php _e( 'By joining our network, you’ll get a share of our users subscription whenever they visit your website.', 'sqweb' ); ?> <a id="moreinfo1" href="#"><?php _e('More info', 'sqweb'); ?></a>
					</p>
					<div id="more1" style="display: none;">
						<ul class="text-left sqw-li">
							<li><?php _e( 'Fair share of income', 'sqweb' ); ?></li>
							<li><?php _e( 'Outsoucing of subscribers management', 'sqweb' ); ?></li>
							<li><?php _e( 'Secured payment (PCI DSS)', 'sqweb' ); ?></li>
							<li><?php _e( 'Cross platform (PC, tablet, mobile).', 'sqweb' ); ?></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="sqweb-half-pipe">
				<div class="text-center">
					<h4><?php _e( 'SQweb is the solution to adblock', 'sqweb' ); ?></h4>
					<p class="text-left sqw-p">
						<?php _e( 'If you have ads on your website, the SQweb plugin allows you to resolve the adblocking problem. SQweb is accepted by users and work with all advertising networks.', 'sqweb' ); ?>  <a id="moreinfo2" href="#"><?php _e('More info', 'sqweb'); ?></a>
					</p>
					<div id="more2" style="display: none;">
						<ul class="text-left sqw-li"> 
							<li><?php _e( 'Adblocking statistics', 'sqweb' ); ?></li>
							<li><?php _e( 'Estimate your losses', 'sqweb' ); ?></li>
							<li><?php _e( 'Communicate with people using adblock', 'sqweb' ); ?></li>
							<li><?php _e( 'Global solution to a global problem', 'sqweb' ); ?></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<p class="text-center sqw-p">
				<?php _e( 'All features are free, select the one you want.', 'sqweb' ); ?>
			</p>
			<div class="sqweb-half-pipe sqweb-right">
				<div class="button-primary sqweb-button-small" onClick="document.getElementById('step1').style.display = 'none'; document.getElementById('step2b').style.display = 'initial';"><?php _e( 'Adblock analytics<br> and SQweb subscription', 'sqweb' ) ?></div>
			</div>
			<div class="sqweb-half-pipe">
				<div class="button-primary sqweb-button-small" style="padding-top: 13px;" onClick="document.getElementById('step1').style.display = 'none'; document.getElementById('step2c').style.display = 'initial';"><?php _e( 'Adblock analytics', 'sqweb' ) ?></div>
			</div>
			<div class="clear"></div>
		</div>
		<div id="step2a" style="display: none;">
			<div class="text-left">
				<div class="button-primary sqw-back" onClick="document.getElementById('step2a').style.display = 'none'; document.getElementById('step1').style.display = 'initial';"><?php _e( 'Back', 'sqweb' ) ?></div>
			</div>
			<div class="clear"></div>
		</div>
		<div id="step2b" style="display: none;">
			<div class="text-left">
				<div class="button-primary sqw-back" onClick="document.getElementById('step2b').style.display = 'none'; document.getElementById('step1').style.display = 'initial';"><?php _e( 'Back', 'sqweb' ) ?></div>
			</div>
			<h3><?php _e( 'Multisite Membership', 'sqweb' ); ?></h3>
			<h4><?php _e( 'SQweb is a subscription where users pay 9$ per month to surf without ad and to access the premium content of all websites with a SQweb plugin', 'sqweb' ); ?></h4>
			<p class="text-left">
				<?php _e( 'By joining our network, you’ll get a part of the membership fee whenever a subscriber visit your website: our subscribers are your subscribers. The more time an user spend on your website, the more income you will get.
	To register, pay or activate the premium navigation, the user does not need to leave your website, he just has to click on the SQweb button, that will open window in your website (Iframe).', 'sqweb' ); ?> <a href="https://www.sqweb.com/users/"><?php _e( 'DEMO', 'sqweb' ); ?></a>
			</p>
			<p class="text-left">
				<?php _e( 'You are free to choose the content to display to SQweb subscribers. The only rule is to not expose them to advertising tracking on them.', 'sqweb' ); ?>
			</p>
			<p class="text-left">
				<?php _e( 'Do you have content restricted for paying user ?', 'sqweb' ); ?>
			</p>
			<div class="sqweb-half-pipe sqweb-right">
				<h4><?php _e( 'Yes, I want to restrict some content for free user.', 'sqweb' ); ?></h4>
				<div class="rounded">
					<input type="radio" value="paywall" id="radiopaywall" name="type" <?php echo ( get_option( 'categorie' ) ? 'checked' : '' ); ?>/>
					<label for="radiopaywall"></label>
				</div>
			</div>
			<div class="sqweb-half-pipe">
				<h4><?php _e( 'No, I just want to hide ads for paying users.', 'sqweb' ); ?></h4>
				<div class="rounded">
					<input type="radio" value="adsfree" id="radioadsfree" name="type"/>
					<label for="radioadsfree"></label>
				</div>
			</div>
			<div class="clear"></div>
			<div id="pw" <?php echo ( get_option( 'categorie' ) ? '' : 'style="display: none;"' ); ?>>
				<div class="sqw-propal">
					<p class="text-left"><?php _e( 'Setup content restrictions', 'sqweb' ); ?></p>
					<span class="squaredalign text-left" style="margin-bottom: 10px;"><?php _e( 'Select the categories affected by the restriction.', 'sqweb' ); ?></span>
					<div class="clear"></div>
				</div>
				<div class="sqw-propal">
					<div class="sqweb-choice">
						<?php
							$scategorie = unserialize( get_option( 'categorie' ) );
							if ( ! $scategorie ) {
								$scategorie = [];
							}
							$categorie = get_categories();
							foreach ( $categorie as $value ) {
								echo '<div class="sqweb-right" style="float: left;"><input type="checkbox" name="categorie[]" value="'. $value->slug .'" '. ( in_array( $value->slug, $scategorie ) ? 'checked' : '' ) .'>'. $value->name .'</input></div>';
							}
						?>
						<div class="clear"></div>
					</div>
				</div>
				<div class="sqw-propal" style="margin-top: 30px;">
					<div>
						<div class="squared">
							<input type="checkbox" id="squared%art" name="squared%art" <?php echo ( get_option( 'cutartperc' ) !== false ? 'checked' : '' ); ?>/>
							<label for="squared%art"></label>
						</div>
						<span class="squaredalign text-left" style="margin-left: 40px; margin-top: -50px;"><?php _e('I want a part of my content to be displayed for non paying users. If you use this option only the beginning of the post will be displayed.', 'sqweb'); ?></span>
					</div>
					<div class="clear"></div>
					<div class="sqweb-choice" id="%art" <?php echo ( get_option( 'cutartperc' ) !== false ? '' : 'style="display: none;"' ); ?>>
						<p><?php _e('How much % of the articles do you want to show free users, free users and search engines will see this ?', 'sqweb'); ?></p>
						<input type="number" name="perctart" min="0" max="100" value="<?php echo ( get_option( 'cutartperc' ) !== false ? get_option( 'cutartperc' ) : '15' ); ?>"/>%
					</div>
				</div>
				<div class="sqw-propal">
					<div>
						<div class="squared">
							<input type="checkbox" id="squarednbart" name="squarednbart" <?php echo ( get_option( 'artbyday' ) !== false ? 'checked' : '' ); ?>/>
							<label for="squarednbart"></label>
						</div>
						<span class="squaredalign text-left" style="margin-left: 40px; margin-top: -50px;"><?php _e('Start restricting content after a number of page views this mean any user will see part of your content and they will be blocked.', 'sqweb'); ?></span>
					</div>
					<div class="clear"></div>
					<div class="sqweb-choice" id="nbart" <?php echo ( get_option( 'artbyday' ) !== false ? '' : 'style="display: none;"' ); ?>>
						<p><?php _e('How many articles free users can see daily before being blocked ?', 'sqweb'); ?></p>
						<input type="number" min="0" max="100" value="<?php echo ( get_option( 'artbyday' ) !== false ? get_option( 'artbyday' ) : '5' ); ?>" name="artbyday"/> <?php _e('Articles per day', 'sqweb'); ?>
					</div>
				</div>
				<div class="sqw-propal">
					<div>
						<div class="squared">
							<input type="checkbox" id="squareddateart" name="squareddateart" <?php echo ( get_option( 'dateart' ) !== false ? 'checked' : '' ); ?>/>
							<label for="squareddateart"></label>
						</div>
						<span class="squaredalign"><?php _e( 'I want the posts to be available to non paying users after some days.', 'sqweb' ); ?></span>
					</div>
					<div class="clear"></div>
					<div class="sqweb-choice" id="dateart" style="<?php echo ( get_option( 'dateart' ) !== false ? '' : 'display: none;' ); ?> margin-top: -10px;">
						<p><?php _e('How many days will the posts remain restricted ?', 'sqweb'); ?></p>
						<input type="number" min="0" max="365" value="<?php echo ( get_option( 'dateart' ) !== false ? get_option( 'dateart' ) : '1' ); ?>" name="dateart"/> <?php _e( 'days before end of restriction', 'sqweb' ); ?>
					</div>
				</div>
			</div>
			<div id="af" style="display: none;">
				<div class="sqw-propal">
					<?php _e('SQweb Users must navigate without ADS on my website.', 'sqweb'); ?>
				</div>
			</div>
			<div class="clear"></div>
			<div class="text-right">
				<div class="button-primary sqw-button" onClick="document.getElementById('step2b').style.display = 'none'; document.getElementById('step2b2').style.display = 'initial';"><?php _e( 'Continue install', 'sqweb' ) ?></div>
			</div>
		</div>
		<div id="step2b2" style="display: none;">
			<div class="text-left">
				<div class="button-primary sqw-back" onClick="document.getElementById('step2b2').style.display = 'none'; document.getElementById('step2b').style.display = 'initial';"><?php _e( 'Back', 'sqweb' ) ?></div>
			</div>
			<p><?php _e( 'This will be used for the iframe that visitors will use to register, payement and login.', 'sqweb' ); ?> <a href="https://www.sqweb.com/users/">DEMO</a></p>
			<h3><?php _e( 'Setup SQweb', 'sqweb' ); ?></h3>
			<div class="clear"></div>
			<div class="sqweb-user-text" style="margin-bottom: 100px;">
				<div class="sqweb-tiers-pipe sqweb-more-right" style="margin-top: 2px">
					<span><?php _e('Language of your website', 'sqweb'); ?></span>
					<select class="sqweb-admin-input sqw-select" name="lang" id="sqweb-lang-select">';
						<option value="fr"><?php _e( 'French', 'sqweb' ); ?></option>
						<option value="en"><?php _e( 'English', 'sqweb' ); ?></option>
						<option value="es"><?php _e( 'Español', 'sqweb' ); ?></option>
					</select>
				</div>
				<div class="sqweb-tiers-pipe sqweb-more-right">
					<label class="sqweb-form-labels" for="sqweb-message-input1"><?php echo ( empty( $flogin ) ? __( 'Text for not connected user', 'sqweb' ) : $flogin ); ?></label>
					<input class="sqweb-admin-input" id="sqweb-message-input1" type="text" name="flogin" value="<?php echo $flogin ?>" placeholder="<?php _e( 'Remove Ads', 'sqweb' ); ?>" />
				</div>
				<div class="sqweb-tiers-pipe">
					<label class="sqweb-form-labels" for="sqweb-message-input2"><?php echo ( empty( $flogin ) ? __( 'Text for connected user', 'sqweb' ) : $flogin ); ?></label>
					<input class="sqweb-admin-input" id="sqweb-message-input2" type="text" name="flogout" value="<?php echo $flogout ?>" placeholder="<?php _e( 'Connected', 'sqweb' ); ?>" />
				</div>
			</div>
			<div class="clear"></div>
			<div class="sqweb-quarter-pipe" style="margin-left: -35px; margin-right: calc(35px + 1%);">
				<input type="radio" name="btheme" value="blue" class="sqweb-radio" <?php echo ( 'blue' == $btheme ? 'checked' : '' ); ?>><?php _e( 'Blue', 'sqweb' ); ?></input>
				<input type="radio" name="btheme" value="grey" class="sqweb-radio" <?php echo ( 'grey' == $btheme ? 'checked' : '' ); ?>><?php _e( 'Grey', 'sqweb' ); ?></input>
			</div>
			<div class="sqweb-half-pipe">
				<div class="sqweb-exemple">
					<div class="sqweb-button sqweb-<?php echo $btheme; ?>" id="sqweb-button">
						<div class="sqweb-btn">
							<a class="sqweb-btn-logo"></a>
							<span id="sqweb_exemple"><?php _e( 'Remove ads', 'sqweb' ); ?></span>
							<a class="sqweb-btn-link sqweb-btn-loggedin">✕</a>
						</div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="text-right">
					<div class="button-primary sqw-button" onClick="document.getElementById('step2b2').style.display = 'none'; document.getElementById('step2c').style.display = 'initial';"><?php _e( 'Go to Adblock Manager', 'sqweb' ) ?></div>
			</div>
		</div>
		<div id="step2c" style="display: none;">
			<div class="text-left">
				<div class="button-primary sqw-back" onClick="document.getElementById('step2c').style.display = 'none'; document.getElementById('step1').style.display = 'initial';"><?php _e( 'Back', 'sqweb' ) ?></div>
			</div>
			<h4><?php _e( 'ADBLOCK MANAGER', 'sqweb' ); ?></h4>
			<p>
				<?php _e( 'Since 2013 we developped an expertise about ad-blocking by working with hundreds of publishers. Our Adblock Manager ables you to measure the impact of adblockers on your websites, target your audience, and deploy an efficient response.', 'sqweb' ); ?> <a id="moreinfo3" href="#"><?php _e('More info', 'sqweb'); ?></a>
			<p>
			<div id="more3" style="display: none;">
				<div class="sqweb-half-pipe sqweb-right">
					<h4><?php _e( 'ANALYSIS', 'sqweb' ); ?></h4>
					<ul class="text-left sqw-li">
						<li><?php _e( 'Adblock rate on visitors and page views', 'sqweb' ); ?></li>
						<li><?php _e( 'Revenu loss estimate', 'sqweb' ); ?></li>
						<li><?php _e( 'Platform, browsers and audience segmentation', 'sqweb' ); ?></li>
						<li><?php _e( 'Personalized reports and benchmarking from other websites', 'sqweb' ); ?></li>
					</ul>
				</div>
				<div class="sqweb-half-pipe">
					<h4><?php _e( 'RESPONSE', 'sqweb' ); ?></h4>
					<ul class="text-left sqw-li">
						<li><?php _e( 'Custom message to adblockers', 'sqweb' ); ?></li>
						<li><?php _e( 'A/B testing and performance reports', 'sqweb' ); ?></li>
						<li><?php _e( 'Experience sharing with other publishers', 'sqweb' ); ?></li>
						<li><?php _e( 'Alternative to ads offers with SQwbe or other paywalls', 'sqweb' ); ?></li>
					</ul>
				</div>
			</div>
			<div class="clear"></div>
			<p>
				<?php _e( 'The Adblock manager will automatically record adblocking statistics when sqweb plugin is active, find the results on your dashboard on', 'sqweb' ); ?> <a href="https://www.sqweb.com/websites/">SQweb.com</a>
			</p>
			<div class="squared">
				<input type="checkbox" id="squaredmsgadblck" name="msgadblck"/>
				<label for="squaredmsgadblck"></label>
			</div>
			<span style="float: left; margin-left: 10px;"><?php _e( 'Would you like to display a message to your adblockers ?', 'sqweb' ); ?></span>
			<div class="clear"></div>
			<div id="msgadblck" style="display: none;">
				<h4><?php _e( 'Enter message to show at adblockers', 'sqweb' ); ?></h4>
				<textarea class="sqweb-admin-textarea" placeholder="Message" name="fmes"><?php echo htmlspecialchars( $fmes ) ?></textarea>
				<span style="color:orange; display: block; margin-bottom: 5px; font-size: 0.8em;"><?php _e( 'The message will be shown in a banner at the bottom of the window.', 'sqweb' ); ?></span>
			</div>
			<div class="text-right">
				<?php if ( $sqw_webmaster > 0 ) { ?>
					<button class="button-primary sqw-button" onClick="document.getElementById('step2c').style.display = 'none'; document.getElementById('step3').style.display = 'initial';"><?php _e( 'Confirm install', 'sqweb' ) ?></button>
				<?php } else { ?>
					<div class="button-primary sqw-button" onClick="document.getElementById('step2c').style.display = 'none'; document.getElementById('step3').style.display = 'initial';"><?php _e( 'Confirm install', 'sqweb' ) ?></div>
				<?php } ?>
			</div>
			<div class="clear"></div>
		</div>
		<div id="step3" style="display: none;">
			<div class="text-left">
				<div class="button-primary sqw-back" onClick="document.getElementById('step3').style.display = 'none'; document.getElementById('step2c').style.display = 'initial';"><?php _e( 'Back', 'sqweb' ) ?></div>
			</div>
			<h4><?php _e( 'Finish installation', 'sqweb' ); ?></h4>
			<?php if ( ! $sqw_webmaster > 0 ) { ?>
			<div class="sqw-connect">
				<div class="button-primary sqw-button" onClick="document.getElementById('haveaccount').style.display = 'none'; document.getElementById('noaccount').style.display = 'initial';"><?php _e( 'I don\'t have account', 'sqweb' ) ?></div>
				<div class="button-primary sqw-button" onClick="document.getElementById('noaccount').style.display = 'none'; document.getElementById('haveaccount').style.display = 'initial';"><?php _e( 'I have an account', 'sqweb' ) ?></div>
			</div>
			<div id="noaccount" style="display: none;">
				<div class="sqweb-signin-mail">
					<label for="firstname">
						<?php _e( 'Firstname', 'sqweb' ); ?>
					</label>
					<input class="sqweb-admin-auth-input" type="text" name="sqw-firstname" value="" placeholder="firstname" />
					<label for="lastname">
						<?php _e( 'Lastname', 'sqweb' ); ?>
					</label>
					<input class="sqweb-admin-auth-input" type="text" name="sqw-lastname" value="" placeholder="lastname" />
					<label for="email">
						<?php _e( 'Email', 'sqweb' ); ?>
					</label>
					<input class="sqweb-admin-auth-input" type="text" name="sqw-email" value="" placeholder="email" />
					<label for="password">
						<?php _e( 'Password', 'sqweb' ); ?>
					</label>
					<input class="sqweb-admin-auth-input" type="password" name="sqw-password" value="" placeholder="<?php _e( 'password', 'sqweb' ); ?>" />
				</div>
				<input class="button button-primary button-large sqweb-admin-auth-button" type="submit" name="Submit" value="<?php _e( 'Sign up', 'sqweb' ); ?>" />
			</div>
			<div id="haveaccount" style="display: none;">
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
			</div>
			<?php } ?>
		</div>
	</div>
</form>
<script>
	var selects = document.getElementsByName("btheme");
	var exemple = document.getElementById("sqweb_exemple");
	var input1 = document.getElementById("sqweb-message-input1");
	var input2 = document.getElementById("sqweb-message-input2");
	var squaredmsgadblck = document.getElementById("squaredmsgadblck");
	var squaredart = document.getElementById("squared%art");
	var squarednbart = document.getElementById("squarednbart");
	var squareddateart = document.getElementById("squareddateart");

	document.getElementById('moreinfo1').addEventListener('click', function(event) {
		if ( document.getElementById('more1').style.display == 'none' ) {
			document.getElementById('more1').style.display = 'block';
			document.getElementById('more2').style.display = 'block';
		} else {
			document.getElementById('more1').style.display = 'none';
			document.getElementById('more2').style.display = 'none';
		}
	});

	document.getElementById('moreinfo2').addEventListener('click', function(event) {
		if ( document.getElementById('more1').style.display == 'none' ) {
			document.getElementById('more1').style.display = 'block';
			document.getElementById('more2').style.display = 'block';
		} else {
			document.getElementById('more1').style.display = 'none';
			document.getElementById('more2').style.display = 'none';
		}
	});

	document.getElementById('moreinfo3').addEventListener('click', function(event) {
		if ( document.getElementById('more3').style.display == 'none' ) {
			document.getElementById('more3').style.display = 'block';
		} else {
			document.getElementById('more3').style.display = 'none';
		}
	});

	if (exemple) {
		if (input1) {
			input1.addEventListener('keyup', function(event) {
				document.getElementById("sqweb_exemple").innerHTML = input1.value;
			});
		}
		if (input2) {
			input2.addEventListener('keyup', function(event) {
				document.getElementById("sqweb_exemple").innerHTML = input2.value;
			});
		}
		if (selects)
		{
			for(select in selects) {
				selects[select].onclick = function(event) {
					document.getElementById("sqweb-button").className = "sqweb-button sqweb-"+this.value;
				};
			}
		}
	}

	squaredmsgadblck.addEventListener("click", function() {
		if (squaredmsgadblck.checked == true) {
			document.getElementById('msgadblck').style.display = 'block';
		} else {
			document.getElementById('msgadblck').style.display = 'none';
		}
	});

	squaredart.addEventListener("click", function() {
		if (squaredart.checked == true) {
			document.getElementById('%art').style.display = 'block';
		} else {
			document.getElementById('%art').style.display = 'none';
		}
	});

	squarednbart.addEventListener("click", function() {
		if (squarednbart.checked == true) {
			document.getElementById('nbart').style.display = 'block';
		} else {
			document.getElementById('nbart').style.display = 'none';
		}
	});

	squareddateart.addEventListener("click", function() {
		if (squareddateart.checked == true) {
			document.getElementById('dateart').style.display = 'block';
		} else {
			document.getElementById('dateart').style.display = 'none';
		}
	});

	document.getElementById("radiopaywall").addEventListener("click", function() {
			document.getElementById('pw').style.display = 'block';
			document.getElementById('af').style.display = 'none';
	});

	document.getElementById("radioadsfree").addEventListener("click", function() {
			document.getElementById('pw').style.display = 'none';
			document.getElementById('af').style.display = 'block';
			document.getElementById("squared%art").checked = false;
			document.getElementById("squarednbart").checked = false;
			document.getElementById("squareddateart").checked = false;
			document.getElementById('dateart').style.display = 'none';
			document.getElementById('nbart').style.display = 'none';
			document.getElementById('%art').style.display = 'none';
	});

</script>
