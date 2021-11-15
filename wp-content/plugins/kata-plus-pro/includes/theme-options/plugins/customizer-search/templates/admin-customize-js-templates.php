<?php
/**
 * Underscore js Template for adding customizer setting for customizer search.
 *
 * @since  1.0.0
 * @package  Customizer_Search
 */

?>

<script type="text/html" id="tmpl-search-button">

	<button type="button" class="customize-search-toggle dashicons dashicons-search" style="display:none;" aria-expanded="false"><span class="screen-reader-text">Search</span></button>

</script>

<script type="text/html" id="tmpl-search-form">
	<div id="accordion-section-customizer-search" class="open">
		<h4 class="customizer-search-section accordion-section-title">
			<span class="search-field-wrapper">
				<input type="text" placeholder="<?php _e( 'Search...', 'kata-plus-pro' ); ?>" name="customizer-search-input" autofocus="autofocus" id="customizer-search-input" class="customizer-search-input">
				<button type="button" class="button clear-search" tabindex="0"><i class="ti-close"></i></button>
			</span>

		</h4>
	</div>
</script>
