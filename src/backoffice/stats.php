<div class="sqweb-ctr-box">
	<?php
	if ( ! empty( $sqw_token )  || '0' != $signinr ) {
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
			$wmid = (get_option( 'wmid' ) !== '') ? get_option( 'wmid' ) : '';
			$wsid = (get_option( 'wsid' ) !== '') ? get_option( 'wsid' ) : '';
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
