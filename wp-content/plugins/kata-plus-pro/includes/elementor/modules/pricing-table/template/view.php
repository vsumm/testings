<?php
/**
 * Pricing Table module view.
 *
 * @author  ClimaxThemes
 * @package Kata Plus Pro
 * @since   1.0.0
 */

// Don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Group_Control_Image_Size;

$settings = $this->get_settings_for_display();
// $this->add_inline_editing_attributes( 'pricing_table_title' );
$space         			= ' ';
$mod_first     			= $settings['mod_first'];
$mod_second    			= $settings['mod_second'];
$column					= Kata_Plus_Pro_Elementor::is_edit_mode() ? 'col-md-3' : 'col-xl-3';
$featured_table_one		= $settings['featured_table'] == 'tableone' ? ' featured-table' : '';
$featured_table_two		= $settings['featured_table'] == 'tabletwo' ? ' featured-table' : '';
$featured_table_three	= $settings['featured_table'] == 'tableThree' ? ' featured-table' : '';
$default_background_one = $featured_table_one != '' ? ' dbg-color' : '';
$default_background_two = $featured_table_two != '' ? ' dbg-color' : '';
$default_background_three = $featured_table_three != '' ? ' dbg-color' : '';
$pricing_tables	= [
	'tools'      => $settings['tools'],
	'table_one'   => [
		'icon'                 => $settings['table_one_icon'],
		'title'                => $settings['table_one_title'],
		'price'                => $settings['table_one_price'],
		'period'               => $settings['table_one_period'],
		'price2'               => $settings['table_one_price2'],
		'period2'              => $settings['table_one_period2'],
		'items'                => $settings['table_one_items'],
		'button'               => $settings['table_one_button'],
		'text_button'          => $settings['table_one_text_button'],
		'link_button'          => $settings['table_one_link_button'],
		'icon_button'          => $settings['table_one_icon_button'],
		'icon_position_button' => $settings['table_one_icon_position_button'],
	],
	'table_two'   => [
		'icon'                 => $settings['table_two_icon'],
		'title'                => $settings['table_two_title'],
		'price'                => $settings['table_two_price'],
		'period'               => $settings['table_two_period'],
		'price2'               => $settings['table_two_price2'],
		'period2'              => $settings['table_two_period2'],
		'items'                => $settings['table_two_items'],
		'button'               => $settings['table_two_button'],
		'text_button'          => $settings['table_two_text_button'],
		'link_button'          => $settings['table_two_link_button'],
		'icon_button'          => $settings['table_two_icon_button'],
		'icon_position_button' => $settings['table_two_icon_position_button'],
	],
	'table_three' => [
		'icon'                 => $settings['table_three_icon'],
		'title'                => $settings['table_three_title'],
		'price'                => $settings['table_three_price'],
		'period'               => $settings['table_three_period'],
		'price2'               => $settings['table_three_price2'],
		'period2'              => $settings['table_three_period2'],
		'items'                => $settings['table_three_items'],
		'button'               => $settings['table_three_button'],
		'text_button'          => $settings['table_three_text_button'],
		'link_button'          => $settings['table_three_link_button'],
		'icon_button'          => $settings['table_three_icon_button'],
		'icon_position_button' => $settings['table_three_icon_position_button'],
	],
];

if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::start_parallax( $settings['parallax'], $settings['parallax_speed'], $settings['parallax_mouse_speed'] );
} ?>
<div class="kata-plus-pricing-table">
	<div class="row">
		<div class="<?php echo esc_attr( $column ); ?>">
			<table class="pricing-tools-table">
				<thead>
					<tr class="pricing-table-header-wrapper">
						<th class="pricing-table-toolbar-header">
							<?php if ( ! empty( $mod_first ) ) { ?>
								<span class="price-mode-first"><?php echo wp_kses( $mod_first, wp_kses_allowed_html( 'post' ) ); ?></span>
							<?php } ?>
							<input type="checkbox" id="pricing-mode">
							<label class="mode-switcher" for="pricing-mode"></label>
							<?php if ( ! empty( $mod_second ) ) { ?>
								<span class="price-mode-second"><?php echo wp_kses( $mod_second, wp_kses_allowed_html( 'post' ) ); ?></span>
							<?php } ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $settings['tools'] as $tool ) : ?>
						<tr>
							<td>
								<div class="pricing-tool-item">
									<?php if ( $tool['tools_link_allow'] == 'yes' ) {
										$url = Kata_Plus_Pro_Helpers::get_link_attr( $tool['tools_link'] );
										echo '<a ' . $url->src . $url->rel . $url->target . ' >'; ?>
									<?php } ?>
									<?php if ( ! empty( $tool['tools_icon'] ) ) { ?>
										<span class="tool-icon"><?php echo Kata_Plus_Pro_Helpers::get_icon( '', $tool['tools_icon'], '', '' ); ?></span>
									<?php } ?>
									<?php if ( ! empty( $tool['tools_text'] ) ) { ?>
										<span class="tool-text"><?php echo wp_kses( $tool['tools_text'], wp_kses_allowed_html( 'post' ) ); ?></span>
									<?php } ?>
									<?php if ( $tool['tools_link_allow'] == 'yes' ) { ?>
										<?php echo '</a>'; ?>
									<?php } ?>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<div class="<?php echo esc_attr( $column ); ?>">
			<table class="pricing-table-table<?php echo esc_attr( $featured_table_one ); ?>">
				<thead>
					<tr class="pricing-table-header-wrapper">
						<th class="pricing-table-header<?php echo esc_attr( $default_background_one ); ?>">
							<?php if ( ! empty( $pricing_tables['table_one']['icon'] ) ) { ?>
								<div class="pricing-table-icon"><?php echo Kata_Plus_Pro_Helpers::get_icon( '', $pricing_tables['table_one']['icon'], '', '' ); ?></div>
							<?php } ?>
							<?php if ( ! empty( $pricing_tables['table_one']['title'] ) ) { ?>
								<div class="pricing-table-title"><?php echo wp_kses( $pricing_tables['table_one']['title'], wp_kses_allowed_html( 'post' ) ); ?></div>
							<?php } ?>
							<?php if ( ! empty( $pricing_tables['table_one']['price'] ) ) { ?>
								<div class="pricing-table-price">
									<span class="currency"><?php echo wp_kses( $settings['currency'], wp_kses_allowed_html( 'post' ) ); ?></span><span class="price"><?php echo wp_kses( $pricing_tables['table_one']['price'], wp_kses_allowed_html( 'post' ) ); ?></span><span class="period"><?php echo wp_kses( $pricing_tables['table_one']['period'], wp_kses_allowed_html( 'post' ) ); ?></span>
								</div>
							<?php } ?>
							<?php if ( ! empty( $pricing_tables['table_one']['price2'] ) ) { ?>
								<div class="pricing-table-price" style="display: none;">
									<span class="currency"><?php echo wp_kses( $settings['currency'], wp_kses_allowed_html( 'post' ) ); ?></span><span class="price"><?php echo wp_kses( $pricing_tables['table_one']['price2'], wp_kses_allowed_html( 'post' ) ); ?></span><span class="period"><?php echo wp_kses( $pricing_tables['table_one']['period2'], wp_kses_allowed_html( 'post' ) ); ?></span>
								</div>
							<?php } ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ( $settings['table_one_items'] as $item ) :?>
						<tr>
							<td>
								<?php if ( $item['table_one_link_allow'] == 'yes' ) {
									$url = Kata_Plus_Pro_Helpers::get_link_attr( $item['table_one_link'] );
									echo '<a ' . $url->src . $url->rel . $url->target . ' >'; ?>
								<?php } ?>
								<div class="pricing-table-item">
									<?php if ( ! empty( $item['table_one_icon'] ) ) { ?>
										<span class="tool-icon"><?php echo Kata_Plus_Pro_Helpers::get_icon( '', $item['table_one_icon'], '', '' ); ?></span>
									<?php } ?>
									<?php if ( ! empty( $item['table_one_text'] ) ) { ?>
										<span class="tool-text"><?php echo wp_kses( $item['table_one_text'], wp_kses_allowed_html( 'post' ) ); ?></span>
									<?php } ?>
								</div>
								<?php if ( $item['table_one_link_allow'] == 'yes' ) { ?>
									<?php echo '</a>'; ?>
								<?php } ?>
							</td>
						</tr>
					<?php endforeach; ?>
					<!-- Footer -->
					<?php if ($pricing_tables['table_one']['button'] == 'yes' ) { ?>
						<tr>
							<td>
								<div class="pricing-table-footer">
									<?php $table_one_url = Kata_Plus_Pro_Helpers::get_link_attr( $pricing_tables['table_one']['link_button'] ); ?>
									<?php $table_one_icon_button = Kata_Plus_Pro_Helpers::get_icon( '', $pricing_tables['table_one']['icon_button'], '', '' ); ?>
									<a <?php echo $table_one_url->src . $table_one_url->rel . $table_one_url->target ?> class="kata-button">
										<?php if ( ! empty( $table_one_icon_button ) && $pricing_tables['table_one']['icon_position_button'] == 'before' ) { ?>
											<?php echo wp_kses( $table_one_icon_button, wp_kses_allowed_html( 'post' ) ); ?>
										<?php } ?>
										<?php echo wp_kses($pricing_tables['table_one']['text_button'], wp_kses_allowed_html( 'post' ) ); ?>
										<?php if ( ! empty( $table_one_icon_button ) && $pricing_tables['table_one']['icon_position_button'] == 'after' ) { ?>
											<?php echo wp_kses( $table_one_icon_button, wp_kses_allowed_html( 'post' ) ); ?>
										<?php } ?>
									</a>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="<?php echo esc_attr( $column ); ?>">
			<table class="pricing-table-table<?php echo esc_attr( $featured_table_two ); ?>">
				<thead>
					<tr class="pricing-table-header-wrapper">
						<th class="pricing-table-header<?php echo esc_attr( $default_background_two ); ?>">
							<?php if ( ! empty( $pricing_tables['table_two']['icon'] ) ) { ?>
								<div class="pricing-table-icon"><?php echo Kata_Plus_Pro_Helpers::get_icon( '', $pricing_tables['table_two']['icon'], '', '' ); ?></div>
							<?php } ?>
							<?php if ( ! empty( $pricing_tables['table_two']['title'] ) ) { ?>
								<div class="pricing-table-title"><?php echo wp_kses( $pricing_tables['table_two']['title'], wp_kses_allowed_html( 'post' ) ); ?></div>
							<?php } ?>
							<?php if ( ! empty( $pricing_tables['table_two']['price'] ) ) { ?>
								<div class="pricing-table-price">
									<span class="currency"><?php echo wp_kses( $settings['currency'], wp_kses_allowed_html( 'post' ) ); ?></span><span class="price"><?php echo wp_kses( $pricing_tables['table_two']['price'], wp_kses_allowed_html( 'post' ) ); ?></span><span class="period"><?php echo wp_kses( $pricing_tables['table_two']['period'], wp_kses_allowed_html( 'post' ) ); ?></span>
								</div>
							<?php } ?>
							<?php if ( ! empty( $pricing_tables['table_two']['price2'] ) ) { ?>
								<div class="pricing-table-price" style="display: none;">
									<span class="currency"><?php echo wp_kses( $settings['currency'], wp_kses_allowed_html( 'post' ) ); ?></span><span class="price"><?php echo wp_kses( $pricing_tables['table_two']['price2'], wp_kses_allowed_html( 'post' ) ); ?></span><span class="period"><?php echo wp_kses( $pricing_tables['table_two']['period2'], wp_kses_allowed_html( 'post' ) ); ?></span>
								</div>
							<?php } ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ( $settings['table_two_items'] as $item ) :?>
						<tr>
							<td>
								<?php if ( $item['table_two_link_allow'] == 'yes' ) {
									$url = Kata_Plus_Pro_Helpers::get_link_attr( $item['table_two_link'] );
									echo '<a ' . $url->src . $url->rel . $url->target . ' >'; ?>
								<?php } ?>
								<div class="pricing-table-item">
									<?php if ( ! empty( $item['table_two_icon'] ) ) { ?>
										<span class="tool-icon"><?php echo Kata_Plus_Pro_Helpers::get_icon( '', $item['table_two_icon'], '', '' ); ?></span>
									<?php } ?>
									<?php if ( ! empty( $item['table_two_text'] ) ) { ?>
										<span class="tool-text"><?php echo wp_kses( $item['table_two_text'], wp_kses_allowed_html( 'post' ) ); ?></span>
									<?php } ?>
								</div>
								<?php if ( $item['table_two_link_allow'] == 'yes' ) { ?>
									<?php echo '</a>'; ?>
								<?php } ?>
							</td>
						</tr>
					<?php endforeach; ?>
					<!-- Footer -->
					<?php if ($pricing_tables['table_two']['button'] == 'yes' ) { ?>
						<tr>
							<td>
								<div class="pricing-table-footer">
									<?php $table_two_url = Kata_Plus_Pro_Helpers::get_link_attr( $pricing_tables['table_two']['link_button'] ); ?>
									<?php $table_two_icon_button = Kata_Plus_Pro_Helpers::get_icon( '', $pricing_tables['table_two']['icon_button'], '', '' ); ?>
									<a <?php echo $table_two_url->src . $table_two_url->rel . $table_two_url->target ?> class="kata-button">
										<?php if ( ! empty( $table_two_icon_button ) && $pricing_tables['table_two']['icon_position_button'] == 'before' ) { ?>
											<?php echo wp_kses( $table_two_icon_button, wp_kses_allowed_html( 'post' ) ); ?>
										<?php } ?>
										<?php echo wp_kses($pricing_tables['table_two']['text_button'], wp_kses_allowed_html( 'post' ) ); ?>
										<?php if ( ! empty( $table_two_icon_button ) && $pricing_tables['table_two']['icon_position_button'] == 'after' ) { ?>
											<?php echo wp_kses( $table_two_icon_button, wp_kses_allowed_html( 'post' ) ); ?>
										<?php } ?>
									</a>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="<?php echo esc_attr( $column ); ?>">
			<table class="pricing-table-table<?php echo esc_attr( $featured_table_three ); ?>">
				<thead>
					<tr class="pricing-table-header-wrapper">
						<th class="pricing-table-header<?php echo esc_attr( $default_background_three ); ?>">
							<?php if ( ! empty( $pricing_tables['table_three']['icon'] ) ) { ?>
								<div class="pricing-table-icon"><?php echo Kata_Plus_Pro_Helpers::get_icon( '', $pricing_tables['table_three']['icon'], '', '' ); ?></div>
							<?php } ?>
							<?php if ( ! empty( $pricing_tables['table_three']['title'] ) ) { ?>
								<div class="pricing-table-title"><?php echo wp_kses( $pricing_tables['table_three']['title'], wp_kses_allowed_html( 'post' ) ); ?></div>
							<?php } ?>
							<?php if ( ! empty( $pricing_tables['table_three']['price'] ) ) { ?>
								<div class="pricing-table-price">
									<span class="currency"><?php echo wp_kses( $settings['currency'], wp_kses_allowed_html( 'post' ) ); ?></span><span class="price"><?php echo wp_kses( $pricing_tables['table_three']['price'], wp_kses_allowed_html( 'post' ) ); ?></span><span class="period"><?php echo wp_kses( $pricing_tables['table_three']['period'], wp_kses_allowed_html( 'post' ) ); ?></span>
								</div>
							<?php } ?>
							<?php if ( ! empty( $pricing_tables['table_three']['price2'] ) ) { ?>
								<div class="pricing-table-price" style="display: none;">
									<span class="currency"><?php echo wp_kses( $settings['currency'], wp_kses_allowed_html( 'post' ) ); ?></span><span class="price"><?php echo wp_kses( $pricing_tables['table_three']['price2'], wp_kses_allowed_html( 'post' ) ); ?></span><span class="period"><?php echo wp_kses( $pricing_tables['table_three']['period2'], wp_kses_allowed_html( 'post' ) ); ?></span>
								</div>
							<?php } ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ( $settings['table_three_items'] as $item ) :?>
						<tr>
							<td>
								<?php if ( $item['table_three_link_allow'] == 'yes' ) {
									$url = Kata_Plus_Pro_Helpers::get_link_attr( $item['table_three_link'] );
									echo '<a ' . $url->src . $url->rel . $url->target . ' >'; ?>
								<?php } ?>
								<div class="pricing-table-item">
									<?php if ( ! empty( $item['table_three_icon'] ) ) { ?>
										<span class="tool-icon"><?php echo Kata_Plus_Pro_Helpers::get_icon( '', $item['table_three_icon'], '', '' ); ?></span>
									<?php } ?>
									<?php if ( ! empty( $item['table_three_text'] ) ) { ?>
										<span class="tool-text"><?php echo wp_kses( $item['table_three_text'], wp_kses_allowed_html( 'post' ) ); ?></span>
									<?php } ?>
								</div>
								<?php if ( $item['table_three_link_allow'] == 'yes' ) { ?>
									<?php echo '</a>'; ?>
								<?php } ?>
							</td>
						</tr>
					<?php endforeach; ?>
					<!-- Footer -->
					<?php if ($pricing_tables['table_three']['button'] == 'yes' ) { ?>
						<tr>
							<td>
								<div class="pricing-table-footer">
									<?php $table_three_url = Kata_Plus_Pro_Helpers::get_link_attr( $pricing_tables['table_three']['link_button'] ); ?>
									<?php $table_three_icon_button = Kata_Plus_Pro_Helpers::get_icon( '', $pricing_tables['table_three']['icon_button'], '', '' ); ?>
									<a <?php echo $table_three_url->src . $table_three_url->rel . $table_three_url->target ?> class="kata-button">
										<?php if ( ! empty( $table_three_icon_button ) && $pricing_tables['table_three']['icon_position_button'] == 'before' ) { ?>
											<?php echo wp_kses( $table_three_icon_button, wp_kses_allowed_html( 'post' ) ); ?>
										<?php } ?>
										<?php echo wp_kses($pricing_tables['table_three']['text_button'], wp_kses_allowed_html( 'post' ) ); ?>
										<?php if ( ! empty( $table_three_icon_button ) && $pricing_tables['table_three']['icon_position_button'] == 'after' ) { ?>
											<?php echo wp_kses( $table_three_icon_button, wp_kses_allowed_html( 'post' ) ); ?>
										<?php } ?>
									</a>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php
if ( class_exists( 'Kata_Plus_Pro_Elementor' ) && ! empty( $settings['parallax'] ) ) {
	Kata_Plus_Pro_Elementor::end_parallax( $settings['parallax'] );
}
if( isset( $settings['custom_css'] ) ) {
	Kata_Plus_Elementor::module_custom_css_editor( $settings['custom_css'] );
}
