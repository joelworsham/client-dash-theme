<?php get_header(); ?>

	<h2 class="page-title">
		<?php the_title(); ?>
	</h2>

<?php the_post(); ?>

<?php the_content(); ?>

<?php comments_template(); ?>

<?php get_footer(); ?>