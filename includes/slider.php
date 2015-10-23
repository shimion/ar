<div id="as-slider-settings">  
    <?php
        //Get slider setting option
        $slider_option = array();
        if(isset($slider)){
            $slider_option = maybe_unserialize( $slider->slider_option );
        }
        
	// Contains the key, the display name and a boolean: true if is the default option
	$slider_select_options = array(
		'layout' => array(
			'full-width' => array(__('Full Width', AIR_TEXTDOMAIN), false),
			'fixed' => array(__('Fixed', AIR_TEXTDOMAIN), true),
		),
		'boolean' => array(
			1 => array(__('Yes', AIR_TEXTDOMAIN), true),
			0 => array(__('No', AIR_TEXTDOMAIN), false),
		),
                'shadow' => array(
                        'shadow1','shadow2','shadow3',
                ),
		'controls' => array(
                        'control1','control2','control3',
                        'control4','control5','control6',
                        'control7','control8','control9'
                ),
		'navigation' => array(
                        'navigation1','navigation2','navigation3',
                        'navigation4','navigation5','navigation6',
                        'navigation7','navigation8','navigation9',
                        'navigation10'
                ),
		'navPosition' => array(
                        'bc' => array(__('Bottom Center', AIR_TEXTDOMAIN), true),
			'bl' => array(__('Bottom Left', AIR_TEXTDOMAIN), true),
			'br' => array(__('Bottom Right', AIR_TEXTDOMAIN), true),
                ),
		'loader' => array(
                        'loader1','loader2','loader3', 
                        'loader4','loader5','loader6',
                ),
	);
	?>
    <div class="ad-s-setting-content">
        <div class="as-slider-settings-list">
            <table class="as-slider-setting-table">
                <tbody>
                    <tr>
                        <td class="as-button as-is-navy as-slider-setting-tab as-is-active" data-slider-tab="#as-slider-info"><?php _e('Slider Info', AIR_TEXTDOMAIN); ?></td>
                    </tr>
                    <tr>
                        <td class="as-button as-is-navy as-slider-setting-tab" data-slider-tab="#as-slider-general"><?php _e('General', AIR_TEXTDOMAIN); ?></td>
                    </tr>
                    <tr>
                        <td class="as-button as-is-navy as-slider-setting-tab" data-slider-tab="#as-slider-loader"><?php _e('Loader', AIR_TEXTDOMAIN); ?></td>
                    </tr>
                    <tr>
                        <td class="as-button as-is-navy as-slider-setting-tab" data-slider-tab="#as-slider-controls"><?php _e('Controls', AIR_TEXTDOMAIN); ?></td>
                    </tr>
                    <tr>
                        <td class="as-button as-is-navy as-slider-setting-tab" data-slider-tab="#as-slider-navigation"><?php _e('Navigation', AIR_TEXTDOMAIN); ?></td>
                    </tr>
                </tbody>    
            </table>
        </div>
        <div class="as-slider-settings-wrapper">
            <h4 class="ad-s-setting-head"><?php _e('Slider Setting Options', AIR_TEXTDOMAIN); ?></h4>
            
            <!-- Slider information Start -->
            <table class="as-table as-slider-setting-block" id="as-slider-info" style="display: table;">
                <tbody>
                    <tr>
                        <td class="as-no-border" colspan="3"><a class="as-button as-is-primary as-reset-slider-settings" data-reset-block="as-slider-info" href="javascript:void(0);"><?php _e('Reset Settings', AIR_TEXTDOMAIN); ?></a></td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Slider Name', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <input type="text" id="as-slider-name" placeholder="<?php _e('Slider Name', AIR_TEXTDOMAIN); ?>" value="<?php echo ($edit) ? $slider->name : ''; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Alias', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content"><span id="as-slider-alias"><?php echo ($edit) ? $slider->alias : ''; ?></span></td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Shortcode', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content" id="as-slider-shortcode"><?php echo ($edit) ? '[airslider alias="' . $slider->alias . '"]' : ''; ?></td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('PHP Function', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content" id="as-slider-php-function"><?php echo ($edit) ? 'if(function_exists("airslider")) airslider("' . $slider->alias . '");' : ''; ?></td>
                    </tr>
                </tbody>
            </table>
            <!-- Slider information End -->

            <!-- Slider General info Start -->
            <table class="as-table as-slider-setting-block" id="as-slider-general">
                <tbody>
                    <tr>
                        <td class="as-no-border" colspan="3"><a class="as-button as-is-primary as-reset-slider-settings" data-reset-block="as-slider-general" href="javascript:void(0);"><?php _e('Reset Settings', AIR_TEXTDOMAIN); ?></a></td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Layout', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <select id="as-slider-layout">
                                <?php
                                foreach ($slider_select_options['layout'] as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ((!$edit && $value[1]) || ($edit && isset($slider_option->layout) && $slider_option->layout == $key)) {
                                        echo ' selected';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td class="as-description">
                            <?php _e('Modify the layout type of the slider.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Responsive', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <select id="as-slider-responsive">
                                <?php
                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ((!$edit && $value[1]) || ($edit && isset($slider_option->responsive) && $slider_option->responsive == $key)) {
                                        echo ' selected';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td class="as-description">
                            <?php _e('The slider will be adapted to the screen size.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Width', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <input id="as-slider-startWidth" type="text" value="<?php echo ($edit && isset($slider_option->startWidth) ? $slider_option->startWidth : '1170') ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('px', AIR_TEXTDOMAIN); ?>
                        </td>
                        <td class="as-description">
                            <?php _e('The content initial width of the slider.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Height', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <input id="as-slider-startHeight" type="text" value="<?php echo ($edit && isset($slider_option->startHeight) ? $slider_option->startHeight : '500') ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('px', AIR_TEXTDOMAIN); ?>
                        </td>
                        <td class="as-description">
                            <?php _e('The content initial height of the slider.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Automatic Slide', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <select id="as-slider-automaticSlide">
                                <?php
                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ((!$edit && $value[1]) || ($edit && isset($slider_option->automaticSlide) && $slider_option->automaticSlide == $key)) {
                                        echo ' selected';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td class="as-description">
                            <?php _e('The slides loop is automatic.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Background Color', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content"> 
                            <label><input type="radio" value="0" name="as-slider-background-type-color" <?php echo (!$edit || ($edit && isset($slider_option->background_type_color) && $slider_option->background_type_color == 'transparent')) ? 'checked="checked"' : '' ?>  /><?php _e('Transparent', AIR_TEXTDOMAIN); ?></label>&nbsp;
                            <input type="radio" value="1" name="as-slider-background-type-color" <?php echo ($edit && isset($slider_option->background_type_color) && $slider_option->background_type_color != '' && $slider_option->background_type_color != 'transparent') ? 'checked="checked"' : '' ?>  /><input class="as-slider-background-type-color-picker-input as-button as-is-default" type="text" value="<?php echo ($edit && isset($slider_option->background_type_color) && $slider_option->background_type_color != '' && $slider_option->background_type_color != 'transparent') ? $slider_option->background_type_color : 'rgb(255,255,255)' ?>" />
                            <input type="text" class="as-slider-background-opacity as-background-opacity" value="<?php echo ($edit && isset($slider_option->background_type_color) && $slider_option->background_type_color != '' && $slider_option->background_type_color != 'transparent') ? $slider_option->background_opacity : '100' ?>" />%
                        </td>
                        <td class="as-description">
                            <?php _e('The background of slider.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr class="as-shadow-block">
                        <td class="as-name"><?php _e('Shadow', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content as-default-option-td">
                            <label><input type="radio" value="0" name="as-slide-shadow" <?php echo (!$edit || (isset($slider_option->showShadowBar) && $slider_option->showShadowBar == '0')) ? 'checked="checked"' : ''; ?> /><?php _e('None', AIR_TEXTDOMAIN); ?></label>&nbsp;
                            <label><input type="radio" value="1" name="as-slide-shadow" <?php echo ($edit && isset($slider_option->showShadowBar) && $slider_option->showShadowBar == '1') ? 'checked="checked"' : ''; ?> /><input class="as-slider-default_shadow as-button as-is-default" type="button" value="<?php _e('Select Default Shadow', AIR_TEXTDOMAIN); ?>" data-shadow-class="<?php echo ($edit && isset($slider_option->showShadowBar) && $slider_option->showShadowBar == '1') ? $slider_option->shadowClass : 'shadow1'; ?>" /></label>
                            <?php
                            $shadow_path = plugins_url() . '/air-slider/images/shadow/';
                            ?>
                            <div class="as-default-option-wrapper as-shadow-list-wrapper">
                                <table cellspacing="0" class="as-default-option-list as-shadow-list">
                                    <?php
                                    $total_shadow = count($slider_select_options['shadow']);
                                    if ($total_shadow > 0) {
                                        foreach ($slider_select_options['shadow'] as $shadow_val) {
                                            echo '<tr>';
                                            echo '<td class="';
                                            if ((!$edit && strtolower($shadow_val) == 'shadow1') || ($edit && isset($slider_option->shadowClass) && $slider_option->shadowClass == strtolower($shadow_val)) || ($edit && isset($slider_option->shadowClass) && trim($slider_option->shadowClass) == '' && strtolower($shadow_val) == 'shadow1')) {
                                                echo ' active';
                                            }
                                            echo '"><img data-shadow-class="' . strtolower($shadow_val) . '" src="' . $shadow_path . strtolower($shadow_val) . '.png" /></td>';
                                            echo '</tr>';
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                        </td>
                        <td class="as-description">
                            <?php _e('Choose to display shadow.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Pause on Hover', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <select id="as-slider-pauseOnHover">
                                <?php
                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ((!$edit && $value[1]) || ($edit && isset($slider_option->pauseOnHover) && $slider_option->pauseOnHover == $key)) {
                                        echo ' selected';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td class="as-description">
                            <?php _e('Pause the current slide when hovered.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Slider General info End -->

            <!-- Slider Loader info Start -->
            <table class="as-table as-slider-setting-block" id="as-slider-loader">
                <tbody>
                    <tr>
                        <td class="as-no-border" colspan="3"><a class="as-button as-is-primary as-reset-slider-settings" data-reset-block="as-slider-loader" href="javascript:void(0);"><?php _e('Reset Settings', AIR_TEXTDOMAIN); ?></a></td>
                    </tr>
                    <tr class="as-loader-block">
                        <td class="as-name"><?php _e('Upload Loader Image', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content as-default-option-td">
                            <label><input type="radio" value="0" name="as-slide-loader-image" <?php echo (!$edit || (isset($slider_option->loader_type) && $slider_option->loader_type == 'default')) ? 'checked="checked"' : '' ?> /><input class="as-slider-default_loader as-button as-is-default" type="button" value="<?php _e('Select Default Loader', AIR_TEXTDOMAIN); ?>" data-loader-class="<?php echo ($edit && isset($slider_option->loaderClass) && $slider_option->loaderClass != '') ? $slider_option->loaderClass : 'loader1' ?>" /></label>&nbsp;
                            <label><input type="radio" value="1" name="as-slide-loader-image" disabled="disabled" /><input class="as-slider-loader-type-image-upload-button as-button as-is-default as-is-temp-disabled as-pro-version" type="button" value="<?php _e('Upload New Loader', AIR_TEXTDOMAIN); ?>" /></label>    
                            <?php
                            $loader_path = plugins_url() . '/air-slider/images/loaders/';
                            ?>
                            <div class="as-default-option-wrapper as-loader-list-wrapper">
                                <table cellspacing="0" class="as-default-option-list as-loader-list">
                                    <?php
                                    $loader_cnt = 0;
                                    $total_loaders = count($slider_select_options['loader']);
                                    if ($total_loaders > 0) {
                                        foreach ($slider_select_options['loader'] as $loader_val) {
                                            if (($loader_cnt == 0 || $loader_cnt % 2 == 0) && $loader_cnt != 1) {
                                                if ($loader_cnt != 0) {
                                                    echo '</tr>';
                                                }
                                                echo '<tr>';
                                            }
                                            $loader_cnt++;
                                            echo '<td class="';
                                            if ((!$edit && strtolower($loader_val) == 'loader1') || ($edit && isset($slider_option->loaderClass) && $slider_option->loaderClass == strtolower($loader_val))) {
                                                echo ' active';
                                            }
                                            if ($total_loaders == $loader_cnt && $loader_cnt % 2 != 0) {
                                                echo ' border-right';
                                            }
                                            echo '"><img data-loader-class="' . strtolower($loader_val) . '" src="' . $loader_path . strtolower($loader_val) . '.gif" /></td>';

                                            if ($total_loaders == $loader_cnt) {
                                                echo '</tr>';
                                            }
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                        </td>
                        <td class="as-description">
                            <?php _e('The loader of the slider.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Slider Loader info End -->

            <!-- Slider Controls info Start -->
            <table class="as-table as-slider-setting-block" id="as-slider-controls"> 
                <tbody>
                    <tr>
                        <td class="as-no-border" colspan="3"><a class="as-button as-is-primary as-reset-slider-settings" data-reset-block="as-slider-controls" href="javascript:void(0);"><?php _e('Reset Settings', AIR_TEXTDOMAIN); ?></a></td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Show Controls', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <select id="as-slider-showControls">
                                <?php
                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ((!$edit && $value[1]) || ($edit && isset($slider_option->showControls) && $slider_option->showControls == $key)) {
                                        echo ' selected';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td class="as-description">
                            <?php _e('Show the previous and next arrows.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr class="as-controls-block" <?php echo (!$edit || ($edit && isset($slider_option->showControls) && $slider_option->showControls == '1')) ? 'style="display:table-row;"' : 'style="display:none;"' ?>>
                        <td class="as-name"><?php _e('Select Controls', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content as-default-option-td">
                            <input class="as-slider-default-controls as-button as-is-default" type="button" value="<?php _e('Select Default Controls', AIR_TEXTDOMAIN); ?>" data-control-class="<?php echo (!$edit) ? 'control1' : trim($slider_option->controlsClass); ?>" />
                            <?php $controls_path = plugins_url() . '/air-slider/images/controls/'; ?>
                            <div class="as-default-option-wrapper as-control-list-wrapper">
                                <table cellspacing="0" class="as-default-option-list as-control-list">
                                    <?php
                                    $controls_cnt = 0;
                                    $total_controls = count($slider_select_options['controls']);
                                    if ($total_controls > 0) {
                                        foreach ($slider_select_options['controls'] as $control_val) {

                                            if (($controls_cnt == 0 || $controls_cnt % 3 == 0) && $controls_cnt != 1) {
                                                if ($controls_cnt != 0) {
                                                    echo '</tr>';
                                                }
                                                echo '<tr>';
                                            }
                                            $controls_cnt++;
                                            echo '<td class="';
                                            if ((!$edit && strtolower($control_val) == 'control1') || ($edit && isset($slider_option->controlsClass) && $slider_option->controlsClass == strtolower($control_val))) {
                                                echo ' active';
                                            }
                                            if ($total_controls == $controls_cnt && $controls_cnt % 3 != 0) {
                                                echo ' border-right';
                                            }
                                            echo '"><img data-control-class="' . strtolower($control_val) . '" src="' . $controls_path . strtolower($control_val) . '.png" /></td>';

                                            if ($total_controls == $controls_cnt) {
                                                echo '</tr>';
                                            }
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                        </td>
                        <td class="as-description">
                            <?php _e('Select Previous and Next control to display on slider.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Enable Swipe and Drag', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <select id="as-slider-enableSwipe">
                                <?php
                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ((!$edit && $value[1]) || ($edit && isset($slider_option->enableSwipe) && $slider_option->enableSwipe == $key)) {
                                        echo ' selected';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td class="as-description">
                            <?php _e('Enable swipe left, swipe right, drag left, drag right commands.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Slider Controls info End -->

            <!-- Slider Navigation info Start -->
            <table class="as-table as-slider-setting-block" id="as-slider-navigation">
                <tbody>
                    <tr>
                        <td class="as-no-border" colspan="3"><a class="as-button as-is-primary as-reset-slider-settings" data-reset-block="as-slider-navigation" href="javascript:void(0);"><?php _e('Reset Settings', AIR_TEXTDOMAIN); ?></a></td>
                    </tr>
                    <tr>
                        <td class="as-name"><?php _e('Show Navigation', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <select id="as-slider-showNavigation">
                                <?php
                                foreach ($slider_select_options['boolean'] as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ((!$edit && $value[1]) || ($edit && isset($slider_option->showNavigation) && $slider_option->showNavigation == $key)) {
                                        echo ' selected';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td class="as-description">
                            <?php _e('Show the links buttons to change slide.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr class="as-navigation-block" <?php echo (!$edit || ($edit && isset($slider_option->showNavigation) && $slider_option->showNavigation == '1')) ? 'style="display:table-row;"' : 'style="display:none;"' ?>>
                        <td class="as-name"><?php _e('Select Navigation', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content as-default-option-td">
                            <input class="as-slider-default-navigation as-button as-is-default" type="button" value="<?php _e('Select Default Navigation', AIR_TEXTDOMAIN); ?>" data-navigation-class="<?php echo (!$edit) ? 'navigation1' : trim($slider_option->navigationClass) ?>" />
                            <?php $navigation_path = plugins_url() . '/air-slider/images/navigation/'; ?>
                            <div class="as-default-option-wrapper as-navigation-list-wrapper">
                                <table cellspacing="0" class="as-default-option-list as-navigation-list">
                                    <?php
                                    $navigation_cnt = 0;
                                    $total_navigation = count($slider_select_options['navigation']);
                                    if ($total_navigation > 0) {
                                        foreach ($slider_select_options['navigation'] as $navigation_val) {

                                            if (($navigation_cnt == 0 || $navigation_cnt % 5 == 0) && $navigation_cnt != 1) {
                                                if ($navigation_cnt != 0) {
                                                    echo '</tr>';
                                                }
                                                echo '<tr>';
                                            }
                                            $navigation_cnt++;
                                            echo '<td class="';
                                            if ((!$edit && strtolower($navigation_val) == 'navigation1') || ($edit && isset($slider_option->navigationClass) && $slider_option->navigationClass == strtolower($navigation_val))) {
                                                echo ' active';
                                            }
                                            if ($total_navigation == $navigation_cnt && $navigation_cnt % 5 != 0) {
                                                echo ' border-right';
                                            }
                                            echo '"><img data-navigation-class="' . strtolower($navigation_val) . '" src="' . $navigation_path . strtolower($navigation_val) . '.png" /></td>';

                                            if ($total_navigation == $navigation_cnt) {
                                                echo '</tr>';
                                            }
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                        </td>
                        <td class="as-description">
                            <?php _e('Select navigation to display on slider.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                    <tr class="as-navigation-block" <?php echo (!$edit || ($edit && isset($slider_option->showNavigation) && $slider_option->showNavigation == '1')) ? 'style="display:table-row;"' : 'style="display:none;"' ?>>
                        <td class="as-name"><?php _e('Navigation Position', AIR_TEXTDOMAIN); ?></td>
                        <td class="as-content">
                            <select id="as-slider-navigationPosition">
                                <?php
                                foreach ($slider_select_options['navPosition'] as $key => $value) {
                                    echo '<option value="' . $key . '"';
                                    if ((!$edit && $key == 'bc') || ($edit && isset($slider_option->navigationPosition) && $slider_option->navigationPosition == $key)) {
                                        echo ' selected';
                                    }
                                    echo '>' . $value[0] . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td class="as-description">
                            <?php _e('Show navigation position on slider.', AIR_TEXTDOMAIN); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Slider Navigation info End -->
        </div>    
        <br clear="all" />
    </div>
    <input class="as-button as-is-success as-save-settings" data-id="<?php echo $id; ?>" type="button" value="<?php _e('Save Settings', AIR_TEXTDOMAIN); ?>" />
    <br clear="all" />
</div>