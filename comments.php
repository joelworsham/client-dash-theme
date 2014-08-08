<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package testest
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

	<div id="comments" class="comments-area">

		<?php // You can start editing here -- including this comment! ?>

		<?php if ( have_comments() ) : ?>
			<h2 class="comments-title">
				<?php
				printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'testest' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
				?>
			</h2>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
				<nav id="comment-nav-above" class="comment-navigation" role="navigation">
					<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'testest' ); ?></h1>
					<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'testest' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'testest' ) ); ?></div>
				</nav><!-- #comment-nav-above -->
			<?php endif; // check for comment navigation ?>

			<ol class="comment-list">
				<?php
				wp_list_comments( array(
					'callback' => 'theme_comment',
					'end-callback' => 'theme_comment_end',
					'style'      => 'ul',
					'short_ping' => true,
				) );
				?>
			</ol><!-- .comment-list -->

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
				<nav id="comment-nav-below" class="comment-navigation" role="navigation">
					<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'testest' ); ?></h1>
					<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'testest' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'testest' ) ); ?></div>
				</nav><!-- #comment-nav-below -->
			<?php endif; // check for comment navigation ?>

		<?php endif; // have_comments() ?>

		<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
			?>
			<p class="no-comments"><?php _e( 'Comments are closed.', 'testest' ); ?></p>
		<?php endif; ?>

		<?php comment_form(); ?>

	</div><!-- #comments -->


<?php
function theme_comment( $comment, $args, $depth ) {

	$author_name = get_comment_author();
	$author_link = get_author_posts_url( $comment->user_id );
	$author = isset( $author_link ) ? "<a href='$author_link' class='comment-author'>$author_name</a>" : "<span class='comment-author'>$author_name</span>";
	?>

	<li class="comment-item">
	<div <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<div class="comment-text">

			<?php if ( $comment->comment_approved == '0' ) { ?>
				<p>Your comment is awaiting moderation.</p>
			<?php } else { ?>
				<?php comment_text(); ?>
			<?php } ?>
		</div>

		<p class="comment-meta">
			This comment was posted on <?php comment_date( 'F d, Y' ); ?> at <?php comment_time( 'g:i a' ); ?> by <?php echo $author; ?>
		</p>
	</div>

<?php
}

function theme_comment_end() {
	echo '</li>';
}