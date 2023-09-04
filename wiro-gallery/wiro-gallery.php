<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://#
 * @since             1.0.0
 * @package           Wiro_Gallery
 *
 * @wordpress-plugin
 * Plugin Name:       Wiro Gallery
 * Plugin URI:        https://#
 * Description:       Кастомная галерея
 * Version:           1.0.0
 * Author:            Deni Okarin
 * Author URI:        https://#
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wiro-gallery
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

define( 'WG_VERSION', '1.0.0' );

if(!function_exists('wg_init')) {
	add_action( 'plugins_loaded', 'wg_init', 11 );
	
	function wg_init() {
		require_once plugin_dir_path(__FILE__) . 'ajax/wg-ajax.php';

		require_once plugin_dir_path(__FILE__) . 'includes/class-wg-post-type.php';
		require_once plugin_dir_path(__FILE__) . 'includes/class-wg-metaboxes.php';

		require_once plugin_dir_path(__FILE__) . 'includes/elementor/plugin.php';
	}
}


add_action('admin_enqueue_scripts', 'wg_load_admin_scripts');

function wg_load_admin_scripts() {
	wp_enqueue_style( 'wg-admin-main', plugins_url( 'admin/css/main.css', __FILE__ ), array(), WG_VERSION);

	wp_register_script( 'ajax-object', plugins_url( 'public/js/ajax-url.js', __FILE__ ), array(), WG_VERSION, true );
	wp_localize_script( 'ajax-object', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_script( 'ajax-object' );
}

add_action('wp_enqueue_scripts', 'wg_load_scripts');

function wg_load_scripts() {
	wp_enqueue_style( 'wg-lightbox', plugins_url( 'public/css/vendor/lightbox.min.css', __FILE__ ), array(), WG_VERSION);

	wp_enqueue_style( 'wg-main', plugins_url( 'public/css/main.css', __FILE__ ), array(), WG_VERSION);


	wp_enqueue_script('jquery');
	wp_enqueue_script( 'isotope', plugins_url( 'public/js/vendor/isotope.pkgd.min.js', __FILE__ ), array(), WG_VERSION, true );
	wp_enqueue_script( 'wg-lightbox', plugins_url( 'public/js/vendor/lightbox.min.js', __FILE__ ), array('jquery'), WG_VERSION, true );

	wp_enqueue_script( 'wg-main', plugins_url( 'public/js/main.js', __FILE__ ), array(), WG_VERSION, true );
}



