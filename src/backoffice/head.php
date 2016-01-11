<div class="sqw-logo-block">
	<a href="https://www.sqweb.com" target="_blank">
		<img class="sqw-logo" src="<?php echo plugins_url( '../resources/img/sqweb_logo.png', __FILE__ ); ?>">
	</a>
	<div class="sqw-admin-b-right">
    <?php
	if ( ! empty( $sqw_token )  || '0' != $signinr ) {
		echo '<a href="' . add_query_arg( 'logout', '1' ) . '">'. __( 'Logout', 'sqweb' ) .'</a>';
	}
	?>
	</div>
</div>
