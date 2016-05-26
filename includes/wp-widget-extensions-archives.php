<?php
/**
 * Admin Widget Register
 *
 * @author  Kazuya Takami
 * @version 1.0.0
 * @since   1.0.0
 * @see     /wp-includes/widgets/class-wp-widget-archives.php
 */

unregister_widget( 'WP_Widget_Archives' );
register_widget( 'WP_Widget_Extensions_Archives' );

class WP_Widget_Extensions_Archives extends WP_Widget_Archives {

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
		 * Type Element
		 */
		if ( !isset( $instance['type'] ) ) {
			$instance['type'] = "monthly";
		}
		$type_array = array(
			"daily"   => esc_html__( "Daily",   $this->text_domain ),
			"weekly"  => esc_html__( "Weekly",  $this->text_domain ),
			"monthly" => esc_html__( "Monthly", $this->text_domain ),
			"yearly"  => esc_html__( "Yearly",  $this->text_domain )
		);
		$id   = $this->get_field_id( 'type' );
		$name = $this->get_field_name( 'type' );

		echo '<p><label for="' . $id . '">' . esc_html__( 'Type', $this->text_domain ) . ':</label><br>';
		printf( '<select id="%s" name="%s" class="widefat">', $id, $name );
		foreach ( $type_array as $key => $row ) {
			if ( $key == $instance['type'] ) {
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
			$instance['order'] = "desc";
		}
		$order_array  = array(
			"ASC"  => esc_html__( "Ascending order",  $this->text_domain ),
			"DESC" => esc_html__( "Descending order", $this->text_domain )
		);
		$id   = $this->get_field_id( 'order' );
		$name = $this->get_field_name( 'order' );

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

		/**
		 * Limit Element
		 */
		if ( !isset( $instance['limit'] ) ) {
			$instance['limit'] = 0;
		}
		$id   = $this->get_field_id( 'limit' );
		$name = $this->get_field_name( 'limit' );
		echo '<p><label for="' . $id . '">' . esc_html__( 'Number of archive to show', $this->text_domain ) . ':&nbsp;</label>';
		printf( '<input type="number" id="%s" name="%s" value="%s" class="small-text">', $id, $name, esc_attr( $instance['limit'] ) );
		echo '</p>';
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

		$instance['type']  = sanitize_text_field( $new_instance['type'] );
		$instance['order'] = sanitize_text_field( $new_instance['order'] );
		$instance['limit'] = (int) $new_instance['limit'];

		return (array) $instance;
	}

	/**
	 * Widget Archives Args
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array $args
	 * @return  array $args
	 */
	public function widget_archives_args ( $args ) {
		if ( isset( $this->instance['type'] ) ) {
			$args['type'] = $this->instance['type'];
		}
		if ( isset( $this->instance['order'] ) ) {
			$args['order'] = $this->instance['order'];
		}
		if ( isset( $this->instance['limit'] ) ) {
			if ( $this->instance['limit'] == 0 ) {
				$args['limit'] = "";
			} else {
				$args['limit'] = $this->instance['limit'];
			}
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

		$d = ! empty( $instance['dropdown'] ) ? '1' : '0';
		if ( $d ) {
			add_filter( 'widget_archives_dropdown_args', array( $this, 'widget_archives_args' ) );
		} else {
			add_filter( 'widget_archives_args', array( $this, 'widget_archives_args' ) );
		}
		parent::widget( $args, $instance );
	}
}