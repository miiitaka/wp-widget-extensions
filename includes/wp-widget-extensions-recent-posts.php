<?php
/**
 * Admin Widget Register
 *
 * @author  Kazuya Takami
 * @version 1.7.0
 * @since   1.7.0
 * @see     /wp-includes/widgets/class-wp-widget-recent-post.php
 */

unregister_widget( 'WP_Widget_Recent_Posts' );
register_widget( 'WP_Widget_Extensions_Recent_Posts' );

class WP_Widget_Extensions_Recent_Posts extends WP_Widget_Recent_Posts {

	/**
	 * Instance array.
	 *
	 * @version 1.7.0
	 * @since   1.7.0
	 */
	private $instance = array();

	/**
	 * Widget Form Display.
	 *
	 * @version 1.7.0
	 * @since   1.7.0
	 * @access  public
	 * @param   array $instance
	 * @return  string Parent::Default return is 'noform'
	 */
	public function form ( $instance ) {
		parent::form( $instance );

		require_once( 'wp-widget-extensions-form-build.php' );
		$form = new WP_Widget_Extensions_Form_Build();

		echo '<hr>';
		echo '<p><strong>[ Plugin: WordPress Default Widget Extension ]</strong></p>';

		/**
		 * Custom Post
		 */
		$post_types = $this->set_post_type();

		foreach ( $post_types as $post_type ) {
			$field_name = esc_html( $post_type->name );
			if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = 0; }
			$form->checkbox(
				$this->get_field_id( $field_name ),
				$this->get_field_name( $field_name ),
				$instance[ $field_name ], $post_type->label
			);
			echo '<br />';
		}
		echo '<hr>';
	}

	/**
	 * Widget Form Update.
	 *
	 * @version 1.7.0
	 * @since   1.7.0
	 * @access  public
	 * @param   array $new_instance
	 * @param   array $old_instance
	 * @return  array $instance
	 */
	public function update ( $new_instance, $old_instance ) {
		$instance = parent::update( $new_instance, $old_instance );

		$post_types = $this->set_post_type();

		foreach ( $post_types as $post_type ) {
			$field_name = esc_html( $post_type->name );
			$instance[ $field_name ] = $new_instance[ $field_name ] ? 1 : 0;
		}

		return (array) $instance;
	}

	/**
	 * Widget Recent Posts Args
	 *
	 * @version 1.7.0
	 * @since   1.7.0
	 * @access  public
	 * @param   array $args
	 * @return  array $args
	 */
	public function widget_recent_posts_args ( $args ) {
		$post_types = $this->set_post_type();
		$posts      = array();

		foreach ( $post_types as $post_type ) {
			$field_name = esc_html( $post_type->name );
			if ( isset( $this->instance[$field_name] ) ) {
				if ( $this->instance[$field_name] == 1 ) {
					$posts[] = $field_name;
				}
			}
		}
		if ( count( $posts ) > 0 ) {
			$args['post_type'] = $posts;
		}

		return (array) $args;
	}

	/**
	 * Widget Display.
	 *
	 * @version 1.7.0
	 * @since   1.7.0
	 * @access  public
	 * @param   array $args
	 * @param   array $instance
	 */
	public function widget ( $args, $instance ) {
		$this->instance = $instance;

		add_filter( 'widget_posts_args', array( $this, 'widget_recent_posts_args' ) );

		parent::widget( $args, $instance );
	}

	/**
	 * Setting post type array.
	 *
	 * @version 1.7.0
	 * @since   1.7.0
	 * @return  array $post_types
	 */
	private function set_post_type () {
		// default post
		$args = array(
			'public'   => true,
			'_builtin' => true
		);
		$post_types = get_post_types( $args, 'objects' );
		unset( $post_types['page'] );
		unset( $post_types['attachment'] );

		// custom post
		$args = array(
			'public'   => true,
			'_builtin' => false
		);
		$custom_post_types = get_post_types( $args, 'objects' );

		$post_types = array_merge( $post_types, $custom_post_types );

		return (array) $post_types;
	}
}