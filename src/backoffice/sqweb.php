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
				<form action="<?php echo sqw_site_url() . $_SERVER['REQUEST_URI']; ?>&type=login" method="post">
					<input type="email" class="sqw-form-email" name="sqw-emailc" placeholder="<?php _e( 'Email' ); ?>">
					<input type="password" class="sqw-form-password" name="sqw-passwordc" placeholder="<?php _e( 'Password' ); ?>">
					<button type="submit"><?php _e( 'Log in', 'sqweb' ); ?></button>
				</form>
			</div>
			<div class="sqw-form sqw-hide">
				<form action="<?php echo sqw_site_url() . $_SERVER['REQUEST_URI']; ?>&type=subscribe" method="post">
					<input type="text" name="sqw-firstname" placeholder="<?php _e( 'First name', 'sqweb' ); ?>">
					<input type="text" name="sqw-lastname" placeholder="<?php _e( 'Last name', 'sqweb' ); ?>">
					<input type="email" class="sqw-form-email" name="sqw-email" placeholder="<?php _e( 'Email', 'sqweb' ); ?>">
					<input type="password" class="sqw-form-password" name="sqw-password" placeholder="<?php _e( 'Password', 'sqweb' ); ?>">
					<input type="password" class="sqw-form-password" name="sqw-confirmp" placeholder="<?php _e( 'Confirm password', 'sqweb' ); ?>">
					<button type="submit"><?php _e( 'Subscribe', 'sqweb' ); ?></button>
				</form>
			</div>
			<div style="text-align:center;" class="">
				<form action="<?php echo sqw_site_url() . $_SERVER['REQUEST_URI']; ?>&type=diagnostic" method="post">
					<button class="sqw-diagnostic" type="submit"><?php _e( 'A problem ? Send us your diagnostic', 'sqweb' ); ?></button>
				</form>
			</div>
		</div>
	</div>
	<?php } else { ?>
	<form action="<?php echo sqw_site_url() . $_SERVER['REQUEST_URI']; ?>&type=save" method="post">
		<div class="sqw-config">
			<div class="sqw-integer">
				<div class="sqw-box sqw-left">
					<div class="sqw-multipass">
						<div class="sqw-header">
							<h3 class="sqw-title sqw-title-multipass <?php echo ( get_option( 'sqw_multipass' ) ? 'sqw-title-multipass-color' : '' ); ?>">
								<?php _e( 'Activate Multipass', 'sqweb' ); ?>
							</h3><div class="sqw-tack sqw-tack-big <?php echo ( get_option( 'sqw_multipass' ) ? 'sqw-tack-big-check sqw-green' : '' ); ?>" name="multipass" data-color="green"><div></div></div>
							<input type="hidden" class="sqw-multipass-input" name="sqw_multipass" value="<?php echo get_option( 'sqw_multipass' ); ?>"/>
						</div>
						<div class="sqw-clear"></div>
						<p class="sqw-body basic-font-10"><?php _e( 'Multipass subscribers access the premium version of partner websites. The 9,90€ subscription will be shared between publishers based on the time spent on each website.', 'sqweb' ); ?> <a href="https://www.sqweb.com/publishers"><?php _e( 'More infos', 'sqweb' ); ?></a></p>
						<div class="sqw-multipass-body sqw-body <?php echo ( get_option( 'sqw_multipass' ) ? '' : 'sqw-hide' ); ?>">
							<div class="sqw-select-lang">
								<h4><?php _e( 'In which language should users see the plugin ?', 'sqweb' ); ?></h4>
								<select class="sqw-select-lang-tag" name="sqw_lang">
									<option value="fr_FR" <?php echo ( get_option( 'sqw_lang' ) === 'fr_FR' ? 'selected' : '' ); ?> ><?php _e( 'French', 'fr' ); ?></option>
									<option value="en_US" <?php echo ( get_option( 'sqw_lang' ) === 'en_US' ? 'selected' : '' ); ?> ><?php _e( 'English', 'en' ); ?></option>
								</select>
							</div>
							<div style="margin-bottom: 20px" class="sqw-support-button">
								<h4><?php _e( 'Do you want Multipass user to be logged in automatically ?', 'sqweb' ); ?></h4>
								<div id="sqw_autologin_trigger" class="sqw-tack sqw-tack-basic <?php echo ( get_option( 'sqw_autologin' ) == 0 ? 'sqw-tack-basic-check sqw-green' : '' ); ?>" name="sqw_autologin" data-color="green"><div></div></div>
								<input type="hidden" id="sqw_autologin" name="sqw_autologin" value="<?php echo get_option( 'sqw_autologin' ); ?>">
							</div>
							<h4 class="sqw-margin-top"><?php _e( 'Do you want to restrict access to some content ?', 'sqweb' ); ?></h4><div class="sqw-tack sqw-tack-basic <?php echo ( get_option( 'cutartperc' ) !== false || get_option( 'artbyday' ) !== false || get_option( 'dateart' ) !== false || get_option( 'sqw_filter_all' ) !== false || get_option( 'archiveart' ) !== false || unserialize( get_option( 'categorie' ) ) ? 'sqw-tack-basic-check sqw-green' : '' ); ?>" id="sqw-paywall" name="sqw-paywall" data-color="green"><div></div></div>
							<div class="sqw-paywall <?php echo ( get_option( 'cutartperc' ) !== false || get_option( 'artbyday' ) !== false || get_option( 'dateart' ) !== false || get_option( 'sqw_filter_all' ) !== false || get_option( 'archiveart' ) !== false || unserialize( get_option( 'categorie' ) ) ? '' : 'sqw-hide' ); ?>">
								<div class="sqw-selector sqw-clear">
									<div class="sqw-select">
										<div class="sqw-fading-art sqw-center">
											<p><?php _e( 'What percentage of the articles do you want to show free users ?', 'sqweb' ); ?></p>
											<p><?php _e( '(Free users and search engines will see this)', 'sqweb' ); ?></p>
											<input type="number" name="perctart" min="0" max="100" value="<?php echo ( get_option( 'cutartperc' ) !== false ? get_option( 'cutartperc' ) : '' ); ?>"/><span class="basic-font-10"> %</span>
										</div>
									</div>
								</div>
								<div class="sqw-check-categorie sqw-filter-all">
									<input type="checkbox" name="sqw_filter_all" id="sqw_filter_all" value="true" <?php echo ( get_option( 'sqw_filter_all' ) !== false ? 'checked' : '' ); ?>><label for="sqw_filter_all"><?php _e( 'Restrict all posts of all categories', 'sqweb' ); ?></label>
								</div>
								<div class="sqw-check-categorie">
									<p><?php _e( 'Restrict specific categories :', 'sqweb' ); ?></p>
									<?php
										$scategorie = unserialize( get_option( 'categorie' ) );
									if ( ! $scategorie ) {
										$scategorie = array();
									}
										$categorie = get_categories();
										$i         = 0;
									foreach ( $categorie as $value ) {
										$i++;
										echo '
											<div>
												<input class="categories_inputs" type="checkbox" name="categorie[]" id="' . $value->slug . '" value="' . $value->slug . '" ' . ( in_array( $value->slug, $scategorie ) ? 'checked' : '' ) . ( get_option( 'sqw_filter_all' ) !== false ? ' disabled' : '' ) . '/>
												<label for="' . $value->slug . '">' . $value->name . '</label>
											</div>';
									}
									?>
								</div>
								<div class="sqw-check-prior-paywall sqw-clear">
									<div>
										<input type="checkbox" name="sqw_prior_paywall" id="sqw_prior_paywall" value="true" <?php echo ( get_option( 'sqw_prior_paywall' ) ? 'checked' : '' ); ?>/>
										<label for="sqw_prior_paywall"><?php _e( 'Prioritize Multipass over other paywalls', 'sqweb' ); ?></label>
									</div>
								</div>
								<div class="sqw-selector sqw-clear">
									<div class="sqw-select">
										<h5><?php _e( 'Start restricting content after a number of page views.', 'sqweb' ); ?></h5>
										<div class="sqw-tack sqw-tack-basic <?php echo ( get_option( 'artbyday' ) !== false ? 'sqw-tack-basic-check sqw-green' : '' ); ?>" name="sqw-number-art" data-color="green"><div></div></div>
										<p><?php _e( '(How many posts can be read for free by a user before beeing asked to pay)', 'sqweb' ); ?></p>
										<div class="sqw-number-art sqw-center sqw-safe-padding <?php echo ( get_option( 'artbyday' ) !== false ? '' : 'sqw-hide' ); ?>">
											<p><?php _e( 'How many articles free users can see daily before being blocked ?', 'sqweb' ); ?></p>
											<input type="number" min="0" max="100" value="<?php echo ( get_option( 'artbyday' ) !== false ? get_option( 'artbyday' ) : '' ); ?>" name="artbyday"/><span class="basic-font-10"> <?php _e( 'Articles per day', 'sqweb' ); ?></span>
										</div>
									</div>
									<div class="sqw-select">
										<h5><?php _e( 'Do you want premium posts to be available to free users after some time ?', 'sqweb' ); ?></h5>
										<div class="sqw-tack sqw-tack-basic <?php echo ( get_option( 'dateart' ) !== false ? 'sqw-tack-basic-check sqw-green' : '' ); ?>" name="sqw-time-art" data-color="green"><div></div></div>
										<div class="sqw-time-art sqw-center sqw-safe-padding <?php echo ( get_option( 'dateart' ) !== false ? '' : 'sqw-hide' ); ?>">
											<p><?php _e( 'How many days will the posts remain restricted after publication ?', 'sqweb' ); ?></p>
											<input type="number" min="0" max="365" value="<?php echo ( get_option( 'dateart' ) !== false ? get_option( 'dateart' ) : '' ); ?>" name="dateart"/><span class="basic-font-10"> <?php _e( 'days before paywall unlock', 'sqweb' ); ?></span>
										</div>
									</div>
									<div class="sqw-select">
										<h5><?php _e( 'Do you want archives (old posts) to be restricted after some time ?', 'sqweb' ); ?></h5>
										<div class="sqw-tack sqw-tack-basic <?php echo ( get_option( 'archiveart' ) !== false ? 'sqw-tack-basic-check sqw-green' : '' ); ?>" name="sqw-archive-art" data-color="green"><div></div></div>
										<div class="sqw-archive-art sqw-center sqw-safe-padding <?php echo ( get_option( 'archiveart' ) !== false ? '' : 'sqw-hide' ); ?>">
											<p><?php _e( 'How many days after publication will the posts remain free ?' ); ?></p>
											<input type="number" min="0" max="365" value="<?php echo ( get_option( 'archiveart' ) !== false ? get_option( 'archiveart' ) : '' ); ?>" name="archiveart"/><span class="basic-font-10"> <?php _e( 'days before paywall lock', 'sqweb' ); ?></span>
										</div>
									</div>
									<div class="sqw-check-user-rank">
										<p><?php _e( 'Do not restrict content to the following user groups :', 'sqweb' ); ?></p>
										<?php
											$sexept_role = unserialize( get_option( 'sqw_exept_role' ) );
											$exept_role  = get_editable_roles();
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
							<div class="sqw-support-button">
								<h4><?php _e( 'Do you want to display a "Support us" message at the end of your posts ?', 'sqweb' ); ?></h4>
								<div id="sqw_display_support_trigger" class="sqw-tack sqw-tack-basic <?php echo ( get_option( 'sqw_display_support' ) != 0 ? 'sqw-tack-basic-check sqw-green' : '' ); ?>" name="sqw_display_support" data-color="green"><div></div></div>
								<input type="hidden" id="sqw_display_support" name="sqw_display_support" value="<?php echo get_option( 'sqw_display_support' ); ?>">
							</div>
							<div class="sqw-support-button-preview <?php echo ( get_option( 'sqw_display_support' ) ? '' : 'sqw-hide' ); ?>">
								<?php echo sqw_support_button_html(); ?>
							</div>
							<!-- <div class="sqw-support-button">
								<input class="sqw-checkbox-border" <?php echo ( get_option( 'sqw_php_parsing' ) ? 'checked' : '' ); ?> type="checkbox" name="sqw_php_parsing">
								<h4><?php _e( 'Enable php parsing in text widgets (this might be needed to filter ads in your theme template)', 'sqweb' ); ?></h4>
							</div> -->
							<div class="sqw-config-button">
								<p class="sqw-center sqw-title-multipass-color basic-font-12"><?php _e( 'Multipass users must browse without ads on your website', 'sqweb' ); ?></p>
								<hr width='270px'></hr>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="sqw-integer">
				<div class="sqw-box sqw-right">
					<div>
						<div class="sqw-header">
							<h3 class="sqw-title sqw-title-multipass sqw-title-multipass-color">
								<?php _e( 'Customize the Multipass button', 'sqweb' ); ?>
							</h3>
						</div>
						<div class="sqw-clear"></div>
						<div class="sqw-body sqw-customize-btn-split-half">
							<h4><?php _e( 'Tiny button', 'sqweb' ); ?></h4>
							<div class="sqweb-button-support multipass-tiny sqw-margin-top">
								<div class="sqw-btn-mp">
									<input name="sqw_btn_login_tiny" type="text" class="sqw-btn-mp-link sqw-btn-mp-link-tiny-only sqw-input-customize-btn sqw-input-customize-btn-tiny" value="<?php echo get_option( 'sqw_btn_login_tiny' ) != '' ? get_option( 'sqw_btn_login_tiny' ) : _e( 'Premium', 'sqweb' ); ?>" maxlength="7">
								</div>
							</div>
						</div>
						<div class="sqw-body sqw-customize-btn-split-half">
							<h4><?php _e( 'Tiny button when logged in', 'sqweb' ); ?></h4>
							<div class="sqweb-button-support multipass-tiny sqw-margin-top">
								<div class="sqw-btn-mp">
									<input name="sqw_btn_connected_tiny" type="text" class="sqw-btn-mp-link sqw-btn-mp-link-tiny-only sqw-input-customize-btn sqw-input-customize-btn-tiny" value="<?php echo get_option( 'sqw_btn_connected_tiny' ) != '' ? get_option( 'sqw_btn_connected_tiny' ) : _e( 'Premium', 'sqweb' ); ?>" maxlength="7">
									<a class="sqw-btn-mp-logout"></a>
								</div>
							</div>
						</div>
						<hr width='270px'></hr>
						<div class="sqw-clear"></div>
						<div class="sqw-body">
							<h4><?php _e( 'Regular button', 'sqweb' ); ?></h4>
							<div class="sqweb-button-support sqw-margin-top">
								<div class="sqw-btn-mp">
									<span class="sqw-btn-mp-logo"></span>
									<input name="sqw_btn_login" type="text" class="sqw-btn-mp-link sqw-btn-mp-link-tiny-none sqw-input-customize-btn sqw-input-customize-btn-regular sqw-input-customize-btn-regular-logged-out" value="<?php echo get_option( 'sqw_btn_login' ) != '' ? get_option( 'sqw_btn_login' ) : _e( 'Premium with Multipass', 'sqweb' ); ?>" maxlength="28">
								</div>
							</div>
						</div>
						<div class="sqw-body">
							<h4><?php _e( 'Regular button when connected', 'sqweb' ); ?></h4>
							<div class="sqweb-button-support sqw-margin-top">
								<div class="sqw-btn-mp">
									<span class="sqw-btn-mp-logo"></span>
									<input name="sqw_btn_connected" type="text" class="sqw-btn-mp-link sqw-btn-mp-link-tiny-none sqw-input-customize-btn sqw-input-customize-btn-regular" value="<?php echo get_option( 'sqw_btn_connected' ) != '' ? get_option( 'sqw_btn_connected' ) : _e( 'Logged in with Multipass', 'sqweb' ); ?>" maxlength="25">
									<a class="sqw-btn-mp-logout"></a>
								</div>
							</div>
						</div>
						<hr width='270px'></hr>
						<div class="sqw-clear"></div>
						<div class="sqw-body">
							<h4><?php _e( 'Support us button', 'sqweb' ); ?></h4>
							<div class="sqweb-button-support sqw-margin-top">
								<div class="sqw-btn-mp">
									<span class="sqw-btn-mp-logo"></span>
									<input name="sqw_btn_support" type="text" class="sqw-btn-mp-link sqw-btn-mp-link-tiny-none sqw-input-customize-btn sqw-input-customize-btn-regular sqw-input-customize-btn-regular-logged-out" value="<?php echo get_option( 'sqw_btn_support' ) != '' ? get_option( 'sqw_btn_support' ) : _e( 'Support us with Multipass', 'sqweb' ); ?>" maxlength="28">
								</div>
							</div>
						</div>
						<div class="sqw-body">
							<h4><?php _e( 'Support us button when connected', 'sqweb' ); ?></h4>
							<div class="sqweb-button-support sqw-margin-top">
								<div class="sqw-btn-mp">
									<span class="sqw-btn-mp-logo"></span>
									<input name="sqw_btn_connected_support" type="text" class="sqw-btn-mp-link sqw-btn-mp-link-tiny-none sqw-input-customize-btn sqw-input-customize-btn-regular" value="<?php echo get_option( 'sqw_btn_connected_support' ) != '' ? get_option( 'sqw_btn_connected_support' ) : _e( 'Support us with Multipass', 'sqweb' ); ?>" maxlength="25">
									<a class="sqw-btn-mp-logout"></a>
								</div>
							</div>
						</div>
						<hr width='270px'></hr>
						<div class="sqw-clear"></div>
						<div class="sqw-body">
							<h4><?php _e( 'Large button', 'sqweb' ); ?></h4>
							<div class="sqweb-button multipass-large sqw-margin-top">
								<div class="sqw-btn-mp">
									<span class="sqw-btn-mp-logo"></span>
									<span class="sqw-btn-mp-link sqw-btn-mp-link-large-only">
										<b><?php echo ( get_option( 'blogname' ) ); ?> PREMIUM</b>
										<br>
										<input name="sqw_btn_unlimited" type="text" class="sqw-input-customize-btn sqw-input-customize-btn-large-before-dot" value="<?php echo get_option( 'sqw_btn_unlimited' ) != '' ? get_option( 'sqw_btn_unlimited' ) : _e( 'Unrestricted access', 'sqweb' ); ?>" maxlength="16">
										<span style="margin-left: -2px;">•</span>
										<input name="sqw_btn_noads" type="text" class="sqw-input-customize-btn sqw-input-customize-btn-large-after-dot" value="<?php echo get_option( 'sqw_btn_noads' ) != '' ? get_option( 'sqw_btn_noads' ) : _e( 'No ads', 'sqweb' ); ?>" maxlength="11">
									</span>
								</div>
							</div>
						</div>
						<div class="sqw-body">
							<h4><?php _e( 'Large button when connected', 'sqweb' ); ?></h4>
							<div class="sqweb-button multipass-large sqw-margin-top">
								<div class="sqw-btn-mp">
									<span class="sqw-btn-mp-logo"></span>
									<span class="sqw-btn-mp-link sqw-btn-mp-link-large-only">
										<b><?php echo ( get_option( 'blogname' ) ); ?> PREMIUM</b>
										<br>
										<input name="sqw_btn_connected_s" type="text" class="sqw-input-customize-btn sqw-input-customize-btn-large-logged-in" value="<?php echo get_option( 'sqw_btn_connected_s' ) != '' ? get_option( 'sqw_btn_connected_s' ) : _e( 'Logged in', 'sqweb' ); ?>" maxlength="25">
									</span>
									<a class="sqw-btn-mp-logout"></a>
								</div>
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
	<?php
} // End if().
	?>
</div>

<script>

var adb_default_message = '<?php _e( 'If you want a better experience on our website you can get <a href="#" onclick="mltpss.modal_first()" class="sqw-btn-link" style="color:white !important;">your Multipass</a> to surf without ads and access premium content on all partner websites.', 'sqweb' ); ?>';

</script>
