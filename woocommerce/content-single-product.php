<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see	 https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version 4.2.0
 */

defined( 'ABSPATH' ) || exit;
global $product;
$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average 	  = $product->get_average_rating();
function totalStar($num)
{
	$star = '';
	for ($i=1; $i <= 5; $i++) {
		if ($num < $i) {
			$star .= '<span class="fa fa-star-o"></span>';
		}else {
			$star .= '<span class="fa fa-star"></span>';
		}
	}
	return $star;
}
do_action( 'woocommerce_before_single_product' );
?>
<div class="content-single-shop my-5">
<nav class="my-3">
<a href="<?php echo home_url(); ?>" class="btn btn-page">Back</a>
</nav>
<div class="product-single overflow-auto" id="product-<?php the_ID(); ?>">
	<?php $thumb_img = wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 'shop_catalog' ); ?>
	<img src="<?php echo $thumb_img[0]; ?>" class="product-single-img" width="<?php echo $thumb_img[1]; ?>" height="<?php echo $thumb_img[2]; ?>" alt="<?php echo get_the_title(); ?>">
	<h1><?php echo $product->get_name(); ?></h1>
	<?php the_content(); ?>
	<small class="my-3 modal-reviews" data-toggle="modal" data-target="#modalreviews"><?php echo totalStar($average); ?> <?php printf('%s See All %s', $average, $rating_count); ?></small>
</div><!-- #product-<?php the_ID(); ?> -->
<div class="mt-3">
<?php woocommerce_template_single_add_to_cart(); ?>
<a href="#" class="d-block text-center text-dark py-2" data-toggle="modal" data-target="#modalWork">How does it work?</a>
</div>

<div class="bg-darkend mt-5">
<div class="row">
	<div class="col-md-4 text-center">
		Responds in <br>
		<i class="fa fa-bolt color-1"></i> <?php echo $product->get_meta( 'respond' ) != '' ? $product->get_meta('respond') : 0; ?> hours
	</div>
	<div class="col-md-8">
		<?php
		$current_tags = get_the_terms( get_the_ID(), 'product_tag' );
		//only start if we have some tags
		if ( $current_tags && ! is_wp_error( $current_tags ) ) { 
			//create a list to hold our tags
			echo '<ul class="product_tags">';
			//for each tag we create a list item
			foreach ($current_tags as $tag) {
				$tag_title = $tag->name; // tag name
				$tag_link = get_term_link( $tag );// tag archive link
				echo '<li><a href="'.$tag_link.'">#'.$tag_title.'</a></li>';
			}
			echo '</ul>';
		}
		?>
	</div>
</div>
</div>

<div class="my-3">
<div class="row">
	<div class="col-md-6">
		<div class="bg-darkend">
		<strong class="color-2">What is Saraut?</strong>
		<div class="row whatis mt-3 text-center">
			<div class="col-4 col-md-4">
				<i class="fa fa-paper-plane-o"></i>
				<p>Send your request</p>
			</div>
			<div class="col-4 col-md-4">
				<i class="fa fa-video-camera"></i>
				<p>Get your video</p>
			</div>
			<div class="col-4 col-md-4">
				<i class="fa fa-thumbs-o-up"></i>
				<p>Make their year</p>
			</div>
		</div>
		</div>
	</div>
	<div class="col-md-6 mt-mb">
		<div class="bg-darkend">
		<strong class="color-3">What does a good request look like?</strong>
		<p>Tip #1 <br>
		Try to be as specific as possible with pronouns, numbers & details. Ex. “tell my BFF Cam (she) congrats on graduating from UCLA</p>
		</div>
	</div>
</div>
</div>
</div>

<div class="modal fade" id="modalWork" tabindex="-1" rol>
	<div class="modal-dialog modal-dialog-scrollable modal-lg">
		<div class="modal-content" style="background: #242424; color: #fff;">
			<div class="modal-header" style="border: none;">
				<h5 class="modal-title">What happens when I request a Saraut?</h5>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<ul class="steps-vertical">
					<li><i class="fa fa-calendar"></i><p>Your request will be completed within 7 days</p></li>

					<li><i class="fa fa-file-text-o"></i><p>Your receipt and order updates will be sent to the email provided under Delivery Information</p></li>

					<li><i class="fa fa-envelope-o"></i><p>When your request is completed, we’ll email and text you a link to view, share, or download your Cameo</p></li>

					<li><i class="fa fa-credit-card"></i><p>If for some reason your video isn’t completed, the hold on your card will be removed within 5-7 business days</p></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalreviews" tabindex="-1" role="dialog" aria-labelledby="modalreviewsTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalreviewsTitle"><?php echo $product->get_name(); ?> reviews (<?php echo $rating_count; ?>)</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php
				$args = array(
					'post_type' => 'product',
					'post_id' => $product->id,
					'status' => "approve"
				);
				$comments = get_comments($args);
				foreach ($comments as $comment) {
					$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
					echo '<div class="reviews mb-3">' . totalStar($rating). " <br> " .$comment->comment_content . "</div>";
				}
				?>
			</div>
		</div>
	</div>
</div>