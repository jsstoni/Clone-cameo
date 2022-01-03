<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see		 https://docs.woocommerce.com/document/template-structure/
 * @package	 WooCommerce/Templates
 * @version	 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$current_user = wp_get_current_user();
$user_id = get_current_user_id();
?>
<?php
	do_action( 'woocommerce_before_edit_account_form' ); ?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

	<div class="myaccount">
	<img src="<?php echo get_user_meta(get_current_user_id(), 'profile_pic', true); ?>" style="width: 90px; height: 90px;" alt="">
	<h1><?php echo esc_attr( $current_user->display_name ); ?></h1>
	<label for="upload">Upload image</label>
	<input type="file" name="picture" id="upload" style="display: none;">
	</div>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $current_user->display_name ); ?>" /> <span><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
	</p>
	<div class="clear"></div>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text form-control" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $current_user->user_email ); ?>" />
	</p>

	<div class="clear"></div>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p>
		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
		<button type="submit" class="btn btn-primary" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<h3>Your Orders</h3>
<?php
$current_page	= empty( $current_page ) ? 1 : absint( $current_page );
$customer_orders = wc_get_orders( apply_filters( 'woocommerce_my_account_my_orders_query', array(
	'customer' => get_current_user_id(),
	'page'	 => $current_page,
	'paginate' => true,
) ) );

wc_get_template(
	'myaccount/orders.php',
	array(
		'current_page'	=> absint( $current_page ),
		'customer_orders' => $customer_orders,
		'has_orders'	  => 0 < $customer_orders->total,
	)
);
?>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
