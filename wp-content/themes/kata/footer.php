<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #site-content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @author  ClimaxThemes
 * @package Kata
 * @since   1.0.0
 */

?>

		</div> <!-- end .kata-section -->
	</div> <!-- end #kata-content -->

	<?php
	$footer_show = Kata_Helpers::get_meta_box( 'show_footer' );
	if ( '1' === $footer_show ) {
		$footer_show = true;
	} elseif ( '0' === $footer_show ) {
		$footer_show = false;
	} elseif ( false === $footer_show || empty( $footer_show ) ) {
		$footer_show = true;
	}
	if ( $footer_show ) {
		do_action( 'kata_footer' );
	}
	?>

</div> <!-- end #kata-site -->
<?php wp_footer(); ?>
</body>
</html>
