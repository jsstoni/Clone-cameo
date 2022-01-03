<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );
global $woocommerce;
?>
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
	<div class="row">
		<div class="col-xs-12 col-md-7">
			<?php if ( $checkout->get_checkout_fields() ) : ?>
				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
				<div id="customer_details">
					<?php do_action( 'woocommerce_checkout_billing' ); ?>

					<?php do_action( 'woocommerce_checkout_shipping' ); ?>
				</div>
				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
			<?php endif; ?>

			<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

				<div id="order_review" class="woocommerce-checkout-review-order">
					<?php do_action( 'woocommerce_checkout_order_review' ); ?>
				</div>

			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
			<?php echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="btn bg-2 text-white btn-block rounded-pill" name="woocommerce_checkout_place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">BOOK FOR '. $woocommerce->cart->get_cart_total() .'</button>' ); // @codingStandardsIgnoreLine ?>
		<?php do_action( 'woocommerce_review_order_after_submit' ); ?>
		</div>

		<div class="col-xs-12 col-md-5">
			<?php
			global $woocommerce;
			$cartTitles = '';
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$cartTitles = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
			}
			?>
			<div class="happens mt-mb d-none d-sm-block">
				<h4>What happens next?</h4>
				<div class="happens-line">
					<img src="https://d3el26csp1xekx.cloudfront.net/static/assets/confirmation-page/confirmation-calendar.svg" alt=""><p><strong><?php echo $cartTitles; ?></strong> has 4 days to complete your request.</p>
				</div>
				<div class="happens-line">
					<img src="https://d3el26csp1xekx.cloudfront.net/static/assets/confirmation-page/confirmation-receipt.svg" alt=""><p>Your receipt and order updates will be sent to the email provided under <strong>Delivery Information.</strong></p>
				</div>
				<div class="happens-line">
					<img src="https://d3el26csp1xekx.cloudfront.net/static/assets/confirmation-page/confirmation-receipt.svg" alt=""><p>When your request is completed, <strong>we'll email and text you</strong> a link to view, share, or download your Saraut.</p>
				</div>
				<div class="happens-line">
					<img src="https://d3el26csp1xekx.cloudfront.net/static/assets/confirmation-page/confirmation-credit-card.svg" alt=""><p>If for some reason your video isn't completed, the <strong><?php echo $woocommerce->cart->get_cart_total(); ?></strong> hold on your card will be removed within 5-7 business days.</p>
				</div>
			</div>
		</div>
	</div>
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
