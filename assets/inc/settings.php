<?php
/**
 * @package Google Map Lite
 * @version 1.0
 */
/*
*/

if ( file_exists( dirname( __FILE__ ) . '/helper/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/helper/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/helper/cmb2//init.php' ) ) {
	require_once dirname( __FILE__ ) . '/helper/cmb2/init.php';
}


/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' cmb2_box parameter
 *
 * @param  CMB2 object $cmb CMB2 object.
 *
 * @return bool             True if metabox should show
 */
 function gmap_show_if_front_page( $cmb ) {
	// Don't show this metabox if it's not the front page template.
	if ( get_option( 'page_on_front' ) !== $cmb->object_id ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field object $field Field object.
 *
 * @return bool                     True if metabox should show
 */
function gmap_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category.
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}
 
/**
 * Manually render a field.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object.
 */
function gmap_render_row_cb( $field_args, $field ) {
	$classes     = $field->row_classes();
	$id          = $field->args( 'id' );
	$label       = $field->args( 'name' );
	$name        = $field->args( '_name' );
	$value       = $field->escaped_value();
	$description = $field->args( 'description' );
	?>
	<div class="custom-field-row <?php echo esc_attr( $classes ); ?>">
		<p><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label></p>
		<p><input id="<?php echo esc_attr( $id ); ?>" type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo $value; ?>"/></p>
		<p class="description"><?php echo esc_html( $description ); ?></p>
	</div>
	<?php
}

add_action( 'cmb2_admin_init', 'gml_map_options' );
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function gml_map_options() {

	/**
	 * Registers options page menu item and form.
	 */
	$cmb_options = new_cmb2_box( array(
		'id'           => 'gml_map_options',
		'title'        => esc_html__( 'Maps Settings', 'gmap' ),
		'object_types' => array( 'options-page' ),

		/*
		 * The following parameters are specific to the options-page box
		 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
		 */

		'option_key'      => 'gml_map_options', // The option key and admin menu page slug.
		'icon_url'        => 'dashicons-location', // Menu icon. Only applicable if 'parent_slug' is left empty.
		'menu_title'      => esc_html__( 'Maps Settings', 'gmap' ), // Falls back to 'title' (above).
		// 'parent_slug'     => 'themes.php', // Make options page a submenu item of the themes menu.
		// 'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		'display_cb'      => true, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		'save_button'     => esc_html__( 'Save Map Settings', 'gmap' ), // The text for the options-page save button. Defaults to 'Save'.
	) );

	/**
	 * Options fields ids only need
	 * to be unique within this box.
	 * Prefix is not needed.
	 */
	
	//========= Maps Title =============
	$cmb_options->add_field( array(
		'name'    => esc_html__( 'Lite Google Map - 1.0', 'gmap' ),
		//'desc'    => esc_html__( 'by B.M. Rafiul Alam', 'gmap' ),
		'id'      => 'title',
		'type'    => 'title',
	) );
 	 //========= Maps Shortcode =============
 	$cmb_options->add_field( array(
		'name'    => esc_html__( 'Shortcode', 'gmap' ),
		'desc'    => esc_html__( 'Copy Shortcode & Paste on your page/post/widget', 'gmap' ),
		'id'      => '',
		'type'    => 'text',
		'attributes'  => array(
		'readonly' => 'readonly',
		//'disabled' => 'disabled',
	),
		'default' => '[google_maps]',
		
	) ); 
	//========= Maps Key =============
	$cmb_options->add_field( array(
		'name'    => esc_html__( 'Maps Key', 'gmap' ),
		'desc'    => esc_html__( 'Enter Google Maps Key', 'gmap' ),
		'id'      => 'maps_key',
		'type'    => 'text',
		'default' => 'AIzaSyDtsjF6u_cJFz57xJqzbWT0Q6Ddl3EsMQ0',
	) );
	//========Lat/long =============
	$cmb_options->add_field( array(
		'name'    => esc_html__( 'Latitude', 'gmap' ),
		'desc'    => esc_html__( 'Enter your location latitude', 'gmap' ),
		'id'      => 'lat',
		'type'    => 'text_small',
		'default' => '40.785091',
	) );

	$cmb_options->add_field( array(
		'name'    => esc_html__( 'Longitude', 'gmap' ),
		'desc'    => esc_html__( 'Enter your location longitude', 'gmap' ),
		'id'      => 'long',
		'type'    => 'text_small',
		'default' => '-73.968285',
	) );
	//============Zoom ===========
	$cmb_options->add_field( array(
		'name'    => esc_html__( 'Zoom', 'gmap' ),
		'desc'    => esc_html__( 'The satellite and hybrid map types support 45° imagery at high zoom levels where available.', 'gmap' ),
		'id'      => 'zoom',
		'type'    => 'text_small',
		'default' => '12',
		'attributes' => array(
		'type' => 'number',
		'pattern' => '\d*',
	),
	) );
	
	//============Maps Type ===========
	$cmb_options->add_field( array(
		'name'    => 'Map Types',
		'id'      => 'mapTypeId',
		'desc'    => 'Some options are disabled for Lite version',
		'type'    => 'radio_inline',
		'options'          => array(
				'roadmap' 	  => __( 'Roadmap', 'gmap' ),
				'satellite'   => __( 'Satellite', 'gmap' ),
				'hybrid'      => __( 'Hybrid', 'gmap' ),
				'terrain'     => __( 'Terrain ', 'gmap' ),
			),
			
		'default' => 'roadmap',
	) );

	//============Map Imagery Control ===========
	
	$cmb_options->add_field(array(
	'name'    => '45° imagery',
	'id'      => 'imagery',
	'desc'    => 'If you Set 45° imagery then set Zoom > 18.',
	'type'    => 'own_yesno',
	));
	//============Map rotate Control ===========
	
	$cmb_options->add_field(array(
	'name'    => 'Rotate Control',
	'id'      => 'rotateControl',
	'desc'    => 'Set rotateControl? Rotate control only work when map type is setelliet & imagery is on',
	'type'    => 'own_yesno',
	));
	//============Map Fullscreen Control ===========
	
	$cmb_options->add_field(array(
	'name'    => 'Fullscreen Control',
	'id'      => 'full_screen',
	'desc'    => 'Do you want to show Full Screen Control?',
	'type'    => 'own_yesno',
	));

	//============Map mapTypeControl Control ===========
	
	$cmb_options->add_field(array(
	'name'    => 'Map Type Control',
	'id'      => 'mapTypeControl',
	'desc'    => 'Set mapTypeControl?',
	'type'    => 'own_yesno',
	));
	
	//============Map Marker Control ===========
	
	$cmb_options->add_field(array(
	'name'    => 'Map Marker',
	'id'      => 'mapMarker',
	'desc'    => 'Show Map Marker?',
	'type'    => 'own_yesno',
	));
	//=========Map Icon============
	$cmb_options->add_field( array(
		'name'    => esc_html__( 'Add Marker', 'gmap' ),
		//'desc'    => esc_html__( 'Upload a Icon', 'gmap' ),
		'id'      => 'map_icon',
		'type'    => 'file',
		'options' => array(
		'url' => false, // Hide the text input for the url
	),
	'text'    => array(
		'add_upload_file_text' => 'Add Marker' // Change upload button text. Default: "Add or Upload File"
	),
	) );
	//====== Map Theme ========
	$cmb_options->add_field( array(
		'name'    => 'Map Scheme',
		'id'      => 'maps_theme',
		'desc'    => esc_html__( 'Select a Scheme', 'gmap' ),
		'type'             => 'radio_image',
		'options'          => array(
			'standard' 	   => __( 'Default', 'gmap' ),
			'blue'     	   => __( 'blue', 'gmap' ),
			'dark'     	   => __( 'dark', 'gmap' ),
			'dark-blue'    => __( 'dark-blue', 'gmap' ),
			'gray'         => __( 'gray', 'gmap' ),
			'gray-blue'    => __( 'gray-blue', 'gmap' ),
			'green'        => __( 'green', 'gmap' ),
			'gray-navy'    => __( 'gray-navy', 'gmap' ),
			'night'        => __( 'night', 'gmap' ),
			'orange'       => __( 'orange', 'gmap' ),
			'silver'       => __( 'silver', 'gmap' ),
		),
		'default' => 'standard',
		'images_path'      	=>  plugin_dir_url( __FILE__ ) ,
			'images'        => array(
				'standard'  => '/theme-img/default.png',
				'blue' 		=> '/theme-img/blue.png',
				'dark' 		=> '/theme-img/dark.png',
				'dark-blue' => '/theme-img/dark-blue.png',
				'gray' 		=> '/theme-img/gray.png',
				'gray-blue' => '/theme-img/gray-blue.png',
				'green' 	=> '/theme-img/green.png',
				'gray-navy' => '/theme-img/gray-navy.png',
				'night' 	=> '/theme-img/night.png',
				'orange' 	=> '/theme-img/orange.png',
				'silver' 	=> '/theme-img/silver.png',
			),
			
	) );	
	//============Map Height ===========
	$cmb_options->add_field( array(
		'name'    => esc_html__( 'Map\'s Height', 'gmap' ),
		'desc'    => esc_html__( 'Enter Map Height', 'gmap' ),
		'id'      => 'height',
		'type'    => 'text_small',
		'default' => '320px',
	) );
}