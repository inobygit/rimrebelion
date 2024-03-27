<?php

// Enqueue Dashicons to load on the front-end
add_action( 'wp_enqueue_scripts', 'dashicons_front_end' );
function dashicons_front_end() {
   wp_enqueue_style( 'dashicons' );
}