<?php
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

// BLOG POSTS
$args = array(
    'post_type' => 'post',
    'posts_per_page' => 9
);
$context['posts'] = Timber::get_posts($args);


// CATEGORIES
$context['categories'] = array('Blog Posts', 'Case Studies', 'White Papers');


Timber::render(array('templates/page-' . $post->post_name . '.twig', 'templates/page.twig'), $context);
// Timber::render('templates/page.twig', $context);