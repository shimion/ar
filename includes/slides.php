<div id="as-slides">
    <div class="as-slide-tabs as-tabs as-tabs-border">
        <ul class="as-sortable as-slide-tab">
            <?php
            if($edit) {
                $j = 0;
                $slides_num = count($slides);
                foreach($slides as $slide) {
                    $params = maybe_unserialize( $slide->params );
                    if($j == $slides_num - 1) {
                        echo '<li class="ui-state-default active">';
                        echo '<a class="as-button as-is-navy as-is-active">';
                    }
                    else {
                        echo '<li class="ui-state-default">';
                        echo '<a class="as-button as-is-navy">';
                    }
                    echo  __('Slide', AIR_TEXTDOMAIN) . ' <span class="as-slide-index">' . (intval(trim($slide->position)) + 1) . '</span>';
                    echo '<span class="dashicons dashicons-dismiss as-close"></span></a>';
                    echo '</li>';

                    $j++;
                }
            }
            ?>
            <li class="ui-state-default ui-state-disabled">
                <a class="as-add-new as-button as-is-inverse"><?php _e('Add New Slide', AIR_TEXTDOMAIN); ?></a>
            </li>
        </ul>

        <div class="as-slides-list">
            <?php
                if($edit) {
                    foreach($slides as $slide) {
                        echo '<div class="as-slide">';
                        airsliderPrintSlide($slider, $slide, $edit);
                        echo '</div>';
                    }
                }
            ?>
        </div>		
        <div class="as-void-slide"><?php airsliderPrintSlide($slider, false, $edit); ?></div>

        <div style="clear: both"></div>
    </div>
</div>

<?php
/**
 * Prints a slide. If the ID is not false, prints the values from MYSQL database, else prints a slide with default values.
 * 
 * @param array $slider Contains the slider information
 * 
 * @param array $slide Contains the slide information
 * 
 * @param boolean $edit variable because the elements.php file has to see it
*/
function airsliderPrintSlide($slider, $slide, $edit) {
if($edit)
    $void = !$slide ? true : false;	
    $params = array();
    $slide_id = 0;
    if($slide){
        $params = maybe_unserialize( $slide->params );
        $slide_id = $slide->id;
    }

    //Default transition
    $animations = array(
            'fade' => array(__('Fade', AIR_TEXTDOMAIN), true),
            'fadeLeft' => array(__('Fade Left', AIR_TEXTDOMAIN), false),
            'fadeRight' => array(__('Fade Right', AIR_TEXTDOMAIN), false),
            'slideLeft' => array(__('Slide Left', AIR_TEXTDOMAIN), false),
            'slideRight' => array(__('Slide Right', AIR_TEXTDOMAIN), false),
            'slideUp' => array(__('Slide Up', AIR_TEXTDOMAIN), false),
            'slideDown' => array(__('Slide Down', AIR_TEXTDOMAIN), false),
    );

    /*
     * Slide block start
     */
    ?>
    <h4 class="ad-s-setting-head"><?php _e('Slide General Options', AIR_TEXTDOMAIN); ?><a class="as-right as-button as-is-primary as-duplicate-slide as-is-temp-disabled as-pro-version"><span class="dashicons dashicons-images-alt mr5"></span><?php _e('Duplicate Slide', AIR_TEXTDOMAIN); ?></a></h4>
    <div class="ad-s-setting-content">
        <table class="as-slide-settings-list as-table">
            <tbody>
                <?php if($void): ?>
                    <tr>
                        <td class="as-name"><?php _e('Background Image', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <form>
                                <label><input type="radio" value="0" name="as-slide-background-type-image" checked /> <?php _e('None', AIR_TEXTDOMAIN); ?></label> &nbsp;
                                <label><input type="radio" value="1" name="as-slide-background-type-image" /> <input class="as-slide-background-type-image-upload-button as-button as-is-default" type="button" value="<?php _e('Select Image', AIR_TEXTDOMAIN); ?>" /></label>
                            </form>
                        </td>
                        <td class="as-description">
                            <?php _e('The background of the slide and its properties.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Background Color', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <form>
                                <label><input type="radio" value="0" name="as-slide-background-type-color" checked /> <?php _e('Transparent', AIR_TEXTDOMAIN); ?></label> &nbsp;
                                <input type="radio" value="1" name="as-slide-background-type-color" /> <input class="as-slide-background-type-color-picker-input as-button as-is-default" type="text" value="rgb(255,255,255)" />
                                <input type="text" class="as-slide-background-opacity as-background-opacity" value="100" />%
                            </form>
                        </td>
                        <td class="as-description">
                            <?php _e('The background of the slide and its properties.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Background Position-x', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <input type="text" value="0" class="as-slide-background-propriety-position-x" />
                        </td>
                        <td class="as-description">
                            <?php _e('The background of the slide and its properties.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Background Position-y', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <input type="text" value="0" class="as-slide-background-propriety-position-y" />
                        </td>
                        <td class="as-description">
                            <?php _e('The background of the slide and its properties.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Background Repeat', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <form>
                                <label><input type="radio" value="1" name="as-slide-background-repeat" checked /> <?php _e('Repeat', AIR_TEXTDOMAIN); ?></label> &nbsp;
                                <label><input type="radio" value="0" name="as-slide-background-repeat" /> <?php _e('No Repeat', AIR_TEXTDOMAIN); ?></label>
                            </form>
                        </td>
                        <td class="as-description">
                            <?php _e('The background of the slide and its properties.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Background Size', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <input type="text" value="auto" class="as-slide-background-propriety-size" />
                        </td>
                        <td class="as-description">
                            <?php _e('The background of the slide and its properties.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td class="as-name"><?php _e('Background Image', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <form>
                                <?php if(!isset($params['background_type_image']) || ((isset($params['background_type_image']) && ($params['background_type_image'] == 'none' || $params['background_type_image'] == 'undefined')))){ ?>
                                    <label><input type="radio" value="0" name="as-slide-background-type-image" checked /> <?php _e('None', AIR_TEXTDOMAIN); ?></label> &nbsp;
                                    <label><input type="radio" value="1" name="as-slide-background-type-image" /> <input class="as-slide-background-type-image-upload-button as-button as-is-default" type="button" value="<?php _e('Select Image', AIR_TEXTDOMAIN); ?>" /></label>
                                <?php } else if(isset($params['background_type_image'])){ ?>
                                    <label><input type="radio" value="0" name="as-slide-background-type-image" /> <?php _e('None', AIR_TEXTDOMAIN); ?></label> &nbsp;
                                    <label><input type="radio" value="1" name="as-slide-background-type-image" checked /> <input class="as-slide-background-type-image-upload-button as-button as-is-default" type="button" value="<?php _e('Select Image', AIR_TEXTDOMAIN); ?>" /></label>
                                <?php } ?>
                            </form>
                        </td>
                        <td class="as-description">
                            <?php _e('The background of the slide and its properties.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Background Color', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <form>
                                <?php if(!isset($params['background_type_color']) || (isset($params['background_type_color']) && $params['background_type_color'] == 'transparent')): ?>
                                    <label><input type="radio" value="0" name="as-slide-background-type-color" checked /> <?php _e('Transparent', AIR_TEXTDOMAIN); ?></label> &nbsp;
                                    <input type="radio" value="1" name="as-slide-background-type-color" /> <input class="as-slide-background-type-color-picker-input as-button as-is-default" type="text" value="rgb(255, 255, 255)" />
                                    <input type="text" class="as-slide-background-opacity as-background-opacity" value="100" />%
                                <?php else: ?>
                                    <label><input type="radio" value="0" name="as-slide-background-type-color" /> <?php _e('Transparent', AIR_TEXTDOMAIN); ?></label> &nbsp;
                                    <input type="radio" value="1" name="as-slide-background-type-color" checked /> <input class="as-slide-background-type-color-picker-input as-button as-is-default" type="text" value="<?php echo isset($params['background_type_color'])?$params['background_type_color']:'rgb(255, 255, 255)'; ?>" />
                                    <input type="text" class="as-slide-background-opacity as-background-opacity" value="<?php echo isset($params['background_opacity'])?$params['background_opacity']:'100'; ?>" />%
                                <?php endif; ?>	
                            </form>
                        </td>
                        <td class="as-description">
                            <?php _e('The background of the slide and its properties.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Background Position-x', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <input type="text" value="<?php echo (isset($params['background_propriety_position_x']))?$params['background_propriety_position_x']:'0'; ?>" class="as-slide-background-propriety-position-x" />
                        </td>
                        <td class="as-description">
                            <?php _e('The background of the slide and its properties.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Background Position-y', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <input type="text" value="<?php echo (isset($params['background_propriety_position_y']))?$params['background_propriety_position_y']:'0'; ?>" class="as-slide-background-propriety-position-y" />
                        </td>
                        <td class="as-description">
                            <?php _e('The background of the slide and its properties.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Background Repeat', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <form>
                                <?php if(!isset($params['background_repeat']) || (isset($params['background_repeat']) && $params['background_repeat'] == 'repeat')): ?>
                                    <label><input type="radio" value="1" name="as-slide-background-repeat" checked /> <?php _e('Repeat', AIR_TEXTDOMAIN); ?></label> &nbsp;
                                    <label><input type="radio" value="0" name="as-slide-background-repeat" /> <?php _e('No Repeat', AIR_TEXTDOMAIN); ?></label>
                                <?php else: ?>
                                    <label><input type="radio" value="1" name="as-slide-background-repeat" /> <?php _e('Repeat', AIR_TEXTDOMAIN); ?></label> &nbsp;
                                    <label><input type="radio" value="0" name="as-slide-background-repeat" checked /> <?php _e('No Repeat', AIR_TEXTDOMAIN); ?></label>
                                <?php endif; ?>
                            </form>
                        </td>
                        <td class="as-description">
                            <?php _e('The background of the slide and its properties.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Background Size', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <input type="text" value="<?php echo isset($params['background_repeat'])?$params['background_propriety_size']:'auto'; ?>" class="as-slide-background-propriety-size" />
                        </td>
                        <td class="as-description">
                            <?php _e('The background of the slide and its properties.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                <?php endif; ?>
                    <tr>
                        <td class="as-name"><?php _e('In Animation', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <select class="as-slide-data-in">
                                <?php
                                foreach($animations as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if(($void && $value[1]) || (!$void && isset($params['data_in']) && $params['data_in'] == $key)) {
                                        echo ' selected';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td class="as-description">
                            <?php _e('The in animation of the slide.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Out Animation', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <select class="as-slide-data-out">
                                <?php
                                foreach($animations as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if(($void && $value[1]) || (!$void && isset($params['data_out']) && $params['data_out'] == $key)) {
                                        echo ' selected';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td class="as-description">
                            <?php _e('The out animation of the slide.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Time', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <?php
                            if($void) echo '<input class="as-slide-data-time" type="text" value="3000" onkeypress="return isNumberKey(event);" />';
                            else echo '<input class="as-slide-data-time" type="text" value="' . (isset($params['data_time'])?$params['data_time']:'3000') .'" onkeypress="return isNumberKey(event);" />';
                            ?>
                            <?php _e('ms', AIR_TEXTDOMAIN); ?>
                        </td>
                        <td class="as-description">
                                <?php _e('The time that the slide will remain on the screen. Default:3000ms', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Ease In', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <?php
                            if($void) echo '<input class="as-slide-data-easeIn" type="text" value="300" onkeypress="return isNumberKey(event);" />';
                            else echo '<input class="as-slide-data-easeIn" type="text" value="' . (isset($params['data_easeIn'])?$params['data_easeIn']:'300') .'" onkeypress="return isNumberKey(event);" />';
                            ?>
                            <?php _e('ms', AIR_TEXTDOMAIN); ?>
                        </td>
                        <td class="as-description">
                            <?php _e('The time that the slide will take to get in. Default:300ms', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Ease Out', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <?php
                            if($void) echo '<input class="as-slide-data-easeOut" type="text" value="300" onkeypress="return isNumberKey(event);" />';
                            else echo '<input class="as-slide-data-easeOut" type="text" value="' . (isset($params['data_easeOut'])?$params['data_easeOut']:'300') .'" onkeypress="return isNumberKey(event);" />';
                            ?>
                            <?php _e('ms', AIR_TEXTDOMAIN); ?>
                        </td>
                        <td class="as-description">
                            <?php _e('The time that the slide will take to get out. Default:300ms', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Custom CSS', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <?php
                            if($void) echo '<textarea class="as-slide-custom-css"></textarea>';
                            else echo '<textarea class="as-slide-custom-css">' . (isset($params['custom_css'])?stripslashes($params['custom_css']):'') . '</textarea>';
                            ?>
                        </td>
                        <td class="as-description">
                            <?php _e('Apply CSS to the slide.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>

    <?php
    /*
     * Slide block end
     */

    // If the slide is not void, select her elements
    if(!$void) {
        global $wpdb;

        $elements = maybe_unserialize( $slide->layers );
    }
    else {
        $elements = NULL;
    }
    airsliderPrintElements($edit, $slider, $slide);
    ?>
    <input class="as-button as-is-success as-save-slide" data-slide-id="<?php echo $slide_id ?>" type="button" value="<?php _e('Save Slide', AIR_TEXTDOMAIN); ?>" />
    <?php
}
?>