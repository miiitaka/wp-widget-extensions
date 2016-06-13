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
	 * @param   string  $id
	 * @param   string  $name
	 * @param   boolean $value
	 * @param   string  $text
	 */
	public function checkbox ( $id, $name, $value, $text ) {
		if ( $value ) {
			printf( '<input type="checkbox" id="%s" name="%s" class="checkbox" checked="checked">', $id, $name );
		} else {
			printf( '<input type="checkbox" id="%s" name="%s" class="checkbox">', $id, $name );
		}
		echo '<label for="' . esc_attr($id) . '">' . $text . '</label>';
	}

}