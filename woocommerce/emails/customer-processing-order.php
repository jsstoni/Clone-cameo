<?php
/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
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
<strong>Nice! Your request has been sent.</strong>
<p>We've just sent out Saraut request to %name%. It may take up to 5 days for Saraut to be completed, but hopefully it comes much faster.</p>

<p>Order # <?php echo $order->id; ?></p>

<p>While you wait, check out all the other awesome talent we have lined up for your next surprise.</p>

<a href="<?php echo get_home_url(); ?>" style="color: #555; background: #fafafa; border: #eee solid 1px; padding: 5px 10px;">BROWSE TALENT</a>

<p>A temporary hold has been placed on your card to ensure sufficient funds. This will turn into a charge when your Saraut is completed. If your request is declined, cancelled, or expired, the hold will be released.</p>
<?php
do_action( 'woocommerce_email_footer', $email );
