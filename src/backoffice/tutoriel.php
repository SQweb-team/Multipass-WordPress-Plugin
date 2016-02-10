<form action="<?php echo sqw_site_url() . $_SERVER['REQUEST_URI'] ?>" method="post">
	<div class="sqw-setting-box">
		<div id="step1">
			<div class="sqweb-right sqweb-half-pipe">
				<div class="text-center">
					<h4><?php _e('SQweb is a multisite membership plugin', 'sqweb'); ?></h4>
					<p class="text-left sqw-p">
						<?php _e('Users subscribe to SQweb for a premium surf on partners websites.', 'sqweb'); ?>
						<?php _e('By joining our network, you’ll get a share of our users subscription whenever they visit your website.', 'sqweb'); ?>
					</p>
					<ul class="text-left sqw-li">
						<li><?php _e('Fair share of income', 'sqweb'); ?></li>
						<li><?php _e('Outsoucing of subscribers management', 'sqweb'); ?></li>
						<li><?php _e('Secured payment (PCI DSS)', 'sqweb'); ?></li>
						<li><?php _e('Cross platform (PC, tablet, mobile).', 'sqweb'); ?></li>
					</ul>
				</div>
			</div>
			<div class="sqweb-half-pipe">
				<div class="text-center">
					<h4><?php _e('SQweb is the solution to adblock', 'sqweb'); ?></h4>
					<p class="text-left sqw-p">
						<?php _e('If you have ads on your website, the SQweb plugin allows you to resolve the adblocking problem. SQweb is accepted by users and work with all advertising network', 'sqweb'); ?>
					</p>
					<ul class="text-left sqw-li"> 
						<li><?php _e('Adblocking statistics', 'sqweb'); ?></li>
						<li><?php _e('Estimate your losses', 'sqweb'); ?></li>
						<li><?php _e('Communicate with people using adblock', 'sqweb'); ?></li>
						<li><?php _e('Global solution to a global problem', 'sqweb'); ?></li>
					</ul>
				</div>
			</div>
			<div class="clear"></div>
			<div class="sqweb-tiers-pipe sqweb-more-right">
				<div class="button-primary sqw-full-width" onClick="document.getElementById('step1').style.display = 'none'; document.getElementById('step2a').style.display = 'initial';"><?php _e( 'I want adblock analytics and SQweb subscription', 'sqweb' ) ?></div>
			</div>
			<div class="sqweb-tiers-pipe sqweb-more-right">
				<div class="button-primary sqw-full-width" onClick="document.getElementById('step1').style.display = 'none'; document.getElementById('step2b').style.display = 'initial';"><?php _e( 'I want to use SQweb subscription', 'sqweb' ) ?></div>
			</div>
			<div class="sqweb-tiers-pipe">
				<div class="button-primary sqw-full-width" onClick="document.getElementById('step1').style.display = 'none'; document.getElementById('step2c').style.display = 'initial';"><?php _e( 'I want to measure adblock rate and communicate with adblocker', 'sqweb' ) ?></div>
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
			<h3><?php _e('Multisite Membership', 'sqweb'); ?></h3>
			<h4><?php _e('SQweb is a 9€ per month subscription to surf without add and to access the premium content of all our partners', 'sqweb'); ?></h4>
			<p class="text-left">
				<?php _e('By joining our network, you’ll get a part of the subscription whenever a subscriber visit your website: our subscribers are your subscribers. The more time an user spend on your website, the more you income you will get.
	Whether it is to register, subscribe or activate the premium navigation, the user does not need to leave your website, he just has to use the SQweb button, that will open a modal.', 'sqweb'); ?>
			</p>
			<p class="text-left">
				<?php _e('You are free to choose what you show to the SQweb subscribers. The only rule is to hide ads nor to do advertising tracking on them.', 'sqweb'); ?>
			</p>
			<div class="sqweb-half-pipe sqweb-right">
				<h4><?php _e('Orienté Paywall', 'sqweb'); ?></h4>
				<div class="rounded">
					<input type="radio" value="paywall" id="radiopaywall" name="type"/>
					<label for="radiopaywall"></label>
				</div>
			</div>
			<div class="sqweb-half-pipe">
				<h4><?php _e('Orienté sans pub', 'sqweb'); ?></h4>
				<div class="rounded">
					<input type="radio" value="adsfree" id="radioadsfree" name="type" checked/>
					<label for="radioadsfree"></label>
				</div>
			</div>
			<div class="clear"></div>
			<div id="pw" style="display: none;">
				<div>
					<div class="squared">
						<input type="checkbox" value="None" id="squaredcatblock" name="check"/>
						<label for="squaredcatblock"></label>
					</div>
					<span class="squaredalign">Je souhaite bloquer certaine categorie aux non abonnées !</span>
				</div>
				<div class="clear"></div>
				<div class="sqweb-choice" id="catblock" style="display: none;">
					<p>Quel categorie souhaitez vous bloquez ?</p>
					<?php
						$categorie = get_categories();
						foreach ( $categorie as $value ) {
							echo '<div class="sqweb-right" style="float: left;"><input type="checkbox" name="categorie" value="'. $value->slug .'">'. $value->name .'</input></div>';
						}
					?>
					<div class="clear"></div>
				</div>
				<div>
					<div class="squared">
						<input type="checkbox" value="None" id="squared%art" name="check"/>
						<label for="squared%art"></label>
					</div>
					<span class="squaredalign">Je souhaite afficher seulement un certain pourcentage des articles aux non abonnées !</span>
				</div>
				<div class="clear"></div>
				<div class="sqweb-choice" id="%art" style="display: none;">
					<p>Quel pourcentage de l'articles voulez vous affichez ?</p>
					<input type="number" min="0" max="100" value="100"/>%
				</div>
				<div>
					<div class="squared">
						<input type="checkbox" value="None" id="squarednbart" name="check"/>
						<label for="squarednbart"></label>
					</div>
					<span class="squaredalign">Je souhaite limité le nombre d'article pouvant être vues par jours aux non abonnées !</span>
				</div>
				<div class="clear"></div>
				<div class="sqweb-choice" id="nbart" style="display: none;">
					<p>Combien d'articles l'utilisateur peut-il voir par jours ? (-1 = Autant qu'il veut)</p>
					<input type="number" min="-1" max="100" value="-1"/> Articles par jours
				</div>
				<div>
					<div class="squared">
						<input type="checkbox" value="None" id="squareddateart" name="check"/>
						<label for="squareddateart"></label>
					</div>
					<span class="squaredalign">Je souhaite que les articles ne puissent être vue que après un certain temps aux non abonnées !</span>
				</div>
				<div class="clear"></div>
				<div class="sqweb-choice" id="dateart" style="display: none;">
					<p>Combien de temps ?</p>
					<input type="number" min="0" max="365" value="0"/> Jours avant de voir l'articles.
				</div>
			</div>
			<div id="af">
				Les utilisateurs SQweb qui naviguerons sur votre site aurons juste l'avantage de ne pas avoir de pub, nous vous aiderons à adapter vos bloc publicitaire pour faire cela.
			</div>
			<div class="clear"></div>
			<div class="text-right">
				<div class="button-primary sqw-button" onClick="document.getElementById('step2b').style.display = 'none'; document.getElementById('step2b2').style.display = 'initial';"><?php _e( 'Continuer l\'installation', 'sqweb' ) ?></div>
			</div>
		</div>
		<div id="step2b2" style="display: none;">
			<div class="text-left">
				<div class="button-primary sqw-back" onClick="document.getElementById('step2b2').style.display = 'none'; document.getElementById('step2b').style.display = 'initial';"><?php _e( 'Back', 'sqweb' ) ?></div>
			</div>
			<h3><?php _e('Personnalisation du bouton SQweb', 'sqweb'); ?></h3>
			<div class="clear"></div>
			<div class="sqweb-user-text" style="margin-bottom: 100px;">
				<div class="sqweb-tiers-pipe sqweb-more-right" style="margin-top: 20px">
					<select class="sqweb-admin-input sqw-select" name="lang" id="sqweb-lang-select">';
						<option value="fr"><?php _e( 'French', 'sqweb' ); ?></option>
						<option value="en"><?php _e( 'English', 'sqweb' ); ?></option>
						<option value="es"><?php _e( 'Español', 'sqweb' ); ?></option>
					</select>
				</div>
				<div class="sqweb-tiers-pipe sqweb-more-right">
					<label class="sqweb-form-labels" for="sqweb-message-input1"><?php _e( 'Not connected user', 'sqweb' ); ?></label>
					<input class="sqweb-admin-input" id="sqweb-message-input1" type="text" name="flogin" value="<?php echo $flogin ?>" placeholder="<?php _e( 'Remove Ads', 'sqweb' ); ?>" />
				</div>
				<div class="sqweb-tiers-pipe">
					<label class="sqweb-form-labels" for="sqweb-message-input2"><?php _e( 'Connected user', 'sqweb' ); ?></label>
					<input class="sqweb-admin-input" id="sqweb-message-input2" type="text" name="flogout" value="<?php echo $flogout ?>" placeholder="<?php _e( 'Connected', 'sqweb' ); ?>" />
				</div>
			</div>
			<div class="clear"></div>
			<div class="sqweb-quarter-pipe" style="margin-left: -35px; margin-right: calc(35px + 1%);">
				<input type="radio" name="btheme" value="blue" class="sqweb-radio"><?php _e( 'Blue', 'sqweb' ); ?></input>
				<input type="radio" name="btheme" value="grey" class="sqweb-radio"><?php _e( 'Grey', 'sqweb' ); ?></input>
			</div>
			<div class="sqweb-half-pipe">
				<div class="sqweb-exemple">
					<div class="sqweb-button sqweb-<?php echo ( ! empty( $selectbtheme ) ? 'blue' : 'grey' ); ?>" id="sqweb-button">
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
				<?php if ( $sqw_webmaster > 0 ) { ?>
					<button class="button-primary sqw-button" onClick="document.getElementById('step2b2').style.display = 'none'; document.getElementById('step3').style.display = 'initial';"><?php _e( 'Terminer l\'installation', 'sqweb' ) ?></button>
				<?php } else { ?>
					<div class="button-primary sqw-button" onClick="document.getElementById('step2b2').style.display = 'none'; document.getElementById('step3').style.display = 'initial';"><?php _e( 'Terminer l\'installation', 'sqweb' ) ?></div>
				<?php } ?>
			</div>
		</div>
		<div id="step2c" style="display: none;">
			<div class="text-left">
				<div class="button-primary sqw-back" onClick="document.getElementById('step2c').style.display = 'none'; document.getElementById('step1').style.display = 'initial';"><?php _e( 'Back', 'sqweb' ) ?></div>
			</div>
			<h4><?php _e('ADBLOCK MANAGER', 'sqweb'); ?></h4>
			<p>
				<?php _e('Since 2013 we developped an expertise about ad-blocking by working with hundreds of publishers. Our Adblock Manager ables you to measure the impact of adblockers on your websites, target your audience, and deploy an efficient response.', 'sqweb'); ?>
			<p>
			<div class="sqweb-half-pipe sqweb-right">
				<h4><?php _e('ANALYSIS', 'sqweb'); ?></h4>
				<ul class="text-left sqw-li">
					<li><?php _e('Adblock rate on visitors and page views', 'sqweb'); ?></li>
					<li><?php _e('Revenu loss estimate', 'sqweb'); ?></li>
					<li><?php _e('Platform, browsers and audience segmentation', 'sqweb'); ?></li>
					<li><?php _e('Personalized reports and benchmarking from other websites', 'sqweb'); ?></li>
				</ul>
			</div>
			<div class="sqweb-half-pipe">
				<h4><?php _e('RESPONSE', 'sqweb'); ?></h4>
				<ul class="text-left sqw-li">
					<li><?php _e('Custom message to adblockers', 'sqweb'); ?></li>
					<li><?php _e('A/B testing et performance reports', 'sqweb'); ?></li>
					<li><?php _e('Experience sharing with other publishers', 'sqweb'); ?></li>
					<li><?php _e('Alternative to ads offers with SQwbe or other paywalls', 'sqweb'); ?></li>
				</ul>
			</div>
			<div class="clear"></div>
			<div class="squared">
				<input type="checkbox" id="squaredmsgadblck" name="msgadblck"/>
				<label for="squaredmsgadblck"></label>
			</div>
			<span style="float: left; margin-left: 10px;"><?php _e('Would you like to display a message to your adblockers ?', 'sqweb'); ?></span>
			<div class="clear"></div>
			<div id="msgadblck" style="display: none;">
				<h4><?php _e( 'Enter message to show at adblockers', 'sqweb' ); ?></h4>
				<textarea class="sqweb-admin-textarea" placeholder="Message" name="fmes"><?php echo htmlspecialchars( $fmes ) ?></textarea>
				<span style="color:orange;display: block;margin-bottom: 5px;font-size: 0.8em;"><?php _e( 'Leave the field above blank if you do not wish the message for adblockers shown.', 'sqweb' ); ?></span>
			</div>
			<div class="text-right">
				<?php if ( $sqw_webmaster > 0 ) { ?>
					<button class="button-primary sqw-button" onClick="document.getElementById('step2c').style.display = 'none'; document.getElementById('step3').style.display = 'initial';"><?php _e( 'Terminer l\'installation', 'sqweb' ) ?></button>
				<?php } else { ?>
					<div class="button-primary sqw-button" onClick="document.getElementById('step2c').style.display = 'none'; document.getElementById('step3').style.display = 'initial';"><?php _e( 'Terminer l\'installation', 'sqweb' ) ?></div>
				<?php } ?>
			</div>
			<div class="clear"></div>
		</div>
		<div id="step3" style="display: none;">
			<div class="text-left">
				<div class="button-primary sqw-back" onClick="document.getElementById('step3').style.display = 'none'; document.getElementById('step2c').style.display = 'initial';"><?php _e( 'Back', 'sqweb' ) ?></div>
			</div>
			<h4><?php _e('Finish installation', 'sqweb'); ?></h4>
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
	var check = [];
	var selects = document.getElementsByName("btheme");
	var exemple = document.getElementById("sqweb_exemple");
	var input1 = document.getElementById("sqweb-message-input1");
	var input2 = document.getElementById("sqweb-message-input2");

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

	document.getElementById("squaredmsgadblck").addEventListener("click", function() {
		if (!check[0]) {
			document.getElementById('msgadblck').style.display = 'block';
			check[0] = 1;
		} else {
			document.getElementById('msgadblck').style.display = 'none';
			check[0] = 0;
		}
	});

	document.getElementById("squaredcatblock").addEventListener("click", function() {
		if (!check[1]) {
			document.getElementById('catblock').style.display = 'block';
			check[1] = 1;
		} else {
			document.getElementById('catblock').style.display = 'none';
			check[1] = 0;
		}
	});

	document.getElementById("squared%art").addEventListener("click", function() {
		if (!check[2]) {
			document.getElementById('%art').style.display = 'block';
			check[2] = 1;
		} else {
			document.getElementById('%art').style.display = 'none';
			check[2] = 0;
		}
	});

	document.getElementById("squarednbart").addEventListener("click", function() {
		if (!check[3]) {
			document.getElementById('nbart').style.display = 'block';
			check[3] = 1;
		} else {
			document.getElementById('nbart').style.display = 'none';
			check[3] = 0;
		}
	});

	document.getElementById("squareddateart").addEventListener("click", function() {
		if (!check[4]) {
			document.getElementById('dateart').style.display = 'block';
			check[4] = 1;
		} else {
			document.getElementById('dateart').style.display = 'none';
			check[4] = 0;
		}
	});

	document.getElementById("radiopaywall").addEventListener("click", function() {
			document.getElementById('pw').style.display = 'block';
			document.getElementById('af').style.display = 'none';
	});

	document.getElementById("radioadsfree").addEventListener("click", function() {
			document.getElementById('pw').style.display = 'none';
			document.getElementById('af').style.display = 'block';
	});

</script>