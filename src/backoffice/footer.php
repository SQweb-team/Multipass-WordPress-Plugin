<div class="sqw-admin-b-right" style="text-align: center;">
	<a href="https://www.sqweb.com/dashboard/support">
		<?php _e( 'Besoin d\'aide ?', 'sqweb' ) ?>
	</a>
	<?php
	if ( ! empty( $sqw_token )  || '0' != $signinr ) {
	?>
	 | <a href="<?php echo add_query_arg( 'logout', '1' ) ?>"><?php _e( 'Logout', 'sqweb' ) ?></a>
	<?php
	}
	?>
</div>
