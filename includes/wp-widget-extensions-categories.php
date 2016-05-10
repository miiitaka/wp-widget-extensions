<?php
/**
 * Admin Widget Register
 *
 * @author  Kazuya Takami
 * @version 1.0.0
 * @since   1.0.0
 * @see     /wp-includes/widgets/class-wp-widget-categories.php
 */

unregister_widget( 'WP_Widget_Categories' );
register_widget( 'WP_Widget_Extensions_Categories' );

class WP_Widget_Extensions_Categories extends WP_Widget_Categories {

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

		if ( !isset( $instance['orderby'] ) ) {
			$instance['orderby'] = "";
		}
		if ( !isset( $instance['order'] ) ) {
			$instance['order'] = "";
		}

		$id   = $this->get_field_id( 'orderby' );
		$name = $this->get_field_name( 'orderby' );
		$sort_array = array(
			"name"  => esc_html__( "Name of the order",  $this->text_domain ),
			"count" => esc_html__( "Posts of the order", $this->text_domain )
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

		$id   = $this->get_field_id( 'order' );
		$name = $this->get_field_name( 'order' );
		$order_array  = array(
			"asc"  => esc_html__( "Ascending order",  $this->text_domain ),
			"desc" => esc_html__( "Descending order", $this->text_domain )
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

		$instance['orderby'] = isset( $new_instance['orderby'] ) ? $new_instance['orderby'] : "";
		$instance['order']   = isset( $new_instance['order'] )   ? $new_instance['order']   : "";

		return (array) $instance;
	}

	/**
	 * Widget Categories Args
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @access  public
	 * @param   array $cat_args
	 * @return  array $cat_args
	 */
	public function widget_categories_args ( $cat_args ) {
		if ( isset( $this->instance['orderby'] ) ) {
			switch ( $this->instance['orderby'] ) {
				case 'count':
					$cat_args['orderby'] = 'count';
					break;
			}
		}

		if ( isset( $this->instance['order'] ) && $this->instance['order'] === 'desc' ) {
			$cat_args['order'] = 'DESC';
		}

		return (array) $cat_args;
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
			add_filter( 'widget_categories_dropdown_args', array( $this, 'widget_categories_args' ) );
		} else {
			add_filter( 'widget_categories_args', array( $this, 'widget_categories_args' ) );
		}
		parent::widget( $args, $instance );
	}
}