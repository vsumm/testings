<?php
/**
* Fast mode Template 6
* @author  ClimaxThemes
* @package Kata Plus
* @since   1.0.0
*/
use Elementor\Plugin;
$blog_url = did_action('elementor/loaded') ? Plugin::$instance->documents->get(Kata_Plus_Blog_Builder::get_instance()->get_builder_id())->get_edit_url() : '';
$header_url = did_action('elementor/loaded') ? Plugin::$instance->documents->get(Kata_Plus_Header_Builder::get_instance()->get_builder_id())->get_edit_url() : '';
$footer_url = did_action('elementor/loaded') ? Plugin::$instance->documents->get(Kata_Plus_Footer_Builder::get_instance()->get_builder_id())->get_edit_url() : '';
$header_url = did_action('elementor/loaded') ? Plugin::$instance->documents->get(Kata_Plus_Header_Builder::get_instance()->get_builder_id())->get_edit_url() : '';

?>


<div id="kt-fst-mod-6" class="kt-fst-mod-wrapper">
	<h1 id="page-title" class="chose-bussiness-type"><?php echo esc_html__( 'Your website is ready to launch', 'kata-plus' ); ?></h1>
    <div class="site-ready-wrapper">
        <div class="col">
            <h3><?php echo __( 'Launch the website right now.', 'kata-plus' ); ?></h3>
            <p><?php echo __( 'You can now see the website with the default content and you can edit it at any time.', 'kata-plus' ) ?></p>
            <a href="<?php echo esc_url( home_url() ); ?>"><?php echo __( 'Visit Site', 'kata-plus' ); ?></a>
        </div>
        <div class="col">
            <h3><?php echo __( 'Edit website’s content and design.', 'kata-plus' ); ?></h3>
            <p><?php echo __( 'You can easily customize the content and design of the website using the visual editor.', 'kata-plus' ) ?></p>
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=kata-plus-fast-mode&step=7' ) ); ?>"><?php echo __( 'Edit Site', 'kata-plus' ); ?></a>
        </div>
    </div>
</div>

<div class="kt-fst-mod-footer-area kt-fst-mod-6">
    <a href="<?php echo esc_url( admin_url( 'admin.php?page=kata-plus-fast-mode&step=5' ) );?>" class="prev-step"><?php echo Kata_Plus_Helpers::get_icon( '', 'eicons/arrow-left', '', '' ) . __( 'Back', 'kata-plus'); ?></a>
    <a href="<?php echo esc_url( home_url() );?>" class="next-step"><?php echo __( 'Visit Site', 'kata-plus') . Kata_Plus_Helpers::get_icon( '', 'eicons/arrow-right', '', '' ); ?></a>
</div>
