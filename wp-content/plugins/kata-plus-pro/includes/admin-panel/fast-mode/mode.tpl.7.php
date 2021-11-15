<?php
/**
* Fast mode Template 7
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


<div id="kt-fst-mod-7" class="kt-fst-mod-wrapper">
	<h1 id="page-title" class="chose-bussiness-type"><?php echo esc_html__( 'Customize your website', 'kata-plus' ); ?></h1>
	<div class="kt-fst-mod-inner-wrapper">
		<div class="edit-btns">
            <a class="customize-site" data-type="home" href="<?php echo esc_url( admin_url( 'post.php?post=' . get_option('page_on_front') . '&action=elementor' ) );?>">
                <?php echo esc_html__( 'Homepage', 'kata-plus' ); ?>
            </a>
            <a class="customize-site" data-type="menu" href="<?php echo esc_url( admin_url( 'nav-menus.php' ) );?>">
                <?php echo esc_html__( 'Menu', 'kata-plus' ); ?>
            </a>
            <a class="customize-site" data-type="blog" href="<?php echo esc_url( $blog_url );?>">
                <?php echo esc_html__( 'Blog', 'kata-plus' ); ?>
            </a>
            <a class="customize-site" data-title="<?php echo esc_attr__( 'Edit Pages', 'kata-plus' ); ?>" data-type="pages-list" href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) );?>">
                <?php echo esc_html__( 'Pages', 'kata-plus' ); ?>
            </a>
            <a class="customize-site" data-title="<?php echo esc_attr__( 'Edit Posts', 'kata-plus' ); ?>" data-type="posts-list" href="<?php echo esc_url( admin_url( 'edit.php' ) );?>">
                <?php echo esc_html__( 'Posts', 'kata-plus' ); ?>
            </a>
            <a class="customize-site" data-title="<?php echo esc_attr__( 'Select your favorite Header', 'kata-plus' ); ?>" data-type="headers-list" href="<?php echo esc_url( $header_url );?>">
                <?php echo esc_html__( 'Header', 'kata-plus' ); ?>
            </a>
            <a class="customize-site" data-type="footers-list" href="<?php echo esc_url( $footer_url );?>">
                <?php echo esc_html__( 'Footer', 'kata-plus' ); ?>
            </a>
            <a class="customize-site" data-type="typography-list" data-title="<?php echo esc_attr__( 'Select your favorite Typography', 'kata-plus' ); ?>" href="<?php echo esc_url( admin_url( '' ) ); ?>">
                <?php echo esc_html__( 'Typography', 'kata-plus'); ?>
            </a>
            <a class="customize-site" data-type="list-plugins" href="#">
                <?php echo esc_html__( 'Plugins', 'kata-plus'); ?>
            </a>
        </div>
        <div class="hide-section pages-list">
            <?php
                $pages = Kata_Plus_Pro_Fast_Mode::pages();
                foreach ($pages as $page) {
                    echo $page;
                }
            ?>
            <p><?php echo esc_html__( 'or', 'kata-plus' ); ?></p>
            <a href="#" class="add-new-post"><?php echo esc_html__( 'Add New Post', 'kata-plus' ); ?></a>
        </div>
        <div class="hide-section posts-list">
            <?php
                $posts = Kata_Plus_Pro_Fast_Mode::posts();
                foreach ($posts as $post) {
                    echo $post;
                }
            ?>
            <p><?php echo esc_html__( 'or', 'kata-plus' ); ?><br><a href="#" class="add-new-post"><?php echo esc_html__( 'Add New Post', 'kata-plus' ); ?></a></p>
        </div>
        <div class="hide-section headers-list">
            <?php Kata_Plus_Pro_Fast_Mode::headers(); ?>
            <p><?php echo esc_html__( 'or', 'kata-plus' ); ?><br><a href="<?php echo esc_url( $header_url ); ?>" class="add-new-post"><?php echo esc_html__( 'Edit Current Header', 'kata-plus' ); ?></a></p>
        </div>
        <div class="hide-section footers-list">
            <?php Kata_Plus_Pro_Fast_Mode::footers(); ?>
            <p><?php echo esc_html__( 'or', 'kata-plus' ); ?><br><a href="<?php echo esc_url( $header_url ); ?>" class="add-new-post"><?php echo esc_html__( 'Edit Current Footer', 'kata-plus' ); ?></a></p>
        </div>
        <div class="hide-section typography-list">
            <?php Kata_Plus_Pro_Fast_Mode::typography(); ?>
            <p><?php echo esc_html__( 'or go to', 'kata-plus' ); ?>
            <br>
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=kata-plus-fonts-manager' ) ); ?>" class="add-new-post"><?php echo esc_html__( 'Font Manager', 'kata-plus' ); ?></a>
            <a href="<?php echo esc_url(admin_url('customize.php?autofocus%5Bsection%5D=styling_typography_section')); ?>" class="add-new-post"><?php echo esc_html__( 'Advanced Styling', 'kata-plus' ); ?></a></p>
        </div>
        <div class="hide-section list-plugins">
            <?php Kata_Plus_Pro_Fast_Mode::plugins(); ?>
            <br>
            <p>
                <a href="#" class="install-plugin-bulk-action add-new-post"><?php echo esc_html__( 'Install & Activate', 'kata-plus' ); ?></a>
                <?php echo esc_html__( 'or go to', 'kata-plus' ); ?>
                <a href="<?php echo esc_url(admin_url('admin.php?page=kata-plus-plugins')); ?>" class="add-new-post"><?php echo esc_html__( 'Plugin Manager', 'kata-plus' ); ?></a>
            </p>
        </div>
	</div>
</div>

<div class="kt-fst-mod-footer-area kt-fst-mod-5">
    <a href="<?php echo esc_url( admin_url( 'admin.php?page=kata-plus-fast-mode&step=6' ) );?>" class="prev-step"><?php echo Kata_Plus_Helpers::get_icon( '', 'eicons/arrow-left', '', '' ) . __( 'Back', 'kata-plus'); ?></a>
    <a href="<?php echo esc_url( home_url() );?>" class="next-step"><?php echo __( 'Visit Site', 'kata-plus') . Kata_Plus_Helpers::get_icon( '', 'eicons/arrow-right', '', '' ); ?></a>
</div>
