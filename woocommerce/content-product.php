<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.2.0
 */
	defined( 'ABSPATH' ) || exit;

	global $product, $woocommerce_loop, $post;
	?>
	<li class="col-6 col-md-2 my-3">
		<div class="products-info">
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
			<?php
			$thumb_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'shop_catalog' );
			?>
			<img src="<?php echo $thumb_img[0]; ?>" alt="<?php echo get_the_title(); ?>" title="<?php echo get_the_title(); ?>" width="<?php echo $thumb_img[1]; ?>" height="<?php echo $thumb_img[2]; ?>">
		</a>
		<div class="price"><?php echo get_woocommerce_currency_symbol()."".$product->get_price(); ?></div>
		<h3>
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
			<span><?php echo $product->get_meta( 'profession' ); ?></span>
		</a>
		</h3>
		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
		</div>
	</li>