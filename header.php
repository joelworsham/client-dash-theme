<?php global $ClientDash_Theme; ?>

	<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<?php // Basic, needed html stuff ?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

		<?php // The page title ?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>

		<?php wp_head(); ?>
	</head>
<body <?php body_class(); ?>>

<div id="wrapper" class="off-canvas-wrap" data-offcanvas>
	<div class="inner-wrap">

	<a id="site-nav-toggle"
	   class="right-off-canvas-toggle icon-menu2" <?php echo wp_is_mobile() ? 'href="#"' : ''; ?>></a>

	<aside class="right-off-canvas-menu">
		<div id="site-navigation">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'site-nav',
			) );
			?>
		</div>
	</aside>

	<header id="site-header">
		<div class="row">
			<div class="columns large-12">
				<?php if ( is_front_page() ) : ?>
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/main-logo.png"/>
					<h1 class="site-title">CLIENT DASH</h1>
				<?php else: ?>
					<a href="<?php echo bloginfo( 'url' ); ?>">
						<h1 class="site-title">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/small-logo.png"/>
							<span>CLIENT DASH</span>
						</h1>
					</a>
				<?php endif; ?>
			</div>
		</div>
		<?php if ( is_front_page() ) : ?>
			<p class="site-tagline"><?php echo get_bloginfo( 'description' ) ? get_bloginfo( 'description' ) : ''; ?></p>
		<?php endif; ?>
	</header>

<?php if ( function_exists( 'yoast_breadcrumb' ) && ! is_front_page() ) : ?>
	<section id="breadcrumbs" class="row">
		<div class="columns small-12">
			<?php yoast_breadcrumb( '<ul class="breadcrumbs">', '</ul>' ); ?>
		</div>
	</section>
<?php endif; ?>