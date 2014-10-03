<?php get_header(); ?>

	<section id="categories" class="row">
		<div class="columns small-12 medium-8">
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
		</div>
		<?php get_sidebar(); ?>
	</section>

<?php get_footer(); ?>