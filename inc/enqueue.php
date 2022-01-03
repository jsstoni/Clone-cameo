<?php
function startertheme_load_scritps() {
  wp_enqueue_style( 'bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css', array(), '4.4.1', 'all' );
  wp_enqueue_style( 'google_fonts', 'https://fonts.googleapis.com/css2?family=Oswald:wght@300;500;700&display=swap', array(), '', 'all' );

  wp_enqueue_style( 'slick_css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css', array(), false, 'all' );
  wp_enqueue_style( 'slick_theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css', array(), false, 'all' );
  if (!is_page("checkout") && !is_account_page() && !is_page( 'video' )) {
  	wp_enqueue_style( 'theme-style', get_template_directory_uri() . '/assets/css/style.css', array(), '1.0.0', 'all' );
  }else {
  	wp_enqueue_style( 'theme-checkout', get_template_directory_uri() . '/assets/css/checkout.css', array(), '1.0.0', 'all' );
  }
  wp_enqueue_style( 'font-awesome-cdn', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );

  wp_enqueue_script( 'slick_js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.js', array( 'jquery' ), false, true );
  wp_enqueue_script( 'popper_js', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js', array(), '1.16.0', true); 
  wp_enqueue_script( 'bootstrap_js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js', array('jquery','popper_js'), '4.4.1', true);
}
add_action( 'wp_enqueue_scripts', 'startertheme_load_scritps' );
add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
?>