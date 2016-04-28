<?php
global $paged;
if (!isset($paged) || !$paged){
    $paged = 1;
}

$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

// BLOG POSTS
$args = array(
    'post_type' => 'post',
    // 'posts_per_page' => 9
    'posts_per_page' => 12
);

query_posts($args);

$context['posts'] = Timber::get_posts($args);

$context['pagination'] = Timber::get_pagination();


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