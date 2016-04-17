<?php
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

$templates = array('templates/page-' . $post->post_name . '.twig', 'templates/page.twig');

$landing_pages = array(6443);

if ( in_array($post->ID, $landing_pages) ) {
     array_unshift($templates, 'templates/page-services.twig');

    $query = array(
        'post_parent' => $post->ID,
        'post_type' => 'page',
        'posts_per_page' => -1
    );

    $context['services'] = Timber::get_posts($query);

}

$parent = $post->post_parent;

$other_pages = array(2381,6444);

if ( in_array($parent, $landing_pages) || in_array($post->ID, $other_pages) ) {
     array_unshift($templates, 'templates/page-services-single.twig');


    $related_ids = $post->related_portfolio_entries;


     // RELATED WORK
	$args = array(
	    'post_type' => 'portfolio',
	    'posts_per_page' => 3,
	    'tax_query' => array(
	    	array(
	    		'taxonomy' => 'portfolio_entries',
	    		'field' => 'id',
	    		'terms' => $related_ids
	    	)
	    )
	);

	$context['related_work'] = Timber::get_posts($args);
	// $context['portfolio_categories'] = Timber::get_terms('portfolio_entries');

	$related_ids = $post->related_posts;
	// RELATED POSTS
	$args = array(
	    'post_type' => 'post',
	    'posts_per_page' => 3,
	    'cat' => $related_ids
	);
	$context['related_articles'] = Timber::get_posts($args);
}



if ( $post->post_parent == 1195 ) {
    array_unshift($templates, 'templates/page-team-single.twig');
}


Timber::render($templates, $context);
// Timber::render('templates/page.twig', $context);