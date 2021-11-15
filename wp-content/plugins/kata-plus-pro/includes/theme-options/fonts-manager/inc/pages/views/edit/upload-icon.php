<?php
// don't load directly.
if (!defined('ABSPATH')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit;
}
$current_font = FontsManager_Edit_Page_Presenter::get_font();
$current_font['selectors'] = json_decode($current_font['selectors'], true);
?>

<form method="post" class="wrap kata-plus-fonts-manager-wrap kata-plus-fonts-manager-wrap kata-plus-fonts-manager-edit-wrap upload-font" id="dashboard-widgets">
    <input type="hidden" value="upload-icon" name="source">
    <input type="hidden" value="<?php echo $current_font['ID']; ?>" name="font_id">
    <h1 class="wp-heading-inline">
        <a href="<?php echo admin_url('admin.php?page=kata-plus-fonts-manager'); ?>"><?php echo esc_html__('Font Manager', 'kata-plus'); ?></a>
        <span class="dashicons dashicons-arrow-right-alt2"></span>
        <span><?php echo esc_html__('Edit Font', 'kata-plus'); ?></span>
    </h1>

    <div class="col col-10" id="kata-plus-fonts-manager-add-font-table">
        <div class="icon-pack-name">
            <input type="text" placeholder="Icon Pack Name" required="required" name="icon-pack-name" value="<?php echo $current_font['name']; ?>">
        </div>
        <div id="poststuff">
            <div id="plupload-upload-ui" class="hide-if-no-js">
                <div id="drag-drop-area">
                    <div class="drag-drop-inside">
                        <p class="drag-drop-info"><?php _e('Drop files here'); ?></p>
                        <p><?php _ex('or', 'Uploader: Drop font files here - or - Select Files'); ?></p>
                        <p class="drag-drop-buttons"><input id="plupload-browse-button" type="button" value="<?php esc_attr_e('Select Files'); ?>" class="button" /></p>
                        <p class="allowed-files">Allowed Files: <span>selection.json from icomoon zip or svg Icons</span></p>
                    </div>
                </div>
            </div>
            <div class="upload-font-result">
                <?php foreach ($current_font['selectors'] as $key => $icon) : ?>
                    <div class="upload-icon-item">
                        <input type="hidden" name="icons[<?php echo $key; ?>][path]" value="<?php echo $icon['path']; ?>">
                        <input type="hidden" name="icons[<?php echo $key; ?>][size]" value="<?php echo isset($icon['size']) ? $icon['size'] : 1024; ?>">
                        <?php echo file_get_contents($icon['path']); ?>
                        <input type="text" name="icons[<?php echo $key; ?>][name]" value="<?php echo $icon['name']; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="hidden">
        <div class="col col-10">
            <div id="poststuff">
                <div id="postbox-container" class="postbox-container">
                    <div class="meta-box-sortables ui-sortable" id="normal-sortables">
                        <div class="postbox ">
                            <div title="Click to toggle" class="handlediv"><br></div>
                            <h3 class="hndle"><span><?php echo esc_html__('Selectors and Sizes', 'kata-plus'); ?></span></h3>
                            <div class="inside has-footer css-selector-wrap">
                                <div class="row postbox-container-footer">
                                    <div class="button" id="add-new-section">
                                        <span aria-hidden="true" class="dashicons dashicons-plus"></span><?php echo esc_html__('Add new selector', 'kata-plus'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="postbox">
                            <div title="Click to toggle" class="handlediv"><br></div>
                            <h3 class="hndle"><span><?php echo esc_html__('Other Options', 'kata-plus'); ?></span></h3>
                            <div class="inside">
                                <div class="row">
                                    <div class="col table">
                                        <label class="block-label">Font status</label>
                                        <select name="font_status" class="kata-plus-fonts-manager-add-new-font-selector-select">
                                            <option <?php echo $current_font['status'] == 'published' ? ' selected="selected"' : ''; ?> value="published">Published</option>
                                            <option <?php echo $current_font['status'] == 'unpublished' ? ' selected="selected"' : ''; ?> value="unpublished">Unpublished</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="kata-plus-fonts-manager-submit-content">
        <input type="submit" class="button" value="<?php echo esc_html__('Update', 'kata-plus'); ?>">
    </div>

</form>