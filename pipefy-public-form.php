<?php
/**
 * Plugin Name:       Pipefy Public Form
 * Description:       Pipefy Public Form allows you to easily add customizable forms to your website to capture lead or customer requests and data.
 * Requires at least: 5.9
 * Requires PHP:      7.0
 * Version:           1.1
 * Author:            Pipefy
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pipefy-public-form
 *
 * @package           pipefy-public-form
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'PFYPF_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'PFYPF_VERSION', '1.1' );
define( 'PFYPF_PHP_MINIMUM_VERSION', '7.0' );
define( 'PFYPF_WP_MINIMUM_VERSION', '5.9' );

if ( ! version_compare( PHP_VERSION, PFYPF_PHP_MINIMUM_VERSION, '>=' ) ) {
	add_action( 'admin_notices', 'pfypf_notice_php_minimum_version' );
	return;
}

if ( ! version_compare( get_bloginfo( 'version' ), PFYPF_WP_MINIMUM_VERSION, '>=' ) ) {
	add_action( 'admin_notices', 'pfypf_notice_wp_minimum_version' );
	return;
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function pfypf_create_block_pipefy_public_form_block_init() {
	register_block_type( __DIR__ . '/build' );
}

add_action( 'init', 'pfypf_create_block_pipefy_public_form_block_init' );

/**
 * Require Elementor files to add custom Widget.
 */
if ( did_action( 'elementor/loaded' ) ) {
	require_once PFYPF_PLUGIN_PATH . 'widgets/register-widgets.php';
}

/**
 * Admin notice PHP minimum version
 */
function pfypf_notice_php_minimum_version() {
	$message = sprintf(
		esc_html( '%s requires PHP version %s or greater.', 'pipefy-public-form' ),
		'<strong>Pipefy Public Form</strong>',
		PFYPF_PHP_MINIMUM_VERSION
	);

	$html_message = sprintf(
		'<div class="notice notice-error"><p>%s</p></div>',
		$message
	);

	echo wp_kses_post( $html_message );
}

/**
 * Admin notice WP minimum version
 */
function pfypf_notice_wp_minimum_version() {
	$message = sprintf(
		esc_html( '%s requires WP version %s or greater.', 'pipefy-public-form' ),
		'<strong>Pipefy Public Form</strong>',
		PFYPF_WP_MINIMUM_VERSION
	);

	$html_message = sprintf(
		'<div class="notice notice-error"><p>%s</p></div>',
		$message
	);

	echo wp_kses_post( $html_message );
}
