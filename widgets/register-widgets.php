<?php

use PipefyPublicForm\Widgets\Pipefy_Public_Form;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register Elementor Widgets
 *
 * @param object $widgets_manager object from Elementor to register widgets.
 */
function pfypf_register_widgets( $widgets_manager ) {
	require_once PFYPF_PLUGIN_PATH . 'widgets/class-pipefy-public-form.php';
	$widgets_manager->register( new Pipefy_Public_Form() );
}

add_action( 'elementor/widgets/register', 'pfypf_register_widgets' );
