<?php
/**
 * @package RemoveLinksScripts\Main
 */

// Make sure we don't expose any info if called directly.
if ( ! defined( 'ABSPATH' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

if ( ! function_exists( 'add_action' ) || ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

define( 'REMOVE_LINKS_SCRIPTS_PLUGIN_VERSION', '0.2.4' );

if ( ! defined( 'REMOVE_LINKS_SCRIPTS_PATH' ) ) {
	define( 'REMOVE_LINKS_SCRIPTS_PATH',
		plugin_dir_path( REMOVE_LINKS_SCRIPTS_FILE )
	);
}

if ( ! defined( 'REMOVE_LINKS_SCRIPTS_BASENAME' ) ) {
	define( 'REMOVE_LINKS_SCRIPTS_BASENAME',
		plugin_basename( REMOVE_LINKS_SCRIPTS_FILE )
	);
}

require_once(
	REMOVE_LINKS_SCRIPTS_PATH . 'frontend/class-remove-links-scripts-frontend.php'
);
new Remove_Links_Scripts_Frontend();

if ( is_admin() ) {
	require_once(
		REMOVE_LINKS_SCRIPTS_PATH . 'admin/class-remove-links-scripts-admin.php'
	);
	new Remove_Links_Scripts_Admin();

	register_uninstall_hook(
		REMOVE_LINKS_SCRIPTS_FILE, 'remove_links_scripts_plugin_uninstall'
	);
}

/**
 * Remove Option on uninstalling/deleting the Plugin.
 */
function remove_links_scripts_plugin_uninstall() {
	delete_option( 'remove_links_scripts' );
}

/**
 * Add textdomain hook for translation.
 */
function remove_links_scripts_translation_capability() {
	load_plugin_textdomain( 'remove-links-scripts', FALSE,
		basename( dirname( REMOVE_LINKS_SCRIPTS_FILE ) ) . '/languages/'
	);
}
add_action( 'plugins_loaded', 'remove_links_scripts_translation_capability' );
