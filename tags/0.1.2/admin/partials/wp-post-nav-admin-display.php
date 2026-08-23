<?php

/**
 * The file used to show the settings on the screen
 *
 * @link:       https://wppostnav.com
 * @since      0.0.1
 *
 * @package    wp_post_nav
 * @subpackage wp_post_nav/admin/partials
 */
?>

<?php
// If this file is called directly, abort. //
if ( ! defined( 'ABSPATH' ) ) {
  exit;
} 
?>

<div class="wrap">
	<h1>WP Post Nav</h1>
		<?php settings_errors('wp_post_nav','',true); ?>
		<form method="POST" action="options.php">
			<?php
				settings_fields( 'wp_post_nav' );
				do_settings_sections( 'wp_post_nav' );
				submit_button();
			?>
		</form>
</div> 