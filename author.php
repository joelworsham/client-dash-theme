<?php
get_header();

global $author;
$curauth = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ) );
?>

	<h2 class="page-title">
		<?php echo $curauth->nickname ?>
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