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
		$value = is_array( $value ) ? $value : array();
		$post_types = get_post_types( array( 'public' => true ), 'objects' );
		$excluded  = apply_filters( 'wp-post-nav-post-type', array( 'attachment' => 'attachment' ) );
		?>
		<fieldset class="wppn-post-type-checkboxes" data-wppn-setting="<?php echo esc_attr( $this->setting->id ); ?>">
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>
			<?php foreach ( $post_types as $post_type => $object ) : ?>
				<?php if ( in_array( $post_type, $excluded, true ) ) { continue; } ?>
				<label>
					<input class="wppn-post-type-checkbox" type="checkbox" value="<?php echo esc_attr( $post_type ); ?>" <?php checked( isset( $value[ $post_type ] ), true ); ?> />
					<?php echo esc_html( $object->labels->singular_name ); ?>
				</label><br />
			<?php endforeach; ?>
		</fieldset>
		<?php
	}
}
