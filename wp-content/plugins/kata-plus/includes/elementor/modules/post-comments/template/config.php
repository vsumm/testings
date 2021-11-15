<?php
/**
 * Post Comments module config.
 *
 * @author  ClimaxThemes
 * @package Kata Plus
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Kata_Plus_Post_Comments extends Widget_Base {
	public function get_name() {
		return 'kata-plus-post-comments';
	}

	public function get_title() {
		return esc_html__( 'Post Comments', 'kata-plus' );
	}

	public function get_style_depends() {
		return [ 'kata-plus-comments' ];
	}

	public function get_script_depends() {
		return [ 'kata-plus-comments' ];
	}

	public function get_icon() {
		return 'kata-widget kata-eicon-comments';
	}

	public function get_categories() {
		return [ 'kata_plus_elementor_blog_and_post' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'wrapper',
			[
				'label' => esc_html__( 'Wrapper', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-comments-area' ),
			]
		);
		$this->add_control(
			'styler_container',
			[
				'label'            => esc_html__( 'Container', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.comment-respond' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'styles_section',
			[
				'label' => esc_html__( 'Form', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'styler_title',
			[
				'label'     => esc_html__( 'Title', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-comments-area #reply-title' ),
			]
		);
		$this->add_control(
			'styler_notes',
			[
				'label'     => esc_html__( 'Note', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-comments-area .comment-notes' ),
			]
		);
		$this->add_control(
			'styler_logged_textarea',
			[
				'label'     => esc_html__( 'Post Comments textarea', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-comments-area textarea' ),
			]
		);
		$this->add_control(
			'styler_name',
			[
				'label'     => esc_html__( 'Name Field Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-comments-area .comment-form-author' ),
			]
		);
		$this->add_control(
			'styler_name_label',
			[
				'label'     => esc_html__( 'Name Field Label', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-comments-area .comment-form-author .label-wrap' ),
			]
		);
		$this->add_control(
			'styler_name_input',
			[
				'label'     => esc_html__( 'Name Field', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-comments-area .comment-form-author input[type="text"]' ),
			]
		);
		$this->add_control(
			'styler_email',
			[
				'label'     => esc_html__( 'Email Field Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-comments-area .comment-form-email' ),
			]
		);
		$this->add_control(
			'styler_email_label',
			[
				'label'     => esc_html__( 'Email Field Label', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-comments-area .comment-form-email .label-wrap' ),
			]
		);
		$this->add_control(
			'styler_email_input',
			[
				'label'     => esc_html__( 'Email Field', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-comments-area .comment-form-email input[type="text"]' ),
			]
		);
		$this->add_control(
			'styler_website',
			[
				'label'     => esc_html__( 'Website Field Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-comments-area .comment-form-url' ),
			]
		);
		$this->add_control(
			'styler_website_label',
			[
				'label'     => esc_html__( 'Website Field Label', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-comments-area .comment-form-url .label-wrap' ),
			]
		);
		$this->add_control(
			'styler_website_input',
			[
				'label'     => esc_html__( 'Website Field', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-comments-area .comment-form-url input[type="text"]' ),
			]
		);
		$this->add_control(
			'styler_consent_wrapper',
			[
				'label'     => esc_html__( 'Consent Checkbox Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-comments-area .comment-form-cookies-consent' ),
			]
		);
		$this->add_control(
			'styler_consent_check_box',
			[
				'label'     => esc_html__( 'Consent Checkbox', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-comments-area .comment-form-cookies-consent #wp-comment-cookies-consent' ),
			]
		);
		$this->add_control(
			'styler_consent_check_box_label',
			[
				'label'     => esc_html__( 'Consent Checkbox label', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-comments-area .comment-form-cookies-consent [for="wp-comment-cookies-consent"]' ),
			]
		);
		$this->add_control(
			'styler_submit_btn_wrapper',
			[
				'label'     => esc_html__( 'Submit Button Wrapper', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-comments-area .form-submit' ),
			]
		);
		$this->add_control(
			'styler_submit_btn',
			[
				'label'     => esc_html__( 'Submit Button', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors( '.kata-comments-area .form-submit .submit' ),
			]
		);
		$this->add_control(
			'styler_logged',
			[
				'label'     => esc_html__( 'Post Comments logged in as', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-comments-area .logged-in-as' ),
			]
		);
		$this->add_control(
			'styler_logged_link',
			[
				'label'     => esc_html__( 'Post Comments logged link', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-comments-area .logged-in-as a' ),
			]
		);
		$this->add_control(
			'styler_logged_comment',
			[
				'label'     => esc_html__( 'Post Comments Comment Title', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-comments-area .comment-form-comment label' ),
			]
		);
		$this->add_control(
			'styler_logged_submit',
			[
				'label'     => esc_html__( 'Post Comments Submit', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-comments-area input#submit' ),
			]
		);
		$this->add_control(
			'styler_posted_comments_number',
			[
				'label'     => esc_html__( 'Number Of Comments Posted', 'kata-plus' ),
				'type'      => 'kata_styler',
				'selectors' => Kata_Styler::selectors(  '.kata-comments-area h2.kata-comments-title' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'comments',
			[
				'label' => esc_html__( 'Comments', 'kata-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'comments_wrapper',
			[
				'label'            => esc_html__( 'Wrapper', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-comment-list' ),
			]
		);
		$this->add_control(
			'comments_item',
			[
				'label'            => esc_html__( 'Comment', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-comment-list .comment' ),
			]
		);
		$this->add_control(
			'comments_avatar',
			[
				'label'            => esc_html__( 'Avatar', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-comments-area .comment-author.vcard img' ),
			]
		);
		$this->add_control(
			'comments_user',
			[
				'label'            => esc_html__( 'User', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-comment-list .comment-author .fn a' ),
			]
		);
		$this->add_control(
			'comments_content',
			[
				'label'            => esc_html__( 'Content', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.kata-comments-area .comment-content' ),
			]
		);
		$this->add_control(
			'comments_reply',
			[
				'label'            => esc_html__( 'Reply Button', 'kata-plus' ),
				'type'             => 'kata_styler',
				'selectors'        => Kata_Styler::selectors( '.comment-reply-link' ),
			]
		);

		$this->end_controls_section();
		
		// Common controls
		apply_filters( 'kata_plus_common_controls', $this );
	}

	protected function render() {
		require dirname( __FILE__ ) . '/view.php';
	}
}
