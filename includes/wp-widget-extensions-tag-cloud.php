<?php
/**
 * Admin Widget Register
 *
 * @author  Kazuya Takami
 * @version 1.0.0
 * @since   1.0.0
 * @see     /wp-includes/widgets/class-wp-widget-tag-cloud.php
 */

unregister_widget( 'WP_Widget_Tag_Cloud' );
register_widget( 'WP_Widget_Extensions_Tag_Cloud' );

class WP_Widget_Extensions_Tag_Cloud extends WP_Widget_Tag_Cloud {

	/**
	 * Variable definition.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	private $text_domain = 'wp-widget-extensions';
	private $instance    = array();

	/**
	 * Widget Form Display.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array $instance
	 * @return  string Parent::Default return is 'noform'
	 */
	public function form ( $instance ) {
		parent::form( $instance );
		
		echo '<hr>';

		/**
		 * OrderBy Element
		 */
		if ( !isset( $instance['orderby'] ) ) {
			$instance['orderby'] = "name";
		}
		$id   = $this->get_field_id( 'orderby' );
		$name = $this->get_field_name( 'orderby' );
		$sort_array = array(
			"name"  => esc_html__( "Name order",  $this->text_domain ),
			"count" => esc_html__( "Tag Count order", $this->text_domain )
		);

		echo '<p><label for="' . $id . '">' . esc_html__( 'Sort by', $this->text_domain ) . ':</label><br>';
		printf( '<select id="%s" name="%s" class="widefat">', $id, $name );
		foreach ( $sort_array as $key => $row ) {
			if ( $key == $instance['orderby'] ) {
				printf( '<option value="%s" selected="selected">%s</option>', $key, esc_html( $row ) );
			} else {
				printf( '<option value="%s">%s</option>', $key, esc_html( $row ) );
			}
		}
		echo '</select></p>';

		/**
		 * Order Element
		 */
		if ( !isset( $instance['order'] ) ) {
			$instance['order'] = "ASC";
		}
		$id   = $this->get_field_id( 'order' );
		$name = $this->get_field_name( 'order' );
		$order_array  = array(
			"ASC"  => esc_html__( "Ascending order",  $this->text_domain ),
			"DESC" => esc_html__( "Descending order", $this->text_domain )
		);

		echo '<p><label for="' . $id . '">' . esc_html__( 'Order by', $this->text_domain ) . ':</label><br>';
		printf( '<select id="%s" name="%s" class="widefat">', $id, $name );
		foreach ( $order_array as $key => $row ) {
			if ( $key == $instance['order'] ) {
				printf( '<option value="%s" selected="selected">%s</option>', $key, esc_html( $row ) );
			} else {
				printf( '<option value="%s">%s</option>', $key, esc_html( $row ) );
			}
		}
		echo '</select></p>';
	}

	/**
	 * Widget Form Update.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array $new_instance
	 * @param   array $old_instance
	 * @return  array $instance
	 */
	public function update ( $new_instance, $old_instance ) {
		$instance = parent::update( $new_instance, $old_instance );

		$instance['orderby'] = sanitize_text_field( $new_instance['orderby'] );
		$instance['order']   = sanitize_text_field( $new_instance['order'] );

		return (array) $instance;
	}

	/**
	 * Widget Tag Cloud Args
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array $args
	 * @return  array $args
	 */
	public function widget_tag_cloud_args ( $args ) {
		if ( isset( $this->instance['orderby'] ) ) {
			$args['orderby'] = $this->instance['orderby'];
		}
		if ( isset( $this->instance['order'] ) ) {
			$args['order'] = $this->instance['order'];
		}

		return (array) $args;
	}

	/**
	 * Widget Display.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array $args
	 * @param   array $instance
	 */
	public function widget ( $args, $instance ) {
		$this->instance = $instance;

		add_filter( 'widget_tag_cloud_args', array( $this, 'widget_tag_cloud_args' ) );

		parent::widget( $args, $instance );
	}
}