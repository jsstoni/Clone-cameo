<?php
/*
Template Name: category page
*/
?>
<?php get_header(); ?>

<div class="content my-5">
<nav class="category-menu">
<ul>
	<li><a href="<?php echo home_url(); ?>">Home</a></li>
	<li class="space"></li>
<?php
$args = array(
	'taxonomy' => 'product_cat',
	'hide_empty' => false,
	'parent'	 => 0,
	'exclude' => array(15)
);
$product_cat = get_terms( $args );
$items_count = 0;
foreach ($product_cat as $parent_product_cat) {
	echo '<li><a href="'.get_term_link($parent_product_cat->term_id).'">'.$parent_product_cat->name." ".$parent_product_cat->count."</a></li>";
	$items_count += $parent_product_cat->count;
}
?>
<li><a href="https://saraut.com/category/" class="active">All Categories <?php echo $items_count; ?></a></li>
</ul>
</nav>
<?php
$product_cat = get_terms( $args );

foreach ($product_cat as $parent_product_cat) {
	echo '<h3 class="mt-4" style="font-size: 42px"><a href="'.get_term_link($parent_product_cat->term_id).'" class="text-dark">'.$parent_product_cat->name.'</a></h3>';
	echo '<div class="row">';
	$child_args = array(
		'taxonomy' => 'product_cat',
		'hide_empty' => false,
		'parent'	 => $parent_product_cat->term_id
	);
	$child_product_cats = get_terms( $child_args );
	foreach ($child_product_cats as $child_product_cat)
	{
		echo '<div class="col-md-2"><a href="'.get_term_link($child_product_cat->term_id).'" class="text-dark">'.$child_product_cat->name.' <small>'.$child_product_cat->count.'</small></a></div>';
	}
	echo '</div>';
}
?>
</div>

<?php get_footer(); ?>