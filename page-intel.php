<?php
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

// BLOG POSTS
$args = array(
    'post_type' => 'post',
    'posts_per_page' => 3
);
$context['blog_posts'] = Timber::get_posts($args);
// $context['blog_posts'] = array('one','two','three');


// CASE STUDIES
$args = array(
    'post_parent' => 7270,
    'post_type' => 'page',
    'posts_per_page' => 3
);
$context['case_studies'] = Timber::get_posts($args);

// CASE STUDIES
$args = array(
    'post_parent' => 7270,
    'post_type' => 'page',
    'posts_per_page' => 3
);
$context['case_studies'] = Timber::get_posts($args);


Timber::render(array('templates/page-' . $post->post_name . '.twig', 'templates/page.twig'), $context);
// Timber::render('templates/page.twig', $context);