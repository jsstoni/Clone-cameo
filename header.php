<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php bloginfo( 'name' ); wp_title(); ?></title>
		<meta name="description" content="<?php bloginfo('description') ?>">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php if(is_singular() && pings_open(get_queried_object())): ?>
			<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		<?php endif ?>
		<?php wp_head(); ?>
	</head>
<body <?php body_class(); ?>>
<div id="wptime-plugin-preloader"></div>
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-page">
<div class="content">
	<a class="navbar-brand float-left" href="<?php echo home_url(); ?>">
	<?php
	if( has_custom_logo() ) { 
		the_custom_logo();
	}else {
		bloginfo( 'name' );
	}
	?>
	</a>

	<div class="ml-auto">
		<?php
		wp_nav_menu( array( 
			'theme_location' => 'header-menu',
			'container' => false,
			'add_li_class' => 'nav-item',
			'items_wrap' => '<ul class="menu-top flex-row float-right">%3$s</ul>'
		) ); 
		?>
		<div class="float-right search-top" style="margin: 0 10px 0 0;">
			<?php echo do_shortcode('[aws_search_form]'); ?>
		</div>
	</div>
</div>
</nav>
<div style="margin: 70px 0 0 0;"></div>