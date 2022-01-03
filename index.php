<?php get_header(); ?>

<div class="content my-5">
<nav class="category-menu">
<ul>
	<li><a href="<?php echo home_url(); ?>">Home</a></li>
	<li class="space"></li>
<?php
$args = array(
	'taxonomy' => 'product_cat',
	'hide_empty' => false,
	'parent'	 => 0,
	'exclude' => array(15)
);
$product_cat = get_terms( $args );
$items_count = 0;
foreach ($product_cat as $parent_product_cat) {
	echo '<li><a href="'.get_term_link($parent_product_cat->term_id).'">'.$parent_product_cat->name." ".$parent_product_cat->count."</a></li>";
	$items_count += $parent_product_cat->count;
}
?>
<li><a href="https://saraut.com/category/">All Categories <?php echo $items_count; ?></a></li>
</ul>
</nav>
<div id="video">
	<video autoplay="true" loop="true" playsinline="true" poster="https://d3el26csp1xekx.cloudfront.net/miscellaneous/videos/useCaseOverlayWebthumbnail.jpg">
		<source src="https://d3el26csp1xekx.cloudfront.net/miscellaneous/videos/useCaseOverlayWebApple.m4v" type="video/mp4">
		<source src="https://d3el26csp1xekx.cloudfront.net/miscellaneous/videos/useCaseOverlayWebMp4.mp4" type="video/mp4">
	</video>
	<p>Get personalized messages from your favorite celebrities</p>
</div>
<?php
	$cat_args = array(
		'parent' => '0',
		'taxonomy' => 'product_cat',
		'orderby' => 'desc'
	);
	$categories = get_categories( $cat_args );

	foreach ($categories as $category) {
?>
	<div class="overflow-auto">
	<h3 class="mt-4 pull-left" style="font-size: 42px; color: #333;"><?php echo $category->cat_name; ?></h3>
	<a href="<?php echo get_term_link($category->term_id); ?>" class="mt-5 pull-right">See All</a>
	</div>
<?php
		echo do_shortcode('[product_category category="'.$category->cat_name.'" columns="6" orderby="date" order="DESC" per_page="6"]');
	}
?>
</div>

<script>
jQuery(document).ready(function($) {
	$(".products-list").slick({
		arrows: false,
		dots: false,
		infinite: false,
		autoplay: false,
		autoplaySpeed: 2000,
		pauseOnFocus: false,
		pauseOnHover: false,
		pauseOnDotsHover: false,
		slidesToShow: 6,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				}
			}
		]
	});
});
</script>
<?php get_footer(); ?>