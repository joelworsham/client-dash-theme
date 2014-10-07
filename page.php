<?php get_header(); ?>

	<section class="page row">
		<div class="columns large 12">

			<?php
			/**
			 * Allows modifying the visibility of the page title.
			 *
			 * @since Client Dash Theme 0.1.2
			 */
			if ( apply_filters( 'cd_page_title', true ) ):
				?>
				<h2 class="page-title">
					<?php the_title(); ?>
				</h2>
			<?php endif; ?>

			<?php the_post(); ?>

			<?php the_content(); ?>
		</div>
	</section>

<?php get_footer(); ?>