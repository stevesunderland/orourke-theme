<?php
$context = Timber::get_context();

Timber::render( array('templates/single-' . $post->post_type . '.twig', 'templates/single.twig'), $context);