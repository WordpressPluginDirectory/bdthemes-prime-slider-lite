<?php

namespace PrimeSlider\Modules\Elysium\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use PrimeSlider\Utils;

use PrimeSlider\Traits\Global_Widget_Controls;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Elysium extends Widget_Base {

	use Global_Widget_Controls;

	public function get_name() {
		return 'prime-slider-elysium';
	}

	public function get_title() {
		return BDTPS . esc_html__( 'Elysium', 'bdthemes-prime-slider' );
	}

	public function get_icon() {
		return 'bdt-widget-icon ps-wi-elysium';
	}

	public function get_categories() {
		return ['prime-slider'];
	}

	public function get_keywords() {
		return ['prime slider', 'slider', 'elysium', 'prime'];
	}

	public function get_style_depends() {
		return ['swiper', 'prime-slider-font', 'ps-elysium'];
	}

	public function get_script_depends() {
		$reveal_effects = prime_slider_option('reveal-effects', 'prime_slider_other_settings', 'off');
		if ('on' === $reveal_effects) {
			if ( true === _is_ps_pro_activated() ) {
				return ['swiper', 'anime', 'revealFx', 'ps-elysium'];
			} else {
				return ['swiper', 'ps-elysium'];
			}
		} else {
			return ['swiper', 'ps-elysium'];
		}
	}
 
	public function get_custom_help_url() {
		return 'https://youtu.be/S3c1G6AFGi0';
	}

	public function has_widget_inner_wrapper(): bool {
        return ! \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_optimized_markup' );
    }
	protected function is_dynamic_content(): bool {
		return false;
	}

	protected function register_controls() {
		$reveal_effects = prime_slider_option('reveal-effects', 'prime_slider_other_settings', 'off');

		$this->start_controls_section(
			'section_content_sliders',
			[
				'label' => esc_html__('Sliders', 'bdthemes-prime-slider'),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs('tabs_slider_item_content');

        $repeater->start_controls_tab(
            'tab_slider_content',
            [
                'label' => __('Content', 'bdthemes-prime-slider'),
            ]
        );

		/**
         * Repeater Title Controls
         */
        $this->register_repeater_title_controls($repeater);

		/**
         * Repeater Image Controls
         */
        $this->register_repeater_image_controls($repeater);

		$repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'tab_slider_optional',
            [
                'label' => __('Optional', 'bdthemes-prime-slider'),
            ]
        );

		/**
         * Repeater Title Link Controls
         */
        $this->register_repeater_title_link_controls($repeater);

		/**
         * Repeater Text Controls
         */
        $this->register_repeater_text_controls($repeater);

		$repeater->end_controls_tab();
        $repeater->end_controls_tabs();

		$this->add_control(
			'slides',
			[
				'label'   => esc_html__('Items', 'bdthemes-prime-slider'),
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => [
					[
						'title'     => esc_html__('Item One', 'bdthemes-prime-slider'),
						'text'     => esc_html__('Prime Slider Addons for elementor!', 'bdthemes-prime-slider'),
						'image'     => ['url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-1.svg']
					],
					[
						'title'     => esc_html__('Item Two', 'bdthemes-prime-slider'),
						'text'     => esc_html__('Prime Slider Addons for elementor!', 'bdthemes-prime-slider'),
						'image'     => ['url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-4.svg']
					],
					[
						'title'     => esc_html__('Item Three', 'bdthemes-prime-slider'),
						'text'     => esc_html__('Prime Slider Addons for elementor!', 'bdthemes-prime-slider'),
						'image'     => ['url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-5.svg']
					],
					[
						'title'     => esc_html__('Item Four', 'bdthemes-prime-slider'),
						'text'     => esc_html__('Prime Slider Addons for elementor!', 'bdthemes-prime-slider'),
						'image'     => ['url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-6.svg']
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__('Additional Options', 'bdthemes-prime-slider'),
			]
		);

		$this->add_responsive_control(
			'slider_slider_height',
			[
				'label' => esc_html__('Slider Height', 'bdthemes-prime-slider'),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => ['px', 'vh'],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1024,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-prime-slider-elysium' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slider_image_height',
			[
				'label' => esc_html__('Image Height', 'bdthemes-prime-slider') . BDTPS_CORE_PC,
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 1024,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bdt-prime-slider-elysium .bdt-image-wrap .bdt-img' => 'height: {{SIZE}}{{UNIT}};',
				],
				'classes'   => BDTPS_CORE_IS_PC
			]
		);

		/**
		 * Show Title Controls
		 */
		$this->register_show_title_controls();

		/**
		 * Show text Controls
		 */
		$this->register_show_text_controls();

		/**
		 * Show Navigation Controls
		 */
		$this->register_show_navigation_controls();

		/**
		 * Show Pagination Controls
		 */
		$this->register_show_pagination_controls();

		$this->add_responsive_control(
            'content_alignment',
            [
                'label'   => esc_html__( 'Alignment', 'bdthemes-prime-slider' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'bdthemes-prime-slider' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'bdthemes-prime-slider' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'bdthemes-prime-slider' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .bdt-prime-slider-elysium .bdt-content' => 'text-align: {{VALUE}};',
                ],
				'separator' => 'before'
            ]
		);

		/**
		 * Thumbnail Size Controls
		 */
		$this->register_thumbnail_size_controls();
		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_carousel_settings',
			[
				'label' => __( 'Slider Settings', 'bdthemes-prime-slider' ),
			]
		);

		/**
		 * Autoplay Controls
		 */
		$this->register_autoplay_controls();

		/**
		 * Grab Cursor Controls
		 */
		$this->register_grab_cursor_controls();

		/**
		 * Loop Controls
		 */
		$this->register_loop_controls();

		/**
		 * Speed & Observer Controls
		 */
		$this->register_speed_observer_controls();

		$this->end_controls_section();


		/**
		 * Reveal Effects
		 */
		if ('on' === $reveal_effects) {
			$this->register_reveal_effects();
		}

		//style
		$this->start_controls_section(
			'section_style_layout',
			[
				'label'     => __( 'Sliders', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-elysium',
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __( 'Content Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .bdt-prime-slider-elysium .bdt-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label'     => __( 'Image', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_background',
				'label' => esc_html__('Background', 'bdthemes-prime-slider'),
				'types' => ['classic', 'gradient'],
				'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .bdt-prime-slider-elysium .bdt-item.swiper-slide-active .bdt-image-wrap::before',
				'fields_options' => [
					'background' => [
						'label' => esc_html__('Overlay Color', 'bdthemes-prime-slider'),
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'image_border',
				'selector'    => '{{WRAPPER}} .bdt-prime-slider-elysium .bdt-image-wrap',
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-prime-slider-elysium .bdt-image-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'custom_css_filters',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-elysium .bdt-image-wrap .bdt-img',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label'     => __( 'Title', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-prime-slider-elysium .bdt-item.swiper-slide-active .bdt-title-wrap .bdt-title, 
					{{WRAPPER}}  .bdt-prime-slider-elysium .bdt-item.swiper-slide-active .bdt-title-wrap .bdt-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label'     => __( 'Hover Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-prime-slider-elysium .bdt-item.swiper-slide-active .bdt-title-wrap .bdt-title:hover, {{WRAPPER}} .bdt-prime-slider-elysium .bdt-item.swiper-slide-active .bdt-title-wrap .bdt-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label'      => __( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .bdt-prime-slider-elysium .bdt-title-wrap .bdt-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => __( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .bdt-prime-slider-elysium .bdt-title-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-elysium .bdt-title-wrap .bdt-title',
			]
		);

		$this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'title_text_stroke',
				'label'    => esc_html__('Text Stroke', 'bdthemes-prime-slider'),
                'selector' => '{{WRAPPER}} .bdt-prime-slider-elysium .bdt-title-wrap .bdt-title',
            ]
        );

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'label' => __( 'Text Shadow', 'bdthemes-prime-slider'),
				'selector' => '{{WRAPPER}} .bdt-prime-slider-elysium .bdt-title-wrap .bdt-title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			[
				'label'     => __( 'Text', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-prime-slider-elysium .bdt-text' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-elysium .bdt-text',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'label' => __( 'Text Shadow', 'bdthemes-prime-slider'),
				'selector' => '{{WRAPPER}} .bdt-prime-slider-elysium .bdt-text',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => __('Navigation', 'bdthemes-prime-slider'),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'pagi_nav_margin',
			[
				'label'      => __( 'Spacing', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .bdt-prime-slider-elysium .bdt-navigation-pagi-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'arrows_heading',
			[
				'label'     => __('Arrows', 'bdthemes-prime-slider'),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'show_navigation_arrows' => ['yes'],
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'navigation_color',
			[
				'label'     => __('Color', 'bdthemes-prime-slider'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-prime-slider-elysium .bdt-navigation-btn .bdt-link, 
					 {{WRAPPER}} .bdt-prime-slider-elysium .bdt-navigation-btn .bdt-link--arrowed g' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_navigation_arrows' => ['yes'],
				],
			]
		);

		$this->add_control(
			'navigation_hover_color',
			[
				'label'     => __('Hover Color', 'bdthemes-prime-slider'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-prime-slider-elysium .bdt-navigation-btn .bdt-link:hover, 
					 {{WRAPPER}}  .bdt-prime-slider-elysium .bdt-navigation-btn .bdt-link--arrowed:hover g' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_navigation_arrows' => ['yes'],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'navigation_typography',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-elysium .bdt-navigation-btn .bdt-link',
			]
		);
		
		$this->add_control(
			'pagination_heading',
			[
				'label'     => __('Dots', 'bdthemes-prime-slider'),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'show_navigation_dots' => ['yes'],
				],
				'separator' => 'before'
			]
		);

		$this->start_controls_tabs(
			'pagination_tabs'
		);
		
		$this->start_controls_tab(
			'pagination_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label'     => __('Color', 'bdthemes-prime-slider'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-prime-slider-elysium .bdt-pagination .swiper-pagination-bullet' => 'background: {{VALUE}}',
				],
				'condition' => [
					'show_navigation_dots' => ['yes'],
				],
			]
		);

		$this->add_responsive_control(
			'pagination_width',
			[
				'label' => esc_html__('Width', 'bdthemes-prime-slider') . BDTPS_CORE_PC,
				'type'  => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .bdt-prime-slider-elysium .bdt-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_navigation_dots' => ['yes'],
				],
				'classes'   => BDTPS_CORE_IS_PC
			]
		);

		$this->add_responsive_control(
			'pagination_height',
			[
				'label' => esc_html__('Height', 'bdthemes-prime-slider') . BDTPS_CORE_PC,
				'type'  => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .bdt-prime-slider-elysium .bdt-pagination .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_navigation_dots' => ['yes'],
				],
				'classes'   => BDTPS_CORE_IS_PC
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'pagination_border',
				'selector'    => '{{WRAPPER}} .bdt-prime-slider-elysium .bdt-pagination .swiper-pagination-bullet',
			]
		);

		$this->add_responsive_control(
			'pagination_border_radius',
			[
				'label'      => __( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bdt-prime-slider-elysium .bdt-pagination .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_active_tab',
			[
				'label' => esc_html__( 'Active', 'bdthemes-prime-slider' ),
			]
		);


		$this->add_control(
			'pagination_active_color',
			[
				'label'     => __('Color', 'bdthemes-prime-slider'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bdt-prime-slider-elysium .bdt-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background: {{VALUE}}',
				],
				'condition' => [
					'show_navigation_dots' => ['yes'],
				],
			]
		);

		$this->add_responsive_control(
			'pagination_width_active',
			[
				'label' => esc_html__('Width', 'bdthemes-prime-slider'),
				'type'  => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .bdt-prime-slider-elysium .bdt-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_navigation_dots' => ['yes'],
				],
			]
		);

		$this->add_responsive_control(
			'pagination_height_active',
			[
				'label' => esc_html__('Height', 'bdthemes-prime-slider'),
				'type'  => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .bdt-prime-slider-elysium .bdt-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_navigation_dots' => ['yes'],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'pagination_border_active',
				'selector'    => '{{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render_header() {
		$settings   = $this->get_settings_for_display();
		$id         = 'bdt-prime-slider-' . $this->get_id();

		if ($settings['show_text'] == 'yes') {
			$targets[2] = '.bdt-text';
		}

		/**
		 * Reveal Effects
		 */
		$this->reveal_effects_attr('prime-slider-elysium');

		$this->add_render_attribute( 'prime-slider-elysium', 'id', $id );
		$this->add_render_attribute( 'prime-slider-elysium', 'class', [ 'bdt-prime-slider-elysium', 'elementor-swiper' ] );

		$this->add_render_attribute(
			[
				'prime-slider-elysium' => [
					'data-settings' => [
						wp_json_encode(array_filter([
							"autoplay"       => ( "yes" == $settings["autoplay"] ) ? [ "delay" => $settings["autoplay_speed"] ] : false,
							"loop"           => ($settings["loop"] == "yes") ? true : false,
							"speed"          => $settings["speed"]["size"],
							"pauseOnHover"   => ("yes" == $settings["pauseonhover"]) ? true : false,
							"slidesPerView"  => isset($settings["columns_mobile"]) ? (int)$settings["columns_mobile"] : 1,
							"spaceBetween"   => !empty($settings["item_gap_mobile"]["size"]) ? (int)$settings["item_gap_mobile"]["size"] : 0,
							"centeredSlides" => true,
							"grabCursor"     => ($settings["grab_cursor"] === "yes") ? true : false,
							"effect"         => 'slide',
                            "parallax"       => true,
							"observer"       => ($settings["observer"]) ? true : false,
							"observeParents" => ($settings["observer"]) ? true : false,
							"initialSlide" => 2,
							"breakpoints" => [
								"768" => [
									"slidesPerView" => 1.8,
									"spaceBetween" => 100,
								],
								"1024" => [
									"slidesPerView" => 1.8,
									"spaceBetween" => 200,
								],
							],
								

							"navigation"         => [
								"nextEl" => "#" . $id . " .bdt-button-next",
								"prevEl" => "#" . $id . " .bdt-button-prev",
							],
							"pagination"         => [
								"el"             => "#" . $id . " .bdt-pagination",
								"clickable"      => "true",
							],
            ]))
					]
				]
			]
		);		

		$this->add_render_attribute( 'prime-slider', 'class', 'bdt-prime-slider' );

		$direction = is_rtl() ? 'rtl' : 'ltr';
		$this->add_render_attribute([
			'swiper' => [
				'class' => 'bdt-slider-continer',
				'role' => 'region',
				'aria-roledescription' => 'carousel',
				'aria-label' => $this->get_title() . ' ' . esc_html__( 'Slider', 'bdthemes-prime-slider' ),
				'dir' => $direction,
			],
		]);

		?>
		<div <?php $this->print_render_attribute_string( 'prime-slider' ); ?>>
		<div <?php $this->print_render_attribute_string( 'prime-slider-elysium' ); ?>>
			<div <?php $this->print_render_attribute_string( 'swiper' ); ?>>
				<div class="swiper-wrapper">
		<?php
	}

	public function render_navigation_arrows() {
		$settings = $this->get_settings_for_display();
	
		?>

        <div class="bdt-navigation-pagi-wrap reveal-muted">
			<?php if ($settings['show_navigation_arrows']) : ?>
				<div class="bdt-navigation-wrap">
					<div class="bdt-button-next bdt-navigation-btn">
						<div class="bdt-link bdt-link--arrowed">
							<span><?php echo esc_html_x('next slide', 'Frontend', 'bdthemes-prime-slider'); ?></span>
							<svg class="bdt-arrow-icon" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 32 32">
								<g fill="none" stroke="#ff215a" stroke-width="1.5" stroke-linejoin="round" stroke-miterlimit="10">
								<circle class="bdt-arrow-icon--circle" cx="16" cy="16" r="15.12"></circle>
								<path class="bdt-arrow-icon--arrow" d="M16.14 9.93L22.21 16l-6.07 6.07M8.23 16h13.98"></path>
								</g>
							</svg>
					</div>
					</div>
					<div class=" bdt-button-prev bdt-navigation-btn">
						<div class="bdt-link bdt-link--arrowed">
							<span><?php echo esc_html_x('prev slide', 'Frontend', 'bdthemes-prime-slider'); ?></span>
							<svg class="bdt-arrow-icon" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 32 32">
								<g fill="none" stroke="#ff215a" stroke-width="1.5" stroke-linejoin="round" stroke-miterlimit="10">
								<circle class="bdt-arrow-icon--circle" cx="16" cy="16" r="15.12"></circle>
								<path class="bdt-arrow-icon--arrow" d="M16.14 9.93L22.21 16l-6.07 6.07M8.23 16h13.98"></path>
								</g>
							</svg>
						</div>

					</div>
				</div>
			<?php endif; ?>

			<?php if ($settings['show_navigation_dots']) : ?>
			    <div class="bdt-pagination"></div>
		    <?php endif; ?>
        </div>
		<?php
	}

	public function render_footer() {
		$settings = $this->get_settings_for_display();
		
		?>
				</div>
			</div>
			
			<?php $this->render_navigation_arrows(); ?>
		</div>
		</div>

		<?php
	}

	public function rendar_item_image($slide) {
		$settings = $this->get_settings_for_display();
		
		?>
		<div class="bdt-image-wrap">
			<?php
			$thumb_url = Group_Control_Image_Size::get_attachment_image_src($slide['image']['id'], 'thumbnail_size', $settings);
			if (!$thumb_url) {
				printf('<img src="%1$s" alt="%2$s" class="bdt-img">', esc_url($slide['image']['url']), esc_html($slide['title']));
			} else {
				print(wp_get_attachment_image(
					$slide['image']['id'],
					$settings['thumbnail_size_size'],
					false,
					[
						'class' => 'bdt-img',
						'alt' => esc_html($slide['title'])
					]
				));
			}
			?>
		</div>
		<?php
	}

	public function render_slides_loop() {
        $settings = $this->get_settings_for_display();

        foreach ($settings['slides'] as $slide) : 
        	if ($slide['title']) {
        		$this->add_link_attributes('title_link', $slide['title_link'], true);
        	}
			
			?>
            <div class="bdt-item swiper-slide">
					<?php $this->rendar_item_image($slide); ?>

					<div class="bdt-content">
						<?php if ($slide['title'] && ('yes' == $settings['show_title'])) : ?>
							<div class="bdt-title-wrap"> 
							<<?php echo esc_attr(Utils::get_valid_html_tag($settings['title_html_tag'])); ?> class="bdt-title" data-reveal="reveal-active">
									<?php if ('' !== $slide['title_link']['url']) : ?>
										<a <?php $this->print_render_attribute_string('title_link'); ?>>
										<?php endif; ?>
											<?php echo esc_html($slide['title']); ?>
											<?php if ('' !== $slide['title_link']['url']) : ?>
										</a>
									<?php endif; ?>
								</<?php echo esc_attr(Utils::get_valid_html_tag($settings['title_html_tag'])); ?>>
							</div>
						<?php endif; ?>
						
						<?php if ($slide['text'] && ('yes' == $settings['show_text'])) : ?>
							<div class="bdt-text" data-reveal="reveal-active">
								<?php echo wp_kses_post($slide['text']); ?>
							</div>
						<?php endif; ?>

					</div>
			</div>

        <?php endforeach;
    }

	public function render() {
		$this->render_header();
		$this->render_slides_loop();
		$this->render_footer();
	}

}
