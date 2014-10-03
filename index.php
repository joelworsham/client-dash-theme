<?php
get_header();
?>

	<section id="page-blog" class="row content-section">
		<div class="columns small-12 medium-8">
			<?php
			// The blog posts loop
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					get_template_part( '/inc/loops/loop', 'posts' );
				}
			}
			?>

			<div class="nav-previous alignleft"><?php next_posts_link( '<span class="icon-arrow-left"></span>' ); ?></div>
			<div class="nav-next alignright"><?php previous_posts_link( '<span class="icon-arrow-right"></span>' ); ?></div>
		</div>
		<?php get_sidebar(); ?>
	</section>

<?php get_footer(); ?>