<div class="sqw-admin-b-right" style="text-align: center;">
	<a href="https://www.sqweb.com/dashboard/support">
		<?php _e( 'Need help ?', 'sqweb' ) ?>
	</a>
	<?php
	if ( ! empty( $sqw_token ) ) {
	?>
	 | <a href="<?php echo add_query_arg( 'logout', '1' ) ?>"><?php _e( 'Logout', 'sqweb' ) ?></a>
	<?php
	}
	?>
</div>
