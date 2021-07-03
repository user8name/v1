<?php
/**
 * @package RemoveLinksScripts\Frontend
 */

class Remove_Links_Scripts_Frontend {

	/**
	 * Initialize WordPress init Hook.
	 */
	public function __construct() {
		add_filter( 'init', array( $this, 'remove_links_scripts' ) );
	}

	/**
	 * Remove Links and Scripts according to the User/'s Settings.
	 */
	public function remove_links_scripts() {
		$remove_settings = unserialize( get_option( 'remove_links_scripts' ) );

		if ( isset( $remove_settings ) && ! empty( $remove_settings ) ) {
			if ( esc_attr( $remove_settings['shortlink'] ) == 'on' ) {
				remove_action('wp_head', 'wp_shortlink_wp_head');
				remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
			}

			if ( esc_attr( $remove_settings['rsd_link'] ) == 'on' ) {
				remove_action( 'wp_head', 'rsd_link' );
			}

			if ( esc_attr( $remove_settings['wlwmanifest_link'] ) == 'on' ) {
				remove_action( 'wp_head', 'wlwmanifest_link' );
			}

			if ( esc_attr( $remove_settings['feed_links'] ) == 'on' ) {
				remove_action( 'wp_head', 'feed_links', 2 );
				remove_action('wp_head','feed_links_extra', 3);
			}

			if ( esc_attr( $remove_settings['emoji_scripts'] ) == 'on' ) {
				remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
				remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
			}

			if ( esc_attr( $remove_settings['wp_embed'] ) == 'on' ) {
				remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
				add_action( 'wp_footer', array( $this, 'deregister_wp_embed' ) );
			}

			if ( esc_attr( $remove_settings['emoji_styles'] ) == 'on' ) {
				remove_action( 'wp_print_styles', 'print_emoji_styles' );
				remove_action( 'admin_print_styles', 'print_emoji_styles' );
			}

			if ( esc_attr( $remove_settings['wp_json'] ) == 'on' ) {
				remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
				remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
				remove_action( 'wp_head', 'wp_resource_hints', 2 );
			}

			if ( esc_attr( $remove_settings['generator'] ) == 'on' ) {
				remove_action('wp_head', 'wp_generator');
			}

			if ( esc_attr( $remove_settings['rel_link'] ) == 'on' ) {
				remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
			}
		}
	}

	/**
	 * Remove/Deregister wp-embed script.
	 */
	public function deregister_wp_embed() {
		wp_deregister_script( 'wp-embed' );
	}

}
