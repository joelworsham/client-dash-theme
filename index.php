<?php get_header(); ?>

<section id="home-download" class="row content-section">
	<div class="columns large-12">
		<a href="http://wordpress.org/plugins/client-dash/" class="button">Download</a>
		<a href="https://github.com/brashrebel/client-dash/" class="button">View on Github</a>
	</div>
</section>

<section id="home-info" class="row content-section">
	<?php
	$home = get_posts( array(
		'name' => 'home',
		'post_type' => 'page'
	) );
	echo do_shortcode( apply_filters( 'the_content', $home[0]->post_content ) );
	?>
</section>

<section id="home-blog" class="row content-section">
	<div class="columns large-12">
		<?php
		// The blog posts loop
		if ( have_posts() ) {
			echo '<h2 class="home-blog-heading">The latest in Client Dash</h2>';
			while ( have_posts() ) {
				the_post();
				get_template_part( '/inc/loops/loop', 'posts' );
			}
		}
		?>
	</div>
</section>

<?php get_footer(); ?>