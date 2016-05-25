<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<div class="sqw-general">
	<?php if ( empty( $sqw_token ) ) { ?>
	<div class="sqw-login">
		<div class="sqw-box-login">
			<div class="sqw-padding-logo">
				<div class="sqw-logo">
				</div>
			</div>
			<div class="sqw-tab">
				<div class="sqw-tab-select sqw-tab-active sqw-tab-login">
					<?php _e( 'Log in' ); ?>
				</div>
				<div class="sqw-tab-select sqw-tab-subscribe">
					<?php _e( 'Subscribe' ); ?>
				</div>
			</div>
			<div class="sqw-clear"></div>
			<div class="sqw-form">
				<form action="<?php echo sqw_site_url() . $_SERVER['REQUEST_URI'] ?>&type=login" method="post">
					<input type="text" class="sqw-form-email" name="sqw-emailc" placeholder="<?php _e( 'Email' ); ?>">
					<input type="password" class="sqw-form-password" name="sqw-passwordc" placeholder="<?php _e( 'Password' ); ?>">
					<button type="submit"><?php _e( 'Log in' ); ?></button>
				</form>
			</div>
			<div class="sqw-form sqw-hide">
				<form action="<?php echo sqw_site_url() . $_SERVER['REQUEST_URI'] ?>&type=subscribe" method="post">
					<input type="text" name="sqw-firstname" placeholder="<?php _e( 'First name' ); ?>">
					<input type="text" name="sqw-lastname" placeholder="<?php _e( 'Last name' ); ?>">
					<input type="text" class="sqw-form-email" name="sqw-email" placeholder="<?php _e( 'Email' ); ?>">
					<input type="password" class="sqw-form-password" name="sqw-password" placeholder="<?php _e( 'Password' ); ?>">
					<input type="password" class="sqw-form-password" name="sqw-confirmp" placeholder="<?php _e( 'Confirm password' ); ?>">
					<button type="submit"><?php _e( 'Subscribe' ); ?></button>
				</form>
			</div>
		</div>
	</div>
	<?php } else { ?>
	<form action="<?php echo sqw_site_url() . $_SERVER['REQUEST_URI'] ?>&type=save" method="post">
		<div class="sqw-config">
			<div class="sqw-integer">
				<div class="sqw-box sqw-left">
					<div class="sqw-multipass">
						<div class="sqw-header">
							<h3 class="sqw-title sqw-title-multipass <?php echo ( get_option( 'sqw_multipass' ) ? 'sqw-title-multipass-color' : '' ) ?>">
								<?php _e( 'Activate Multipass' ); ?>
							</h3><div class="sqw-tack sqw-tack-big <?php echo ( get_option( 'sqw_multipass' ) ? 'sqw-tack-big-check sqw-green' : '' ); ?>" name="multipass" data-color="green"><div></div></div>
							<input type="hidden" class="sqw-multipass-input" name="sqw_multipass" value="<?php echo get_option( 'sqw_multipass' ); ?>"/>
						</div>
						<div class="sqw-clear"></div>
						<p class="sqw-body basic-font-10"><?php _e( 'By joining our network, you’ll get a part of the membership fee whenever a subscriber visit your website.' ); ?> <a href="https://www.sqweb.com/publishers"><?php _e( 'More infos' ); ?></a></p>
						<div class="sqw-multipass-body sqw-body <?php echo ( get_option( 'sqw_multipass' ) ? '' : 'sqw-hide' ); ?>">
							<h4><?php _e( 'Do you want to restrict some content for free users ?' ); ?></h4><div class="sqw-tack sqw-tack-basic <?php echo ( get_option( 'cutartperc' ) !== false || get_option( 'artbyday' ) !== false || get_option( 'dateart' ) !== false || unserialize( get_option( 'categorie' ) ) ? 'sqw-tack-basic-check sqw-green' : '' ); ?>" name="sqw-paywall" data-color="green"><div></div></div>
							<div class="sqw-paywall <?php echo ( get_option( 'cutartperc' ) !== false || get_option( 'artbyday' ) !== false || get_option( 'dateart' ) !== false || unserialize( get_option( 'categorie' ) ) ? '' : 'sqw-hide' ); ?>">
								<div class="sqw-check-categorie">
									<p><?php _e( 'Setup content restrictions :' ); ?></p>
									<?php
										$scategorie = unserialize( get_option( 'categorie' ) );
									if ( ! $scategorie ) {
										$scategorie = array();
									}
										$categorie = get_categories();
										$i = 0;
									foreach ( $categorie as $value ) {
										$i++;
										echo '
											<div>
												<input type="checkbox" name="categorie[]" id="' . $value->slug . '" value="' . $value->slug . '" ' . ( in_array( $value->slug, $scategorie ) ? 'checked' : '' ) . '/>
												<label for="' . $value->slug . '">' . $value->name . '</label>
											</div>';
									}
									?>
								</div>
								<div class="sqw-selector sqw-clear">
									<div class="sqw-select">
										<h5><?php _e( 'I want a part of my content to be displayed for non paying users.' ); ?></h5>
										<div class="sqw-tack sqw-tack-basic <?php echo ( get_option( 'cutartperc' ) !== false ? 'sqw-tack-basic-check sqw-green' : '' ); ?>" name="sqw-fading-art" data-color="green"><div></div></div>
										<p><?php _e( '(if you use this option only the beginning of the post will be displayed)' ); ?></p>
										<div class="sqw-fading-art sqw-center sqw-safe-padding <?php echo ( get_option( 'cutartperc' ) !== false ? '' : 'sqw-hide' ); ?>">
											<p><?php _e( 'How much % of the articles do you want to show free users ?', 'sqweb' ); ?></p>
											<p><?php _e( '(Free users and search engines will see this)', 'sqweb' ); ?></p>
											<input type="number" name="perctart" min="0" max="100" value="<?php echo ( get_option( 'cutartperc' ) !== false ? get_option( 'cutartperc' ) : '' ); ?>"/><span class="basic-font-10"> %</span>
										</div>
									</div>
									<div class="sqw-select">
										<h5><?php _e( 'Start restricting content after a number of page views.' ); ?></h5>
										<div class="sqw-tack sqw-tack-basic <?php echo ( get_option( 'artbyday' ) !== false ? 'sqw-tack-basic-check sqw-green' : '' ); ?>" name="sqw-number-art" data-color="green"><div></div></div>
										<p><?php _e( '(This means any user will see part of your content and they will be blocked)' ); ?></p>
										<div class="sqw-number-art sqw-center sqw-safe-padding <?php echo ( get_option( 'artbyday' ) !== false ? '' : 'sqw-hide' ); ?>">
											<p><?php _e( 'How many articles free users can see daily before being blocked ?', 'sqweb' ); ?></p>
											<input type="number" min="0" max="100" value="<?php echo ( get_option( 'artbyday' ) !== false ? get_option( 'artbyday' ) : '' ); ?>" name="artbyday"/><span class="basic-font-10"> <?php _e( 'Articles per day', 'sqweb' ); ?></span>
										</div>
									</div>
									<div class="sqw-select">
										<h5><?php _e( 'I want the posts to be available to non paying users after some days.' ); ?></h5>
										<div class="sqw-tack sqw-tack-basic <?php echo ( get_option( 'dateart' ) !== false ? 'sqw-tack-basic-check sqw-green' : '' ); ?>" name="sqw-time-art" data-color="green"><div></div></div>
										<div class="sqw-time-art sqw-center sqw-safe-padding <?php echo ( get_option( 'dateart' ) !== false ? '' : 'sqw-hide' ); ?>">
											<p><?php _e( 'How many days will the posts remain restricted ?', 'sqweb' ); ?></p>
											<input type="number" min="0" max="365" value="<?php echo ( get_option( 'dateart' ) !== false ? get_option( 'dateart' ) : '' ); ?>" name="dateart"/><span class="basic-font-10"> <?php _e( 'days before end of restriction', 'sqweb' ); ?></span>
										</div>
									</div>
								</div>
							</div>
							<div class="sqw-config-button">
								<p class="sqw-center sqw-title-multipass-color basic-font-12"><?php _e( 'SQweb users must navigate without ADS on your website' ); ?></p>
								<hr width='270px'></hr>
								<p class="sqw-center basic-font-12"><?php _e( 'This will be used for the iframe that visitors will use to register, payment and login.' ); ?> <a href="https://www.sqweb.com/users/">DEMO</a></p>
								<div class="sqw-full-width">
									<div class="sqw-tiers">
										<div class="sqw-margin-top">
											<label for="sqw-lang-select"><?php _e( 'Language of your website :' ); ?></label>
											<select class="sqw-input-select" name="lang" id="sqw-lang-select">';
												<option value="fr"><?php _e( 'French', 'sqweb' ); ?></option>
												<option value="en"><?php _e( 'English', 'sqweb' ); ?></option>
												<option value="es"><?php _e( 'Español', 'sqweb' ); ?></option>
											</select>
										</div>
										<div class="sqw-margin-top">
											<label for="sqw-login-msg"><?php _e( 'Text for not connected users' ); ?></label>
											<input class="sqw-input" type="text" name="flogin" id="sqw-login-msg" value="<?php echo $flogin ?>" placeholder="<?php _e( 'Remove Ads', 'sqweb' ); ?>">
										</div>
										<div class="sqw-margin-top">
											<label for="sqw-logout-msg"><?php _e( 'Text for connected user' ); ?></label>
											<input class="sqw-input" type="text" name="flogout" id="sqw-logout-msg" value="<?php echo $flogout ?>" placeholder="<?php _e( 'Connected', 'sqweb' ); ?>">
										</div>
									</div>
									<div class="sqw-tiers">
										<div class="sqw-padding-left">
											<p><?php _e( 'Select the color :' ); ?></p>
											<div class="sqw-margin-top">
												<input class="sqw-radio" id="blue" type="radio" name="btheme" value="blue" <?php echo ('blue' == $btheme ? 'checked' : '') ?>/><label for="blue" ><?php _e( 'Blue' ); ?></label>
											</div>
											<div class="sqw-margin-top">
												<input class="sqw-radio" id="grey" type="radio" name="btheme" value="grey" <?php echo ('grey' == $btheme ? 'checked' : '') ?>/><label for="grey"><?php _e( 'Grey' ); ?></label>
											</div>
											<!--<div class="sqw-margin-top">
												<input class="sqw-radio" id="red" type="radio" name="btheme" value="red"/><label for="red"><?php _e( 'Red' ); ?></label>
											</div>
											<div class="sqw-margin-top">
												<input class="sqw-radio" id="purple" type="radio" name="btheme" value="purple"/><label for="purple"><?php _e( 'Purple' ); ?></label>
											</div>
											<div class="sqw-margin-top">
												<input class="sqw-radio" id="green" type="radio" name="btheme" value="green"/><label for="green"><?php _e( 'Green' ); ?></label>
											</div>-->
										</div>
									</div>
									<div class="sqw-tiers">
										<p><?php _e( 'Preview :' ); ?></p>
									</div>
								</div>
							</div>
							<div class="sqw-clear">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="sqw-integer">
				<div class="sqw-box sqw-right">
					<div class="sqw-analytics">
						<div class="sqw-header">
							<h3 class="sqw-title sqw-title-analytics <?php echo ( get_option( 'sqw_analytics' ) ? 'sqw-title-analytics-color' : '' ) ?>">
								<?php _e( 'Activate Adblockers Manager' ); ?>
							</h3><div class="sqw-tack sqw-tack-big <?php echo ( get_option( 'sqw_analytics' ) ? 'sqw-tack-big-check sqw-red' : '' ); ?>" name="analytics" data-color="red"><div></div></div>
							<input type="hidden" class="sqw-analytics-input" name="sqw_analytics" value="<?php echo get_option( 'sqw_analytics' ); ?>"/>
						</div>
						<p class="sqw-body basic-font-10"><?php _e( 'If you have ads on your website, the SQweb plugin allows you to resolve the adblocking problem.' ); ?> <a href="https://www.sqweb.com/publishers"><?php _e( 'More infos' ); ?></a></p>
						<div class="sqw-analytics-body sqw-body <?php echo ( get_option( 'sqw_analytics' ) ? '' : 'sqw-hide' ); ?>">
							<h4><?php _e( 'Would you like to display a message to your adblockers ?' ); ?></h4><div class="sqw-tack sqw-tack-basic <?php echo ( ! empty( $fmes ) ? 'sqw-tack-basic-check sqw-red' : '' ); ?>" name="sqw-message" data-color="red"><div></div></div>
							<div class="sqw-message sqw-center <?php echo ( ! empty( $fmes ) ? '' : 'sqw-hide' ); ?>">
								<h5><?php _e( 'Enter message to show at adblockers', 'sqweb' ); ?></h4>
								<textarea class="sqw-textarea" placeholder="Message" name="fmes"><?php echo stripslashes( $fmes ); ?></textarea>
								<span class="sqw-info sqw-title-analytics"><?php _e( 'The message will be shown in a banner at the bottom of the window.', 'sqweb' ); ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="sqw-clear"></div>
			<div class="sqw-center">
				<button type="submit" class="sqw-save"><?php _e( 'Save' ); ?></button>
			</div>
		</div>
	</form>
	<?php } ?>
</div>
