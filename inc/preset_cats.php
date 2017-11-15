<?php

/**
 * Add Categories that corrospond with above function
 */

function indie_studio_insert_category() {
	wp_insert_term(
		'Home',
		'category',
		array(
		  'description'	=> 'All posts with this category are displayed on the home page.',
		  'slug' 		=> 'home'
		)
	);
	wp_insert_term(
		'Feed',
		'category',
		array(
		  'description'	=> 'All posts with this category are displayed on the feed page.',
		  'slug' 		=> 'feed'
		)
	);
}
add_action( 'after_setup_theme', 'indie_studio_insert_category' );