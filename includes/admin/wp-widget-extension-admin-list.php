<?php
/**
 * Schema.org Admin List
 *
 * @author  Kazuya Takami
 * @version 2.0.4
 * @since   2.0.0
 */
class WP_Widget_Extension_List {

	/**
	 * Variable definition.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	private $text_domain;

	/**
	 * Variable definition.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	private $widget_type = array(
		"widget_archives"        => 'Archives Widget',
		"widget_calendar"        => 'Calendar Widget',
		"widget_categories"      => 'Categories Widget',
		"widget_meta"            => 'Meta Widget',
		"widget_nav_menu"        => 'Custom Menu Widget',
		"widget_pages"           => 'Pages Widget',
		"widget_recent-comments" => 'Recent Comments Widget',
		"widget_recent-posts"    => 'Recent Posts Widget',
		"widget_rss"             => 'RSS Widget',
		"widget_search"          => 'Search Widget',
		"widget_tag_cloud"       => 'Tag Cloud Widget',
		"widget_text"            => 'Text Widget'
	);

	/**
	 * Constructor Define.
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 * @param   String $text_domain
	 */
	public function __construct ( $text_domain ) {
		$this->text_domain = $text_domain;
		$this->update_data();
		$this->page_render();
	}

	/**
	 * LIST Page HTML Render.
	 *
	 * @version 2.0.4
	 * @since   2.0.0
	 */
	private function page_render () {
		$html  = '';
		$html .= '<div class="wrap">';
		$html .= '<h1>' . esc_html__( 'Widget Extension Settings', $this->text_domain ) . '</h1>';
		$html .= '<hr>';
		echo $html;

		if ( isset( $_POST[$this->text_domain] ) && $_POST[$this->text_domain] ) {
			if ( check_admin_referer( $this->text_domain . '-key', $this->text_domain ) ) {
				$this->information_render();
			}
		}

		$html  = '<form action="" method="POST">';
		$html .= '<table class="wp-list-table widefat fixed striped posts">';
		$html .= '<tr>';
		$html .= '<th scope="row" style="width: 100px;">' . __( 'Status', $this->text_domain ) . '</th>';
		$html .= '<th scope="row">' . esc_html__( 'Widget Type', $this->text_domain ) . '</th>';
		$html .= '</tr>';
		echo $html;

		$args = get_option( $this->text_domain );

		$html = '';
		foreach ( $this->widget_type as $key => $value ) {
			$html .= '<tr><td>';
			if ( isset( $args[$key] ) && $args[$key] ) {
				$html .= '<input type="checkbox" id="' . esc_attr( $value ) . '" name="widget[' . esc_attr( $key ) . ']" value="1" checked>';
			} else {
				$html .= '<input type="checkbox" id="' . esc_attr( $value ) . '" name="widget[' . esc_attr( $key ) . ']" value="1">';
			}
			$html .= '<label for="' . esc_attr( $value ) . '">Enabled</label></td>';
			$html .= '<td>' . esc_html( $value ) . '</td>';
			$html .= '</tr>';
		}
		echo $html;

		echo '</table>';
		wp_nonce_field( $this->text_domain . '-key', $this->text_domain );
		submit_button();
		echo '</form></div>';
	}

	/**
	 * Update option
	 *
	 * @version 2.0.0
	 * @since   2.0.0
	 */
	private function update_data () {
		if ( isset( $_POST[$this->text_domain] ) && $_POST[$this->text_domain] ) {
			if ( check_admin_referer( $this->text_domain . '-key', $this->text_domain ) ) {
				update_option( $this->text_domain, $_POST['widget'] );
			}
		}
	}

	/**
	 * Information Message Render
	 *
	 * @version 2.0.4
	 * @since   1.0.0
	 */
	private function information_render () {
		$html  = '<div id="message" class="updated notice notice-success is-dismissible below-h2">';
		$html .= '<p>Widget Extensions Information Update.</p>';
		$html .= '<button type="button" class="notice-dismiss">';
		$html .= '<span class="screen-reader-text">Widget Extensions Information Update.</span>';
		$html .= '</button>';
		$html .= '</div>';

		echo $html;
	}
}