<?php
/**
 * Adding SQweb button
 */

class WidgetSqwebButton extends WP_Widget
{

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_text', 'description' => __( 'Button to activate SQweb on your website.', 'sqweb' ) );
		$control_ops = array( 'width' => 400, 'height' => 350 );
		parent::__construct( 'widgetSqwebButton', __( 'SQweb button', 'sqweb' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		$langue = apply_filters( 'widget_text', empty( $instance['langue'] ) ? '' : $instance['langue'], $instance );
		$get_options['btheme'] = get_option( 'btheme' );
		echo $before_widget;
		if ( 'grey' == $get_options['btheme'] ) {
			echo '<div class="sqweb-button sqweb-grey"></div>';
		} else {
			echo '<div class="sqweb-button"></div>';
		}
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'flogin' => 'Remove ads', 'flogout' => 'Connected' ) );
		$get_options['wmid'] = get_option( 'wmid' );
		$get_options['wsid'] = get_option( 'wsid' );
		$get_options['fmes'] = get_option( 'fmes' );
		if ( '' === $get_options['wsid'] || '' === $get_options['wmid'] ) {
			echo '<span style="color:red">ID MISSING<a href="admin.php?page=SQwebAdmin"><br>', __( 'CLICK HERE TO LOG IN', 'sqweb' ), '<br></a></span>';
		}
		echo '<a href="admin.php?page=SQwebAdmin">', __( 'Edit settings', 'sqweb' ), '</a><br><br><br>';
	}
}
