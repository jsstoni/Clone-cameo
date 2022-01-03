<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited

if ( ! $order ) {
	return;
}

$order_items           = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note    = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();

if ( $show_downloads ) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}
?>
<section class="woocommerce-order-details">
	<?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>
<?php
$items = $order->get_items();
$name = '';
$link = '';
foreach ($items as $item) {
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $item->get_product_id() ), 'single-post-thumbnail' );
	$link = get_permalink( $item->get_product_id() );
	$name = $item->get_name();
}
?>
<div class="row">
	<div class="col-md-5">
		<?php $video = get_post_meta( $order->id, '_url_video', true ); ?>
		<?php if ($video != ''): ?>
			<iframe src="https://drive.google.com/file/d/<?php echo $video; ?>/preview" width="100%" height="350"></iframe>
		<?php endif; ?>
	</div>
	<div class="col-md-7">
		<a href="https://www.facebook.com/sharer/sharer.php?u=https://drive.google.com/file/d/<?php echo $video; ?>" class="btn btn-light shadow-sm border" target="_blank"><i class="fa fa-facebook"></i> SHARE ON FACEBOOK</a>
		<a href="http://twitter.com/share?text=@saraut&url=https://drive.google.com/file/d/<?php echo $video; ?>/&hashtags=saraut" class="btn btn-light shadow-sm border" target="_blank"><i class="fa fa-twitter"></i> SHARE ON TWITTER</a>
		<br>
		<?php if (is_user_logged_in() && $order->get_user_id() == get_current_user_id()): ?>
		<a href="https://drive.google.com/uc?id=<?php echo $video; ?>&export=download&authuser=0" class="btn btn-light shadow-sm border"><i class="fa fa-download"></i> DOWNLOAD</a>
		<?php else: ?>
		<a class="xoo-el-login-tgr btn btn-light shadow-sm border d-inline-block mt-2"><i class="fa fa-download"></i> DOWNLOAD</a>
		<?php endif; ?>
		<br>
		<div class="d-inline-block text-center my-3">
			<img src="<?php echo $image[0]; ?>" alt="" class="rounded-circle mb-2" style="width: 90px; height: 90px;">
			<p><strong class="d-block"><?php echo $name; ?></strong>
			<a href="<?php echo $link; ?>" class="btn btn-primary shadow-sm border d-inline-block rounded-pill">BOOK <?php echo $name; ?></a></p>
		</div>
	</div>
</div>
<hr>
<h3 class="my-3">Details</h3>
<hr>
<?php
$isfor = get_post_meta( $order->id, '_isfor', true );
echo '<p><strong>'.__('This video is for').':</strong> ' . $isfor . '</p>';
switch ($isfor) {
	case 'someoneElse':
		echo '<p><strong>'.__('To').':</strong> ' . get_post_meta( $order->id, 'to', true ) . '</p>';
		echo '<p><strong>'.__('From').':</strong> ' . get_post_meta( $order->id, 'from', true ) . '</p>';
		break;
	case 'myself':
		echo '<p><strong>'.__('My name is').':</strong> ' . get_post_meta( $order->id, 'mynameis', true ) . '</p>';
		break;
	case 'brand':
		echo '<p><strong>'.__('This shoutout is for').':</strong> ' . get_post_meta( $order->id, 'brand', true ) . '</p>';
		break;
}
echo '<p><strong>'.__("What's the occasion?").':</strong> ' . get_post_meta( $order->id, 'occasion', true ) . '</p>';
echo '<p><strong>'.__("Instructions").':</strong> ' . get_post_meta( $order->id, 'instructions', true ) . '</p>';
?>

	<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
</section>

<?php
if ( $show_customer_details ) {
	wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
}
