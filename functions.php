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

/* Add ACF to JSON API */
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
    $post->interview_fields = get_fields($post->id);
}

add_filter('json_api_encode', 'json_api_encode_acf');



/* Advanced Custom Fields */
if( function_exists('register_field_group') ):

register_field_group(array (
	'key' => 'group_5445336f90f43',
	'title' => 'Biography',
	'fields' => array (
		array (
			'key' => 'field_5445338abea12',
			'label' => 'Name',
			'name' => 'interviewee_name',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'default_value' => '',
			'placeholder' => 'Name',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_544533dfbea13',
			'label' => 'Jobtitle',
			'name' => 'interviewee_jobtitle',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'default_value' => '',
			'placeholder' => 'Jobtitle',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'interview',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array (
		0 => 'permalink',
		1 => 'the_content',
		2 => 'excerpt',
		3 => 'custom_fields',
		4 => 'discussion',
		5 => 'comments',
		6 => 'revisions',
		7 => 'slug',
		8 => 'author',
		9 => 'format',
		10 => 'featured_image',
		11 => 'categories',
		12 => 'tags',
		13 => 'send-trackbacks',
	),
));

register_field_group(array (
	'key' => 'group_54466f275f0f2',
	'title' => 'Infocard & Page Fields',
	'fields' => array (
		array (
			'key' => 'field_54467103b878d',
			'label' => 'Subtitle',
			'name' => 'subtitle',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_54467134b878e',
			'label' => 'Links',
			'name' => 'links',
			'prefix' => '',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'min' => '',
			'max' => '',
			'layout' => 'table',
			'button_label' => 'Add Link',
			'sub_fields' => array (
				array (
					'key' => 'field_54467140b878f',
					'label' => 'url',
					'name' => 'url',
					'prefix' => '',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'column_width' => '',
					'default_value' => '',
					'placeholder' => 'http://',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_54467150b8790',
					'label' => 'label',
					'name' => 'label',
					'prefix' => '',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'column_width' => '',
					'default_value' => '',
					'placeholder' => 'name',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
			),
		),
		array (
			'key' => 'field_54467175b8791',
			'label' => 'Location Name',
			'name' => 'location',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'default_value' => '',
			'placeholder' => 'i.e. London',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_544671cfb8792',
			'label' => 'Location URL',
			'name' => 'location_url',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'default_value' => '',
			'placeholder' => 'http://maps.google.com/.......',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'infocard',
			),
		),
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array (
		0 => 'permalink',
		1 => 'excerpt',
		2 => 'custom_fields',
		3 => 'discussion',
		4 => 'comments',
		5 => 'revisions',
		6 => 'slug',
		7 => 'author',
		8 => 'format',
		9 => 'categories',
		10 => 'tags',
		11 => 'send-trackbacks',
	),
));

register_field_group(array (
	'key' => 'group_54466bc6eb12d',
	'title' => 'Video URL\'s',
	'fields' => array (
		array (
			'key' => 'field_54466bd6c02db',
			'label' => 'MP4',
			'name' => 'url_mp4',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'default_value' => '',
			'placeholder' => 'http://',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_54466c16c02dc',
			'label' => 'WebM',
			'name' => 'url_webm',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'default_value' => '',
			'placeholder' => 'http://',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_54466c30c02de',
			'label' => 'Ogg',
			'name' => 'url_ogg',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'default_value' => '',
			'placeholder' => 'http://',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'interview',
			),
		),
	),
	'menu_order' => 1,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
));

register_field_group(array (
	'key' => 'group_54452b41a5c8c',
	'title' => 'Video Fragments',
	'fields' => array (
		array (
			'key' => 'field_54452ba2ae1eb',
			'label' => 'Clips',
			'name' => 'clips',
			'prefix' => '',
			'type' => 'repeater',
			'instructions' => 'Select begin time, end time and the subject(s)',
			'required' => 0,
			'conditional_logic' => 0,
			'min' => '',
			'max' => '',
			'layout' => 'table',
			'button_label' => 'Add Clip',
			'sub_fields' => array (
				array (
					'key' => 'field_54452c35ae1ec',
					'label' => 'Begin',
					'name' => 'clip_begin_time',
					'prefix' => '',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'column_width' => '',
					'default_value' => '',
					'placeholder' => '00:00:00',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_544532bd8686d',
					'label' => 'End',
					'name' => 'clip_end_time',
					'prefix' => '',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'column_width' => '',
					'default_value' => '',
					'placeholder' => '00:00:00',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_54452dc6ae1ef',
					'label' => 'Subject',
					'name' => 'clip_subject',
					'prefix' => '',
					'type' => 'taxonomy',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'column_width' => '',
					'taxonomy' => 'post_tag',
					'field_type' => 'multi_select',
					'allow_null' => 0,
					'load_save_terms' => 1,
					'return_format' => 'id',
					'multiple' => 0,
				),
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'interview',
			),
		),
	),
	'menu_order' => 2,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
));

register_field_group(array (
	'key' => 'group_5445355996f7e',
	'title' => 'Infocards',
	'fields' => array (
		array (
			'key' => 'field_54453563cb72a',
			'label' => 'infocards',
			'name' => 'infocards',
			'prefix' => '',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'min' => '',
			'max' => '',
			'layout' => 'table',
			'button_label' => 'Add Infocard',
			'sub_fields' => array (
				array (
					'key' => 'field_54453573cb72b',
					'label' => 'Time',
					'name' => 'infocard_begin_time',
					'prefix' => '',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'column_width' => '',
					'default_value' => '',
					'placeholder' => '00:00:00',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_544535f1cb72c',
					'label' => 'Card',
					'name' => 'infocard_card',
					'prefix' => '',
					'type' => 'relationship',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'column_width' => '',
					'post_type' => array (
						0 => 'infocard',
					),
					'taxonomy' => '',
					'filters' => array (
						0 => 'search',
					),
					'elements' => array (
						0 => 'featured_image',
					),
					'max' => 1,
					'return_format' => 'object',
				),
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'interview',
			),
		),
	),
	'menu_order' => 3,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
));

endif;

?>
