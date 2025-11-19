<?php
/**
 * Investment Portal CPTs, Taxonomies, and ACF Fields.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'investment_portal_register_cpts' ) ) {
	/**
	 * Register Custom Post Types and Taxonomies.
	 */
	function investment_portal_register_cpts() {
		// Register Investment Projects CPT.
		register_post_type(
			'invest_project',
			array(
				'labels'       => array(
					'name'          => __( 'Investment Projects', 'generatepress' ),
					'singular_name' => __( 'Investment Project', 'generatepress' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'supports'     => array( 'title', 'editor', 'thumbnail' ),
				'rewrite'      => array( 'slug' => 'invest-projects' ),
				'show_in_rest' => true,
			)
		);

		// Register Project Categories Taxonomy.
		register_taxonomy(
			'project_category',
			'invest_project',
			array(
				'labels'       => array(
					'name'          => __( 'Project Categories', 'generatepress' ),
					'singular_name' => __( 'Project Category', 'generatepress' ),
				),
				'hierarchical' => true,
				'rewrite'      => array( 'slug' => 'project-categories' ),
				'show_in_rest' => true,
			)
		);

		// Register Land Plots CPT.
		register_post_type(
			'land_plot',
			array(
				'labels'       => array(
					'name'          => __( 'Land Plots', 'generatepress' ),
					'singular_name' => __( 'Land Plot', 'generatepress' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'supports'     => array( 'title', 'editor', 'thumbnail' ),
				'rewrite'      => array( 'slug' => 'land-plots' ),
				'show_in_rest' => true,
			)
		);

		// Register Plot Types Taxonomy.
		register_taxonomy(
			'plot_type',
			'land_plot',
			array(
				'labels'       => array(
					'name'          => __( 'Plot Types', 'generatepress' ),
					'singular_name' => __( 'Plot Type', 'generatepress' ),
				),
				'hierarchical' => true,
				'rewrite'      => array( 'slug' => 'plot-types' ),
				'show_in_rest' => true,
			)
		);
	}
	add_action( 'init', 'investment_portal_register_cpts' );
}

if ( function_exists( 'acf_add_local_field_group' ) ) {
	// For invest_project.
	acf_add_local_field_group(
		array(
			'key'      => 'group_invest_project',
			'title'    => 'Project Details',
			'fields'   => array(
				array(
					'key'   => 'field_short_description',
					'label' => 'Short Description',
					'name'  => 'short_description',
					'type'  => 'textarea',
				),
				array(
					'key'   => 'field_investment_amount',
					'label' => 'Investment Amount',
					'name'  => 'investment_amount',
					'type'  => 'number',
				),
				array(
					'key'     => 'field_project_status',
					'label'   => 'Project Status',
					'name'    => 'project_status',
					'type'    => 'select',
					'choices' => array(
						'idea'         => 'Idea',
						'in_progress'  => 'In Progress',
						'implemented'  => 'Implemented',
					),
				),
				array(
					'key'   => 'field_pdf_presentation',
					'label' => 'PDF Presentation',
					'name'  => 'pdf_presentation',
					'type'  => 'file',
				),
				array(
					'key'   => 'field_image_gallery',
					'label' => 'Image Gallery',
					'name'  => 'image_gallery',
					'type'  => 'gallery',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'invest_project',
					),
				),
			),
		)
	);

	// For land_plot.
	acf_add_local_field_group(
		array(
			'key'      => 'group_land_plot',
			'title'    => 'Land Plot Details',
			'fields'   => array(
				array(
					'key'   => 'field_area_hectares',
					'label' => 'Area (hectares)',
					'name'  => 'area_hectares',
					'type'  => 'number',
				),
				array(
					'key'   => 'field_cadastral_number',
					'label' => 'Cadastral Number',
					'name'  => 'cadastral_number',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_land_purpose',
					'label' => 'Land Purpose',
					'name'  => 'land_purpose',
					'type'  => 'textarea',
				),
				array(
					'key'        => 'field_communications',
					'label'      => 'Communications',
					'name'       => 'communications',
					'type'       => 'repeater',
					'sub_fields' => array(
						array(
							'key'   => 'field_comm_name',
							'label' => 'Name',
							'name'  => 'name',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_comm_status',
							'label' => 'Status',
							'name'  => 'status',
							'type'  => 'text',
						),
					),
				),
				array(
					'key'   => 'field_location_map',
					'label' => 'Location Map',
					'name'  => 'location_map',
					'type'  => 'google_map',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'land_plot',
					),
				),
			),
		)
	);
}

if ( ! function_exists( 'investment_portal_enqueue_scripts' ) ) {
	/**
	 * Enqueue scripts and styles.
	 */
	function investment_portal_enqueue_scripts() {
		if ( is_front_page() ) {
			// Enqueue Swiper JS and CSS.
			wp_enqueue_style( 'swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css', array(), '6.8.4' );
			wp_enqueue_script( 'swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', array(), '6.8.4', true );

			// Enqueue custom script and style.
			wp_enqueue_style( 'investment-portal-style', get_template_directory_uri() . '/assets/css/investment-portal.css', array(), '1.0.0' );
			wp_enqueue_script( 'investment-portal-script', get_template_directory_uri() . '/assets/js/investment-portal.js', array( 'jquery' ), '1.0.0', true );
		}
	}
	add_action( 'wp_enqueue_scripts', 'investment_portal_enqueue_scripts' );
}
