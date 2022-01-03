<?php
/**
 * The Template for displaying products in a product tag. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product_tag.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header( 'shop' );
?>
<div class="content my-5">
<?php
$cat = get_queried_object();
$term = get_term_by( 'id', $cat->term_id, 'product_tag' );
echo do_shortcode('[products tag="'.$term->name.'" columns="6" orderby="date" order="DESC" paginate="true" per_page="24"]');
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