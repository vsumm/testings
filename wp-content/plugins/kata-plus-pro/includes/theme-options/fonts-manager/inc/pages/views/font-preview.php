<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Kata Fonts</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		p {
			margin-block-start: 0;
			margin-block-end: 0;
			margin-inline-start: 0px;
			margin-inline-end: 0px;
		}
	</style>
	<?php
	if ( $_REQUEST['source'] === 'google' ) :
		$response = wp_remote_get(
			'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBOOsgUB12UtiN0m4IBv0DsDMx1_SHp57s',
			array(
				'timeout' => 20,
			)
		);
		// $google_fonts = json_decode( file_get_contents( Kata_Plus_Pro::$dir . 'assets/src/json/google-webfonts.json' ) );
		$google_fonts = json_decode( $response['body'] );
		// $google_fonts = json_decode( file_get_contents( Kata_Plus_Pro::$dir . 'assets/src/json/google-webfonts.json' ) );
		$json_data = false;
		foreach ( $google_fonts->items as $item ) {
			if ( $item->family == $_REQUEST['font-family'] ) {
				$json_data = $item;
				break;
			}
		}
		if ( $json_data == false ) {
			echo esc_html__( 'The font was not found', 'kata-plus' );
			die();
		}
		$variants = implode( ',', $json_data->variants );
		$subsets  = implode( ',', $json_data->subsets );
		?>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=<?php echo urlencode( esc_html( $_REQUEST['font-family'] ) ); ?>:<?php echo $variants; ?>&amp;<?php echo $subsets; ?>">
		<style>
			body {
				padding: 0;
				margin: 0;
			}

			.font-entry-content * {
				font-family: <?php echo esc_html( $_REQUEST['font-family'] ); ?>, <?php echo $json_data->category; ?>;
				font-size: <?php echo isset( $_REQUEST['font-size'] ) ? $_REQUEST['font-size'] : get_option( 'kata.plus.fonts_manager.font.preview.size', 13 ); ?>px;
				margin: 0;
			}

			.kata-plus-fonts-manager-category-name {
				font-family: <?php echo esc_html( $_REQUEST['font-family'] ); ?>, <?php echo $json_data->category; ?>;
				display: block;
				margin-top: 5px;
				padding: 5px;
			}

			.table-cel {
				width: 50%;
				display: table-cel;
			}
		</style>
	<?php endif; ?>

	<?php if ( $_REQUEST['source'] === 'typekit' || $_REQUEST['source'] === 'custom-font' || $_REQUEST['source'] === 'upload-font' ) : ?>
		<?php if ( $_REQUEST['source'] !== 'upload-font' ) : ?>
			<link rel="stylesheet" href="<?php echo $_REQUEST['url']; ?>">
		<?php endif; ?>
		<style>
			@import url(https://fonts.googleapis.com/css?family=Nunito:400);

			body {
				padding: 0;
				margin: 0;
			}

			.table-cel {
				width: 50%;
				display: table-cel;
			}

			<?php
			if ( isset( $_REQUEST['full'] ) && $_REQUEST['full'] == true ) :
				?>
				.font-entry-content {
				display: table;
			}

			.font-entry-content>* {
				display: inline-block;
				text-align: right;
				width: 100px;
				text-transform: capitalize;
			}

			span.font-style,
			span.font-weight {
				color: #747b8a;
				font-family: "Nunito", sans-serif;
				font-size: 12px;
				letter-spacing: 0.3px;
			}

			span.copy-styles {
				cursor: pointer;
			}

			span.copy-styles svg path {
				fill: #747b8a;
			}

			span.copy-styles:hover svg path {
				fill: #403cf2;
			}

			.font-entry-content>p {
				width: calc(100% - 350px);
				text-align: left;
			}

			<?php endif; ?>
		</style>
	<?php endif; ?>
</head>

<body>
	<?php if ( $_REQUEST['source'] === 'google' ) : ?>
		<?php foreach ( $json_data->variants as $entry ) : ?>
			<?php
			$font_weight    = intval( $entry ) ? 'font-weight: ' . intval( $entry ) . ';' : '';
			$font_style     = preg_replace( '/\d+/u', '', $entry ) ? 'font-style: ' . preg_replace( '/\d+/u', '', $entry ) : '';
			$kata_options   = get_option( 'kata_options' );
			$content_style  = $kata_options['prefers_color_scheme'] == 'dark' ? 'display:block;padding:2px 5px;color: #d1d6db;' : 'display:block;padding:2px 5px;color: #171717;';
			$content_style2 = $kata_options['prefers_color_scheme'] == 'dark' ? 'display:block;padding:2px 5px;border-bottom:solid 1px #3b434a;color: #d1d6db;padding-bottom: 18px;' : 'display:block;padding:2px 5px;border-bottom:solid 1px #f2f2f2;color: #171717;';
			$color          = $kata_options['prefers_color_scheme'] == 'dark' ? 'color: #d1d6db;' : '';
			?>
			<?php if ( isset( $_REQUEST['single-line'] ) ) { ?>
				<div class="font-entry-content" style="<?php echo esc_attr( $content_style ); ?>">
				<?php } else { ?>
					<div class="font-entry-content" style="<?php echo esc_attr( $content_style2 ); ?>">
					<?php } ?>
					<p class="font-preview-text" style="<?php echo $font_weight; ?><?php echo $color; ?>font-size:<?php echo isset( $_REQUEST['font-size'] ) ? $_REQUEST['font-size'] : get_option( 'kata.plus.fonts_manager.font.preview.size', 13 ); ?>px">
						<?php echo get_option( 'kata.plus.fonts_manager.font.preview.text', 'Create your awesome website, fast and easy.' ); ?>
						<div class="table-cel">
							<?php
							if ( ! isset( $_REQUEST['single-line'] ) ) {
								if ( intval( $entry ) ) {
									echo intval( $entry );
									if ( preg_replace( '/\d+/u', '', $entry ) ) {
										echo ', ';
									}
								}
								if ( preg_replace( '/\d+/u', '', $entry ) ) {
									echo preg_replace( '/\d+/u', '', $entry );
								}
							}
							?>
						</div>
					</p>
					</div>
					<?php
					if ( isset( $_REQUEST['single-line'] ) ) {
						break;
					}
					?>
				<?php endforeach; ?>
				<?php if ( ! isset( $_REQUEST['single-line'] ) ) : ?>
					<div class="kata-plus-fonts-manager-category-name" style="<?php echo esc_attr( $content_style2 ); ?>padding-top: 11px;">
						<b>Category : </b>
						<span><?php echo $json_data->category; ?></span>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ( $_REQUEST['source'] === 'typekit' || $_REQUEST['source'] === 'custom-font' ) : ?>
				<?php
				$font_families = explode( ',', $_REQUEST['font-family'] );
				$font_style    = isset( $_REQUEST['font-style'] ) ? 'font-style:' . $_REQUEST['font-style'] : '';
				$font_weight   = isset( $_REQUEST['font-weight'] ) ? 'font-weight:' . $_REQUEST['font-weight'] : '';
				foreach ( $font_families as $font_family ) :
					?>
					<?php if ( isset( $_REQUEST['single-line'] ) ) { ?>
						<div class="font-entry-content" style="display:block;padding:2px 5px;color: #171717;">
						<?php } else { ?>
							<div class="font-entry-content" style="display:block;padding:2px 5px;border-bottom:solid 1px #f2f2f2;color: #171717;">
							<?php } ?>
							<p class="font-preview-text" style="font-family:'<?php echo $font_family; ?>';<?php echo $font_style; ?>;<?php echo $font_weight; ?>;font-size:<?php echo isset( $_REQUEST['font-size'] ) ? $_REQUEST['font-size'] : get_option( 'kata.plus.fonts_manager.font.preview.size', 13 ); ?>px">
								<?php echo get_option( 'kata.plus.fonts_manager.font.preview.text', 'Create your awesome website, fast and easy.' ); ?>
							</p>
							<?php if ( isset( $_REQUEST['full'] ) && $_REQUEST['full'] == true ) : ?>
								<span class="font-weight">
									<?php echo isset( $_REQUEST['font-weight'] ) ? $_REQUEST['font-weight'] : '-'; ?>
								</span>
								<span class="font-style">
									<?php echo isset( $_REQUEST['font-style'] ) ? $_REQUEST['font-style'] : '-'; ?>
								</span>
								<span class="copy-styles" data-copy="font-family:<?php echo $font_family; ?>;<?php echo "\n" . $font_style; ?>;<?php echo "\n" . $font_weight; ?>;">
									<?php echo Kata_Plus_Pro_Helpers::get_icon( 'themify', 'layers' ); ?>
								</span>
							<?php endif; ?>

							</div>
							<?php
							if ( isset( $_REQUEST['single-line'] ) ) {
								break;
							}
							?>
						<?php endforeach; ?>
					<?php endif; ?>

					<?php if ( $_REQUEST['source'] === 'upload-font' ) : ?>

						<?php
						isset( $_REQUEST['url-ttf'] ) ? $src[]   = 'url(' . $_REQUEST['url-ttf'] . ") format('truetype')" : false;
						isset( $_REQUEST['url-otf'] ) ? $src[]   = 'url(' . $_REQUEST['url-otf'] . ") format('opentype')" : false;
						isset( $_REQUEST['url-eot'] ) ? $src[]   = "url('" . $_REQUEST['url-eot'] . "');\n\tsrc: url('" . $_REQUEST['url-eot'] . "?#iefix') format('embedded-opentype')" : false;
						isset( $_REQUEST['url-woff'] ) ? $src[]  = 'url(' . $_REQUEST['url-woff'] . ") format('woff')" : false;
						isset( $_REQUEST['url-woff2'] ) ? $src[] = 'url(' . $_REQUEST['url-woff2'] . ") format('woff2')" : false;

						?>
						<style>
							/* latin */
							@font-face {
								font-family: '<?php echo $_REQUEST['font-family']; ?>';
								font-style: <?php echo $_REQUEST['font-style']; ?>;
								font-weight: <?php echo $_REQUEST['font-weight']; ?>;
								src: <?php echo implode( ', ', $src ); ?>;
							}
						</style>
						<?php
						$font_families = [ $_REQUEST['font-family'] ];
						$font_style    = isset( $_REQUEST['font-style'] ) ? 'font-style:' . $_REQUEST['font-style'] : '';
						$font_weight   = isset( $_REQUEST['font-weight'] ) ? 'font-weight:' . $_REQUEST['font-weight'] : '';


						foreach ( $font_families as $font_family ) :
							?>
							<?php if ( isset( $_REQUEST['single-line'] ) ) { ?>
								<div class="font-entry-content" style="display:block;padding:2px 5px;color: #171717;">
								<?php } else { ?>
									<div class="font-entry-content" style="display:block;padding:2px 5px;border-bottom:solid 1px #f2f2f2;color: #171717;">
									<?php } ?>
									<p class="font-preview-text" style="font-family:'<?php echo $font_family; ?>';<?php echo $font_weight; ?>;font-size:<?php echo isset( $_REQUEST['font-size'] ) ? $_REQUEST['font-size'] : get_option( 'kata.plus.fonts_manager.font.preview.size', 13 ); ?>px">
										<?php echo get_option( 'kata.plus.fonts_manager.font.preview.text', 'Create your awesome website, fast and easy.' ); ?>
									</p>
									<?php if ( isset( $_REQUEST['full'] ) && $_REQUEST['full'] == true ) : ?>
										<span class="font-weight">
											<?php echo isset( $_REQUEST['font-weight'] ) ? $_REQUEST['font-weight'] : '-'; ?>
										</span>
										<span class="font-style">
											<?php echo isset( $_REQUEST['font-style'] ) ? $_REQUEST['font-style'] : '-'; ?>
										</span>
										<span class="copy-styles" data-copy="font-family:<?php echo $font_family; ?>;<?php echo "\n" . $font_style; ?>;<?php echo "\n" . $font_weight; ?>;">
											<?php echo Kata_Plus_Pro_Helpers::get_icon( 'themify', 'layers' ); ?>
										</span>
									<?php endif; ?>

									</div>
									<?php
									if ( isset( $_REQUEST['single-line'] ) ) {
										break;
									}
									?>
								<?php endforeach; ?>
							<?php endif; ?>
</body>

</html>
