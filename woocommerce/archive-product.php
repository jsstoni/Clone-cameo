<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>
<div class="content my-5">
<nav class="category-menu">
<ul>
	<li><a href="<?php echo home_url(); ?>">Home</a></li>
	<li><a href="#" class="active"><?php woocommerce_page_title(); ?></a></li>
	<li class="space"></li>
<?php
$args = array(
	'taxonomy' => 'product_cat',
	'hide_empty' => false,
	'parent' => get_queried_object_id(),
	'exclude' => array(15),
);
$product_cat = get_terms( $args );
foreach ($product_cat as $parent_product_cat) {
	echo '<li><a href="'.get_term_link($parent_product_cat->term_id).'">'.$parent_product_cat->name." ".$parent_product_cat->count."</a></li>";
}
?>
<li><a href="https://saraut.com/category/">All Categories</a></li>
</ul>
</nav>
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title text-dark"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>
	<?php
	if (sizeof($product_cat) > 0 ) {
		$product_cat = $product_cat;
		foreach ($product_cat as $category) {
		?>
			<div class="overflow-auto">
			<h3 class="mt-4 pull-left" style="font-size: 42px; color: #333;"><?php echo $category->name; ?></h3>
			<a href="<?php echo get_term_link($category->term_id); ?>" class="mt-5 pull-right">See All</a>
			</div>
		<?php
			echo do_shortcode('[product_category category="'.$category->name.'" columns="6" orderby="date" order="DESC" per_page="6"]');
		}
	}else {
		$cat = get_queried_object();
		$term = get_term_by( 'id', $cat->term_id, 'product_cat' );
		echo do_shortcode('[product_category category="'.$term->name.'" columns="6" orderby="date" order="DESC" paginate="true" per_page="24"]');
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
<?php get_footer( 'shop' ); ?>