<?php
/**
 * @package RemoveLinksScripts\Admin
 */

class Remove_Links_Scripts_Admin {
  
	/**
	 * Initializes WordPress hooks.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_filter( 'plugin_action_links_' . REMOVE_LINKS_SCRIPTS_BASENAME,
			array( $this, 'settings_link' ) );
  }

	/**
	 * Add Settings Page in Menu.
	 */
	public function admin_menu() {
		add_menu_page( 'Remove Links and Scripts Settings',
			'Remove Links and Scripts', 'administrator',
			'remove-links-scripts-settings', array( $this, 'admin_settings_page' )
		);
		add_submenu_page( 'remove-links-scripts-settings',
			'Remove Links and Scripts Settings', 'Settings',
			'administrator', 'remove-links-scripts-settings',
			array( $this, 'admin_settings_page' )
		);
		add_submenu_page( 'remove-links-scripts-settings',
			'About Remove Links and Scripts', 'About', 'administrator',
			'remove-links-scripts-about-plugins', array( $this, 'about_plugin' )
		);
	}

	/**
	 * Settings Page where user can choose their settings for remove links and scripts.
	 */
	public function admin_settings_page() {
		if ( ! current_user_can( 'administrator' ) )  {
			wp_die(
				__( 'You do not have sufficient permissions to access this page.' )
			);
		}

		require_once(
			REMOVE_LINKS_SCRIPTS_PATH . 'admin/class-remove-links-scripts-settings.php'
		);
		new Remove_Links_Scripts_Settings();
		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), 1 );
	}

	/**
	 * Add About Plugins Page
	 */
	public function about_plugin() {
		require_once(
			REMOVE_LINKS_SCRIPTS_PATH . 'admin/class-remove-links-scripts-about.php'
		);
		new Remove_Links_Scripts_About();
		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), 1 );
	}
	
	/**
	 * Add Plugin Support and Follow Message in the footer of Admin Pages
	 */
	public function admin_footer_text() {
		$footer_text = sprintf(
			__( 'Remove Links and Scripts version %s by <a href="%s" title="YAS Global Website" target="_blank">YAS Global</a> - <a href="%s" title="Support forums" target="_blank">Support forums</a> - Follow on Twitter: <a href="%s" title="Follow YAS Global on Twitter" target="_blank">YAS Global</a>', 'remove-links-and-scripts' ),
			REMOVE_LINKS_SCRIPTS_PLUGIN_VERSION, 'https://www.yasglobal.com',
			'https://wordpress.org/support/plugin/remove-links-and-scripts',
			'https://twitter.com/samisiddiqui91'
		);
		return $footer_text;
	}

	/**
	 * Add About, Contact and Settings Page Link on the Plugin Page
	 * under the Plugin Name.
	 */
	public function settings_link( $links ) {
		$about = sprintf(
			__( '<a href="%s" title="About">About</a>', 'remove-links-and-scripts' ),
			'admin.php?page=remove-links-scripts-about-plugins'
		);
		$contact = sprintf(
			__( '<a href="%s" title="Contact" target="_blank">Contact</a>', 'remove-links-and-scripts' ),
			'https://www.yasglobal.com/#request-form'
		);
		$settings_link = sprintf(
			__( '<a href="%s" title="Settings">Settings</a>', 'remove-links-and-scripts' ),
			'admin.php?page=remove-links-scripts-settings'
		);
		array_unshift( $links, $settings_link );
		array_unshift( $links, $contact );
		array_unshift( $links, $about );
		return $links;
	}
}
