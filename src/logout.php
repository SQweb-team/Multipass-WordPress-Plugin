<?php
function sqw_logout() {
	echo '<a href=' . add_query_arg( 'logout', '1' ) . " style='position: absolute; bottom: 32px; right: 20px; text-decoration: none; height: 18px'>" . __( 'Logout from SQweb', 'sqweb' ) . '</p>';
}
	add_action( 'admin_footer', 'sqw_logout', 1 );
