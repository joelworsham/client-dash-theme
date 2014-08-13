<?php
get_header();

// Meta information
$author_name = get_the_author_meta( 'display_name' );
$author_link = get_author_posts_url( $post->post_author );

the_post();
?>

	<h2 class="page-title">
		<?php the_title(); ?>
	</h2>

	<div class="post-meta">
		<p>This was written by <a href="<?php echo $author_link; ?>"><?php echo $author_name; ?></a>
			on <?php the_date(); ?>
			in <?php the_category( ', ' ); ?><?php edit_post_link( ' | <span class="icon-pencil"></span> Edit This' ); ?>
	</div>

<?php the_content(); ?>

<?php comments_template(); ?>

<?php get_footer(); ?>