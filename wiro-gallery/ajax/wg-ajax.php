<?php

add_action('wp_ajax_get_gallery_terms', 'get_gallery_terms_callback');
add_action('wp_ajax_nopriv_get_gallery_terms', 'get_gallery_terms_callback');

function get_gallery_terms_callback() {
  $terms = get_terms(array(
    'taxonomy'   => 'gallery_category',
    'hide_empty' => false,
  ));

  wp_send_json($terms);
}