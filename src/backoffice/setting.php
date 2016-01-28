<div class="sqw-setting-box">
	<div id="settings" style="display: initial;">
		<?php
		if ( isset( $_POST['sqw-ws-name'] ) && isset( $_POST['sqw-ws-name'] ) ) {
			$add_ws = sqw_add_website( $_POST, $sqw_token );
		}
		$sqw_webmaster = $signinr > 0 ? $signinr : sqweb_check_token( $sqw_token );
		if ( $sqw_webmaster > 0 ) {
			if ( isset( $_GET['website'] ) && 'add' == $_GET['website'] ) {
				?>
				<form action="<?php echo remove_query_arg( 'website' ); ?>" method="post" name="options">
					<h3><?php _e( 'Register a new website', 'sqweb' ); ?></h3>
					<input class="sqweb-admin-auth-input" type="text" name="sqw-ws-name" value="" placeholder="<?php _e( 'Website name', 'sqweb' ); ?>" />
					<input class="sqweb-admin-auth-input" type="text" name="sqw-ws-url" value="" placeholder="<?php _e( 'http://exemple.com', 'sqweb' ); ?>" />
					<input class="button button-primary button-large sqweb-admin-button" type="submit" name="Submit" value="<?php _e( 'Add website', 'sqweb' ); ?>" />
				</form>
				<?php
			} else {
				$sqw_sites = sqw_get_sites( $sqw_webmaster );
				if ( false != $sqw_sites ) {
					$selectbtheme = '';
					$selectgtheme = '';
					$arraylang = array(
										'fr',
										'en',
										'es',
									);
					foreach ( $arraylang as $value ) {
						$selectlang[ $value ] = '';
					}
					$selectlang[ $lang ] = 'selected';
					if ( 'grey' == $btheme ) {
						$selectgtheme = 'checked';
					} else {
						$selectbtheme = 'checked';
					}
					$arraytargeting = array(
										'true',
										'false',
										'oa',
										'tpw',
										'ppw'
									);
					foreach ( $arraytargeting as $value) {
						$selecttargeting[$value] = '';
					}
					$selecttargeting[$targeting] = 'selected';
					$categorie = get_categories();
					if ( isset( $updated ) && true == $updated ) {
					?>
						<span class="sqw-success">
							<?php _e( 'Settings updated.', 'sqweb' ); ?>
						</span>
					<?php } ?>
					<form action="admin.php?page=SQwebAdmin" method="post" name="options">
						<h2><?php _e( 'Settings', 'sqweb' ); ?></h2>
						<input class="sqweb-admin-input" type="hidden" name="wmid" value="<?php echo $sqw_webmaster ?>" placeholder="<?php _e( 'Webmaster ID', 'sqweb' ); ?>" />
						<div class="sqweb-form-div">
							<span class="sqweb-form-title"><?php _e( 'Select your website', 'sqweb' ); ?></span>
							<div class="sqweb-3quarter-pipe sqweb-right">
								<?php
								echo '<select class="sqweb-admin-input sqw-select" name="wsid">';
								foreach ( $sqw_sites as $key => $sqw_site ) {
									if ( $sqw_site->id == $wsid ) {
										echo '<option value="' . $sqw_site->id . '" selected="selected">' . $sqw_site->url . '</option>';
									} else {
										echo '<option value="' . $sqw_site->id . '">' . $sqw_site->url . '</option>';
									}
								}
								echo '</select>';
								echo '<a href="' . add_query_arg( 'website', 'add' ) . '">', __( 'Click here', 'sqweb' ), '</a> ', __( 'add a new website', 'sqweb' ), '<br>';
								?>
							</div>
							<div class="sqweb-quarter-pipe">
								<select class="sqweb-admin-input sqw-select" name="lang" id="sqweb-lang-select">';
									<option value="fr" <?php echo $selectlang['fr'] ?>><?php _e( 'French', 'sqweb' ); ?></option>
									<option value="en" <?php echo $selectlang['en'] ?>><?php _e( 'English', 'sqweb' ); ?></option>
									<option value="es" <?php echo $selectlang['es'] ?>><?php _e( 'Español', 'sqweb' ); ?></option>
								</select>
							</div>
						</div>
						<div class="clear"></div>
						<div class="sqweb-form-div">
							<span class="sqweb-form-title"><?php _e( 'Type of service', 'sqweb' ); ?></span>
							<select id="type_select" class="sqweb-admin-input sqw-select" name="targets" id="sqweb-view-select">
								<option value="false" <?php echo $selecttargeting['false'] ?>><?php _e( 'Subscription for everybody', 'sqweb' ); ?></option>
								<option value="true" <?php echo $selecttargeting['true'] ?>><?php _e( 'Subscription only for adblockers', 'sqweb' ); ?></option>
								<option value="oa" <?php echo $selecttargeting['oa'] ?>><?php _e( 'Analytics only', 'sqweb' ); ?></option>
								<option value="tpw" <?php echo $selecttargeting['tpw'] ?>><?php _e( 'Go to total Paywall', 'sqweb' ); ?></option>
								<option value="ppw" <?php echo $selecttargeting['ppw'] ?>><?php _e( 'Go to partial Paywall', 'sqweb' ); ?></option>
							</select>
						</div>
						<div id="div_settings" <?php if ( $targeting != 'true' && $targeting != 'false' ) { echo 'style="display: none;"'; } ?>>
							<div id="div_button">
								<div class="sqweb-form-div">
									<span class="sqweb-form-title"><?php _e( 'SQweb button', 'sqweb' ); ?></span>
									<div class="sqweb-3quarter-pipe sqweb-right">
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
									<div class="sqweb-quarter-pipe" style="margin-left: -35px">
										<input type="radio" name="btheme" value="blue" class="sqweb-radio" <?php echo $selectbtheme ?>><?php _e( 'Blue', 'sqweb' ); ?></input>
										<input type="radio" name="btheme" value="grey" class="sqweb-radio" <?php echo $selectgtheme ?>><?php _e( 'Grey', 'sqweb' ); ?></input>
									</div>
									<div class="clear"></div>
									<div class="sqweb-user-text">
										<div class="sqweb-half-pipe sqweb-right">
											<label class="sqweb-form-labels" for="sqweb-message-input1"><?php _e( 'Not connected user', 'sqweb' ); ?></label>
											<input class="sqweb-admin-input" id="sqweb-message-input1" type="text" name="flogin" value="<?php echo $flogin ?>" placeholder="<?php _e( 'Remove Ads', 'sqweb' ); ?>" />
										</div>
										<div class="sqweb-half-pipe">
											<label class="sqweb-form-labels" for="sqweb-message-input2"><?php _e( 'Connected user', 'sqweb' ); ?></label>
											<input class="sqweb-admin-input" id="sqweb-message-input2" type="text" name="flogout" value="<?php echo $flogout ?>" placeholder="<?php _e( 'Connected', 'sqweb' ); ?>" />
										</div>
									</div>
								</div>
							</div>
							<div class="clear"></div>
							<div id="div_message">
								<div class="sqweb-form-div">
									<span class="sqweb-form-title"><?php _e( 'Enter message to show at adblockers', 'sqweb' ); ?></span>
									<textarea class="sqweb-admin-textarea" placeholder="Message" name="fmes"><?php echo htmlspecialchars( $fmes ) ?></textarea>
									<span style="color:orange;display: block;margin-bottom: 5px;font-size: 0.8em;"><?php _e( 'Leave the field above blank if you do not wish the message for adblockers shown.', 'sqweb' ); ?></span>
								</div>
							</div>
						</div>
						<div class="clear"></div>
						<div id="div_partial_paywall" <?php if ( $targeting != 'ppw' ) { echo 'style="display: none;"'; } ?>>
							<span class="sqweb-form-title"><?php _e( 'Partial Paywall', 'sqweb' ); ?></span>
							<div class="sqweb-half-pipe sqweb-right" style="margin-top: 16px;">
								<?php
									foreach ($categorie as $value) {
										echo '<div class="sqweb-right" style="float: left;"><input type="checkbox" name="categorie" value="'. $value->slug .'">'. $value->name .'</input></div>';
									}
								?>
							</div>
							<div class="sqweb-half-pipe">
								<label class="sqweb-form-labels" for="sqweb-wordsfilters"><?php _e( 'Articles preview ( word )', 'sqweb' ); ?></label>
								<input class="sqweb-admin-input" type="number" min="0" name="wordsfilters" id="sqweb-wordsfilters" value="0" step="2" style="padding: 0px 8px;"/>
							</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
						<input class="button button-primary button-large sqweb-admin-button" style="margin-bottom: 10px" type="submit" name="Submit" value="<?php if ( ! empty( $wsid ) ) { _e( 'Update', 'sqweb' ); } else { _e( 'Register', 'sqweb' ); } ?>" />
						<div class="clear"></div>
					</form>
					<a href="#" onClick="document.getElementById('settings').style.display = 'none'; document.getElementById('tutoriel').style.display = 'initial';"><?php _e( 'How use button and Adsense filters ?', 'sqweb' ) ?></a>
					<?php
				} else {
					echo '<p class="sqw-notice">', __( 'Woops! It looks like you havent registered your website yet', 'sqweb' ), '<br><a href="' . add_query_arg( 'website', 'add' ) . '">', __( 'Click here', 'sqweb' ), '</a> ', __( 'to start', 'sqweb' ), '</p>';
				}
			}
		}
		?>
	</div>
	<div id="tutoriel" style="display: none;">
		<a href="#" onClick="document.getElementById('settings').style.display = 'initial'; document.getElementById('tutoriel').style.display = 'none';"><?php _e( 'Return to settings', 'sqweb' ) ?></a>
	</div>
</div>
<script type="text/javascript">
	var input1 = document.getElementById("sqweb-message-input1");
	var input2 = document.getElementById("sqweb-message-input2");
	var selects = document.getElementsByName("btheme");
	var exemple = document.getElementById("sqweb_exemple");
	var div_settings = document.getElementById("div_settings");
	var div_ppw = document.getElementById("div_partial_paywall");
	var div_button = document.getElementById("div_button");
	var type_select = document.getElementById("type_select");
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

	if (type_select) {
		type_select.addEventListener('change', function(event) {
			if (div_button) {
				switch (type_select.value) {
					case 'oa':
						div_settings.style.display = 'none';
						div_ppw.style.display = 'none';
						break;
					case 'tpw':
						div_settings.style.display = 'none';
						div_ppw.style.display = 'none';
						break;
					case 'ppw':
						div_settings.style.display = 'none';
						div_ppw.style.display = 'initial';
						break;
					case 'false':
						div_settings.style.display = 'initial';
						div_ppw.style.display = 'none';
						break;
					case 'true':
						div_settings.style.display = 'initial';
						div_ppw.style.display = 'none';
						break;
				}
			}
		});
	}
</script>
