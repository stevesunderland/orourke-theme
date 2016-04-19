<?php
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

$templates = array('templates/index.twig');

if ( is_category() ) {

	$post = new TimberPost(9725);
	$context['post'] = $post;

	$context['pagination'] = Timber::get_pagination();

	$categories = array();

	foreach ($post->intel_categories as $key => $value) {
		// echo($value);
		$category = get_category( $value );
		array_push($categories, $category);
	}

	$context['categories'] = $categories;

	$context['category_title'] = get_cat_name(get_query_var('cat'));


    // $intel_categories = get_field('intel_categories', 9725);


    array_unshift($templates, 'templates/page-intel.twig');

}


Timber::render($templates, $context);