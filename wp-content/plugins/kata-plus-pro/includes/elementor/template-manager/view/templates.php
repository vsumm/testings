<?php

defined('ABSPATH') || die();

?>

<script type="text/template" id="tmpl-kata-plus-elementor-template-library-header-preview">
	<div id="elementor-template-library-header-preview-insert-wrapper" class="elementor-templates-modal__header__item">
		{{{ kata_plus_elementor.editor.templates.layout.getTemplateActionButton( obj ) }}}
	</div>
</script>

<script type="text/template" id="tmpl-kata-plus-elementor-template-library-template-remote">
	<div class="elementor-template-library-template-body">
		<# if ( 'page' === type ) { #>
			<div class="elementor-template-library-template-screenshot" style="background-image: url({{ thumbnail }});"></div>
		<# } else { #>
			<img src="{{ thumbnail }}">
		<# } #>
		<div class="elementor-template-library-template-preview">
			<i class="eicon-zoom-in" aria-hidden="true"></i>
		</div>
	</div>
	<div class="elementor-template-library-template-footer">
		{{{ kata_plus_elementor.editor.templates.layout.getTemplateActionButton( obj ) }}}
		<div class="elementor-template-library-template-name">{{{ title }}}</div>
		<!-- {{{ type }}}
		<div class="elementor-template-library-favorite">
			<input id="elementor-template-library-template-{{ template_id }}-favorite-input" class="elementor-template-library-template-favorite-input" type="checkbox"{{ favorite ? " checked" : "" }}>
			<label for="elementor-template-library-template-{{ template_id }}-favorite-input" class="elementor-template-library-template-favorite-label">
				<i class="eicon-heart-o" aria-hidden="true"></i>
				<span class="elementor-screen-only"><?php echo __('Favorite', 'kata-plus'); ?></span>
			</label>
		</div>  -->
	</div>
</script>

<script type="text/template" id="tmpl-kata-plus-elementor-template-library-templates">
	<#
		var activeSource = kata_plus_elementor.editor.templates.getFilter('source');
	#>
	<div id="elementor-template-library-toolbar">
		<# if ( activeSource ) {
			var activeType = kata_plus_elementor.editor.templates.getFilter('type');
			var config = kata_plus_elementor.editor.templates.getConfig( activeType );
			var categories = config['categories'] || false
			#>
			<div id="elementor-template-library-filter-toolbar-remote" class="elementor-template-library-filter-toolbar">
				<# if ( categories ) { #>
					<div id="elementor-template-library-filter">
						<select id="elementor-template-library-filter-subtype" class="elementor-template-library-filter-select" data-elementor-filter="subtype">
							<option></option>
							<# categories.forEach( function( category ) {
								var selected = category === kata_plus_elementor.editor.templates.getFilter( 'subtype' ) ? ' selected' : '';
								#>
								<option value="{{ category }}"{{{ selected }}}>{{{ category }}}</option>
							<# } ); #>
						</select>
					</div>
				<# } #>
				<!-- <div id="elementor-template-library-my-favorites">
					<# var checked = kata_plus_elementor.editor.templates.getFilter( 'favorite' ) ? ' checked' : ''; #>
					<input id="elementor-template-library-filter-my-favorites" type="checkbox"{{{ checked }}}>
					<label id="elementor-template-library-filter-my-favorites-label" for="elementor-template-library-filter-my-favorites">
						<i class="eicon" aria-hidden="true"></i>
						<?php echo __( 'My Favorites', 'elementor' ); ?>
					</label>
				</div>  -->
			</div>
		<# } #>
		<div id="elementor-template-library-filter-text-wrapper">
			<label for="elementor-template-library-filter-text" class="elementor-screen-only"><?php echo __('Search Templates:', 'kata-plus'); ?></label>
			<input id="elementor-template-library-filter-text" placeholder="<?php echo esc_attr__('Search', 'kata-plus'); ?>">
			<i class="eicon-search"></i>
		</div>
	</div>
	<div id="elementor-template-library-templates-container"></div>
</script>