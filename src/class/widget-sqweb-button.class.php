<?php
/**
 * Adding SQweb button
 */

class WidgetSqwebButton extends WP_Widget {

	function __construct() {

		$widget_ops = array( 'classname' => 'widget_text', 'description' => __( 'Button to activate Multipass on your website.', 'sqweb' ) );
		$control_ops = array( 'width' => 400, 'height' => 350 );
		parent::__construct( 'widgetSqwebButton', __( 'Multipass button', 'sqweb' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {

		echo $args['before_widget'];
		echo '<div class="sqweb-button' . ( 'normal' !== $instance['button'] ? ' multipass-' . $instance['button'] : '' ) . '"></div>';
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['button'] = $new_instance['button'];

		return $instance;
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array( 'button' => '' ) );
		$get_options['wsid'] = (get_option( 'wsid' ) != false ? get_option( 'wsid' ) : 0);
		$button = $instance['button'];

		?>
<p><label for="<?php echo $this->get_field_id( 'button' ); ?>"><?php _e( 'Choose button', 'sqweb' ); ?> :</label>
<select id="<?php echo $this->get_field_id( 'button' ); ?>" name="<?php echo $this->get_field_name( 'button' ); ?>">
	<option value="tiny" <?php echo 'tiny' === $button ? 'selected' : ''; ?>><?php _e( 'Tiny', 'sqweb' ); ?></option>
	<option value="slim" <?php echo 'slim' === $button ? 'selected' : ''; ?>><?php _e( 'Slim', 'sqweb' ); ?></option>
	<option value="normal" <?php echo 'normal' === $button ? 'selected' : ''; ?>><?php _e( 'Normal', 'sqweb' ); ?></option>
	<option value="large" <?php echo 'large' === $button ? 'selected' : ''; ?>><?php _e( 'Large', 'sqweb' ); ?></option>
</select></p>
	 <?php
		if ( '' === $get_options['wsid'] ) {
			echo '<span style="color:red">ID MISSING<a href="admin.php?page=SQwebAdmin"><br>', __( 'CLICK HERE TO LOG IN', 'sqweb' ), '<br></a></span>';
		}
		echo '<a href="admin.php?page=SQwebAdmin">', __( 'Edit settings', 'sqweb' ), '</a><br><br>';
	}
}
