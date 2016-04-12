<?php
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;


// LEADERSHIP
$leadership = array(5781,5872,5889);
$args = array(
    'post__in' => $leadership,
    'post_type' => 'page',
    'posts_per_page' => -1
);
$context['leadership'] = Timber::get_posts($args);


// TEAM MEMBERS
$args = array(
    'post_parent' => 1195,
    'post__not_in' => $leadership,
    'post_type' => 'page',
    'posts_per_page' => -1
);
$context['team_members'] = Timber::get_posts($args);




Timber::render(array('templates/page-' . $post->post_name . '.twig', 'templates/page.twig'), $context);
// Timber::render('templates/page.twig', $context);