<?php
/*
Plugin Name:  Themify Builder Integration for Themify Flow
Plugin URI:   https://github.com/2nickpick
Version:      1.0.0
Author:       Nick Pickering
Description:  Themify Flow / Builder Integration
Text Domain:  themify-flow-builder-integration
*/

defined( 'ABSPATH' ) or die;

/**
 * Load module file
 */
add_action( 'tf_modules_loaded', 'tf_builder_integration_load_plugin' );
function tf_builder_integration_load_plugin() {
	include( plugin_dir_path( __FILE__ ) . '/includes/themify-flow-builder-integration-module.php' );
}

add_action('init', 'create_builder_post_type');
function create_builder_post_type() {
	$labels = array(
			'name'               => _x( 'Builder Post', 'post type general name', 'your-plugin-textdomain' ),
			'singular_name'      => _x( 'Builder Post', 'post type singular name', 'your-plugin-textdomain' ),
			'menu_name'          => _x( 'Builder Posts', 'admin menu', 'your-plugin-textdomain' ),
			'name_admin_bar'     => _x( 'Builder Post', 'add new on admin bar', 'your-plugin-textdomain' ),
			'add_new'            => _x( 'Add New', 'Builder Post', 'your-plugin-textdomain' ),
			'add_new_item'       => __( 'Add New Builder Post', 'your-plugin-textdomain' ),
			'new_item'           => __( 'New Builder Post', 'your-plugin-textdomain' ),
			'edit_item'          => __( 'Edit Builder Post', 'your-plugin-textdomain' ),
			'view_item'          => __( 'View Builder Post', 'your-plugin-textdomain' ),
			'all_items'          => __( 'All Builder Posts', 'your-plugin-textdomain' ),
			'search_items'       => __( 'Search Builder Posts', 'your-plugin-textdomain' ),
			'parent_item_colon'  => __( 'Parent Builder Posts:', 'your-plugin-textdomain' ),
			'not_found'          => __( 'No Builder Posts found.', 'your-plugin-textdomain' ),
			'not_found_in_trash' => __( 'No Builder Posts found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'your-plugin-textdomain' ),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => false,
			'show_in_menu'       => false,
			'query_var'          => false,
			'rewrite'            => array( 'slug' => 'builder_post' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor' )
	);

	register_post_type( 'builder_post', $args );
}

function create_builder_post() {
	$post_ID = wp_insert_post(
			array(
					'post_type' => 'builder_post',
					'post_status' => 'publish',
					'post_title' => time(),
					'post_content' => '',
			)
	);

	return $post_ID;
}

add_shortcode('add_builder_section', 'add_builder_section');
function add_builder_section($post_id) {
	$query = new WP_Query(array('p' => $post_id, 'post_type' => 'builder_post'));

	ob_start();
	?>
	<div class="tf_module_builder">
		<?php
		if ($query->have_posts()) :
			while ($query->have_posts()) :
				$query->the_post();
				the_content();
			endwhile;
		endif;
		?>
	</div>
	<?php
	$content = ob_get_contents();
	ob_end_clean();

	wp_reset_postdata();

	return $content;
}

add_action('wp_ajax_tf_builder_form_save', 'detect_new_builder_added');
function detect_new_builder_added($data) {
	if ( strpos( $_POST['data'], 'themify-flow-builder-integration' ) !== false ) {
		if ( strpos( $_POST['data'], 'builder_post_id=&' ) !== false) {
			$post_id       = create_builder_post();
			$_POST['data'] = str_replace( 'builder_post_id=', 'builder_post_id=' . $post_id, $_POST['data'] );
		}
	}
}

add_action('wp_enqueue_scripts', 'themify_flow_builder_integration_styles');
function themify_flow_builder_integration_styles() {
	wp_enqueue_style('themify-flow-builder-integration-styles', plugin_dir_url(__FILE__).'css/styles.css', array(), time());
}

function add_image_text_styling($data) {
	$data['tf_module_text_img'] =
			array(
				'label' => __( 'Image', 'themify-flow' ),
				'selector' => '.tf_module_text img',
				'basic_styling' => array( 'border', 'font', 'margin' ),
	);

	return $data;
}
add_filter('tf_module_text_styles', 'add_image_text_styling');
