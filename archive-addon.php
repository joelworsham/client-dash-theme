<?php get_header(); ?>

	<section class="row addons">
		<div class="columns small-12">
			<h2 class="page-title">Addons</h2>
			<?php if ( have_posts() ) : ?>
				<ul class="addons-list row">
					<?php while ( have_posts() ) : ?>
						<?php the_post(); ?>
						<?php $link = get_post_meta( $post->ID, '_cd_addon_link', true ); ?>
						<?php $icon = get_post_meta( $post->ID, '_cd_addon_icon', true ); ?>

						<li class="addon columns small-6 medium-4 <?php echo $post->post_status == 'draft' ? 'draft' : ''; ?>">
							<?php if ( $post->post_status == 'draft' ): ?>
								<p class="addon-icon icon-<?php echo $icon; ?>"></p>
								<h3 class="addon-title"><?php the_title(); ?></h3>
							<?php else: ?>
								<a class="link-invert" href="<?php echo $link ? $link : '#'; ?>">
									<p class="addon-icon icon-<?php echo $icon; ?>"></p>
									<h3 class="addon-title"><?php the_title(); ?></h3>
								</a>
							<?php endif; ?>
							<div class="addon-description">
								<?php the_content(); ?>
							</div>
						</li>
					<?php endwhile; ?>
				</ul>
			<?php endif; ?>
		</div>
	</section>

<?php get_footer(); ?>