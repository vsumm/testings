<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @package Kata
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$latest_post_id = class_exists( 'Kata_Plus_Helpers' ) ? Kata_Plus_Helpers::get_latest_post_id() : get_the_ID();
?>

<div id="kata-comments" class="kata-comments-area">
	<?php
	global $user_identity;

	$commenter     = wp_get_current_commenter();
	$req           = get_option( 'require_name_email' );
	$aria_req      = ( $req ? " aria-required='true'" : '' );
	$required_text = __( 'Required fields are marked', 'kata' ) . ' <span class="required">*</span>';
	$fields        = array(
		'author' => '<p class="comment-form-author"> <span class="label-wrap"> <label for="author">' . __( 'Name', 'kata' ) . '</label>' . ( $req ? '<span class="required">*</span>' : '' ) . '</span> <input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email"> <span class="label-wrap"> <label for="email">' . __( 'Email', 'kata' ) . '</label>' . ( $req ? '<span class="required">*</span>' : '' ) . '</span> <input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'kata' ) . '</label><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
	);

	$args = array(
		'id_form'              => 'commentform',
		'class_form'           => 'comment-form',
		'id_submit'            => 'submit',
		'class_submit'         => 'submit',
		'name_submit'          => 'submit',
		'title_reply'          => __( 'Leave a Reply', 'kata' ),
		'title_reply_to'       => __( 'Leave a Reply to', 'kata' ),
		'cancel_reply_link'    => __( 'Cancel Reply', 'kata' ),
		'label_submit'         => __( 'Post Comment', 'kata' ),
		'format'               => 'xhtml',
		'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . __( 'Comment', 'kata' ) . '</label><textarea id="comment" name="comment" cols="45" rows="6" aria-required="true"></textarea></p>',
		'must_log_in'          => '<p class="must-log-in">' . __( 'You must be logged in to post a comment.', 'kata' ) . ' <a href="' . wp_login_url( apply_filters( 'kata_the_permalink', get_permalink() ) ) . '">' . __( 'Login', 'kata' ) . '</a></p>',
		'logged_in_as'         => '<p class="logged-in-as">' . esc_html__( 'Logged in as', 'kata' ) . ' <a href="' . esc_url( admin_url( 'profile.php' ) ) . '">' . $user_identity . '</a> ' . '<a href="' . esc_url( wp_logout_url( apply_filters( 'kata_the_permalink', get_permalink() ) ) ) . '">' . esc_html__( 'Log out?', 'kata' ) . '</a></p>',
		'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.', 'kata' ) . ( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after'  => '',
		'fields'               => apply_filters( 'kata_comment_form_default_fields', $fields ),
	);

	comment_form( $args, $latest_post_id );

	$kata_comment_count = get_comments_number( $latest_post_id );
	if ( '0' !== $kata_comment_count ) {
		?>
		<h2 class="kata-comments-title">
			<?php
			if ( '1' === $kata_comment_count ) {
				echo esc_html__( 'One thought on', 'kata' ) . '<span>"' . esc_html( get_the_title() ) . '"</span>';
			} else {
				echo esc_html( $kata_comment_count ) . esc_html__( ' thought on ', 'kata' ) . '<span>' . esc_html( get_the_title() ) . '</span>';
			}
			?>
		</h2> <!-- .kata-comments-title -->

		<?php the_comments_navigation(); ?>

		<ul class="kata-comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ul',
					'short_ping'  => true,
					'avatar_size' => '81',
				)
			);
			?>
		</ul><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="kata-no-comments"><?php esc_html_e( 'Comments are closed.', 'kata' ); ?></p>
			<?php
		endif;
	}
	?>

</div><!-- #comments -->
