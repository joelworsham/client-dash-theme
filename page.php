<?php get_header(); ?>

	<section class="page row">
		<div class="columns large 12">
			<h2 class="page-title">
				<?php the_title(); ?>
			</h2>

			<?php the_post(); ?>

			<?php the_content(); ?>
		</div>
	</section>

<?php get_footer(); ?>