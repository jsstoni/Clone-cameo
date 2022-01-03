<?php
/*
Template Name: Video page
*/
get_header();
?>
<div class="content my-5">
	<?php if (isset($_GET['order'])) : ?>
		<?php
		$order = wc_get_order($_GET['order']);
		$items = $order->get_items();
		$name = '';
		$link = '';
		foreach ($items as $item) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $item->get_product_id() ), 'single-post-thumbnail' );
			$link = get_permalink( $item->get_product_id() );
			$name = $item->get_name();
		}
		if ($order->get_order_key() == $_GET['key']) :
		?>
		<div class="row">
			<div class="col-md-5">
				<?php $video = get_post_meta( $order->id, '_url_video', true ); ?>
				<?php if (is_user_logged_in() && $order->get_user_id() == get_current_user_id()) : ?>
					<iframe src="https://drive.google.com/file/d/<?php echo $video; ?>/preview" width="100%" height="350"></iframe>
				<?php else: ?>
					<img src="https://drive.google.com/a/saraut.com/thumbnail?id=<?php echo $video; ?>&sz=w445" width="100%" height="350" alt="">
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
		<?php else: ?>
			
		<?php endif; ?>
	<?php else: ?>
	<?php endif; ?>
</div>
<?php
get_footer();