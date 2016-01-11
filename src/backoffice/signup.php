<div class="sqw-auth-box">
	<h2>
		<?php _e( 'Sign up', 'sqweb' ); ?>
	</h2>
	<?php
	if ( isset( $error ) && 1 == $error ) {
	?>
	<span class="sqw-error">
		<?php _e( 'You need to fill in all fields', 'sqweb' ); ?>
	</span>
	<?php } ?>
	<form action="<?php echo sqw_site_url() . $_SERVER['REQUEST_URI'] ?>" method="post" name="sqw-auth">
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
		<input class="button button-primary button-large sqweb-admin-auth-button" type="submit" name="Submit" value="<?php _e( 'Sign up', 'sqweb' ); ?>" />
	</form>
	<div class="sqw-signup">
		<?php echo '<a href="' . remove_query_arg( 'action' ) . '"><span class="sqweb-ctr-link">'; ?><?php _e( 'Back to sign in', 'sqweb' ); ?></span></a>
	</div>
</div>
