<?php
/**
 * Admin Widget Register ( Search Widget )
 *
 * @author  Kazuya Takami
 * @version 1.6.0
 * @since   1.6.0
 * @see     /wp-includes/widgets/class-wp-widget-search.php
 * @see     wp-widget-extensions-form-build.php
 */

unregister_widget( 'WP_Widget_Search' );
register_widget( 'WP_Widget_Extensions_Search' );

class WP_Widget_Extensions_Search extends WP_Widget_Search {

	/**
	 * Widget Form Display.
	 *
	 * @version 1.6.0
	 * @since   1.6.0
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
		echo '<p>';

		/**
		 * Post
		 */
		 $field_name = 'post';
		 if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = 1; }
 		$form->checkbox(
 			$this->get_field_id( $field_name ),
 			$this->get_field_name( $field_name ),
 			$instance[ $field_name ], __( 'Post' )
 		);
 		echo '<br />';

		/**
		 * Page
		 */
		 $field_name = 'page';
		 if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = 1; }
 		$form->checkbox(
 			$this->get_field_id( $field_name ),
 			$this->get_field_name( $field_name ),
 			$instance[ $field_name ], __( 'Page' )
 		);
 		echo '<br />';

		 /* Custom Posts */
		 $args = array(
			'public'   => true,
			'_builtin' => false
		 );
		 $post_types = get_post_types( $args, 'objects' );
		 foreach ( $post_types as $post_type ) {
			$field_name = esc_html( $post_type->name );
	 		if ( !isset( $instance[ $field_name ] ) ) { $instance[ $field_name ] = 0; }
	 		$form->checkbox(
	 			$this->get_field_id( $field_name ),
	 			$this->get_field_name( $field_name ),
	 			$instance[ $field_name ], esc_html( $post_type->label )
	 		);
	 		echo '<br />';
		 }

		echo '</p>';
	}

	/**
	 * Widget Form Update.
	 *
	 * @version 1.6.0
	 * @since   1.6.0
	 * @access  public
	 * @param   array $new_instance
	 * @param   array $old_instance
	 * @return  array $instance
	 */
	public function update ( $new_instance, $old_instance ) {
		$instance = parent::update( $new_instance, $old_instance );

		$instance['post'] = $new_instance['post'] ? 1 : 0;
		$instance['page'] = $new_instance['page'] ? 1 : 0;

		/* Custom Posts */
		$args = array(
			'public'   => true,
			'_builtin' => false
		);
		$post_types = get_post_types( $args, 'objects' );
		foreach ( $post_types as $post_type ) {
			$field_name = esc_html( $post_type->name );
			$instance[ $field_name ] = $new_instance[ $field_name ] ? 1 : 0;
		}

		return (array) $instance;
	}

	/**
	 * Widget Display.
	 *
	 * @version 1.6.0
	 * @since   1.6.0
	 * @access  public
	 * @param   array $args
	 * @param   array $instance
	 */
	public function widget ( $args, $instance ) {
		parent::widget( $args, $instance );
	}
}