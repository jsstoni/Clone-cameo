<?php get_header(); ?>
<?php
if (is_account_page() || is_checkout()) :
	$class = 'content-checkout';
else :
	$class = 'content';
endif;
?>
<div class="<?php echo $class; ?> my-5">
<?php 
  if(have_posts()):
    while(have_posts()): the_post(); ?>
      <?php echo the_content(); ?>
    <?php endwhile;
  endif;
?>
</div>
<?php get_footer(); ?>