<?php
global $wpdb;

//Get the slider information
$sliders = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'air_sliders');
?>

<!-- Display slider on home page -->
<table class="as-sliders-list as-table">
    <thead>
        <tr>
            <th colspan="5"><?php _e('Sliders List', AIRSLIDER_TEXTDOMAIN); ?></th>
        </tr>
    </thead>
    <tbody>
        <tr class="as-table-header">
            <td><?php _e('Sr. No.', AIRSLIDER_TEXTDOMAIN); ?></td>
            <td><?php _e('Name', AIRSLIDER_TEXTDOMAIN); ?></td>
            <td><?php _e('Alias', AIRSLIDER_TEXTDOMAIN); ?></td>
            <td><?php _e('Shortcode', AIRSLIDER_TEXTDOMAIN); ?></td>
            <td><?php _e('Actions', AIRSLIDER_TEXTDOMAIN); ?></td>
        </tr>
        <?php
        if (!$sliders) {
            echo '<tr>';
            echo '<td colspan="5">';
            _e('No Sliders found.', AIRSLIDER_TEXTDOMAIN);
            echo '</td>';
            echo '</tr>';
        } else {
            $slider_cnt = 0;
            foreach ($sliders as $slider) {
                $slider_cnt++;
                echo '<tr>';
                echo '<td>' . $slider_cnt . '</td>';
                echo '<td><a href="?page=airslider&view=edit&id=' . $slider->id . '">' . $slider->name . '</a></td>';
                echo '<td>' . $slider->alias . '</td>';
                echo '<td>[airslider alias="' . $slider->alias . '"]</td>';
                echo '<td>
                        <a class="as-edit-slider as-button as-button as-is-success" href="?page=airslider&view=edit&id=' . $slider->id . '"><span class="dashicons dashicons-admin-generic mr5"></span>' . __('Settings', AIRSLIDER_TEXTDOMAIN) . '</a>
                        <a class="as-edit-slider as-button as-button as-is-primary" href="?page=airslider&view=edit&id=' . $slider->id . '#as-slides"><span class="dashicons dashicons-edit mr5"></span>' . __('Edit Slides', AIRSLIDER_TEXTDOMAIN) . '</a>
                        <a class="as-export-slider as-button as-button as-is-warning as-is-temp-disabled as-pro-version" href="javascript:void(0);"><span class="dashicons dashicons-share-alt2 mr5"></span>' . __('Export Slider', AIRSLIDER_TEXTDOMAIN) . '</a>
                        <a class="as-delete-slider as-button as-button as-is-danger" href="javascript:void(0)" data-delete="' . $slider->id . '" title="' . __('Delete Slider', AIRSLIDER_TEXTDOMAIN) . '"><span class="dashicons dashicons-trash"></span></a>
                        <a class="as-duplicate-slider as-button as-button as-is-secondary as-is-temp-disabled as-pro-version" href="javascript:void(0)" data-duplicate="' . $slider->id . '" title="' . __('Duplicate Slider', AIRSLIDER_TEXTDOMAIN) . '"><span class="dashicons dashicons-format-gallery"></span></a>
                     </td>';
                echo '</tr>';
            }
        }
        ?>
    </tbody>
</table>

<!-- Create new slider -->
<a class="as-button as-is-primary as-add-slider" href="?page=airslider&view=add">
    <?php _e('Create New Slider', AIRSLIDER_TEXTDOMAIN); ?>
</a>
<!-- Import slider block -->
<div class="as-import-wrapper">
    <a href="javascript:void(0);" class="as-button as-is-success as-call-import-slider as-is-temp-disabled as-pro-version">
        <?php _e('Import Slider', AIRSLIDER_TEXTDOMAIN); ?>
    </a>
</div>