<?php

if ( isset( $_GET['logout'] ) && 1 == $_GET['logout'] ) {
	delete_option( 'sqw_token' );
	wp_redirect( remove_query_arg( 'logout' ) );
	exit;
}

// Checking if options have yet been set
$sqw_token = (get_option( 'sqw_token' ) !== '') ? get_option( 'sqw_token' ) : '';
$wmid = (get_option( 'wmid' ) !== '') ? get_option( 'wmid' ) : '';
$wsid = (get_option( 'wsid' ) !== '') ? get_option( 'wsid' ) : '';
$flogin = (get_option( 'flogin' ) !== '') ? get_option( 'flogin' ) : 'Remove ads';
$flogout = (get_option( 'flogout' ) !== '') ? get_option( 'flogout' ) : 'Connected';
$fmes = (get_option( 'fmes' ) !== '') ? get_option( 'fmes' ) : '';
$fpubg = (get_option( 'fpubg' ) !== '') ? get_option( 'fpubg' ) : '';
$fpufc = (get_option( 'fpufc' ) !== '') ? get_option( 'fpufc' ) : '';
$btheme = (get_option( 'btheme' ) !== '') ? get_option( 'btheme' ) : 'blue';
$lang = (get_option( 'lang' ) !== '') ? get_option( 'lang' ) : 'en';
$targeting = (get_option( 'targets' ) !== '') ? get_option( 'targets' ) : 'false';

// Building the form
$errorc = 0;
$signinr = 0;
if ( isset( $_POST['sqw-emailc'] ) && isset( $_POST['sqw-passwordc'] ) ) {
	if ( ! empty( $_POST['sqw-emailc'] ) && ! empty( $_POST['sqw-passwordc'] ) ) {
		$signinr = sqweb_sign_in( $_POST['sqw-emailc'], $_POST['sqw-passwordc'] );
	} else {
		$errorc = 1;
	}
}
?>
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
<?php
if ( ! empty( $sqw_token ) || '0' != $signinr ) {
?>
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
			$selectfrlang = '';
			$selectenlang = '';
			$selectyestarget = '';
			$selectnotarget = '';
			if ( 'grey' == $btheme ) {
				$selectgtheme = 'selected';
			} else {
				$selectbtheme = 'selected';
			}
			if ( 'fr' == $lang ) {
				$selectfrlang = 'selected';
			} else {
				$selectenlang = 'selected';
			}
			if ( 'true' == $targeting ) {
				$selectyestarget = 'selected';
			} else {
				$selectnotarget = 'selected';
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
        <span class="sqweb-form-title"><?php _e( 'Step 3 : Messages you\'d like on the button', 'sqweb' ); ?></span>
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
        <span class="sqweb-form-title"><?php _e( 'Step 4 : choose the button color', 'sqweb' ); ?></span>
        <select class="sqweb-admin-input sqw-select" name="btheme" id="sqweb-color-select">';
         <option value="blue" <?php echo $selectbtheme ?>><?php _e( 'Blue', 'sqweb' ); ?></option>
         <option value="grey" <?php echo $selectgtheme ?>><?php _e( 'Grey', 'sqweb' ); ?></option>
        </select>
       </div>
       <div class="sqweb-form-div">
        <span class="sqweb-form-title"><?php _e( 'Step 5 : select lang', 'sqweb' ); ?></span>
        <select class="sqweb-admin-input sqw-select" name="lang" id="sqweb-color-select">';
         <option value="fr" <?php echo $selectfrlang ?>><?php _e( 'French', 'sqweb' ); ?></option>
         <option value="en" <?php echo $selectenlang ?>><?php _e( 'English', 'sqweb' ); ?></option>
        </select>
        </div>
        <div class="sqweb-form-div">
         <span class="sqweb-form-title"><?php _e( 'Step 6 : Display button', 'sqweb' ); ?></span>
         <select class="sqweb-admin-input sqw-select" name="targets" id="sqweb-color-select">';
       <option value="true" <?php echo $selectyestarget ?>><?php _e( 'Only to adblockers', 'sqweb' ); ?></option>
       <option value="false" <?php echo $selectnotarget ?>><?php _e( 'To everybody', 'sqweb' ); ?></option>
         </select>
        </div>
       <input type="hidden" name="page_options" value="wmid, wsid, flogin, flogout, fmes, btheme, lang, targets" />
       <input class="button button-primary button-large sqweb-admin-button" type="submit" name="Submit" value="<?php _e( 'Update', 'sqweb' ); ?>" />
         </form>
            <?php
		} else {
			echo '<p class="sqw-notice">', __( 'Woops! It looks like you havent registered your website yet', 'sqweb' ), '<br><a href="' . add_query_arg( 'website', 'add' ) . '">', __( 'Click here', 'sqweb' ), '</a> ', __( 'to start', 'sqweb' ), '</p>';
		}
	}
	?>
   </div>
    <?php
}
if ( ! empty( $sqw_token ) && 0 == $sqw_webmaster ) {
	delete_option( 'sqw_token' );
	wp_redirect( sqw_site_url() . $_SERVER['REQUEST_URI'] );
}
} else {
?>
<div class="sqw-auth-box">
<?php
if ( isset( $_GET['action'] ) && 'signup' == $_GET['action'] ) {
	if ( isset( $_POST ) && ( ! empty( $_POST['sqw-firstname'] ) || ! empty( $_POST['sqw-lastname'] ) || ! empty( $_POST['sqw-email'] ) || ! empty( $_POST['sqw-password'] ) ) ) {
		$error = 0;
		$r = sqweb_sign_up( $_POST['sqw-firstname'], $_POST['sqw-lastname'], $_POST['sqw-email'], $_POST['sqw-password'] );
		if ( 1 == $r ) {
			wp_redirect( add_query_arg( array( 'action' => 'signin', 'success' => 'true' ) ) );
			exit;
		}
	} elseif ( ! empty( $_POST ) ) {
		$error = 1;
	}
?>
<h2><?php _e( 'Sign up', 'sqweb' ); ?></h2>
<?php if ( isset( $error ) && 1 == $error ) {?><span class="sqw-error"><?php _e( 'You need to fill in all fields', 'sqweb' ); ?></span><?php
} ?>
<form action="<?php echo sqw_site_url() . $_SERVER['REQUEST_URI'] ?>" method="post" name="sqw-auth">
	<label for="firstname"><?php _e( 'Firstname', 'sqweb' ); ?></label>
	<input class="sqweb-admin-auth-input" type="text" name="sqw-firstname" value="" placeholder="firstname" />
	<label for="lastname"><?php _e( 'Lastname', 'sqweb' ); ?></label>
	<input class="sqweb-admin-auth-input" type="text" name="sqw-lastname" value="" placeholder="lastname" />
	<label for="email"><?php _e( 'Email', 'sqweb' ); ?></label>
	<input class="sqweb-admin-auth-input" type="text" name="sqw-email" value="" placeholder="email" />
	<label for="password"><?php _e( 'Password', 'sqweb' ); ?></label>
	<input class="sqweb-admin-auth-input" type="password" name="sqw-password" value="" placeholder="<?php _e( 'password', 'sqweb' ); ?>" />
	<input class="button button-primary button-large sqweb-admin-auth-button" type="submit" name="Submit" value="<?php _e( 'Sign up', 'sqweb' ); ?>" />
</form>
<div class="sqw-signup">
<?php echo '<a href="' . remove_query_arg( 'action' ) . '"><span class="sqweb-ctr-link">'; ?><?php _e( 'Back to sign in', 'sqweb' ); ?></span></a>
</div>
<?php
} else {
?>
<h2><?php _e( 'Sign in', 'sqweb' ); ?></h2>
				<?php if ( 1 == $errorc ) {?><span class="sqw-error"><?php _e( 'You need to fill in all fields', 'sqweb' ); ?></span><?php
} ?>
				<?php if ( isset( $_GET['success'] ) && 'true' == $_GET['success'] ) {?><span class="sqw-success"><?php _e( 'You signed up successfuly.', 'sqweb' ); ?></span><?php
} ?>
				<form action="<?php echo remove_query_arg( 'success' ) ?>" method="post" name="sqw-auth">
 <label for="email"><?php _e( 'Email', 'sqweb' ); ?></label>
 <input class="sqweb-admin-auth-input" type="text" name="sqw-emailc" value="" placeholder="email" />
 <label for="password"><?php _e( 'Password', 'sqweb' ); ?></label>
 <input class="sqweb-admin-auth-input" type="password" name="sqw-passwordc" value="" placeholder="<?php _e( 'password', 'sqweb' ); ?>" />
 <input class="button button-primary button-large sqweb-admin-auth-button" type="submit" name="Submit" value="<?php _e( 'Sign in', 'sqweb' ); ?>" />
				</form>
				<div class="sqw-signup">
    <?php echo '<a href="' . add_query_arg( array( 'action' => 'signup' ) ) . '">'; ?>
  <span class="sqweb-ctr-link"><?php _e( 'Don\'t have an account ?', 'sqweb' ); ?></span>
  <span class="sqweb-ctr-link"><?php _e( 'Sign up for free in 30 seconds !', 'sqweb' ); ?></span>
 </a>
				</div>
				<a target="_blank" href="https://www.sqweb.com/password/email">
 <span class="sqweb-ctr-link"><?php _e( 'Forgot your password ?', 'sqweb' ); ?></span>
				</a>
	</div>
	<div class="sqweb-ctr-box">
    <?php
}
}
	?>
<?php

// These two are need for PHP pre 5.5 compatibility
// See http://php.net/manual/en/function.empty.php
$workaround_wmid = get_option( 'wmid' );
$workaround_wsid = get_option( 'wsid' );

if ( ( ! empty( $workaround_wmid ) && ! empty( $workaround_wsid ) ) && ! empty( $sqw_token )  || '0' != $signinr ) {
?>
	<div class="sqweb-stats">
		<div class="sqweb-canvas" id="canvas-holder">
			<canvas id="chart01-area" width="200" height="200"/></canvas>
			<ul class="sqweb-ulle">
				<li class="sqweb-li"><span class="sqweb-red sqweb-col"></span><?php _e( 'Users detected with Adblock', 'sqweb' ); ?></li>
				<li class="sqweb-li"><span class="sqweb-blue sqweb-col"></span><?php _e( 'Users paying with SQweb', 'sqweb' ); ?></li>
				<li class="sqweb-li"><span class="sqweb-yellow sqweb-col"></span><?php _e( 'Users seeing ads', 'sqweb' ); ?></li>
			</ul>
		</div>
		<div class="sqweb-canvas" id="canvas-holder">
			<canvas id="chart02-area" width="200" height="200"/></canvas>
			<ul class="sqweb-ulle">
				<li class="sqweb-li"><span class="sqweb-red sqweb-col"></span><?php _e( 'Pages seen with ads blocked', 'sqweb' ); ?></li>
				<li class="sqweb-li"><span class="sqweb-blue sqweb-col"></span><?php _e( 'Pages seen by SQwebmen', 'sqweb' ); ?></li>
				<li class="sqweb-li"><span class="sqweb-yellow sqweb-col"></span><?php _e( 'Pages seen with ads', 'sqweb' ); ?></li>
			</ul>
		</div>
	</div>
<?php
add_action( 'admin_footer', 'stats_ajax_call' );

function stats_ajax_call() {

	$wmid = ( ! empty( get_option( 'wmid' ) ) ) ? get_option( 'wmid' ) : null;
	$wsid = ( ! empty( get_option( 'wsid' ) ) ) ? get_option( 'wsid' ) : null;
	if ( null !== $wsid && null !== $wmid ) {
		if ( ! empty( $wmid ) && ! empty( $wsid ) && defined( 'SQW_ENDPOINT' ) ) {
			?>
	      <script type="text/javascript" >
	       jQuery(document).ready(function($) {
	     var data = {
	      token: "<?php echo get_option( 'sqw_token' ); ?>",
							webmaster_id: <?php echo ( ! empty( $wmid ) ? $wmid : "''"); ?>,
							website_id: <?php echo ( ! empty( $wsid ) ? $wsid : "''"); ?>
						};
						$.post('<?php echo SQW_ENDPOINT; ?>apistats', data, function(response) {
							console.log(response);
							if (response[0])
							{
								var doughnutData1 = [
								{
									value: response[0]["visiteurs"] - response[0]["bloqueurs"] - response[0]["sqwebers"],
									color: "#f7bc31",
									highlight: "#f7bc31",
									label: "<?php _e( 'Displayed', 'sqweb' ); ?>"
								},
								{
									value: response[0]["bloqueurs"],
									color:"#f50057",
									highlight: "#f50057",
									label: "<?php _e( 'Blocked', 'sqweb' ); ?>"
								},
								{
									value: response[0]["sqwebers"],
									color:"#4190ff",
									highlight: "#4190ff",
									label: "SQweb"
								}
								];
								var doughnutData2 = [
								{
									value: response[0]["pages"] - response[0]["pagesbloqueurs"] - response[0]["pagessqwebers"],
									color: "#f7bc31",
									highlight: "#f7bc31",
									label: "<?php _e( 'Displayed', 'sqweb' ); ?>"
								},
								{
									value: response[0]["pagesbloqueurs"],
									color:"#f50057",
									highlight: "#f50057",
									label: "<?php _e( 'Blocked', 'sqweb' ); ?>"
								},
								{
									value: response[0]["pagessqwebers"],
									color:"#4190ff",
									highlight: "#4190ff",
									label: "SQweb"
								}
									];

								var ctx = document.getElementById("chart01-area").getContext("2d");
								var myDoughnut = new Chart(ctx).Doughnut(doughnutData1, {percentageInnerCutout: 50, responsive : false});
								var ctx2 = document.getElementById("chart02-area").getContext("2d");
								var myDoughnut2 = new Chart(ctx2).Doughnut(doughnutData2, {percentageInnerCutout: 50, responsive : false});
							}
						});
					});
	      </script>
	        <?php
	    }
	}
}
}
?>
	</div>
	<div class="sqweb-ctr-box" style="text-decoration: none;">
    <?php
	if ( ! empty( $sqw_token ) || '0' != $signinr ) {
		echo '<a href="https://www.sqweb.com/dashboard/support" target="_blank">', __( 'Help', 'sqweb' ), '</a>';
	}
	?>
		<a href="https://www.sqweb.com/contact" target="_blank" class="sqweb-ctr-link">Contact</a>
	</div>
</div>
<script type="text/javascript">
	var input1 = document.getElementById("sqweb-message-input1");
	var input2 = document.getElementById("sqweb-message-input2");
	var select = document.getElementById("sqweb-color-select");
	document.getElementById("sqweb_exemple");
	if (input1) {
		input1.addEventListener('keyup', function(event) {
			document.getElementById("sqweb_exemple").innerHTML = input1.value;
		});
	}
	if (input2) {
		input2.addEventListener('keyup', function(event) {
			document.getElementById("sqweb_exemple").innerHTML = input2.value;
		});
	}
	if (select)
	{
		select.addEventListener('change', function(event) {
			document.getElementById("sqweb-button").className = "sqweb-button sqweb-"+select.value;
		});
	}
</script>
