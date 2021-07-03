<?php
/**
 * @package RemoveLinksScripts\Admin
 */

class Remove_Links_Scripts_Settings {
	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->remove_scripts_settings();
	}

	/**
	 * Remove Links and Scripts Settings
	 */
	private function remove_scripts_settings() {
		if ( isset( $_POST['submit'] ) ) {
			if ( ! isset( $_POST['shortlink'] ) ) {
				$_POST['shortlink'] = '';
			}
			if ( ! isset( $_POST['rsd_link'] ) ) {
				$_POST['rsd_link'] = '';
			}
			if ( ! isset( $_POST['wlwmanifest_link'] ) ) {
				$_POST['wlwmanifest_link'] = '';
			}
			if ( ! isset( $_POST['feed_links'] ) ) {
				$_POST['feed_links'] = '';
			}
			if ( ! isset( $_POST['emoji_scripts'] ) ) {
				$_POST['emoji_scripts'] = '';
			}
			if ( ! isset( $_POST['wp_embed'] ) ) {
				$_POST['wp_embed'] = '';
			}
			if ( ! isset( $_POST['wp_json'] ) ) {
				$_POST['wp_json'] = '';
			}
			if ( ! isset( $_POST['emoji_styles'] ) ) {
				$_POST['emoji_styles'] = '';
			}
			if ( ! isset( $_POST['generator'] ) ) {
				$_POST['generator'] = '';
			}
			if ( ! isset( $_POST['rel_link'] ) ) {
				$_POST['rel_link'] = '';
			}

			$remove_settings =  array(
				'shortlink'					=>	$_POST['shortlink'],
				'rsd_link'					=>	$_POST['rsd_link'],
				'wlwmanifest_link'	=>	$_POST['wlwmanifest_link'],
				'feed_links'				=>	$_POST['feed_links'],
				'emoji_scripts'			=>	$_POST['emoji_scripts'],
				'wp_embed'					=>	$_POST['wp_embed'],
				'wp_json'						=>	$_POST['wp_json'],
				'emoji_styles'			=>	$_POST['emoji_styles'],
				'generator'					=>	$_POST['generator'],
				'rel_link'					=>	$_POST['rel_link'],
			);
			update_option( 'remove_links_scripts', serialize( $remove_settings ) );
		}
		$remove_settings = unserialize( get_option('remove_links_scripts') );
		$remove_settings_shortlink_checked        = '';
		$remove_settings_rsd_link_checked         = '';
		$remove_settings_wlwmanifest_link_checked = '';
		$remove_settings_feed_links_checked       = '';
		$remove_settings_emoji_scripts_checked    = '';
		$remove_settings_wp_embed_checked         = '';
		$remove_settings_wp_json_checked          = '';
		$remove_settings_emoji_styles_checked     = '';
		$remove_settings_generator_checked        = '';
		$remove_settings_rel_link_checked         = '';

		if ( isset( $remove_settings ) ) {
			if ( esc_attr( $remove_settings['shortlink'] ) == 'on' ) {
				$remove_settings_shortlink_checked = 'checked';
			}

			if ( esc_attr( $remove_settings['rsd_link'] ) == 'on' ) {
				$remove_settings_rsd_link_checked = 'checked';
			}

			if ( esc_attr( $remove_settings['wlwmanifest_link'] ) == 'on' ) {
				$remove_settings_wlwmanifest_link_checked = 'checked';
			}

			if ( esc_attr( $remove_settings['feed_links'] ) == 'on' ) {
				$remove_settings_feed_links_checked = 'checked';
			}

			if ( esc_attr( $remove_settings['emoji_scripts'] ) == 'on' ) {
				$remove_settings_emoji_scripts_checked = 'checked';
			}

			if ( esc_attr( $remove_settings['wp_embed'] ) == 'on' ) {
				$remove_settings_wp_embed_checked = 'checked';
			}

			if ( esc_attr( $remove_settings['wp_json'] ) == 'on' ) {
				$remove_settings_wp_json_checked = 'checked';
			}

			if ( esc_attr( $remove_settings['emoji_styles'] ) == 'on' ) {
				$remove_settings_emoji_styles_checked = 'checked';
			}

			if ( esc_attr( $remove_settings['generator'] ) == 'on' ) {
				$remove_settings_generator_checked = 'checked';
			}

			if ( esc_attr( $remove_settings['rel_link'] ) == 'on' ) {
				$remove_settings_rel_link_checked = 'checked';
			}
		}
		wp_enqueue_style( 'style',
			plugins_url( '/admin/css/admin-style.min.css', REMOVE_LINKS_SCRIPTS_FILE )
		);
		?>
		<div class="wrap">
			<h1><?php _e( 'Remove Links and Scripts Settings', 'remove-links-and-scripts' ); ?></h1>
			<div><?php _e( 'Change settings to remove unwanted links and scripts from the wordpress.', 'remove-links-and-scripts' ); ?></div>
			<form enctype="multipart/form-data" action="" method="POST" id="remove-links-and-scripts">
   
				<table class="remove-links-and-scripts">
					<caption>Remove Links</caption>
					<tbody>
						<tr>
							<td><input type="checkbox" name="shortlink" value="on" <?php echo $remove_settings_shortlink_checked; ?> /><strong><?php _e( 'Remove Shortlink', 'remove-links-and-scripts' ); ?></strong></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="rsd_link" value="on" <?php echo $remove_settings_rsd_link_checked; ?> /><strong><?php _e( 'Remove RSD Links', 'remove-links-and-scripts' ); ?></strong></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="wlwmanifest_link" value="on" <?php echo $remove_settings_wlwmanifest_link_checked; ?> /><strong><?php _e( 'Remove WLW Manifest Links', 'remove-links-and-scripts' ); ?></strong></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="feed_links" value="on" <?php echo $remove_settings_feed_links_checked; ?> /><strong><?php _e( 'Remove RSS Links', 'remove-links-and-scripts' ); ?></strong></td>
						</tr>
					</tbody>
				</table>

				<table class="remove-links-and-scripts">
					<caption>Remove Scripts</caption>
					<tbody>
						<tr>
							<td><input type="checkbox" name="emoji_scripts" value="on" <?php echo $remove_settings_emoji_scripts_checked; ?> /><strong><?php _e( 'Remove Emoji Scripts', 'remove-links-and-scripts' ); ?></strong></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="wp_embed" value="on" <?php echo $remove_settings_wp_embed_checked; ?> /><strong><?php _e( 'Remove Oembed(json + xml)', 'remove-links-and-scripts' ); ?></strong></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="wp_json" value="on" <?php echo $remove_settings_wp_json_checked; ?> /><strong><?php _e( 'Remove wp_json', 'remove-links-and-scripts' ); ?></strong></td>
						</tr>
					</tbody>
				</table>

				<table class="remove-links-and-scripts">
					<caption>Remove Styles</caption>
					<tbody>
						<tr>
							<td><input type="checkbox" name="emoji_styles" value="on" <?php echo $remove_settings_emoji_styles_checked; ?> /><strong><?php _e( 'Remove Emoji Styles', 'remove-links-and-scripts' ); ?></strong></td>
						</tr>
					</tbody>
				</table>

				<table class="remove-links-and-scripts">
					<caption>Remove Meta</caption>
					<tbody>
						<tr>
							<td><input type="checkbox" name="generator" value="on" <?php echo $remove_settings_generator_checked; ?> /><strong><?php _e( 'Remove WordPress Generator Meta', 'remove-links-and-scripts' ); ?></strong></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="rel_link" value="on" <?php echo $remove_settings_rel_link_checked; ?> /><strong><?php _e( 'Remove Ajacent Relational Links (Next + Prev)', 'remove-links-and-scripts' ); ?></strong></td>
						</tr>
					</tbody>
				</table>

				<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Changes', 'remove-links-and-scripts' ); ?>" /></p>
			</form>
		</div>
		<?php
	}
}
