<div class="sqw-setting-box">
	<?php
	if ( isset( $_POST['sqw-ws-name'] ) && isset( $_POST['sqw-ws-name'] ) ) {
		$add_ws = sqw_add_website( $_POST, $sqw_token );
	}
	$token = $signinr ? $signinr : $sqw_token;
	$sqw_webmaster = sqweb_check_token( $token );
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
				$selectyestarget = '';
				$selectnotarget = '';
				if ( 'grey' == $btheme ) {
					$selectgtheme = 'selected';
				} else {
					$selectbtheme = 'selected';
				}

				$selectlang[ $lang ] = 'selected';
				if ( 'true' == $targeting ) {
					$selectyestarget = 'selected';
				} elseif ( 'false' == $targeting ) {
					$selectnotarget = 'selected';
				} else {
					$selectnobutton = 'selected';
				}
				?>
				<form action="options.php" method="post" name="options">
					<h3><?php _e( 'Settings', 'sqweb' ); ?></h3>
					<?php echo wp_nonce_field( 'update-options' ) ?>
					<input class="sqweb-admin-input" type="hidden" name="wmid" value="<?php echo $sqw_webmaster ?>" placeholder="<?php _e( 'Webmaster ID', 'sqweb' ); ?>" />
					<div class="sqweb-form-div">
						<span class="sqweb-form-title"><?php _e( 'Step 1 : select your website', 'sqweb' ); ?></span>
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
					<div class="sqweb-form-div">
						<span class="sqweb-form-title"><?php _e( 'Step 2 : Enter the message that will be shown to adblockers', 'sqweb' ); ?></span>
						<textarea class="sqweb-admin-textarea" placeholder="Message" name="fmes"><?php echo htmlspecialchars( $fmes ) ?></textarea>
						<input type="hidden" name="action" value="update" />
						<span style="color:orange;display: block;margin-bottom: 5px;font-size: 0.8em;"><?php _e( 'Leave the field above blank if you do not wish the message for adblockers shown.', 'sqweb' ); ?></span>
					</div>
					<div class="sqweb-form-div">
						<span class="sqweb-form-title"><?php _e( 'Step 3 : Display button', 'sqweb' ); ?></span>
						<select class="sqweb-admin-input sqw-select" name="targets" id="sqweb-color-select">';
							<option value="true" <?php echo $selectyestarget ?>><?php _e( 'Only to adblockers', 'sqweb' ); ?></option>
							<option value="false" <?php echo $selectnotarget ?>><?php _e( 'To everybody', 'sqweb' ); ?></option>
							<option value="oa" <?php echo $selectnobutton ?>><?php _e( 'Analytics only', 'sqweb' ); ?></option>
						</select>
					</div>
					<div class="sqweb-form-div">
						<span class="sqweb-form-title"><?php _e( 'Step 4 : Messages you\'d like on the button', 'sqweb' ); ?></span>
						<div class="sqweb-exemple">
							<div class="sqweb-button sqweb-<?php echo ( ! empty( $selectbtheme ) ? 'blue' : 'grey' ); ?>" id="sqweb-button">
								<div class="sqweb-btn">
									<a href="#" class="sqweb-btn-logo"></a>
									<span id="sqweb_exemple"><?php _e( 'Remove ads', 'sqweb' ); ?></span>
									<a href="#" class="sqweb-btn-link sqweb-btn-loggedin">✕</a>
								</div>
							</div>
						</div>
						<div class="sqweb-user-text">
							<label class="sqweb-form-labels" for "flogin"><?php _e( 'Text for not connected user', 'sqweb' ); ?></label>
							<input class="sqweb-admin-input" id="sqweb-message-input1" type="text" name="flogin" value="<?php echo $flogin ?>" placeholder="<?php _e( 'Remove Ads', 'sqweb' ); ?>" />
							<label class="sqweb-form-labels" for "flogout"><?php _e( 'Text for connected user', 'sqweb' ); ?></label>
							<input class="sqweb-admin-input" id="sqweb-message-input2" type="text" name="flogout" value="<?php echo $flogout ?>" placeholder="<?php _e( 'Connected', 'sqweb' ); ?>" />
						</div>
					</div>
					<div class="sqweb-form-div">
						<span class="sqweb-form-title"><?php _e( 'Step 5 : choose the button color', 'sqweb' ); ?></span>
						<select class="sqweb-admin-input sqw-select" name="btheme" id="sqweb-color-select">';
							<option value="blue" <?php echo $selectbtheme ?>><?php _e( 'Blue', 'sqweb' ); ?></option>
							<option value="grey" <?php echo $selectgtheme ?>><?php _e( 'Grey', 'sqweb' ); ?></option>
						</select>
					</div>
					<div class="sqweb-form-div">
						<span class="sqweb-form-title"><?php _e( 'Step 6 : select lang', 'sqweb' ); ?></span>
						<select class="sqweb-admin-input sqw-select" name="lang" id="sqweb-color-select">';
							<option value="fr" <?php echo $selectlang['fr'] ?>><?php _e( 'French', 'sqweb' ); ?></option>
							<option value="en" <?php echo $selectlang['en'] ?>><?php _e( 'English', 'sqweb' ); ?></option>
							<option value="es" <?php echo $selectlang['es'] ?>><?php _e( 'Español', 'sqweb' ); ?></option>
						</select>
					</div>
					<input type="hidden" name="page_options" value="wmid, wsid, flogin, flogout, fmes, btheme, lang, targets" />
					<input class="button button-primary button-large sqweb-admin-button" type="submit" name="Submit" value="<?php if ( ! empty( $wsid ) ) { _e( 'Update', 'sqweb' ); } else { _e( 'register', 'sqweb' ); } ?>" />
				</form>
				<?php
			} else {
				echo '<p class="sqw-notice">', __( 'Woops! It looks like you havent registered your website yet', 'sqweb' ), '<br><a href="' . add_query_arg( 'website', 'add' ) . '">', __( 'Click here', 'sqweb' ), '</a> ', __( 'to start', 'sqweb' ), '</p>';
			}
		}
	}
	?>
</div>
