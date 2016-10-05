<?php
/**
 * Admin Widget Register
 *
 * @author  Kazuya Takami
 * @version 1.4.0
 * @since   1.4.0
 * @see     /wp-includes/widgets/class-wp-widget-search.php
 */

unregister_widget( 'WP_Widget_Search' );
register_widget( 'WP_Widget_Extensions_Search' );

class WP_Widget_Extensions_Search extends WP_Widget_Search {

	/**
	 * Variable definition.
	 *
	 * @version 1.4.0
	 * @since   1.4.0
	 */
	private $text_domain = 'wp-widget-extentions';
	private $instance    = array();

	/**
	 * Widget Form Display.
	 *
	 * @version 1.4.0
	 * @since   1.4.0
	 * @access  public
	 * @param   array $instance
	 * @return  string Parent::Default return is 'noform'
	 */
	public function form ( $instance ) {
		parent::form( $instance );

		require_once( 'wp-widget-extensions-form-build.php' );
		$form = new WP_Widget_Extensions_Form_Build();

		echo '<hr>';
	}

	/**
	 * Widget Form Update.
	 *
	 * @version 1.4.0
	 * @since   1.4.0
	 * @access  public
	 * @param   array $new_instance
	 * @param   array $old_instance
	 * @return  array $instance
	 */
	public function update ( $new_instance, $old_instance ) {
		$instance = parent::update( $new_instance, $old_instance );

		//$instance['depth'] = sanitize_text_field( $new_instance['depth'] );

		return (array) $instance;
	}

	/**
	 * Widget Pages Args
	 *
	 * @version 1.4.0
	 * @since   1.4.0
	 * @access  public
	 * @param   object $query
	 * @return  object $query
	 */
	public function widget_search_query ( $query ) {
		var_dump($query);
		if ( !$query->is_admin && $query->is_search ) {
			$query->set( 'post_type', 'post' );
			//$query->set('post__not_in', array(5, 10, 20, 32, 48) );
		}
		return $query;
	}

	/**
	 * Widget Display.
	 *
	 * @version 1.4.0
	 * @since   1.4.0
	 * @access  public
	 * @param   array $args
	 * @param   array $instance
	 */
	public function widget ( $args, $instance ) {
		$this->instance = $instance;

		//add_filter( 'pre_get_posts', array( $this, 'widget_search_query' ) );
		add_filter( 'posts_search', array( $this, 'widget_search_query' ) );

		parent::widget( $args, $instance );
	}
}