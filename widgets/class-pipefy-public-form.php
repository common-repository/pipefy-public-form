<?php

namespace PipefyPublicForm\Widgets;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Pipefy Public form widget class
 */
class Pipefy_Public_Form extends Widget_Base {
	/**
	 * Prefix to prevent conflict with Widgets controls.
	 */
	public $prefix = 'pfypf_public_form';

	/**
	 * Get name.
	 */
	public function get_name() {
		return 'pipefy-public-form';
	}

	/**
	 * Get title.
	 */
	public function get_title()	{
		return 'Pipefy Public Form';
	}

	/**
	 * Get icon.
	 */
	public function get_icon() {
		return 'eicon-code';
	}

	/**
	 * Get categories.
	 */
	public function get_categories() {
		return array( 'general' );
	}

	/**
	 * Register controls.
	 */
	protected function register_controls() {
		$this->start_controls_section(
			$this->prefix . '_form_content',
			array(
				'label' => __( 'Public Form URL', 'pipefy-public-form' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			$this->prefix . '_link',
			[
				'label' => __( 'Link', 'pipefy-public-form' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'https://app.pipefy.com/public/form/abcdef', 'pipefy-public-form' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			$this->prefix . '_container_style',
			array(
				'label' => __( 'Form', 'pipefy-public-form' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			$this->prefix . '_iframe_width',
			[
				'label' => esc_html__( 'Width', 'pipefy-public-form' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 480,
				],
				'selectors' => [
					'{{WRAPPER}} .pfy-responsive-iframe-container iframe' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			$this->prefix . '_iframe_height',
			[
				'label' => esc_html__( 'Height', 'pipefy-public-form' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 400,
				],
				'selectors' => [
					'{{WRAPPER}} .pfy-responsive-iframe-container iframe' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			$this->prefix . '_iframe_alignment',
			[
				'label' => esc_html__( 'Alignment', 'pipefy-public-form' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'textdomain' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'textdomain' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'textdomain' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .pfy-responsive-iframe-container' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render Widget.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$public_form_link = $settings[ $this->prefix . '_link' ];

		if ( empty( $public_form_link ) ) {
			echo esc_html__( 'Please, add the public form url to control.', 'pipefy-public-form' );
			return;
		}

		$is_valid_url = preg_match( '/https\:\/\/app\.pipefy\.com\/public\/form\/.+/', $public_form_link );
		if ( $is_valid_url ) {
			?>
				<div class="pfy-responsive-iframe-container">
					<iframe src="<?php echo esc_attr( $public_form_link ); ?>?embedded=true" frameborder="0" loading="lazy"></iframe>
				</div>

				<?php if ( $this->is_widget_first_render( $this->get_name() ) ) : ?>
					<style>.pfy-responsive-iframe-container{display:flex;overflow:hidden;}.pfy-responsive-iframe-container iframe{width:100%;}</style>
				<?php endif; ?>
			<?php
		} else {
			echo esc_html__( 'Sorry the url is not valid.', 'pipefy-public-form' );
		}
	}
}
