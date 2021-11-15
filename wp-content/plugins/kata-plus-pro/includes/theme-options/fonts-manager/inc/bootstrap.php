<?php
// don't load directly.
if ( ! defined( 'ABSPATH' ) ) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}

# Load Controllers
Kata_Plus_Pro_FontsManager_Helpers::register_router( self::$dir . 'inc/pages/controller', [

    '?page=kata-plus-fonts-manager'                                     => 'main',
    '?page=kata-plus-fonts-manager&paged=(:any)'                        => 'main',
    '?page=kata-plus-fonts-manager&action=delete&font_id=(:any)'        => 'main',
    '?page=kata-plus-fonts-manager&orderby=(:any)'                      => 'main',
    '?page=kata-plus-fonts-manager&action=edit&font_id=(:any)'          => 'edit',
    '?page=kata-plus-fonts-manager&action=add_new_font'                 => 'add-new',
    '?page=kata-plus-fonts-manager&action=add_new_font&source=(:any)'   => 'add-new',
    '?page=kata-plus-fonts-manager&controller=(:any)'                   => 'page',

], '404');
if ( ! defined('KATA_PLUS_PRO_FONTS_MANAGER_CURRENT_CONTROLLER') ) {
    define( "KATA_PLUS_PRO_FONTS_MANAGER_CURRENT_CONTROLLER", Kata_Plus_Pro_FontsManager_Helpers::run_router() );
}