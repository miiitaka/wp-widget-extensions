<?php
/**
 * Admin Widget Form Build
 *
 * @author  Kazuya Takami
 * @version 1.1.0
 * @since   1.1.0
 */

class WP_Widget_Extensions_Form_Build {

	/**
	 * Widget Form Checkbox.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 * @access  private
	 * @param   string $id
	 * @param   string $name
	 * @param   string $value
	 * @param   string $text
	 */
	public function checkbox ( $id, $name, $value, $text ) {
		printf( '<input type="checkbox" id="%s" name="%s" value="%s" class="checkbox">', $id, $name, $value );
		echo '<label for="' . esc_attr( $id ) . '">' . $text . '</label>';
	}

}