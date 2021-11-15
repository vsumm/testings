<?php
/**
 * Custom template tags.
 *
 * @author  ClimaxThemes
 * @package Kata
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kata_Template_Tags' ) ) {

	/**
	 * Class Kata Template Tag.
	 *
	 * @since   1.0.0
	 */
	class Kata_Template_Tags {

		/**
		 * Prints HTML with meta information for the categories.
		 *
		 * @param string $separator Optional, Category separator symbol.
		 * @param string $icon Optional, Icon name.
		 * @since   1.0.0
		 */
		public static function post_categories( $separator = ' ', $icon = '' ) {
			$output          = array();
			$post_categories = get_the_category( get_the_ID() );
			if ( $post_categories ) {
				foreach ( $post_categories as $post_category ) {
					$output[]       = '<a href="' . esc_url( get_category_link( $post_category ) ) . '">' . esc_html( $post_category->name ) . '</a>';
				}
				if ( $output ) {
					echo wp_kses_post( '<span class="kata-category-links">' . $icon . implode( $separator, $output ) . '</span>' );
				}
			}
		}

		/**
		 * Prints HTML with meta information for the tags.
		 *
		 * @since   1.0.0
		 */
		public static function post_tags( $separator = ' ', $icon = '' ) {
			if ( get_post_type() === 'post' ) {
				$tags_list = get_the_tag_list( $icon, $separator, '' );
				if ( $tags_list ) {
					echo wp_kses_post( '<span class="kata-tags-links">' . $tags_list . '</span>' );
				}
			}
		}

		/**
		 * Prints HTML with meta information for the current post-date/time.
		 *
		 * @param string $icon Optional, Icon name.
		 * @since   1.0.0
		 */
		public static function posts_bookmark( $icon = 'themify/bookmark' ) {
			if ( class_exists( 'Kata_Plus_Helpers' ) ) {
				$meta = get_user_meta( get_current_user_id(), '_kata_bookmark_posts', true );
				$meta = is_array( $meta ) && in_array( get_the_ID(), $meta ) ? true : false;
				$meta = $meta ? 'remove': 'add'; 
				echo '<span class="kata-bookmark" data-status="' . esc_attr( $meta ) . '">';
				echo wp_kses_post( $icon );
				echo '</span>';
			}
		}

		/**
		 * Prints HTML with meta information for the current post-date/time.
		 *
		 * @param string $icon Optional, Icon name.
		 * @since   1.0.0
		 */
		public static function post_date( $icon = '', $format1 = '', $format2 = '', $format3 = '', $class = '' ) {
			if ( $format1 || $format2 || $format3 ) {
				$date_format = $format1 ? '<span class="kt-date-format1">' . get_the_date( $format1 ) . '</span>' : '';
				$date_format .= $format2 ? '<span class="kt-date-format2">' . get_the_date( $format2 ) . '</span>' : '';
				$date_format .= $format3 ? '<span class="kt-date-format3">' . get_the_date( $format3 ) . '</span>' : '';
			} else {
				$date_format = '<span>' . esc_html( get_the_date() ) . '</span>';
			}
			$classes = 'kata-post-date';
			$classes .= $class;
			$date = '<span class="' . esc_attr( $classes ) . '">';
			$date .= '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">';
			$date .= $icon . $date_format;
			$date .= '</a></span>';
			echo wp_kses_post( $date );
		}

		/**
		 * Prints HTML with comments.
		 *
		 * @param string $icon Optional. Icon name.
		 * @since   1.0.0
		 */
		public static function post_comments_number( $icon = '' ) {
			if ( comments_open() || get_comments_number() ) {
				echo wp_kses_post( '<span class="kata-comments-number">' . $icon . '<span>' . get_comments_number() . '</span></span>' );
			}
		}

		/**
		 * Prints HTML with comments.
		 *
		 * @param string $icon Required, Icon name.
		 * @param string $id Optional, Post meta ID.
		 * @since   1.0.0
		 */
		public static function post_time_to_read( $icon = '', $id = '' ) {
			$id = $id ? $id : get_the_ID();
			if ( get_post_meta( $id, 'post_time_to_read', true ) ) {
				echo wp_kses_post( '<span class="kata-time-to-read">' . $icon . '<span>' . get_post_meta( $id, 'post_time_to_read', true ) . '</span></span>' );
			}
		}

		/**
		 * Prints HTML with comments.
		 *
		 * @param string $icon Required, Icon Name.
		 * @param string $id Optional, Post Meta ID.
		 * @since   1.0.0
		 */
		public static function post_share_count( $icon = '', $id = '' ) {
			$id = $id ? $id : get_the_ID();
			if ( get_post_meta( $id, 'post_share_count', true ) ) {
				echo wp_kses_post( '<span class="kata-post-share-count">' . $icon . '<span>' . get_post_meta( $id, 'post_share_count', true ) . '</span></span>' );
			} else {
				echo wp_kses_post( '<span class="kata-post-share-count">' . $icon . '<span>' . 0 . '</span></span>' );
			}
		}

		/**
		 * Prints HTML with comments.
		 *
		 * @param string $icon Optional, Icon Name.
		 * @since   1.0.0
		 */
		public static function post_view( $icon = '' ) {
			if ( get_post_meta( get_the_ID(), 'kata_post_view', true ) ) {
				echo wp_kses_post( '<span class="kata-post-view">' . $icon . '<span>' . get_post_meta( get_the_ID(), 'kata_post_view', true ) . '</span></span>' );
			}
		}

		/**
		 * Prints HTML with meta information for the current author.
		 *
		 * @param string $icon Optional. Icon name.
		 * @param string $symbol Optional. Symbol avatar.
		 * @param string $size Optional. Icon size.
		 * @since   1.0.0
		 */
		public static function post_author( $icon = '', $symbol = 'avatar', $size = '25' ) {
			if ( 'avatar' === $symbol && $size ) {
				$symbol = get_avatar( get_the_author_meta( 'user_email' ), $size, '', esc_html( get_the_author_meta('display_name') ) );
			} else {
				$symbol = $icon;
			}
			$author_name = get_the_author_meta( 'display_name' ) ? get_the_author_meta( 'display_name' ) : __( 'Author', 'kata' );
			echo wp_kses_post( '<span class="kata-post-author">' . $symbol . '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( $author_name ) . '</a></span>' );
		}

		/**
		 * Displays an optional post thumbnail.
		 *
		 * Wraps the post thumbnail in an anchor element on index views, or a div
		 * element when on single views.
		 *
		 * @since   1.0.0
		 */
		public static function post_thumbnail() {
			if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
				return;
			}
			if ( is_single() ) {
				the_post_thumbnail( get_the_ID() );
			} else {
				echo wp_kses_post( '<a href="' . esc_url( get_the_permalink() ) . '">' );
				echo get_the_post_thumbnail( get_the_ID() );
				echo wp_kses_post( '</a>' );
			}
		}

		/**
		 * Displays an optional post thumbnail.
		 *
		 * Wraps the post thumbnail in an anchor element on index views, or a div
		 * element when on single views.
		 *
		 * @since   1.0.0
		 */
		public static function get_the_post_thumbnail() {
			if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
				return;
			}

			return get_the_post_thumbnail( get_the_ID(), 'full' );
		}

		/**
		 * Author Box.
		 *
		 * @since   1.0.0
		 */
		public static function author_box() {
			$email           = get_the_author_meta( 'user_email' );
			$author_id       = get_the_author_meta( 'ID' );
			$author_nicename = get_the_author_meta( 'nickname' );
			$author_link     = get_author_posts_url( $author_id, $author_nicename );
			?>
			<div class="kata-author-box">
				<div class="kata-author-thumbnail kata-lazyload"><?php echo get_avatar( get_the_author_meta( 'user_email' ), 96 ) ?></div>
					<div class="kata-plus-author-content">
					<h3 class="kata-plus-author-name"><?php echo get_the_author_meta( 'display_name' ) ? get_the_author_meta( 'display_name' ) : __( 'author', 'kata' ); ?></h3>
					<?php if ( get_the_author_meta( 'user_description' ) ) : ?>
						<p class="kata-author-box-description"><?php echo get_the_author_meta( 'user_description' ); ?></p>
					<?php endif;?>
				</div>
			</div>
			<?php
		}

		

		/**
		 * Get Woocommerce.
		 *
		 * @param integer $part return specefic woocommerce part.
		 * @since   1.0.0
		 */
		public static function get_woocommerce_part( $part ) {
			if ( ! class_exists( 'WooCommerce') ) {
				return;
			}
			if ( ! isset( $product ) ) {
				global $product;
			}
			switch ( $part ) {
				case 'price':
					echo wp_kses(
						$product->get_price_html(),
						[
							'del' => [
								'class' => true,
							],
							'span' => [
								'class' => true,
							],
							'bdi' => [
								'class' => true,
							],
							'ins' => [
								'class' => true,
							]
						]
					);
				break;
			}
		}

		/**
		 * Excerpt.
		 *
		 * @param integer $limit return post excerpt limitation.
		 * @since   1.0.0
		 */
		public static function excerpt( $limit = 15 ) {
			$post_format = get_post_format( get_the_ID() ) ? get_post_format( get_the_ID() ) : 'standard';
			if ( has_excerpt() ) {
				if ( ! $limit ) {
					return get_the_excerpt();
				}
				$excerpt = explode( ' ', get_the_excerpt(), $limit );

				if ( count( $excerpt ) >= $limit ) {
					array_pop( $excerpt );
					$excerpt = implode( ' ', $excerpt ) . '...';
				} else {
					$excerpt = implode( ' ', $excerpt );
				}

				$excerpt = preg_replace( '`\[[^\]]*\]`', '', $excerpt );
				return $excerpt;
			}
			if ( 'video' === $post_format || 'status' === $post_format || 'quote' === $post_format || 'link' === $post_format || 'audio' === $post_format || 'image' === $post_format ) :
				if ( 'image' === $post_format && ! has_post_thumbnail() ) {
					return false;
				} 
				return apply_filters( 'the_content', get_the_content() );
			else :
				if ( ! $limit ) {
					return get_the_excerpt();
				}
				$excerpt = explode( ' ', get_the_excerpt(), $limit );

				if ( count( $excerpt ) >= $limit ) {
					array_pop( $excerpt );
					$excerpt = implode( ' ', $excerpt ) . '...';
				} else {
					$excerpt = implode( ' ', $excerpt );
				}

				$excerpt = preg_replace( '`\[[^\]]*\]`', '', $excerpt );
				return $excerpt;
			endif;
		}

		/**
		 * Social Share.
		 *
		 * @since   1.0.0
		 */
		public static function social_share( $type = '', $toggle_icon = '' ) {
			$allowed_html = array(
				'a'    => array(
					'href'   => array(),
					'target' => array(),
				),
				'svg'  => array(
					'width'   => array(),
					'height'  => array(),
					'version' => array(),
					'id'      => array(),
					'x'       => array(),
					'y'       => array(),
					'viewbox' => array(),
					'style'   => array(),
				),
				'path' => array(
					'id'    => array(),
					'style' => array(),
					'd'     => array(),
				),
				'g'    => array(),
			);
			echo '<div class="kt-post-socials-share-wrapper">';
				echo '<div class="kt-post-share-toggle-socials-wrapper">';
					echo wp_kses_post( '<a href="' . esc_url( 'https://www.facebook.com/sharer.php?u=' . esc_url( get_the_permalink( get_the_ID() ) ) ) . '" target="_blank"><svg width="13" height="16" version="1.1" x="0px" y="0px" viewBox="0 0 155.139 155.139" xml:space="preserve"> <g> <path d="M89.584,155.139V84.378h23.742l3.562-27.585H89.584V39.184 c0-7.984,2.208-13.425,13.67-13.425l14.595-0.006V1.08C115.325,0.752,106.661,0,96.577,0C75.52,0,61.104,12.853,61.104,36.452 v20.341H37.29v27.585h23.814v70.761H89.584z"/> </g> </svg></a>' );
					echo wp_kses_post( '<a href="' . esc_url( 'https://twitter.com/intent/tweet?url=' . esc_url( get_the_permalink( get_the_ID() ) ) ) . '" target="_blank"><svg width="13" height="16" version="1.1" x="0px" y="0px" viewBox="0 0 310 310" xml:space="preserve"> <g> <path d="M302.973,57.388c-4.87,2.16-9.877,3.983-14.993,5.463c6.057-6.85,10.675-14.91,13.494-23.73 c0.632-1.977-0.023-4.141-1.648-5.434c-1.623-1.294-3.878-1.449-5.665-0.39c-10.865,6.444-22.587,11.075-34.878,13.783 c-12.381-12.098-29.197-18.983-46.581-18.983c-36.695,0-66.549,29.853-66.549,66.547c0,2.89,0.183,5.764,0.545,8.598 C101.163,99.244,58.83,76.863,29.76,41.204c-1.036-1.271-2.632-1.956-4.266-1.825c-1.635,0.128-3.104,1.05-3.93,2.467 c-5.896,10.117-9.013,21.688-9.013,33.461c0,16.035,5.725,31.249,15.838,43.137c-3.075-1.065-6.059-2.396-8.907-3.977 c-1.529-0.851-3.395-0.838-4.914,0.033c-1.52,0.871-2.473,2.473-2.513,4.224c-0.007,0.295-0.007,0.59-0.007,0.889 c0,23.935,12.882,45.484,32.577,57.229c-1.692-0.169-3.383-0.414-5.063-0.735c-1.732-0.331-3.513,0.276-4.681,1.597 c-1.17,1.32-1.557,3.16-1.018,4.84c7.29,22.76,26.059,39.501,48.749,44.605c-18.819,11.787-40.34,17.961-62.932,17.961 c-4.714,0-9.455-0.277-14.095-0.826c-2.305-0.274-4.509,1.087-5.294,3.279c-0.785,2.193,0.047,4.638,2.008,5.895 c29.023,18.609,62.582,28.445,97.047,28.445c67.754,0,110.139-31.95,133.764-58.753c29.46-33.421,46.356-77.658,46.356-121.367 c0-1.826-0.028-3.67-0.084-5.508c11.623-8.757,21.63-19.355,29.773-31.536c1.237-1.85,1.103-4.295-0.33-5.998 C307.394,57.037,305.009,56.486,302.973,57.388z"/> </g> </svg></a>' );
					echo wp_kses_post( '<a href="' . esc_url( 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=' . esc_url( get_the_permalink( get_the_ID() ) ) ) . '" target="_blank"><svg width="12" height="18" version="1.1" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve"> <g> <path d="M348.832,428.544c-14.208,0-27.52-3.328-38.528-10.048c-8.8-5.12-16.544-13.824-19.616-22.112 c-3.072-8.448-2.752-25.728-2.752-55.296V223.84h128.096v-95.808H287.936V0h-82.528c-3.328,26.336-9.312,48.192-18.112,65.088 c-8.416,17.216-20.256,31.776-34.24,44.096c-14.464,12.192-36.864,21.504-57.088,28.128v72.544h68.704V389.28 c0,23.52,2.368,41.472,7.424,53.728c4.96,12.352,13.44,23.968,26.4,34.848c12.736,11.008,27.968,19.456,46.176,25.408 C262.4,509.12,276.352,512,299.808,512c20.576,0,39.808-1.952,57.408-6.272c17.632-4,36.8-10.08,58.816-20.352v-76.96 C390.304,425.216,374.784,428.544,348.832,428.544z"/> </g> </svg></a>' );
					echo wp_kses_post( '<a href="' . esc_url( 'http://pinterest.com/pin/create/button/?url=' . esc_url( get_the_permalink( get_the_ID() ) ) ) . '" target="_blank"><svg width="13" height="16" version="1.1" x="0px" y="0px" viewBox="0 0 579.148 579.148" xml:space="preserve"> <g> <path d="M434.924,38.847C390.561,12.954,342.107,0.01,289.574,0.01c-52.54,0-100.992,12.944-145.356,38.837 C99.854,64.741,64.725,99.87,38.837,144.228C12.944,188.597,0,237.049,0,289.584c0,58.568,15.955,111.732,47.883,159.486 c31.922,47.768,73.771,83.08,125.558,105.949c-1.01-26.896,0.625-49.137,4.902-66.732l37.326-157.607 c-6.285-12.314-9.425-27.645-9.425-45.999c0-21.365,5.404-39.217,16.212-53.538c10.802-14.333,24.003-21.5,39.59-21.5 c12.564,0,22.246,4.143,29.034,12.448c6.787,8.292,10.184,18.727,10.184,31.292c0,7.797-1.451,17.289-4.334,28.47 c-2.895,11.187-6.665,24.13-11.31,38.837c-4.651,14.701-7.98,26.451-9.994,35.252c-3.525,15.33-0.63,28.463,8.672,39.4 c9.295,10.936,21.616,16.4,36.952,16.4c26.898,0,48.955-14.951,66.176-44.865c17.217-29.914,25.826-66.236,25.826-108.973 c0-32.925-10.617-59.701-31.859-80.312c-21.242-20.606-50.846-30.918-88.795-30.918c-42.486,0-76.862,13.642-103.123,40.906 c-26.267,27.277-39.401,59.896-39.401,97.84c0,22.625,6.414,41.609,19.229,56.941c4.272,5.029,5.655,10.428,4.149,16.205 c-0.508,1.512-1.511,5.281-3.017,11.309c-1.505,6.029-2.515,9.934-3.017,11.689c-2.014,8.049-6.787,10.564-14.333,7.541 c-19.357-8.043-34.064-21.99-44.113-41.85c-10.055-19.854-15.08-42.852-15.08-68.996c0-16.842,2.699-33.685,8.103-50.527 c5.404-16.842,13.819-33.115,25.264-48.832c11.432-15.698,25.135-29.596,41.102-41.659c15.961-12.069,35.38-21.738,58.256-29.04 c22.871-7.283,47.51-10.93,73.904-10.93c35.693,0,67.744,7.919,96.146,23.751c28.402,15.839,50.086,36.329,65.043,61.463 c14.951,25.135,22.436,52.026,22.436,80.692c0,37.705-6.541,71.641-19.607,101.807c-13.072,30.166-31.549,53.855-55.43,71.072 c-23.887,17.215-51.035,25.826-81.445,25.826c-15.336,0-29.664-3.58-42.986-10.748c-13.33-7.166-22.503-15.648-27.528-25.453 c-11.31,44.486-18.097,71.018-20.361,79.555c-4.78,17.852-14.584,38.457-29.413,61.836c26.897,8.043,54.296,12.062,82.198,12.062 c52.534,0,100.987-12.943,145.35-38.83c44.363-25.895,79.492-61.023,105.387-105.393c25.887-44.365,38.838-92.811,38.838-145.352 c0-52.54-12.951-100.985-38.838-145.355C514.422,99.87,479.287,64.741,434.924,38.847z"/> </g> </svg></a>' );
				echo '</div>';
				if ( 'toggle' == $type ) {
					if ( $toggle_icon ) {
						echo '<div class="kt-post-share-toggle-wrapper">';
						echo Kata_Plus_Helpers::get_icon( '', $toggle_icon, '', '' );
						echo '</div>';
					}
				}
			echo '</div>';
		}
	} // class
}
