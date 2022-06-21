<?php

//Enqeue scripts and css

function scripts_css()
{
	wp_enqueue_script('jquery');

	wp_register_script('app', get_template_directory_uri() . '/dist/app.js', ['jquery'], 1, true);
	wp_enqueue_script('app');

	wp_register_style('style', get_template_directory_uri() . '/dist/app.css', [], 1, 'all');
	wp_enqueue_style('style');
}
add_action('wp_enqueue_scripts', 'scripts_css');

// Theme Options

add_theme_support('menus');
add_theme_support('post-thumbnails');
add_theme_support('widgets');

// Menus

register_nav_menus(
	array(
		'main-menu' => 'Main Menu Location',
	)
);

// Custom Image Sizes

add_image_size('blog-small', 300, 300);
add_image_size('blog-thumb', 200, 200);

// Custom Taxonomy

add_action('init', 'custom_taxonomy');
function custom_taxonomy()
{
	$args = array(
		'labels' => array(
			'name' => 'Types',
			'singular_name' => 'Type',
		),
		'public' => true,
		'hierarchical' => true,
		'show_admin_column' => true,
	);
	register_taxonomy('types', array('post'), $args);
}


// Register Custom Navigation Walker

function register_navwalker(){
	require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}
add_action( 'after_setup_theme', 'register_navwalker' );


// bootstrap 5 wp_nav_menu walker
class bootstrap_5_wp_nav_menu_walker extends Walker_Nav_menu
{
  private $current_item;
  private $dropdown_menu_alignment_values = [
    'dropdown-menu-start',
    'dropdown-menu-end',
    'dropdown-menu-sm-start',
    'dropdown-menu-sm-end',
    'dropdown-menu-md-start',
    'dropdown-menu-md-end',
    'dropdown-menu-lg-start',
    'dropdown-menu-lg-end',
    'dropdown-menu-xl-start',
    'dropdown-menu-xl-end',
    'dropdown-menu-xxl-start',
    'dropdown-menu-xxl-end'
  ];

  function start_lvl(&$output, $depth = 0, $args = null)
  {
    $dropdown_menu_class[] = '';
    foreach($this->current_item->classes as $class) {
      if(in_array($class, $this->dropdown_menu_alignment_values)) {
        $dropdown_menu_class[] = $class;
      }
    }
    $indent = str_repeat("\t", $depth);
    $submenu = ($depth > 0) ? ' sub-menu' : '';
    $output .= "\n$indent<ul class=\"dropdown-menu$submenu " . esc_attr(implode(" ",$dropdown_menu_class)) . " depth_$depth\">\n";
  }

  function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
  {
    $this->current_item = $item;

    $indent = ($depth) ? str_repeat("\t", $depth) : '';

    $li_attributes = '';
    $class_names = $value = '';

    $classes = empty($item->classes) ? array() : (array) $item->classes;

    $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
    $classes[] = 'nav-item';
    $classes[] = 'nav-item-' . $item->ID;
    if ($depth && $args->walker->has_children) {
      $classes[] = 'dropdown-menu dropdown-menu-end';
    }

    $class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
    $class_names = ' class="' . esc_attr($class_names) . '"';

    $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
    $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

    $output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';

    $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
    $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
    $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
    $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

    $active_class = ($item->current || $item->current_item_ancestor || in_array("current_page_parent", $item->classes, true) || in_array("current-post-ancestor", $item->classes, true)) ? 'active' : '';
    $nav_link_class = ( $depth > 0 ) ? 'dropdown-item ' : 'nav-link ';
    $attributes .= ( $args->walker->has_children ) ? ' class="'. $nav_link_class . $active_class . ' dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="'. $nav_link_class . $active_class . '"';

    $item_output = $args->before;
    $item_output .= '<a' . $attributes . '>';
    $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }
}

// Custom Search //
function search_query()
{
	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

	$resargs = [
		'paged' => $paged,
		'post_type' => 'post',
		'posts_per_page' => '4',
		'tax_query' => [],
		'meta_query' => [
			'relation' => 'AND',
		],
	];
	if(isset($_GET['keyword'])) 
	{
		if(!empty($_GET['keyword']))
		{
			$resargs['s'] = sanitize_text_field($_GET['keyword']);
		}
	}
	if(isset($_GET['Subject'])) 
	{
		if(!empty($_GET['Subject']))
		{
			$resargs['tax_query'][] = [
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => array( sanitize_text_field( $_GET['Subject']) ),
			];
		}
	}
	if(isset($_GET['Media'])) 
	{
		if(!empty($_GET['Media']))
		{
			$resargs['tax_query'][] = [
				'taxonomy' => 'types',
				'field'    => 'slug',
				'terms'    => array( sanitize_text_field( $_GET['Media']) ),
			];
		}
	}
	if(isset($_GET['the_pub_year'])) 
	{
		if(!empty($_GET['the_pub_year']))
		{
			$resargs['meta_query'][] = [
				'key' => 'pub_year',
				'value' => sanitize_text_field( $_GET['the_pub_year']),
				'type' => 'numeric',
				'compare' => '>=',
			];
		}
	}
	if(isset($_GET['the_pub_year_last'])) 
	{
		if(!empty($_GET['the_pub_year_last']))
		{
			$resargs['meta_query'][] = [
				'key' => 'pub_year',
				'value' => sanitize_text_field( $_GET['the_pub_year_last']),
				'type' => 'numeric',
				'compare' => '<=',
			];
		}
	}
	if(isset($_GET['the_author'])) 
	{
		if(!empty($_GET['the_author']))
		{
			$resargs['meta_query'][] = [
				'key' => 'doc_author',
				'value' => sanitize_text_field( $_GET['the_author']),
				'compare' => 'LIKE',
			];
		}
	}
	return new WP_Query($resargs);
}

?>