<?php

/**
 * Customizer control for the compatible post-type array setting.
 *
 * @package wp_post_nav
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'WP_Customize_Control' ) ) {
	exit;
}

/**
 * Displays the existing post-type array as newline-separated Customizer text.
 */
class WPPN_Customizer_Post_Types_Control extends WP_Customize_Control {
	/**
	 * Render the post-type input without changing its stored format.
	 *
	 * @return void
	 */
	public function render_content() {
		$value = $this->value();
		$value = is_array( $value ) ? implode( "\n", array_keys( $value ) ) : (string) $value;
		?>
		<label>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>
			<textarea class="widefat" rows="4" <?php $this->input_attrs(); ?>><?php echo esc_textarea( $value ); ?></textarea>
		</label>
		<?php
	}
}
