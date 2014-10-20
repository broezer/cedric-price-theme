<?php
// Theme setup
function cpmb_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'cpmb', get_template_directory() . '/lang' );

	// Enable thumbnail support
	add_theme_support( 'post-thumbnails' );

	// Set thumbnail sizes
	add_image_size('square', 512, 512, true);
	add_image_size('gallery', 400, 900);

	// Add excerpts to pages
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'after_setup_theme', 'cpmb_setup' );


function cpmb_register_customposts() {
    register_post_type('article',
        array(
            'labels' => array(
                'name' => _x('Articles', 'post type general name', 'lb'),
                'singular_name' => _x('Article', 'post type singular name', 'lb'),
                'add_new' => _x('Add New', 'article', 'lb'),
                'add_new_item' => __('Add New Article', 'lb'),
                'edit_item' => __('Edit Article', 'lb'),
                'new_item' => __('New Article', 'lb'),
                'view_item' => __('View Article', 'lb'),
                'search_items' => __('Search Articles', 'lb'),
                'not_found' => __('No Articles found', 'lb'),
                'not_found_in_trash' => __('No Articles found in Trash', 'lb'),
                'parent' => __('Parent Article', 'lb'),
            ),
            'public' => true,
            'menu_icon' => 'dashicons-editor-alignleft',
            'menu_position' => 5,
            'hierarchical' => true,
            'has_archive' => true,
            'supports' => array('title', 'thumbnail', 'page-attributes', 'excerpt', 'comments',  'author'),
            'taxonomies' => array('post_tag'),
            'rewrite' => array('slug' => _x('articles', 'URL slug', 'lb'), 'with_front' => false)
        )
    );
}

add_action('init', 'cpmb_register_customposts');


function cpmb_register_customtaxonomies() {
    register_taxonomy(
        'article_category',
        'article',
        array(
            'label' => __( 'Category' ),
            'labels' => array(
                'name'              => 'Category',
                'singular_name'     => 'Category',
                'search_items'      => 'Search Categories',
                'popular_items'     => 'Popular Categories',
                'all_items'         => 'All Categories',
                'parent_item'       => 'Parent Category',
                'parent_item_colon' => 'Parent Category:',
                'edit_item'         => 'Edit Category',
                'update_item'       => 'Update Category',
                'add_new_item'      => 'Add New Category',
                'new_item_name'     => 'New Category Name'
                ),
            'hierarchical'  => true,
            'sort'          => true,
            'query_var'     => true,
            'rewrite'       => array('slug' => 'article-category', 'with_front' => false)
            )
        );
}

add_action('init', 'cpmb_register_customtaxonomies');

?>
