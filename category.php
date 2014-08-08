<?php get_header(); ?>

	<h2 class="page-title">
		<?php single_cat_title(); ?>
	</h2>


<?php
// The blog posts loop
if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		get_template_part( '/inc/loops/loop', 'posts' );
	}
}
?>

<?php comments_template(); ?>

<?php get_footer(); ?>