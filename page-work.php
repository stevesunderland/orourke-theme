<?php
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;


// PORTFOLIO ITEMS
$args = array(
    'post_type' => 'portfolio',
    'posts_per_page' => -1
);
$context['portfolio'] = Timber::get_posts($args);
$context['portfolio_categories'] = Timber::get_terms('portfolio_entries');

Timber::render(array('templates/page-' . $post->post_name . '.twig', 'templates/page.twig'), $context);
// Timber::render('templates/page.twig', $context);