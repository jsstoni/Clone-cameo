<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
<?php
$items = $order->get_items();
$name = '';
foreach ($items as $item) {
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $item->get_product_id() ), 'single-post-thumbnail' );
	$name = $item->get_name();
}
?>
<p>The moment you've been waiting for! <?php echo $name; ?> completed your Saraut request and it's pretty epic</p>

<?php $video = get_post_meta( $order->id, '_url_video', true ); ?>

<img src="https://drive.google.com/a/saraut.com/thumbnail?id=<?php echo $video; ?>&sz=w445" width="100%" height="350" alt="">

<a href="<?php echo get_home_url().'/video/?order='.$order->id.'&key='.$order->get_order_key(); ?>" style="color: #555; background: #fafafa; border: #eee solid 1px; padding: 5px 10px;">View your Saraut</a>

<p>They are going to freak out! Make sure to capture a reaction video and don't forget to let <?php echo $name; ?> know you think of the video.</p>

<p>Best,<br>Saraut</p>
<?php
do_action( 'woocommerce_email_footer', $email );
