<?php
// Theme setup
function cpmb_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'cpmb', get_template_directory() . '/lang' );

	// Enable thumbnail support
	add_theme_support( 'post-thumbnails' );

	// Set thumbnail sizes
	// Media thumbnail size should be 200 x 110
	add_image_size('infocard-image', 580, 320, true);

	// Add excerpts to pages
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'after_setup_theme', 'cpmb_setup' );


function cpmb_register_customposts() {
    register_post_type('interview',
        array(
            'labels' => array(
                'name' => _x('Interviews', 'post type general name', 'cpmb'),
                'singular_name' => _x('Interview', 'post type singular name', 'cpmb'),
                'add_new' => _x('Add New', 'interview', 'cpmb'),
                'add_new_item' => __('Add New Interview', 'cpmb'),
                'edit_item' => __('Edit Interview', 'cpmb'),
                'new_item' => __('New Interview', 'cpmb'),
                'view_item' => __('View Interview', 'cpmb'),
                'search_items' => __('Search Interview', 'cpmb'),
                'not_found' => __('No Interview found', 'cpmb'),
                'not_found_in_trash' => __('No Interview found in Trash', 'cpmb'),
                'parent' => __('Parent Interview', 'cpmb'),
            ),
            'public' => true,
            'menu_icon' => 'dashicons-editor-alignleft',
            'menu_position' => 5,
            'hierarchical' => true,
            'has_archive' => true,
            'supports' => array('title', 'thumbnail', 'page-attributes', 'excerpt', 'comments',  'author'),
            'taxonomies' => array('post_tag'),
            'rewrite' => array('slug' => _x('interview', 'URL slug', 'cpmb'), 'with_front' => false)
        )
    );
	register_post_type('infocard',
		array(
			'labels' => array(
				'name' => _x('Infocards', 'post type general name', 'cpmb'),
				'singular_name' => _x('Infocard', 'post type singular name', 'cpmb'),
				'add_new' => _x('Add New', 'Infocard', 'cpmb'),
				'add_new_item' => __('Add New Infocard', 'cpmb'),
				'edit_item' => __('Edit Infocard', 'cpmb'),
				'new_item' => __('New Infocard', 'cpmb'),
				'view_item' => __('View Infocard', 'cpmb'),
				'search_items' => __('Search Infocard', 'cpmb'),
				'not_found' => __('No Infocard found', 'cpmb'),
				'not_found_in_trash' => __('No Infocard found in Trash', 'cpmb'),
				'parent' => __('Parent Infocard', 'cpmb'),
			),
			'public' => true,
			'menu_icon' => 'dashicons-id',
			'menu_position' => 5,
			'hierarchical' => true,
			'has_archive' => true,
			'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
			'taxonomies' => array('post_tag'),
			'rewrite' => array('slug' => _x('infocard', 'URL slug', 'cpmb'), 'with_front' => false)
		)
	);
}

add_action('init', 'cpmb_register_customposts');

function cpmb_remove_admin_menus(){
	global $menu;
	$restricted = array(__('Posts'),__('Comments'));
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}
add_action('admin_menu', 'cpmb_remove_admin_menus');


function json_api_encode_acf($response)
{
    if (isset($response['posts'])) {
        foreach ($response['posts'] as $post) {
            json_api_add_acf($post); // Add specs to each post
        }
    }
    else if (isset($response['post'])) {
        json_api_add_acf($response['post']); // Add a specs property
    }

    return $response;
}

function json_api_add_acf(&$post)
{
    $post->acf = get_fields($post->id);
}

add_filter('json_api_encode', 'json_api_encode_acf');

?>
