<?php

class TF_Module_Builder_Integration extends TF_Module {
	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct( array(
			'name' => __( 'Builder', 'themify-flow' ),
			'slug' => 'themify-flow-builder-integration',
			'shortcode' => 'tf_builder_integration',
			'category' => 'content'
		) );
	}

	/**
	 * Module settings field
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array
	 */
	public function fields() {
		return array(
			'builder_post_id' => array(
				'type' => 'hidden',
				'label' => '', /* Removed label for cleanliness */
				'class' => 'tf_input_width_70'
			)
		);
	}


	/**
	 * Module style selectors.
	 *
	 * Hold module stye selectors to be used in Styling Panel.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array
	 */
	public function styles() {
		return apply_filters( 'tf_module_builder_styles', array(
				'tf_module_text_container' => array(
						'label' => __('Text Container', 'themify-flow'),
						'selector' => '.tf_module_builder',
						'basic_styling' => array( 'background', 'font', 'padding', 'margin', 'border' ),
				),
				'tf_module_text_p' => array(
						'label' => __( 'Paragraph', 'themify-flow' ),
						'selector' => '.tf_module_builder p',
						'basic_styling' => array( 'border', 'font', 'margin' ),
				),
				'tf_module_text_a' => array(
						'label' => __( 'Link', 'themify-flow' ),
						'selector' => '.tf_module_builder a',
						'basic_styling' => array( 'border', 'font', 'margin' ),
				),
				'tf_module_text_h1' => array(
						'label' => __( 'H1', 'themify-flow' ),
						'selector' => '.tf_module_builder h1',
						'basic_styling' => array( 'font', 'margin' ),
				),
				'tf_module_text_h2' => array(
						'label' => __( 'H2', 'themify-flow' ),
						'selector' => '.tf_module_builder h2',
						'basic_styling' => array( 'font', 'margin' ),
				),
				'tf_module_text_h3' => array(
						'label' => __( 'H3', 'themify-flow' ),
						'selector' => '.tf_module_builder h3',
						'basic_styling' => array( 'font', 'margin' ),
				),
				'tf_module_text_h4' => array(
						'label' => __( 'H4', 'themify-flow' ),
						'selector' => '.tf_module_builder h4',
						'basic_styling' => array( 'font', 'margin' ),
				),
				'tf_module_text_h5' => array(
						'label' => __( 'H5', 'themify-flow' ),
						'selector' => '.tf_module_builder h5',
						'basic_styling' => array( 'font', 'margin' ),
				),
				'tf_module_text_h6' => array(
						'label' => __( 'H6', 'themify-flow' ),
						'selector' => '.tf_module_builder h6',
						'basic_styling' => array( 'font', 'margin' ),
				),
		) );
	}

	/**
	 * Render main shortcode.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param array $atts
	 * @param string $content
	 * @return string
	 */
	public function render_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
				'builder_post_id' => 3861,
		), $atts, $this->shortcode ) );

		return add_builder_section($builder_post_id);
	}
}

new TF_Module_Builder_Integration();
