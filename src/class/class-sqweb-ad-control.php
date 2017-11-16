<?php
/**
 * Adding SQweb Ad control Widget
 */

class SqwebAdControl extends WP_Widget {

	public function __construct() {

		$widget_ops  = array(
			'classname'   => 'widget_text',
			'description' => __( 'Put here your advertising code to hide it for Multipass users', 'sqweb' ),
		);
		$control_ops = array(
			'width'  => 400,
			'height' => 350,
		);
		parent::__construct( 'sqweb_ad_control', __( 'Multipass ad manager', 'sqweb' ), $widget_ops, $control_ops );
	}

	/**
	 * Display Ads or content.
	 */

	function widget( $args, $instance ) {

		$title   = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$text    = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		$adblock = apply_filters( 'widget_adblock', empty( $instance['adblock'] ) ? '' : $instance['adblock'], $instance );
		echo $args['before_widget'];
		echo '<div class="textwidget">';
		SQweb_filter::get_instance()->add_ads( $adblock, $text );
		echo '</div>';
		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {

		$instance          = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text']    = $new_instance['text'];
			$instance['adblock'] = $new_instance['adblock'];
		} else {
			$instance['text']    = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) );
			$instance['adblock'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['adblock'] ) ) );
		}
		return $instance;
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance,
			array(
				'title'   => '',
				'text'    => '',
				'adblock' => '',
			)
		);
		$title    = strip_tags( $instance['title'] );
		$text     = esc_textarea( $instance['text'] );
		$adblock  = esc_textarea( $instance['adblock'] );
	?>
	<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'sqweb' ); ?> :</label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

	<p><label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Advertising code', 'sqweb' ); ?> :</label>
	<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'adblock' ); ?>" name="<?php echo $this->get_field_name( 'adblock' ); ?>"><?php echo $adblock; ?></textarea></p>

	<p><label for="<?php echo $this->get_field_id( 'adblock' ); ?>"><?php _e( 'Content for paying users', 'sqweb' ); ?> :</label>
	<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea></p>

	<?php
	}
}
