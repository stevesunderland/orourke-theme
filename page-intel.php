<?php
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

// BLOG POSTS
$args = array(
    'post_type' => 'post',
    // 'posts_per_page' => 9
    'posts_per_page' => 90
);
$context['posts'] = Timber::get_posts($args);





// CATEGORIES

$categories = array();

foreach ($post->intel_categories as $key => $value) {
	// echo($value);
	$category = get_category( $value );
	// print_r($category);
	array_push($categories, $category);
}

// $context['categories'] = array('Blog Posts', 'Case Studies', 'White Papers');
$context['categories'] = $categories;


Timber::render(array('templates/page-' . $post->post_name . '.twig', 'templates/page.twig'), $context);
// Timber::render('templates/page.twig', $context);