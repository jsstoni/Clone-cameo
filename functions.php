<?php
add_theme_support( 'woocommerce' );
add_theme_support( 'custom-logo' );
require get_template_directory() . '/inc/cleanup.php';
require get_template_directory() . '/inc/enqueue.php';
require get_template_directory() . '/inc/theme-support.php';

//Quitar boton agregr al carrito
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 20);

//Menu header
function wpb_custom_new_menu()
{
	register_nav_menu('header-menu',__( 'Header Menu' ));
}
add_action( 'init', 'wpb_custom_new_menu' );

function add_additional_class_on_li($classes, $item, $args) {
	if(isset($args->add_li_class)) {
		$classes[] = $args->add_li_class;
	}
	return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

function add_menuclass($ulclass) {
	return preg_replace('/<a /', '<a class="nav-link"', $ulclass);
}
add_filter('wp_nav_menu','add_menuclass');
//end menu

//Remover opciones de la pagina producto o tienda
remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

//Eliminar los breadcrumbs
function woo_remove_wc_breadcrumbs() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}
add_action( 'init', 'woo_remove_wc_breadcrumbs' );

//Permite agregar un solo producto al carro
function only_one_item_in_cart( $cartItemData ) {
	wc_empty_cart();
	return $cartItemData;
}
add_filter( 'woocommerce_add_cart_item_data', 'only_one_item_in_cart', 10, 1 );

//Eliminar cantidad de productos
function woo_remove_all_quantity_fields( $return, $product ) {
	return true;
}
add_filter( 'woocommerce_is_sold_individually', 'woo_remove_all_quantity_fields', 10, 2 );

//Redireccionar al agregar producto al carro
function cod_redirect_checkout_add_cart($url)
{
	$url = WC()->cart->get_checkout_url();
	return $url;
}
add_filter( 'woocommerce_add_to_cart_redirect', 'cod_redirect_checkout_add_cart' );

//redireccioar si es la pagina de carrito al checkout
function redirect_to_checkout_if_cart() {
	if ( !is_cart() ) return;
	global $woocommerce;
	if ( $woocommerce->cart->is_empty() ) {
		wp_redirect( get_home_url(), 302 );
	} else {
		wp_redirect( $woocommerce->cart->get_checkout_url(), 302 );
	}
	exit;
}
add_action( 'template_redirect', 'redirect_to_checkout_if_cart' );

//Quitar mensjae al agregar al carro
add_filter( 'wc_add_to_cart_message_html', '__return_false' );

//Quitar nota adicional
add_filter( 'woocommerce_checkout_fields' , 'bbloomer_remove_checkout_order_notes' );
function bbloomer_remove_checkout_order_notes( $fields ) {
	unset($fields['order']['order_comments']);
	return $fields;
}
add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );

//cambiar clases a formulario checkout
function addBootstrapToCheckoutFields($fields) {
	foreach ($fields as &$fieldset) {
		foreach ($fieldset as &$field) {
			// if you want to add the form-group class around the label and the input
			$field['class'][] = 'form-group'; 

			// add form-control to the actual input
			$field['input_class'][] = 'form-control';
		}
	}
	return $fields;
}
add_filter('woocommerce_checkout_fields', 'addBootstrapToCheckoutFields' );

//agregar custom field
function extra_fields_checkout () {
global $woocommerce;
$cartTitles = '';
foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
	$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
	$cartTitles = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
}
	?>
	<h4>Book a Saraut video from <?php echo $cartTitles; ?></h4>
	<label for="">This video is for:</label> <br>
	<input type="radio" name="isfor" value="someoneElse" id="someoneElse"> <label for="someoneElse">Someone else</label><br>
	<input type="radio" name="isfor" value="myself" id="myself"> <label for="myself">Myself</label><br>
	<input type="radio" name="isfor" value="brand" id="brand"> <label for="brand">A brand or business</label>
	<div class="row" id="sameoelse_op">
		<div class="col">
			<p class="form-row form-row-wide thwcfd-field-wrapper form-group validate-required" id="_to_field">
				<label for="_to" class="">To&nbsp;<abbr class="required" title="required">*</abbr></label>
				<span class="woocommerce-input-wrapper"><input type="text" class="input-text form-control" name="_to" id="_to" placeholder="Marcus"></span>
			</p>
		</div>
		<div class="col">
			<p class="form-row form-row-wide thwcfd-field-wrapper form-group validate-required" id="_from_field">
				<label for="_from" class="">From&nbsp;<abbr class="required" title="required">*</abbr></label>
				<span class="woocommerce-input-wrapper"><input type="text" class="input-text form-control" name="_from" id="_from" placeholder="Marian"></span>
			</p>
		</div>
	</div>

	<div id="myself_op" style="display: none;">
		<p class="form-row form-row-wide thwcfd-field-wrapper form-group" id="mynameis_field">
			<label for="mynameis" class="">My name is&nbsp;<abbr class="required" title="required">*</abbr></label>
			<span class="woocommerce-input-wrapper"><input type="text" class="input-text form-control" name="mynameis" id="mynameis" placeholder="Marian"></span>
		</p>
	</div>

	<div id="brand_op" style="display: none;">
		<p class="form-row form-row-wide thwcfd-field-wrapper form-group" id="brandbus_field">
			<label for="brandbus" class="">This shoutout is for&nbsp;<abbr class="required" title="required">*</abbr></label>
			<span class="woocommerce-input-wrapper"><input type="text" class="input-text form-control" name="brandbus" id="brandbus" placeholder="Johnny's Coffee Shop"></span>
		</p>
	</div>

	<div>
		<label for="occasion">What's the occasion?</label>
		<select name="occasion" id="occasion" class="form-control" data-allow_clear="true" data-placeholder="Choose an option" tabindex="-1" aria-hidden="true">
			<option value="gift">Gift</option><option value="birthday" selected="selected">Birthday</option><option value="valentines">Valentine's Day</option><option value="mothersday">Mother's Day</option><option value="pepTalk">Pep Talk</option><option value="announcement">Announcement</option><option value="advice">Advice</option><option value="roast">Roast</option><option value="wedding">Wedding</option><option value="anniversary">Anniversary</option><option value="question">Question</option>
		</select>
	</div>

	<div>
		<p class="form-row form-row-wide thwcfd-field-wrapper form-group validate-required" id="_from_field">
			<label for="mesagge">My instructions for <?php echo $cartTitles; ?> are&nbsp;<abbr class="required" title="required">*</abbr></label>
			<span class="woocommerce-input-wrapper"><textarea name="mesagge" class="input-text form-control" id="mesagge" placeholder="Hey my bro Brad and I (Chad) love your stuff. Can you say what up to Brad and tell him to 'keep his antlers long'? Thanks bro!" rows="4"></textarea></span>
		</p>
	</div>

	<h4>Contact information</h4>
	<p>This is where your receipt and order updates will be sent</p>
	<?php 
}
add_action( 'woocommerce_before_checkout_billing_form', 'extra_fields_checkout', 10, 1 );

function extra_fields_checkout_js()
{
?>
<script>
	jQuery("#someoneElse").prop("checked", true);
	jQuery("input[name=isfor]").on("change", function() {
		var vl = jQuery(this).val();
		if(vl == 'someoneElse') {
			jQuery("#mesagge").attr('placeholder', "Hey my bro Brad and I (Chad) love your stuff. Can you say what up to Brad and tell him to 'keep his antlers long'? Thanks bro!");
			jQuery("#sameoelse_op").find('p').addClass('validate-required');
			jQuery("#sameoelse_op").show();
			jQuery("#myself_op").hide();
			jQuery("#brand_op").hide();
			jQuery("#myself_op, #brand_op").find('p').removeClass('validate-required');
		}else if (vl == 'myself') {
			jQuery("#mesagge").attr('placeholder', "Can you tell me a funny joke? I'm a big fan of jokes, and you!");
			jQuery("#sameoelse_op").hide();
			jQuery("#myself_op").show();
			jQuery("#myself_op").find('p').addClass('validate-required');
			jQuery("#brand_op").hide();
			jQuery("#sameoelse_op, #brand_op").find('p').removeClass('validate-required');
		}else {
			jQuery("#mesagge").attr('placeholder', "Hey can you let the world know that Johnny's Coffee Shop is the best ever?");
			jQuery("#sameoelse_op").hide();
			jQuery("#myself_op").hide();
			jQuery("#sameoelse_op, #myself_op").find('p').removeClass('validate-required');
			jQuery("#brand_op").show();
			jQuery("#brand_op").find('p').addClass('validate-required');
		}
	});
</script>
<?php
}
add_action( 'woocommerce_after_checkout_billing_form', 'extra_fields_checkout_js', 10, 1 );

//validar custom fields
function validate_custom_fields( $fields, $errors )
{
	$form = (isset($_POST['isfor']) && !empty($_POST['isfor'])) &&
	(isset($_POST['occasion']) && !empty($_POST['occasion'])) &&
	(isset($_POST['mesagge']) && !empty($_POST['mesagge']));
	if ($form) {
		switch ($_POST['isfor']) {
			case 'someoneElse':
				$post = (isset($_POST['_to']) && !empty($_POST['_to'])) &&
				(isset($_POST['_from']) && !empty($_POST['_from']));
				if (!$post) {
					$errors->add( 'validation', 'Complete field (To) and (From)' );
				}
				break;
			case 'myself':
				if (!(isset($_POST['mynameis']) && !empty($_POST['mynameis']))) {
					$errors->add( 'validation', 'Complete your name' );
				}
				break;
			case 'brand':
				if (!(isset($_POST['brandbus']) && !empty($_POST['brandbus']))) {
					$errors->add( 'validation', 'Complete your brand' );
				}
				break;
			default:
				$errors->add( 'validation', $_POST['isfor'] );
				break;
		}
	}else {
		$errors->add( 'validation', 'Sorry complete form' );
	}
}
add_action( 'woocommerce_after_checkout_validation', 'validate_custom_fields', 10, 2);

//guardar custom fields
add_action( 'woocommerce_checkout_create_order', function( $order, $data ) {
	if (isset($_POST['isfor'])) {
		$order->update_meta_data( '_isfor', $_POST['isfor'] );
		switch ($_POST['isfor']) {
			case 'someoneElse':
				$order->update_meta_data( 'to', $_POST['_to'] );
				$order->update_meta_data( 'from', $_POST['_from'] );
				break;
			case 'myself':
				$order->update_meta_data( 'mynameis', $_POST['mynameis'] );
				break;
			case 'brand':
				$order->update_meta_data( 'brand', $_POST['brandbus'] );
				break;
		}
	}
	if (isset($_POST['occasion'])) $order->update_meta_data( 'occasion', $_POST['occasion'] );
	if (isset($_POST['mesagge'])) $order->update_meta_data( 'instructions', $_POST['mesagge'] );
}, 10, 2 );


//custom field admin order
function editable_order_meta_general($order)
{
	$_url = get_post_meta( $order->get_id(), '_url_video', true );
	woocommerce_wp_text_input( array(
		'id'	=> '_url_video',
		'label' => 'URL Video:',
		'value' => $_url,
		'wrapper_class' => 'form-field-wide'
	) );
}
add_action( 'woocommerce_admin_order_data_after_order_details', 'editable_order_meta_general' );

function save_general_details($order)
{
	update_post_meta( $order, '_url_video', wc_clean($_POST['_url_video']) );
}
add_action( 'woocommerce_process_shop_order_meta', 'save_general_details' );

function select_checkout_field_display($order) {
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
}
add_action( 'woocommerce_admin_order_data_after_billing_address', 'select_checkout_field_display', 10, 1 );

add_action('woocommerce_thankyou', 'checkout_fields_thankyou', 10, 2 );
function checkout_fields_thankyou($order_id)
{
	$isfor = get_post_meta( $order_id, '_isfor', true );
	echo '<p><strong>'.__('This video is for').':</strong> ' . $isfor . '</p>';
	switch ($isfor) {
		case 'someoneElse':
			echo '<p><strong>'.__('To').':</strong> ' . get_post_meta( $order_id, 'to', true ) . '</p>';
			echo '<p><strong>'.__('From').':</strong> ' . get_post_meta( $order_id, 'from', true ) . '</p>';
			break;
		case 'myself':
			echo '<p><strong>'.__('My name is').':</strong> ' . get_post_meta( $order_id, 'mynameis', true ) . '</p>';
			break;
		case 'brand':
			echo '<p><strong>'.__('This shoutout is for').':</strong> ' . get_post_meta( $order_id, 'brand', true ) . '</p>';
			break;
	}
	echo '<p><strong>'.__("What's the occasion?").':</strong> ' . get_post_meta( $order_id, 'occasion', true ) . '</p>';
	echo '<p><strong>'.__("Instructions").':</strong> ' . get_post_meta( $order_id, 'instructions', true ) . '</p>';
}

add_filter( 'wc_stripe_payment_icons', 'change_my_icons' );
function change_my_icons( $icons ) {
	// var_dump( $icons ); to show all possible icons to change.
	unset($icons['visa']);
	unset($icons['amex']);
	unset($icons['mastercard']);
	unset($icons['discover']);
	unset($icons['diners']);
	unset($icons['jcb']);
	return $icons;
}

//Campo personalizado en producto
function profession_custom_field() {
	$profession = array(
		'id' => 'profession',
		'label' => __( 'Profession', 'wooocommerce' ),
		'desc_tip' => true,
		'description' => __( 'Profession.', 'woocommerce' ),
	);
	woocommerce_wp_text_input( $profession );

	$respond = array(
		'id' => 'respond',
		'label' => __( 'Responds in', 'wooocommerce' ),
		'desc_tip' => true,
		'description' => __( 'Responds in', 'woocommerce' ),
	);
	woocommerce_wp_text_input( $respond );
}
add_action( 'woocommerce_product_options_general_product_data', 'profession_custom_field' );

//Guardar campo personalizado del producto
function profession_save_field( $post_id )
{
	$product = wc_get_product( $post_id );
	$profession = isset( $_POST['profession'] ) ? $_POST['profession'] : '';
	$respond = isset( $_POST['respond'] ) ? $_POST['respond'] : 0;
	$product->update_meta_data( 'profession', sanitize_text_field( $profession ) );
	$product->update_meta_data( 'respond', sanitize_text_field( $respond ) );
	$product->save();
}
add_action( 'woocommerce_process_product_meta', 'profession_save_field' );

//Widgets para el footer
function footer_widgets_init()
{
	register_sidebar( array(
		'name'			=> __( 'Footer 1', 'woocommerce' ),
		'id'			=> 'footer-1',
		'description'	 => __( 'Add widgets here to appear in your footer.', 'woocommerce' ),
		'before_widget' => '<section id="%1$s">',
		'after_widget'	=> '</section>',
		'before_title'	=> '<span>',
		'after_title'	 => '</span>',
	) );
	register_sidebar( array(
		'name'			=> __( 'Footer 2', 'woocommerce' ),
		'id'			=> 'footer-2',
		'description'	 => __( 'Add widgets here to appear in your footer.', 'woocommerce' ),
		'before_widget' => '<section id="%1$s">',
		'after_widget'	=> '</section>',
		'before_title'	=> '<span>',
		'after_title'	 => '</span>',
	) );
}
add_action( 'widgets_init', 'footer_widgets_init' );

//profile
function myaccount_required_fields( $account_fields )
{
	unset( $account_fields['account_last_name'] );
	unset( $account_fields['account_first_name'] ); // First name
	// unset( $account_fields['account_display_name'] ); // Display name
	return $required_fields;
}
add_filter('woocommerce_save_account_details_required_fields', 'myaccount_required_fields');

function action_woocommerce_edit_account_form_tag()
{
	echo 'enctype="multipart/form-data"';
}
add_action( 'woocommerce_edit_account_form_tag', 'action_woocommerce_edit_account_form_tag' );

function action_woocommerce_save_account_details( $user_id )
{	
	if (isset($_FILES['picture']))
		save_profile_picture($_FILES['picture'], $user_id);
}
add_action( 'woocommerce_save_account_details', 'action_woocommerce_save_account_details', 10, 1 );

function save_profile_picture($picture_id, $user_id)
{
	if (!function_exists('wp_handle_upload')) {
		require_once(ABSPATH . 'wp-admin/includes/file.php');
	}
	$uploadedfile = $picture_id;
	$upload_overrides = array('test_form' => false);
	$imageFileType = pathinfo($uploadedfile['name'], PATHINFO_EXTENSION);
	$movefile = wp_handle_upload($uploadedfile, $upload_overrides);
	if ($movefile && !isset($movefile['error'])) {
		$success_upload = $movefile['url'];
		update_user_meta( $user_id, 'profile_pic', $success_upload );
	}
}

function check_if_register_user($user_id)
{
	global $wpdb;
	$info_user = get_userdata($user_id);
	$bil_id = $wpdb->get_results($wpdb->prepare( 'SELECT post_id FROM wp_postmeta WHERE meta_key = "_billing_email" AND meta_value = %s', $info_user->user_email));
	if (sizeof($bil_id) > 0) {
		foreach ($bil_id as $item) {
			update_post_meta($item->post_id, '_customer_user', $user_id);
		}
	}
}
add_action( 'user_register', 'check_if_register_user', 10, 1 );

add_action('wp_logout','redirect_after_logout');
function redirect_after_logout()
{
	wp_redirect( get_home_url() );
	exit();
}
?>