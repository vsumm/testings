<?php

/**
 * Elementor Class.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

use Elementor\Plugin;

if ( ! class_exists( 'Kata_Plus_Pro_Templates_Types_Manager' ) ) {
	class Kata_Plus_Pro_Templates_Types_Manager {
		
		/**
		 * The directory of the file.
		 *
		 * @access  private
		 * @var     string
		 */
		private $docs_types = [];

		/**
		 * Instance of this class.
		 *
		 * @since   1.0.0
		 * @access  public
		 * @var     Kata_Plus_Pro_Templates_Types_Manager
		 */
		public static $instance;

		/**
		 * Provides access to a single instance of a module using the singleton pattern.
		 *
		 * @since   1.0.0
		 * @return  object
		 */
		public static function get_instance() {
			if ( self::$instance === null ) {
				self::$instance = new self();
			}
			return self::$instance;
		}
	
		public function __construct() {
			// if( ! defined( 'ELEMENTOR_PRO_VERSION' ) ){
			// 	add_action( 'elementor/documents/register', [ $this, 'register_documents' ] );
			// }
			add_action( 'elementor/dynamic_tags/register_tags', [ $this, 'register_tag' ] );
		}
	
		public function register_documents() {
			$this->docs_types = [
				'header' => Documents\Header::get_class_full_name(),
				'footer' => Documents\Footer::get_class_full_name()
			];
	
			foreach ( $this->docs_types as $type => $class_name ) {
				Plugin::instance()->documents->register_document_type( $type, $class_name );
			}
		}
	
		public function register_tag( $dynamic_tags ) {
	
			$tags = array(
				'kata-plus-pro-archive-description' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/archive-description.php',
					'class' => 'Kata_Plus_Pro_Archive_Description',
					'group' => 'archive',
					'title' => 'Archive',
				),
				'kata-plus-pro-archive-meta' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/archive-meta.php',
					'class' => 'Kata_Plus_Pro_Archive_Meta',
					'group' => 'archive',
					'title' => 'Archive',
				),
				'kata-plus-pro-archive-title' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/archive-title.php',
					'class' => 'Kata_Plus_Pro_Archive_Title',
					'group' => 'archive',
					'title' => 'Archive',
				),
				'kata-plus-pro-author-info' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/author-info.php',
					'class' => 'Kata_Plus_Pro_Author_Info',
					'group' => 'author',
					'title' => 'Author',
				),
				'kata-plus-pro-author-meta' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/author-meta.php',
					'class' => 'Kata_Plus_Pro_Author_Meta',
					'group' => 'author',
					'title' => 'Author',
				),
				'kata-plus-pro-author-name' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/author-name.php',
					'class' => 'Kata_Plus_Pro_Author_Name',
					'group' => 'author',
					'title' => 'Author',
				),
				'kata-plus-pro-author-profile-picture' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/author-profile-picture.php',
					'class' => 'Kata_Plus_Pro_Author_Profile_Picture',
					'group' => 'author',
					'title' => 'Author',
				),
				'kata-plus-pro-comments-number' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/comments-number.php',
					'class' => 'Kata_Plus_Pro_Comments_Number',
					'group' => 'comments',
					'title' => 'Comments',
				),
				'kata-plus-pro-comments-url' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/comments-url.php',
					'class' => 'Kata_Plus_Pro_Comments_URL',
					'group' => 'comments',
					'title' => 'Comments',
				),
				'kata-plus-pro-contact-url' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/contact-url.php',
					'class' => 'Kata_Plus_Pro_Contact_URL',
					'group' => 'action',
					'title' => 'Action',
				),
				'kata-plus-pro-current-date-time' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/current-date-time.php',
					'class' => 'Kata_Plus_Pro_Current_Date_Time',
					'group' => 'site',
					'title' => 'Site',
				),
				'kata-plus-pro-featured-image-data' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/featured-image-data.php',
					'class' => 'Kata_Plus_Pro_Featured_Image_Data',
					'group' => 'media',
					'title' => 'Media',
				),
				'kata-plus-pro-page-title' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/page-title.php',
					'class' => 'Kata_Plus_Pro_Page_Title',
					'group' => 'site',
					'title' => 'Site',
				),
				'kata-plus-pro-post-custom-field' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/post-custom-field.php',
					'class' => 'Kata_Plus_Pro_Post_Custom_Field',
					'group' => 'post',
					'title' => 'Post',
				),
				'kata-plus-pro-pages-url' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/pages-url.php',
					'class' => 'Kata_Plus_Pro_Kata_Plus_pro_Pages_Url',
					'group' => 'URL',
					'title' => 'URL',
				),
				'kata-plus-pro-cats-url' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/taxonomies-url.php',
					'class' => 'Kata_Plus_Pro_Kata_Plus_pro_Taxonomies_Url',
					'group' => 'URL',
					'title' => 'URL',
				),
				'kata-plus-pro-archive-url' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/archive-url.php',
					'class' => 'Kata_Plus_Pro_Archive_URL',
					'group' => 'URL',
					'title' => 'URL',
				),
				'kata-plus-pro-post-date' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/post-date.php',
					'class' => 'Kata_Plus_Pro_Post_Date',
					'group' => 'post',
					'title' => 'Post',
				),
				'kata-plus-pro-post-excerpt' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/post-excerpt.php',
					'class' => 'Kata_Plus_Pro_Post_Excerpt',
					'group' => 'post',
					'title' => 'Post',
				),
				'kata-plus-pro-post-featured-image' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/post-featured-image.php',
					'class' => 'Kata_Plus_Pro_Post_Featured_Image',
					'group' => 'post',
					'title' => 'Post',
				),
				'kata-plus-pro-post-gallery' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/post-gallery.php',
					'class' => 'Kata_Plus_Pro_Post_Gallery',
					'group' => 'post',
					'title' => 'Post',
				),
				'kata-plus-pro-post-id' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/post-id.php',
					'class' => 'Kata_Plus_Pro_Post_ID',
					'group' => 'post',
					'title' => 'Post',
				),
				'kata-plus-pro-post-terms' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/post-terms.php',
					'class' => 'Kata_Plus_Pro_Post_Terms',
					'group' => 'post',
					'title' => 'Post',
				),
				'kata-plus-pro-post-time' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/post-time.php',
					'class' => 'Kata_Plus_Pro_Post_Time',
					'group' => 'post',
					'title' => 'Post',
				),
				'kata-plus-pro-post-title' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/post-title.php',
					'class' => 'Kata_Plus_Pro_Post_Title',
					'group' => 'post',
					'title' => 'Post',
				),
				'kata-plus-pro-post-url' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/post-url.php',
					'class' => 'Kata_Plus_Pro_Post_URL',
					'group' => 'post',
					'title' => 'Post',
				),
				'kata-plus-pro-request-parameter' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/request-parameter.php',
					'class' => 'Kata_Plus_Pro_Request_Parameter',
					'group' => 'site',
					'title' => 'Site',
				),
				'kata-plus-pro-shortcode' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/shortcode.php',
					'class' => 'Kata_Plus_Pro_Shortcode',
					'group' => 'site',
					'title' => 'Site',
				),
				'kata-plus-pro-site-logo' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/site-logo.php',
					'class' => 'Kata_Plus_Pro_Site_Logo',
					'group' => 'site',
					'title' => 'Site',
				),
				'kata-plus-pro-site-tagline' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/site-tagline.php',
					'class' => 'Kata_Plus_Pro_Site_Tagline',
					'group' => 'site',
					'title' => 'Site',
				),
				'kata-plus-pro-site-title' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/site-title.php',
					'class' => 'Kata_Plus_Pro_Site_Title',
					'group' => 'site',
					'title' => 'Site',
				),
				'kata-plus-pro-site-url' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/site-url.php',
					'class' => 'Kata_Plus_Pro_Site_URL',
					'group' => 'site',
					'title' => 'Site',
				),
				'kata-plus-pro-user-info' => array(
					'file'  => Kata_Plus_Pro_Elementor::$dir . '/dynamic-tags/user-info.php',
					'class' => 'Kata_Plus_Pro_User_Info',
					'group' => 'site',
					'title' => 'Site',
				)
			);
	
			foreach ( $tags as $tags_type => $tags_info ) {
				if( ! empty( $tags_info['file'] ) && ! empty( $tags_info['class'] ) ){
					// In our Dynamic Tag we use a group named request-variables so we need
					// To register that group as well before the tag
					\Elementor\Plugin::instance()->dynamic_tags->register_group( $tags_info['group'] , [
						'title' => $tags_info['title']
					] );
	
					include_once( $tags_info['file'] );
					if( class_exists( $tags_info['class'] ) ){
						$class_name = $tags_info['class'];
					} elseif( class_exists( $tags_info['class'] ) ){
						$class_name = $tags_info['class'];
					}
					$dynamic_tags->register_tag( $class_name );
				}
			}
		}
	
	}
	Kata_Plus_Pro_Templates_Types_Manager::get_instance();
}

