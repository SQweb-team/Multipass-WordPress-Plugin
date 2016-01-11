<div class="sqw-auth-box">
	<h2>
		<?php _e( 'Sign in', 'sqweb' ); ?>
	</h2>
	<?php
	if ( 1 == $errorc ) {
	?>
	<span class="sqw-error">
		<?php _e( 'You need to fill in all fields', 'sqweb' ); ?>
	</span>
	<?php
	}
	if ( isset( $_GET['success'] ) && 'true' == $_GET['success'] ) {
	?>
	<span class="sqw-success">
		<?php _e( 'You signed up successfuly.', 'sqweb' ); ?>
	</span>
	<?php } ?>
	<form action="<?php echo remove_query_arg( 'success' ) ?>" method="post" name="sqw-auth">
		<label for="email">
			<?php _e( 'Email', 'sqweb' ); ?>
		</label>
		<input class="sqweb-admin-auth-input" type="text" name="sqw-emailc" value="" placeholder="email" />
		<label for="password">
			<?php _e( 'Password', 'sqweb' ); ?>
		</label>
		<input class="sqweb-admin-auth-input" type="password" name="sqw-passwordc" value="" placeholder="<?php _e( 'password', 'sqweb' ); ?>" />
		<input class="button button-primary button-large sqweb-admin-auth-button" type="submit" name="Submit" value="<?php _e( 'Sign in', 'sqweb' ); ?>" />
	</form>
	<div class="sqw-signup">
		<?php echo '<a href="' . add_query_arg( array( 'action' => 'signup' ) ) . '">'; ?>
			<span class="sqweb-ctr-link">
				<?php _e( 'Don\'t have an account ?', 'sqweb' ); ?>
			</span>
			<span class="sqweb-ctr-link">
				<?php _e( 'Sign up for free in 30 seconds !', 'sqweb' ); ?>
			</span>
		</a>
	</div>
	<a target="_blank" href="https://www.sqweb.com/password/email">
		<span class="sqweb-ctr-link">
			<?php _e( 'Forgot your password ?', 'sqweb' ); ?>
		</span>
	</a>
</div>
