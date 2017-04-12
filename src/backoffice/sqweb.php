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
					<?php _e( 'Log in', 'sqweb' ); ?>
				</div>
				<div class="sqw-tab-select sqw-tab-subscribe">
					<?php _e( 'Register', 'sqweb' ); ?>
				</div>
			</div>
			<div class="sqw-clear"></div>
			<div class="sqw-form">
				<form action="<?php echo sqw_site_url() . $_SERVER['REQUEST_URI'] ?>&type=login" method="post">
					<input type="email" class="sqw-form-email" name="sqw-emailc" placeholder="<?php _e( 'Email' ); ?>">
					<input type="password" class="sqw-form-password" name="sqw-passwordc" placeholder="<?php _e( 'Password' ); ?>">
					<button type="submit"><?php _e( 'Log in', 'sqweb' ); ?></button>
				</form>
			</div>
			<div class="sqw-form sqw-hide">
				<form action="<?php echo sqw_site_url() . $_SERVER['REQUEST_URI'] ?>&type=subscribe" method="post">
					<input type="text" name="sqw-firstname" placeholder="<?php _e( 'First name', 'sqweb' ); ?>">
					<input type="text" name="sqw-lastname" placeholder="<?php _e( 'Last name', 'sqweb' ); ?>">
					<input type="email" class="sqw-form-email" name="sqw-email" placeholder="<?php _e( 'Email', 'sqweb' ); ?>">
					<input type="password" class="sqw-form-password" name="sqw-password" placeholder="<?php _e( 'Password', 'sqweb' ); ?>">
					<input type="password" class="sqw-form-password" name="sqw-confirmp" placeholder="<?php _e( 'Confirm password', 'sqweb' ); ?>">
					<button type="submit"><?php _e( 'Subscribe', 'sqweb' ); ?></button>
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
								<?php _e( 'Activate Multipass', 'sqweb' ); ?>
							</h3><div class="sqw-tack sqw-tack-big <?php echo ( get_option( 'sqw_multipass' ) ? 'sqw-tack-big-check sqw-green' : '' ); ?>" name="multipass" data-color="green"><div></div></div>
							<input type="hidden" class="sqw-multipass-input" name="sqw_multipass" value="<?php echo get_option( 'sqw_multipass' ); ?>"/>
						</div>
						<div class="sqw-clear"></div>
						<p class="sqw-body basic-font-10"><?php _e( 'Multipass subscribers access the premium version of partner websites. The 9,90€ subscription will be shared between publishers based on the time spent on each website.', 'sqweb' ); ?> <a href="https://www.sqweb.com/publishers"><?php _e( 'More infos', 'sqweb' ); ?></a></p>
						<div class="sqw-multipass-body sqw-body <?php echo ( get_option( 'sqw_multipass' ) ? '' : 'sqw-hide' ); ?>">
							<h4><?php _e( 'Do you want to restrict some content for free users ?', 'sqweb' ); ?></h4><div class="sqw-tack sqw-tack-basic <?php echo ( get_option( 'cutartperc' ) !== false || get_option( 'artbyday' ) !== false || get_option( 'dateart' ) !== false || unserialize( get_option( 'categorie' ) ) ? 'sqw-tack-basic-check sqw-green' : '' ); ?>" name="sqw-paywall" data-color="green"><div></div></div>
							<div class="sqw-paywall <?php echo ( get_option( 'cutartperc' ) !== false || get_option( 'artbyday' ) !== false || get_option( 'dateart' ) !== false || unserialize( get_option( 'categorie' ) ) ? '' : 'sqw-hide' ); ?>">
								<div class="sqw-check-categorie">
									<p><?php _e( 'Setup content restrictions :', 'sqweb' ); ?></p>
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
								<div class="sqw-check-prior-paywall sqw-clear">
									<div>
										<input type="checkbox" name="sqw_prior_paywall" id="sqw_prior_paywall" value="true" <?php echo ( get_option( 'sqw_prior_paywall' ) ? 'checked' : '' ) ?>/>
										<label for="sqw_prior_paywall"><?php _e( 'Prioritize Multipass over other paywalls', 'sqweb' ); ?></label>
									</div>
								</div>
								<div class="sqw-selector sqw-clear">
									<div class="sqw-select">
										<h5><?php _e( 'I want a part of my content to be displayed for non paying users.', 'sqweb' ); ?></h5>
										<div class="sqw-tack sqw-tack-basic <?php echo ( get_option( 'cutartperc' ) !== false ? 'sqw-tack-basic-check sqw-green' : '' ); ?>" name="sqw-fading-art" data-color="green"><div></div></div>
										<p><?php _e( '(if you use this option only the beginning of the post will be displayed)', 'sqweb' ); ?></p>
										<div class="sqw-fading-art sqw-center sqw-safe-padding <?php echo ( get_option( 'cutartperc' ) !== false ? '' : 'sqw-hide' ); ?>">
											<p><?php _e( 'How much % of the articles do you want to show free users ?', 'sqweb' ); ?></p>
											<p><?php _e( '(Free users and search engines will see this)', 'sqweb' ); ?></p>
											<input type="number" name="perctart" min="0" max="100" value="<?php echo ( get_option( 'cutartperc' ) !== false ? get_option( 'cutartperc' ) : '' ); ?>"/><span class="basic-font-10"> %</span>
										</div>
									</div>
									<div class="sqw-select">
										<h5><?php _e( 'Start restricting content after a number of page views.', 'sqweb' ); ?></h5>
										<div class="sqw-tack sqw-tack-basic <?php echo ( get_option( 'artbyday' ) !== false ? 'sqw-tack-basic-check sqw-green' : '' ); ?>" name="sqw-number-art" data-color="green"><div></div></div>
										<p><?php _e( '(This means any user will see part of your content and they will be blocked)', 'sqweb' ); ?></p>
										<div class="sqw-number-art sqw-center sqw-safe-padding <?php echo ( get_option( 'artbyday' ) !== false ? '' : 'sqw-hide' ); ?>">
											<p><?php _e( 'How many articles free users can see daily before being blocked ?', 'sqweb' ); ?></p>
											<input type="number" min="0" max="100" value="<?php echo ( get_option( 'artbyday' ) !== false ? get_option( 'artbyday' ) : '' ); ?>" name="artbyday"/><span class="basic-font-10"> <?php _e( 'Articles per day', 'sqweb' ); ?></span>
										</div>
									</div>
									<div class="sqw-select">
										<h5><?php _e( 'I want the posts to be available to non paying users after some days.', 'sqweb' ); ?></h5>
										<div class="sqw-tack sqw-tack-basic <?php echo ( get_option( 'dateart' ) !== false ? 'sqw-tack-basic-check sqw-green' : '' ); ?>" name="sqw-time-art" data-color="green"><div></div></div>
										<div class="sqw-time-art sqw-center sqw-safe-padding <?php echo ( get_option( 'dateart' ) !== false ? '' : 'sqw-hide' ); ?>">
											<p><?php _e( 'How many days will the posts remain restricted ?', 'sqweb' ); ?></p>
											<input type="number" min="0" max="365" value="<?php echo ( get_option( 'dateart' ) !== false ? get_option( 'dateart' ) : '' ); ?>" name="dateart"/><span class="basic-font-10"> <?php _e( 'days before end of restriction', 'sqweb' ); ?></span>
										</div>
									</div>
									<div class="sqw-check-user-rank">
										<p><?php _e( 'Do not restrict content to the following user groups :', 'sqweb' ); ?></p>
										<?php
											$sexept_role = unserialize( get_option( 'sqw_exept_role' ) );
											$exept_role = get_editable_roles();
										if ( ! is_array( $sexept_role ) ) {
											$sexept_role = array_keys( $exept_role );
										}
											$i = 0;
										foreach ( $exept_role as $key => $value ) {
											$i++;
											echo '
													<div>
														<input type="checkbox" name="exept_role[]" id="' . $key . '" value="' . $key . '" ' . ( in_array( $key, $sexept_role ) ? 'checked' : '' ) . '/>
														<label for="' . $key . '">' . $value['name'] . '</label>
													</div>';
										}
										?>
									</div>
									<div class="sqw-clear"></div>
								</div>
							</div>
							<div class="sqw-config-button">
								<p class="sqw-center sqw-title-multipass-color basic-font-12"><?php _e( 'Multipass users must browse without ads on your website', 'sqweb' ); ?></p>
								<hr width='270px'></hr>
								<p class="sqw-center basic-font-12"><?php _e( 'This will be used for the button that visitors will use to register, payment and login.', 'sqweb' ); ?></p>
								<div class="sqw-full-width">
									<div class="sqw-tiers">
										<div class="sqw-margin-top">
											<p><label for="sqw-lang-select"><?php _e( 'Language of your website :', 'sqweb' ); ?></label></p>
											<select class="sqw-input-select" name="lang" id="sqw-lang-select">';
												<option value="fr" <?php echo 'fr' === $lang ? 'selected' : ''; ?>><?php _e( 'French', 'sqweb' ); ?></option>
												<option value="en" <?php echo 'en' === $lang ? 'selected' : ''; ?>><?php _e( 'English', 'sqweb' ); ?></option>
												<!--<option value="es" <?php echo 'es' === $lang ? 'selected' : ''; ?>><?php _e( 'Español', 'sqweb' ); ?></option>-->
											</select>
											<select class="sqw-input-select" id="sqw-previ-select">
												<option value="tiny"><?php _e( 'Tiny', 'sqweb' ); ?></option>
												<option value="slim"><?php _e( 'Slim', 'sqweb' ); ?></option>
												<option value="normal"><?php _e( 'Normal', 'sqweb' ); ?></option>
												<option value="large"><?php _e( 'Large', 'sqweb' ); ?></option>
											</select>
										</div>
									</div>
									<div class="sqw-tiers2 sqw-padding-left">
										<?php
										if ( function_exists( 'get_blog_details' ) ) {
											$current_site = get_blog_details();
											$blogname = $current_site->blogname;
										} else {
											$blogname = get_option( 'blogname' );
										}
										?>
										<p><?php _e( 'Preview :', 'sqweb' ); ?></p>
										<div class="sqweb-button multipass-large">
											<div class="sqw-btn-mp">
												<span class="sqw-btn-mp-logo"></span>
												<a onclick="sqw.modal_first()" class="sqw-btn-mp-link sqw-btn-mp-link-tiny-none">Premium avec Multipass</a>
												<a onclick="sqw.modal_first()" class="sqw-btn-mp-link sqw-btn-mp-link-tiny-only">Premium</a>
												<a onclick="sqw.modal_first()" class="sqw-btn-mp-link sqw-btn-mp-link-large-only">
													<b>
													<?php echo $blogname ?> PREMIUM</b>
													<br><span id="sqw-punch-line">Lecture Illimitée • Zéro Pub</span>
												</a>
											</div>
										</div>
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
						<p class="sqw-body basic-font-10"><?php _e( 'The Adblock Manager gives you tools to mitigate adblocking.', 'sqweb' ); ?> <a href="https://www.sqweb.com/publishers"><?php _e( 'More infos' ); ?></a></p>
						<div class="sqw-analytics-body sqw-body <?php echo ( get_option( 'sqw_analytics' ) ? '' : 'sqw-hide' ); ?>">
							<div class="sqw-margin-top">
								<h4><?php _e( 'Would you like to display a dynamic popup to your adblockers ?', 'sqweb' ); ?></h4><div class="sqw-tack sqw-tack-basic <?php echo ( get_option( 'sqw_popup' ) ? 'sqw-tack-basic-check sqw-red' : '' ); ?>" name="sqw-popup" data-color="red" data-type="popup"><div></div></div>
								<input type="checkbox" value="true" name="sqw_popup" id="checkbox_popup" style="display:none;" <?php echo ( get_option( 'sqw_popup' ) ? 'checked' : '' ) ?>>
							</div>
							<div class="sqw-margin-top">
								<h4><?php _e( 'Would you like to display a message to your adblockers ?', 'sqweb' ); ?></h4><div class="sqw-tack sqw-tack-basic <?php echo ( ! empty( $fmes ) ? 'sqw-tack-basic-check sqw-red' : '' ); ?>" name="sqw-message" data-color="red" data-type="message"><div></div></div>
							</div>
							<div class="sqw-message sqw-center <?php echo ( ! empty( $fmes ) ? '' : 'sqw-hide' ); ?>">
								<h5><?php _e( 'Message shown to your adblockers', 'sqweb' ); ?></h4>
								<textarea class="sqw-textarea" placeholder="Message" name="fmes"><?php echo stripslashes( $fmes ); ?></textarea>
								<span class="sqw-info sqw-title-analytics"><?php _e( 'The message will be shown in a banner at the bottom of the window.', 'sqweb' ); ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="sqw-clear"></div>
			<div class="sqw-center">
				<button type="submit" class="sqw-save"><?php _e( 'Save', 'sqweb' ); ?></button>
			</div>
		</div>
	</form>
	<?php } // End if(). ?>
</div>

<script>

var adb_default_message = '<?php _e( 'If you want a better experience on our website you can get <a href="#" onclick="sqw.modal_first()" class="sqw-btn-link" style="color:white !important;">your Multipass</a> to surf without ads and access premium content on all partner websites.', 'sqweb' ); ?>';

</script>
