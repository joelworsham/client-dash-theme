<?php
get_header();

$features = get_posts( array(
	'post_type'    => 'feature',
	'number_posts' => - 1,
) );

$addon_list = array(
	'Widget Roles',
	'WP Help',
	'Backup Buddy',
	'Status Cake',
);

// Get which addons to include by the title
foreach ( $addon_list as $addon_item ) {
	$addon_item = get_page_by_title( $addon_item, 'OBJECT', 'addon' );
	$addon_in[] = $addon_item->ID;
}

$addons = get_posts( array(
	'post_type' => 'addon',
	'post__in'  => $addon_in,
	'post_status' => array( 'publish', 'draft' ),
) )
?>

	<section id="home-download" class="row content-section">
		<div class="columns large-12">
			<div class="show-for-medium-up">
				<a href="http://wordpress.org/plugins/client-dash/" class="button large">Download Now!</a>
			</div>
			<div class="show-for-small-only">
				<a href="http://wordpress.org/plugins/client-dash/" class="button">Download Now!</a>
			</div>
		</div>
	</section>


<?php
// Output our features
if ( ! empty( $features ) ) {
	global $post;
	$i = 0;
	foreach ( $features as $post ) {
		$i ++;
		setup_postdata( $post );

		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		?>
		<section class="feature columns large-12">
			<?php
			if ( $icon = get_post_meta( $post->ID, '_cd_feature_icon', true ) ) {
				?>
				<div class="row">
				<?php if ( $i % 2 == 0 ) : ?>
					<div class="columns small-12 medium-5 hide-for-small-only">
						<a href="<?php echo $large_image_url[0]; ?>" title="<?php the_title_attribute(); ?>"
						   rel="lightbox">
							<?php the_post_thumbnail( 'large' ); ?>
						</a>
					</div>
				<?php endif; ?>

				<div class="columns small-12 medium-7">
					<p class="feature-icon icon-<?php echo $icon; ?>"></p>

					<h3 class="feature-title"><?php the_title(); ?></h3>

					<div class="feature-content">
						<?php the_content(); ?>
					</div>
				</div>

				<?php if ( $i % 2 != 0 ) : ?>
					<div class="columns small-12 medium-5">
						<a href="<?php echo $large_image_url[0]; ?>" title="<?php the_title_attribute(); ?>"
						   rel="lightbox">
							<?php the_post_thumbnail( 'large' ); ?>
						</a>
					</div>
				<?php else: ?>
					<div class="columns small-12 medium-5 show-for-small-only">
						<a href="<?php echo $large_image_url[0]; ?>" title="<?php the_title_attribute(); ?>"
						   rel="lightbox">
							<?php the_post_thumbnail( 'large' ); ?>
						</a>
					</div>
				<?php endif; ?>

				</div><?php // .row ?>

				<hr/>
			<?php
			} // end if has icon
			?>
		</section>
	<?php
	} // end foreach
	?>
<?php
}

if ( ! empty( $addons ) ) {
	?>
	<section class="addons columns small-12">
		<div class="row">
			<h2 class="featured-addons columns small-12">Featured Addons</h2>
			<ul>
				<?php
				foreach ( $addons as $post ) {
					if ( $icon = get_post_meta( $post->ID, '_cd_addon_icon', true ) ) {
						setup_postdata( $post );
						$link = get_post_meta( $post->ID, '_cd_addon_link', true );
						?>
						<li class="addon columns small-6 medium-3 <?php echo $post->post_status == 'draft' ? 'draft' : ''; ?>">
							<?php if ( $post->post_status == 'draft' ): ?>
								<p class="addon-icon icon-<?php echo $icon; ?>"></p>
								<h3 class="addon-title"><?php the_title(); ?></h3>
							<?php else: ?>
								<a class="link-invert" href="<?php echo $link ? $link : '#'; ?>">
									<p class="addon-icon icon-<?php echo $icon; ?>"></p>
									<h3 class="addon-title"><?php the_title(); ?></h3>
								</a>
							<?php endif; ?>
						</li>
					<?php
					}
				}
				?>
			</ul>
			<div class="clear"></div>
			<p class="text-center addons-view-all">
				<a href="/addons/">View all</a>
			</p>
		</div>
		<div class="clear"></div>
		<hr/>
	</section>
<?php
}

global $posts, $wp_query;
$posts                = get_posts( array(
	'post_type'   => 'post',
	'numberposts' => 3,
) );
$wp_query->post_count = count( $posts );
?>
	<section id="home-blog" class="row content-section">
		<div class="columns large-12">
			<?php
			// The blog posts loop
			if ( have_posts() ) {
				echo '<h2 class="home-blog-heading"><a class="link-invert" href="/blog">The latest in Client Dash</a></h2>';
				while ( have_posts() ) {
					the_post();
					get_template_part( '/inc/loops/loop', 'posts' );
				}
			}
			?>
		</div>
	</section>

<?php get_footer(); ?>