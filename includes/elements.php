<?php
/**
 * Print Elements slide wise
 * 
 * @param boolean $edit identify that you are in edit mode or not
 * 
 * @param array $slider slider information
 * 
 * @param array $slide slide information
*/
if(!function_exists('airsliderPrintElements'))
{
    function airsliderPrintElements($edit, $slider, $slide) {
    
        //Get slider option
        $slider_option = maybe_unserialize( $slider->slider_option );

        //Get all Slides settings by params and elements by layers
        $params = $elements = array();
        $slide_index = 0;
        if($slide){
            $params = maybe_unserialize( $slide->params );
            $slide_index = ($slide->position + 1);
            $elements = maybe_unserialize($slide->layers);
        }
        $aios_ele_time_output = '';
        ?>
	<div class="as-elements">
            <div
            class="as-slide-editing-area"
            <?php 
            if($edit && $slide): ?>
                    <?php
                    if(isset($params['background_type_image']) && $params['background_type_image'] != 'none') {
                            echo 'data-background-image-src="' . $params['background_type_image'] . '"';
                    }
                    ?>
                    style="
                    width: <?php echo isset($slider_option->startWidth) ? $slider_option->startWidth : '1170'; ?>px;
                    height: <?php echo isset($slider_option->startHeight) ? $slider_option->startHeight:'500'; ?>px;
                    background-image: url('<?php echo isset($params['background_type_image']) ? $params['background_type_image']:''; ?>');
                    background-color: <?php echo (isset($params['background_type_color']) && isset($params['background_opacity']) && $params['background_type_color'] == 'transparent') ? 'rgb(255, 255, 255)' : airsliderHex2Rgba($params['background_type_color'],trim($params['background_opacity'])); ?>;
                    background-position: <?php if(isset($params['background_propriety_position_x']) && isset($params['background_propriety_position_y'])) { 
                            echo ($params['background_propriety_position_x'] ." ". $params['background_propriety_position_y']);                             
                        } else { 
                            echo '0 0'; } ?>;			
                    background-repeat: <?php echo isset($params['background_repeat']) ? $params['background_repeat'] : 'no-repeat'; ?>;
                    background-size: <?php echo isset($params['background_propriety_size']) ? $params['background_propriety_size'] : 'auto' ; ?>;
                    <?php echo isset($params['custom_css']) ? stripslashes($params['custom_css']) : ''; ?>
                    "
            <?php endif; ?>
            >
                <?php
                if($edit && $elements != NULL) {
                    $ele_cnt = 0;
                    foreach($elements as $ele_key=>$element) {
                        if(isset($element->link) && $element->link != '') {
                            $target = (isset($element->link_new_tab) && $element->link_new_tab == 1) ? 'target="_blank"' : '';

                            $link_output = '<a' . "\n" .
                            'class="as-element as-' . ( isset($element->type) ? $element->type : 'text' ) . '-element"' . "\n" .
                            'href="' . (isset($element->link) ? stripslashes($element->link) : '')  . '"' . "\n" .
                            $target . "\n" .
                            'style="' .
                            'z-index: ' . (isset($element->z_index) ? ($element->z_index . ';') : '1') . "\n" .
                            'top: ' . (isset($element->data_top) ? ($element->data_top . 'px;') : '0') . "\n" .
                            'left: ' . (isset($element->data_left) ? ($element->data_left . 'px;') : '0') . "\n" .
                            '">' .  "\n";

                            echo $link_output;
                        }
                        
                        if(isset($element->type) && $element->type != '') {
                            switch($element->type) {
                                case 'text':
                                    $aios_ele_time_output .= '<tr class="as-ele-list">'.
                                        '<td title='.__('Show/Hide Element', AIRSLIDER_TEXTDOMAIN).'><span class="dashicons dashicons-visibility"></span></td>'.
                                        '<td class="as-ele-title"><span class="dashicons dashicons-editor-textcolor"></span><span>'. (isset($element->inner_html) ? stripslashes($element->inner_html) : '').'</span></td>'.
                                        '<td><input type="text" value="'. (isset($element->data_delay) ? trim($element->data_delay) : '0') .'" class="as-delay-ele as-txt-delay-time" onkeypress="return isNumberKey(event);" /></td>'.
                                        '<td><input type="text" value="'. (isset($element->data_easeIn) ? trim($element->data_easeIn) : '300') .'" class="as-easein-ele as-txt-easein" onkeypress="return isNumberKey(event);" /></td>'.
                                        '<td><input type="text" value="'. (isset($element->data_easeOut) ? trim($element->data_easeOut) : '300') .'" class="as-easeout-ele as-txt-easeout" onkeypress="return isNumberKey(event);" /></td>'.
                                        '<td><input type="number" min="0" value="'. (isset($element->z_index) ? trim($element->z_index) : '1') .'" class="as-z-index-ele as-txt-z-index" onkeypress="return isNumberKey(event);" /></td>'.
                                        '</tr>';
                                        ?>
                                        <div
                                        style="
                                        <?php
                                        if( isset($element->link) && $element->link == '') {
                                            if(isset($element->z_index)) { 
                                                echo 'z-index: ' . $element->z_index . ';';
                                            }
                                            if(isset($element->data_left)) { 
                                                echo 'left: ' . $element->data_left . 'px;';
                                            }
                                            if(isset($element->data_top)) { 
                                                echo 'top: ' . $element->data_top . 'px;';
                                            }
                                        }
                                        if(isset($element->custom_css)) { 
                                            echo stripslashes($element->custom_css);
                                        }
                                        ?>
                                        "
                                        <?php
                                        if(isset($element->link) && $element->link == '') {
                                            echo 'class="as-element as-text-element"';
                                        }
                                        ?>
                                        >
                                        <?php 
                                        echo isset($element->inner_html) ? stripslashes($element->inner_html) : ''; ?>
                                        </div>
                                        <?php
                                    break;
                                case 'video':
                                    $aios_ele_time_output .= '<tr class="as-ele-list">'.
                                        '<td title='.__('Show/Hide Element', AIRSLIDER_TEXTDOMAIN).'><span class="dashicons dashicons-visibility"></span></td>'.
                                        '<td class="as-ele-title"><span class="dashicons dashicons-format-video"></span><span>';
                                    $video_title = 'Video Element';
                                    $video_icon = 'youtube_icon';
                                    $video_preview_img_src = AIR_PLUGIN_URL.'/images/video_sample.jpg';
                                    if(isset($element->video_type) && $element->video_type=='H')
                                    {
                                        $video_title = 'Html5 Video';
                                        $video_icon = 'html5_icon';
                                        if(isset($element->video_html5_poster_url) && trim($element->video_html5_poster_url)!=''){
                                            $video_preview_img_src = trim($element->video_html5_poster_url);
                                        }
                                        else
                                        {
                                            $video_preview_img_src = AIR_PLUGIN_URL.'/images/html5-video.png';
                                        }
                                    }
                                    else 
                                    {
                                        if(isset($element->video_type) && $element->video_type=='Y')
                                        {
                                            $video_icon = 'youtube_icon';
                                        }
                                        else if(isset($element->video_type) && $element->video_type=='V')
                                        {
                                            $video_icon = 'vimeo_icon';
                                        }
                                        if(isset($element->video_preview_img_src) && trim($element->video_preview_img_src)!=''){
                                            $video_preview_img_src = trim($element->video_preview_img_src);
                                        }
                                        if(isset($element->video_preview_img_alt) && trim($element->video_preview_img_alt)!='')
                                        {
                                            $video_title = trim($element->video_preview_img_alt);
                                        }
                                    }

                                    $aios_ele_time_output .= $video_title;
                                    $aios_ele_time_output .= '</span></td>'.
                                        '<td><input type="text" value="'. (isset($element->data_delay) ? trim($element->data_delay) : '0') .'" class="as-delay-ele as-txt-delay-time" onkeypress="return isNumberKey(event);" /></td>'.
                                        '<td><input type="text" value="'. (isset($element->data_easeIn) ? trim($element->data_easeIn) : '300').'" class="as-easein-ele as-txt-easein" onkeypress="return isNumberKey(event);" /></td>'.
                                        '<td><input type="text" value="'. (isset($element->data_easeOut) ? trim($element->data_easeOut) : '300').'" class="as-easeout-ele as-txt-easeout" onkeypress="return isNumberKey(event);" /></td>'.
                                        '<td><input type="number" min="0" value="'. (isset($element->z_index) ? trim($element->z_index) : '1') .'" class="as-z-index-ele as-txt-z-index" onkeypress="return isNumberKey(event);" /></td>'.
                                        '</tr>'
                                        ?>
                                        <div id="video_block_<?php echo $ele_key; ?>" 
                                            <?php
                                            if(isset($element->link) && $element->link == '') {
                                                echo 'class="as-element as-video-element as-iframe-element"';
                                            }
                                            ?>
                                            style="<?php
                                        if(isset($element->link) && $element->link == '') {
                                            if(isset($element->z_index)) {
                                                echo 'z-index: ' . $element->z_index . ';';
                                            }
                                            if(isset($element->data_left)) { 
                                                echo 'left: ' . $element->data_left . 'px;';
                                            }
                                            if(isset($element->data_top)) {
                                                echo 'top: ' . $element->data_top . 'px;';
                                            }
                                        }
                                        if(isset($element->custom_css)) { 
                                            echo stripslashes($element->custom_css);
                                        }
                                        ?>">
                                            <label class="video_block_title"><?php echo $video_title; ?></label>

                                            <img src="<?php echo $video_preview_img_src; ?>" width="<?php echo isset($element->video_width) ? $element->video_width : '320px'; ?>" height="<?php echo isset($element->video_height) ? $element->video_height : '240px'; ?>"/>  
                                            <div class="video_block_icon <?php echo $video_icon; ?>"></div>
                                        </div>
                                        <?php
                                    break;
                                case 'image':
                                    $ele_cnt++;
                                    $aios_ele_time_output .= '<tr class="as-ele-list as-ele-image-list">'.
                                        '<td title='.__('Show/Hide Element', AIRSLIDER_TEXTDOMAIN).'><span class="dashicons dashicons-visibility"></span></td>'.
                                        '<td class="as-ele-title"><span class="dashicons dashicons-format-image"></span><span>Image Element '. $ele_cnt .'</span></td>'.
                                        '<td><input type="text" value="'. (isset($element->data_delay) ? trim($element->data_delay) : '0') .'" class="as-delay-ele as-txt-delay-time" onkeypress="return isNumberKey(event);" /></td>'.
                                        '<td><input type="text" value="'. (isset($element->data_easeIn) ? trim($element->data_easeIn) : '300') .'" class="as-easein-ele as-txt-easein" onkeypress="return isNumberKey(event);" /></td>'.
                                        '<td><input type="text" value="'. (isset($element->data_easeOut) ? trim($element->data_easeOut) : '300') .'" class="as-easeout-ele as-txt-easeout" onkeypress="return isNumberKey(event);" /></td>'.
                                        '<td><input type="number" min="0" value="'. (isset($element->z_index) ? trim($element->z_index) : '1') .'" class="as-z-index-ele as-txt-z-index" onkeypress="return isNumberKey(event);" /></td>'.
                                        '</tr>';
                                        ?>
                                        <img
                                            width="<?php echo isset($element->image_width) ? $element->image_width : '0'; ?>"
                                            height="<?php echo isset($element->image_height) ? $element->image_height : '0'; ?>"
                                        src="<?php echo isset($element->image_src) ? $element->image_src : ''; ?>"
                                        alt="<?php echo isset($element->image_alt) ? $element->image_alt : ''; ?>"
                                        style="
                                        <?php
                                        if(isset($element->link) && $element->link == '') {
                                            if(isset($element->z_index)) { 
                                                echo 'z-index: ' . $element->z_index . ';';
                                            }
                                            if(isset($element->data_left)) { 
                                                echo 'left: ' . $element->data_left . 'px;';
                                            }
                                            if(isset($element->data_top)) {
                                                echo 'top: ' . $element->data_top . 'px;';
                                            }
                                        }
                                        if(isset($element->custom_css)) { 
                                            echo stripslashes($element->custom_css);
                                        }
                                        ?>
                                        "
                                        <?php
                                        if(isset($element->link) && $element->link == '') {
                                                echo 'class="as-element as-image-element"';
                                        }
                                        ?>
                                        />
                                        <?php
                                    break;
                            }
                        }
                        if(isset($element->link) && $element->link != '') {
                            echo '</a>' . "\n";
                        }
                    }
                }
                ?>
            </div>
		
            <div class="as-elements-actions">
                <div class="as-left">		
                    <a class="as-add-text-element as-button as-is-warning"><?php _e('Add Text', AIRSLIDER_TEXTDOMAIN); ?></a>
                    <a class="as-add-image-element as-button as-is-warning"><?php _e('Add Image', AIRSLIDER_TEXTDOMAIN); ?></a>
                    <a class="as-add-video-element as-button as-is-warning"><?php _e('Add Video', AIRSLIDER_TEXTDOMAIN); ?></a>
                </div>
                <div class="as-right">
                    <span title="<?php _e('Element Timing', AIRSLIDER_TEXTDOMAIN); ?>" class="as-ele-time-btn as-button as-is-secondary"><span class="dashicons dashicons-backup"></span></span>
                    <a title="<?php _e('Live Preview', AIRSLIDER_TEXTDOMAIN); ?>" class="as-live-preview as-button as-is-success"><span class="dashicons dashicons-search"></span></a>
                    <a title="<?php _e('Delete Element', AIRSLIDER_TEXTDOMAIN); ?>" class="as-delete-element as-button as-is-danger as-is-disabled"><span class="dashicons dashicons-dismiss"></span></a>
                    <a title="<?php _e('Duplicate Element', AIRSLIDER_TEXTDOMAIN); ?>" class="as-duplicate-element as-button as-is-primary as-is-disabled"><span class="dashicons dashicons-images-alt"></span></a>
                    <a title="<?php _e('Delete All Element', AIRSLIDER_TEXTDOMAIN); ?>" class="as-delete-all-element as-button as-is-danger <?php echo ($slide && $slide->layers!='')?'':'as-is-disabled'; ?>"><span class="dashicons dashicons-trash"></span></a>
                </div>
                <div style="clear: both;"></div>
            </div>
            <div class="as-ele-time" style="display: none;">
                <span class="as-close-block">X</span>
                <h4 class="ad-s-setting-head"><?php _e('All Elements Timing', AIRSLIDER_TEXTDOMAIN); ?></h4>
                <table  cellspacing="0">
                    <thead class="as-ele-list-tilte">
                        <tr>
                            <th title="<?php _e('Show/Hide Element', AIRSLIDER_TEXTDOMAIN); ?>"><center><span class="dashicons dashicons-visibility"></span></center></th>
                            <th><center><?php _e('Element List', AIRSLIDER_TEXTDOMAIN); ?></center></th>
                            <th><center><?php _e('Delay Time', AIRSLIDER_TEXTDOMAIN); ?> <small>(<?php _e('ms', AIRSLIDER_TEXTDOMAIN); ?>)</small></center></th>
                            <th><center><?php _e('Ease In', AIRSLIDER_TEXTDOMAIN); ?> <small>(<?php _e('ms', AIRSLIDER_TEXTDOMAIN); ?>)</small></center></th>
                            <th><center><?php _e('Ease Out', AIRSLIDER_TEXTDOMAIN); ?> <small>(<?php _e('ms', AIRSLIDER_TEXTDOMAIN); ?>)</small></center></th>
                            <th><center><?php _e('Z-index', AIRSLIDER_TEXTDOMAIN); ?></center></th>
                            </tr>   
                    </thead>
                    <tbody>
                        <?php 
                        if($aios_ele_time_output!='')
                        {
                            echo $aios_ele_time_output;
                        }
                        else
                        {
                            ?>
                            <tr class="as-no-record">
                                <td colspan="6" align="center"><?php _e('No element found.', AIRSLIDER_TEXTDOMAIN); ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="as-elements-list">
                <?php
                if($edit && $elements != NULL) {
                    foreach($elements as $ele_key => $element) {
                        if(isset($element->type)) {
                            switch($element->type) {
                                case 'text':
                                        echo '<div class="as-element-settings as-text-element-settings" style="display: none;">';
                                        airsliderPrintTextElement($element);
                                        echo '</div>';
                                    break;
                                case 'image':
                                        echo '<div class="as-element-settings as-image-element-settings" style="display: none;">';
                                        airsliderPrintImageElement($element, $ele_key);
                                        echo '</div>';
                                    break;
                                case 'video':
                                        echo '<div class="as-element-settings as-video-element-settings" style="display: none;">';
                                        airsliderPrintVideoElement($element, $slide_index, $ele_key);
                                        echo '</div>';
                                    break;    
                            }
                        }
                    }
                }
                echo '<div class="as-void-element-settings as-void-text-element-settings as-element-settings as-text-element-settings">';
                airsliderPrintTextElement(false);
                echo '</div>';
                echo '<div class="as-void-element-settings as-void-image-element-settings as-element-settings as-image-element-settings">';
                airsliderPrintImageElement(false);
                echo '</div>';
                echo '<div class="as-void-element-settings as-void-video-element-settings as-element-settings as-video-element-settings">';
                airsliderPrintVideoElement(false);
                echo '</div>';
                ?>
            </div>

	</div>
        <?php
    }
}

/**
 * Print Text Element
 *  
 * @param array $element text element information
*/
if(!function_exists('airsliderPrintTextElement'))
{
    function airsliderPrintTextElement($element) {
	$void = !$element ? true : false;
	
        //Default Transition
	$animations = array(
		'slideDown' => array(__('Slide Down', AIRSLIDER_TEXTDOMAIN), false),
		'slideUp' => array(__('Slide Up', AIRSLIDER_TEXTDOMAIN), false),
		'slideLeft' => array(__('Slide Left', AIRSLIDER_TEXTDOMAIN), false),
		'slideRight' => array(__('Slide Right', AIRSLIDER_TEXTDOMAIN), false),
		'fade' => array(__('Fade', AIRSLIDER_TEXTDOMAIN), true),
		'fadeDown' => array(__('Fade Down', AIRSLIDER_TEXTDOMAIN), false),
		'fadeUp' => array(__('Fade Up', AIRSLIDER_TEXTDOMAIN), false),
		'fadeLeft' => array(__('Fade Left', AIRSLIDER_TEXTDOMAIN), false),
		'fadeRight' => array(__('Fade Right', AIRSLIDER_TEXTDOMAIN), false),
		'fadeSmallDown' => array(__('Fade Small Down', AIRSLIDER_TEXTDOMAIN), false),
		'fadeSmallUp' => array(__('Fade Small Up', AIRSLIDER_TEXTDOMAIN), false),
		'fadeSmallLeft' => array(__('Fade Small Left', AIRSLIDER_TEXTDOMAIN), false),
		'fadeSmallRight' => array(__('Fade Small Right', AIRSLIDER_TEXTDOMAIN), false),
	);
	
	?>
        <div class="as-element-pro-tab as-tabs">
            <ul class="as-element-pro-tab-ul">
                <li class="">
                    <a class="as-button as-is-navy as-is-active" href="javascript:void(0);" data-href=".as-ele-txt-general-parameter"><?php _e('General Parameter', AIRSLIDER_TEXTDOMAIN); ?></a>
                </li>
                <li class="">
                    <a  class="as-button as-is-navy" href="javascript:void(0);" data-href=".as-ele-txt-animation-parameter"><?php _e('Animation Parameter', AIRSLIDER_TEXTDOMAIN); ?></a>
                </li>
                <li class="">
                    <a  class="as-button as-is-navy" href="javascript:void(0);" data-href=".as-ele-txt-advanced-parameter"><?php _e('Advanced Parameter', AIRSLIDER_TEXTDOMAIN); ?></a>
                </li>
            </ul>
            <div class="as-element-type-block as-ele-txt-general-parameter" style="display: block;">
                <table class="as-element-settings-list as-text-element-settings-list as-table">
                    <tbody>
                        <tr>
                            <td class="as-name"><?php _e('Text', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <textarea class="as-element-inner-html"><?php echo ($void)? __('Text element', AIRSLIDER_TEXTDOMAIN) : (isset($element->inner_html) ? stripslashes($element->inner_html) : '') ?></textarea>
                            </td>
                            <td class="as-description">
                                <?php _e('Write the text or the HTML.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Left', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-left" type="text" value="<?php echo ($void) ? '0' : (isset($element->data_left) ? $element->data_left : '0') ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('px', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('Left distance in px from the start width.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Top', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-top" type="text" value="<?php echo ($void) ? '0' : (isset($element->data_top) ? $element->data_top : '0') ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('px', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('Top distance in px from the start height.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Z - index', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-z-index" type="number" min="0" value="<?php echo ($void) ? '1' : (isset($element->z_index) ? $element->z_index : '1'); ?>" onkeypress="return isNumberKey(event);" />
                            </td>
                            <td class="as-description">
                                <?php _e('An element with an high z-index will cover an element with a lower z-index if they overlap.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="as-element-type-block as-ele-txt-animation-parameter">
                <table class="as-element-settings-list as-text-element-settings-list as-table">
                    <tbody>
                        <tr>
                            <td class="as-name"><?php _e('Delay', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-delay" type="text" value="<?php echo ($void) ? '0' : (isset($element->data_delay) ? $element->data_delay : '0') ; ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('How long will the element wait before the entrance. Default:0ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Time', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-time" type="text" value="<?php echo ($void) ? 'all' : (isset($element->data_time) ? $element->data_time : 'all'); ?>" />&nbsp;<?php _e('ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('How long will the element be displayed during the slide execution. Write "all" to set the entire time. Default:all', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('In Animation', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <select class="as-element-data-in">
                                    <?php
                                    foreach($animations as $key => $value) {
                                        echo '<option value="' . $key . '"';
                                        if(($void && $value[1]) || (!$void && isset($element->data_in) && $element->data_in == $key)) {
                                            echo ' selected';
                                        }
                                        echo '>' . $value[0] . '</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                            <td class="as-description">
                                <?php _e('The in animation of the element.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Out Animation', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <select class="as-element-data-out">
                                    <?php
                                    foreach($animations as $key => $value) {
                                        echo '<option value="' . $key . '"';
                                        if(($void && $value[1]) || (!$void && isset($element->data_out) && $element->data_out == $key)) {
                                            echo ' selected';
                                        }
                                        echo '>' . $value[0] . '</option>';
                                    }
                                    ?>
                                </select>
                                <br />
                                <label><input class="as-element-data-ignoreEaseOut" type="checkbox" <?php echo (!$void && isset($element->data_ignoreEaseOut) && $element->data_ignoreEaseOut) ? 'checked="checked"' : '' ?> /><?php _e('Disable synchronization with slide out animation', AIRSLIDER_TEXTDOMAIN) ?></label>
                            </td>
                            <td class="as-description">
                                <?php _e('The out animation of the element.<br /><br />Disable synchronization with slide out animation: if not checked, the slide out animation won\'t start until all the elements that have this option unchecked are animated out.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Ease In', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-easeIn" type="text" value="<?php echo ($void) ? '300' : (isset($element->data_easeIn) ? $element->data_easeIn : '300'); ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('How long will the in animation take. Default:300ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Ease Out', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-easeOut" type="text" value="<?php echo ($void) ? '300' : (isset($element->data_easeOut) ? $element->data_easeOut : '300'); ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('How long will the out animation take. Default:300ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="as-element-type-block as-ele-txt-advanced-parameter">
                <table class="as-element-settings-list as-text-element-settings-list as-table">
                    <tbody>
                        <tr>
                            <td class="as-name"><?php _e('Attribute ID', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-id" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_id) ? $element->attr_id : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add ID attribute to element.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Attribute Classes', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-class" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_class) ? $element->attr_class : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Class attribute to element.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Attribute Title', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-title" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_title) ? $element->attr_title : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Title attribute to element.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Attribute Rel', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-rel" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_rel) ? $element->attr_rel : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Rel attribute to element.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Link', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-link" type="text" value="<?php echo ($void) ? '' : (isset($element->link) ? stripslashes($element->link) : ''); ?>" />
                                <br />
                                <label><input class="as-element-link-new-tab" type="checkbox" <?php echo (!$void && isset($element->link_new_tab) && $element->link_new_tab) ? 'checked="checked"' : '';  ?> /><?php _e('Open link in a new tab', AIRSLIDER_TEXTDOMAIN) ?></label>
                            </td>
                            <td class="as-description">
                                <?php _e('Open the link (e.g.: http://www.google.com) on click. Leave it empty if you don\'t want it.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Link ID', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-link-id" type="text" value="<?php echo ($void) ? '' : (isset($element->link_id) ? $element->link_id :''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add ID attribute to element\'s link.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Link Classes', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-link-class" type="text" value="<?php echo ($void) ? '' : (isset($element->link_class) ? $element->link_class : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Class attribute to element\'s link .', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Link Title', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-link-title" type="text" value="<?php echo ($void) ? '' : (isset($element->link_title) ? $element->link_title : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Title attribute to element\'s link.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Link Rel', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-link-rel" type="text" value="<?php echo ($void) ? '' : (isset($element->link_rel) ? $element->link_rel : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Rel attribute to element\'s link.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Custom CSS', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <textarea class="as-element-custom-css"><?php echo ($void) ? '' : (isset($element->custom_css) ? stripslashes($element->custom_css) : ''); ?></textarea>
                            </td>
                            <td class="as-description">
                                <?php _e('Style the element.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
	<?php
    }
}

/**
 * Print Image Element
 *  
 * @param array $element image element information
 * 
 * @param integer $ele_no element number
*/
if(!function_exists('airsliderPrintImageElement'))
{
    function airsliderPrintImageElement($element, $ele_no = null) {
	$void = !$element ? true : false;
	
        //Default Transition
	$animations = array(
		'slideDown' => array(__('Slide Down', AIRSLIDER_TEXTDOMAIN), false),
		'slideUp' => array(__('Slide Up', AIRSLIDER_TEXTDOMAIN), false),
		'slideLeft' => array(__('Slide Left', AIRSLIDER_TEXTDOMAIN), false),
		'slideRight' => array(__('Slide Right', AIRSLIDER_TEXTDOMAIN), false),
		'fade' => array(__('Fade', AIRSLIDER_TEXTDOMAIN), true),
		'fadeDown' => array(__('Fade Down', AIRSLIDER_TEXTDOMAIN), false),
		'fadeUp' => array(__('Fade Up', AIRSLIDER_TEXTDOMAIN), false),
		'fadeLeft' => array(__('Fade Left', AIRSLIDER_TEXTDOMAIN), false),
		'fadeRight' => array(__('Fade Right', AIRSLIDER_TEXTDOMAIN), false),
		'fadeSmallDown' => array(__('Fade Small Down', AIRSLIDER_TEXTDOMAIN), false),
		'fadeSmallUp' => array(__('Fade Small Up', AIRSLIDER_TEXTDOMAIN), false),
		'fadeSmallLeft' => array(__('Fade Small Left', AIRSLIDER_TEXTDOMAIN), false),
		'fadeSmallRight' => array(__('Fade Small Right', AIRSLIDER_TEXTDOMAIN), false),
	);
	
	?>
        <div class="as-element-pro-tab as-tabs">
            <ul class="as-element-pro-tab-ul ui-tabs-nav">
                <li class="">
                    <a  class="as-button as-is-navy as-is-active" href="javascript:void(0);" data-href=".as-ele-img-general-parameter"><?php _e('General Parameter', AIRSLIDER_TEXTDOMAIN); ?></a>
                </li>
                <li class="">
                    <a  class="as-button as-is-navy" href="javascript:void(0);" data-href=".as-ele-img-animation-parameter"><?php _e('Animation Parameter', AIRSLIDER_TEXTDOMAIN); ?></a>
                </li>
                <li class="">
                    <a  class="as-button as-is-navy" href="javascript:void(0);" data-href=".as-ele-img-advanced-parameter"><?php _e('Advanced Parameter', AIRSLIDER_TEXTDOMAIN); ?></a>
                </li>
            </ul>
            <div class="as-element-type-block as-ele-img-general-parameter" style="display: block;">
                <table class="as-element-settings-list as-text-element-settings-list as-table">
                    <tbody>
			<tr>
                            <td class="as-name"><?php _e('Modify Image', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input data-width="<?php echo ($void) ? '' : (isset($element->image_width) ? $element->image_width : ''); ?>" data-height="<?php echo ($void) ? '' : (isset($element->image_height) ? $element->image_height : ''); ?>" data-src="<?php echo ($void) ? '' : (isset($element->image_src) ? $element->image_src : ''); ?>" class="as-image-element-upload-button as-button as-is-default" type="button" value="<?php _e('Open Gallery', AIRSLIDER_TEXTDOMAIN) ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Change the image source or the alt text.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
                        <tr>
                            <td class="as-name"><?php _e('Image Alt', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-image-alt" type="text" value="<?php echo ($void) ? '' : (isset($element->image_alt) ? trim($element->image_alt) : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add image alt text.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
                        <tr>
                            <td class="as-name as-label-for" data-label-for=".as-element-image-scale"><?php _e('Scale Proportional', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-image-scale" type="checkbox" value="Y" <?php echo (!$void && isset($element->image_scale) && $element->image_scale == 'Y') ? 'checked="checked"' : ''; ?> />
                            </td>
                            <td class="as-description">
                                <?php _e('An element with Scale Proportional will scalling width and height with respect to slider width and height.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
			<tr>
                            <td class="as-name"><?php _e('Left', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-left" type="text" value="<?php echo ($void) ? '0' : (isset($element->data_left) ? $element->data_left : '0'); ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('px', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('Left distance in px from the start width.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Top', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-top" type="text" value="<?php echo ($void) ? '0' : (isset($element->data_top) ? $element->data_top : '0'); ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('px', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('Top distance in px from the start height.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Z - index', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-z-index" type="number" min="0" value="<?php echo ($void) ? '1' : (isset($element->z_index) ? $element->z_index : '1'); ?>" onkeypress="return isNumberKey(event);" />
                            </td>
                            <td class="as-description">
                                <?php _e('An element with an high z-index will cover an element with a lower z-index if they overlap.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="as-element-type-block as-ele-img-animation-parameter">
                <table class="as-element-settings-list as-text-element-settings-list as-table">
                    <tbody>
			<tr>
                            <td class="as-name"><?php _e('Delay', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-delay" type="text" value="<?php echo ($void) ? '0' : (isset($element->data_delay) ? $element->data_delay : '0'); ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('How long will the element wait before the entrance. Default:0ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Time', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-time" type="text" value="<?php echo ($void) ? 'all' : (isset($element->data_time) ? $element->data_time : 'all'); ?>" />&nbsp;<?php _e('ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('How long will the element be displayed during the slide execution. Write "all" to set the entire time. Default:all', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('In Animation', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <select class="as-element-data-in">
                                    <?php
                                    foreach($animations as $key => $value) {
                                        echo '<option value="' . $key . '"';
                                        if(($void && $value[1]) || (!$void && isset($element->data_in) && $element->data_in == $key)) {
                                            echo ' selected';
                                        }
                                        echo '>' . $value[0] . '</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                            <td class="as-description">
                                <?php _e('The in animation of the element.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Out Animation', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <select class="as-element-data-out">
                                    <?php
                                    foreach($animations as $key => $value) {
                                        echo '<option value="' . $key . '"';
                                        if(($void && $value[1]) || (!$void && isset($element->data_out) && $element->data_out == $key)) {
                                            echo ' selected';
                                        }
                                        echo '>' . $value[0] . '</option>';
                                    }
                                    ?>
                                </select>
                                <br />
                                <label><input class="as-element-data-ignoreEaseOut" type="checkbox" <?php echo (!$void) ? 'checked="checked"' : '' ?> /><?php _e('Disable synchronization with slide out animation', AIRSLIDER_TEXTDOMAIN) ?></label>
                            </td>
                            <td class="as-description">
                                <?php _e('The out animation of the element.<br /><br />Disable synchronization with slide out animation: if not checked, the slide out animation won\'t start until all the elements that have this option unchecked are animated out.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Ease In', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-easeIn" type="text" value="<?php echo ($void) ? '300' : (isset($element->data_easeIn) ? $element->data_easeIn : '300'); ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('How long will the in animation take. Default:300ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Ease Out', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-easeOut" type="text" value="<?php echo ($void) ? '300' : (isset($element->data_easeOut) ? $element->data_easeOut : '300') ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('How long will the out animation take. Default:300ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="as-element-type-block as-ele-img-advanced-parameter">
                <table class="as-element-settings-list as-text-element-settings-list as-table">
                    <tbody>
                        <tr>
                            <td class="as-name"><?php _e('Attribute ID', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-id" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_id) ? $element->attr_id : '') ; ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add ID attribute to element.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Attribute Classes', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-class" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_class) ? $element->attr_class : '') ; ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Class attribute to element.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Attribute Title', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-title" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_title) ? $element->attr_title : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Title attribute to element.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Attribute Rel', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-rel" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_rel) ? $element->attr_rel : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Rel attribute to element.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Link', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-link" type="text" value="<?php echo ($void) ? '' : (isset($element->link) ? stripslashes($element->link) : ''); ?>" />
                                <br />
                                <label><input class="as-element-link-new-tab" type="checkbox" <?php echo (!$void && isset($element->link_new_tab) && $element->link_new_tab) ? 'checked="checked"' : '';  ?> /><?php _e('Open link in a new tab', AIRSLIDER_TEXTDOMAIN) ?></label>
                            </td>
                            <td class="as-description">
                                <?php _e('Open the link (e.g.: http://www.google.com) on click. Leave it empty if you don\'t want it.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Link ID', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-link-id" type="text" value="<?php echo ($void) ? '' : (isset($element->link_id) ? $element->link_id : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add ID attribute to element\'s link.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Link Classes', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-link-class" type="text" value="<?php echo ($void) ? '' : (isset($element->link_class) ? $element->link_class : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Class attribute to element\'s link .', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Link Title', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-link-title" type="text" value="<?php echo ($void) ? '' : (isset($element->link_title) ? $element->link_title : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Title attribute to element\'s link.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Link Rel', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-link-rel" type="text" value="<?php echo ($void) ? '' : (isset($element->link_rel) ? $element->link_rel : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Rel attribute to element\'s link.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Custom CSS', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <textarea class="as-element-custom-css"><?php echo ($void) ? '' : (isset($element->custom_css) ? stripslashes($element->custom_css) : ''); ?></textarea>
                            </td>
                            <td class="as-description">
                                <?php _e('Style the element.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
	<?php
    }
}

/**
 * Print Video Element
 *  
 * @param array $element video element information
 * 
 * @param integer $ele_no element number
*/
if(!function_exists('airsliderPrintVideoElement'))
{
    function airsliderPrintVideoElement($element, $slide_index = 0, $ele_no = null) {
	$void = !$element ? true : false;
	$animations = array(
		'slideDown' => array(__('Slide Down', AIRSLIDER_TEXTDOMAIN), false),
		'slideUp' => array(__('Slide Up', AIRSLIDER_TEXTDOMAIN), false),
		'slideLeft' => array(__('Slide Left', AIRSLIDER_TEXTDOMAIN), false),
		'slideRight' => array(__('Slide Right', AIRSLIDER_TEXTDOMAIN), false),
		'fade' => array(__('Fade', AIRSLIDER_TEXTDOMAIN), true),
		'fadeDown' => array(__('Fade Down', AIRSLIDER_TEXTDOMAIN), false),
		'fadeUp' => array(__('Fade Up', AIRSLIDER_TEXTDOMAIN), false),
		'fadeLeft' => array(__('Fade Left', AIRSLIDER_TEXTDOMAIN), false),
		'fadeRight' => array(__('Fade Right', AIRSLIDER_TEXTDOMAIN), false),
		'fadeSmallDown' => array(__('Fade Small Down', AIRSLIDER_TEXTDOMAIN), false),
		'fadeSmallUp' => array(__('Fade Small Up', AIRSLIDER_TEXTDOMAIN), false),
		'fadeSmallLeft' => array(__('Fade Small Left', AIRSLIDER_TEXTDOMAIN), false),
		'fadeSmallRight' => array(__('Fade Small Right', AIRSLIDER_TEXTDOMAIN), false),
	);
	
	?>
        <div class="as-element-pro-tab as-tabs">
            <ul class="as-element-pro-tab-ul ui-tabs-nav">
                <li class="">
                    <a  class="as-button as-is-navy as-is-active" href="javascript:void(0);" data-href=".as-ele-video-general-parameter"><?php _e('General Parameter', AIRSLIDER_TEXTDOMAIN); ?></a>
                </li>
                <li class="">
                    <a  class="as-button as-is-navy" href="javascript:void(0);" data-href=".as-ele-video-animation-parameter"><?php _e('Animation Parameter', AIRSLIDER_TEXTDOMAIN); ?></a>
                </li>
                <li class="">
                    <a  class="as-button as-is-navy" href="javascript:void(0);" data-href=".as-ele-video-advanced-parameter"><?php _e('Advanced Parameter', AIRSLIDER_TEXTDOMAIN); ?></a>
                </li>
            </ul>
            <div class="as-element-type-block as-ele-video-general-parameter" style="display: block;">
                <table class="as-element-settings-list as-text-element-settings-list as-table">
                    <tbody>
			<tr>
                            <td class="as-name"><?php _e('Choose Video Type ', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <label><input name="<?php echo (!$void) ? 'as-video-type-'.$slide_index.'-'.($ele_no+1) : 'as-video-type' ?>" class="as-element-video-type" type="radio" value="Y" <?php echo ($void || (!$void && isset($element->video_type) && $element->video_type == 'Y')) ? 'checked="checked"' : ''  ?> /><?php _e('Youtube', AIRSLIDER_TEXTDOMAIN); ?></label>
                                <label><input name="<?php echo (!$void) ? 'as-video-type-'.$slide_index.'-'.($ele_no+1) : 'as-video-type' ?>" class="as-element-video-type" type="radio" value="V" <?php echo (!$void && isset($element->video_type) && $element->video_type == 'V') ? 'checked="checked"' : ''  ?> /><?php _e('Vimeo', AIRSLIDER_TEXTDOMAIN); ?></label>
                                <label><input name="<?php echo (!$void) ? 'as-video-type-'.$slide_index.'-'.($ele_no+1) : 'as-video-type' ?>" class="as-element-video-type" type="radio" value="H" <?php echo (!$void && isset($element->video_type) && $element->video_type == 'H') ? 'checked="checked"' : ''  ?> /><?php _e('Html5', AIRSLIDER_TEXTDOMAIN); ?></label>
                            </td>
                            <td class="as-description">
                                <?php _e('Choose video type ', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
                        <?php
                        $youtube_style = $vimeo_style = $html5_style = '';
                        if((!$void && isset($element->video_type) && $element->video_type=='Y') || $void) {
                            $youtube_style = 'style="display:table-row;"';
                        }
                        else if(!$void && isset($element->video_type) && $element->video_type=='V') {
                            $vimeo_style = 'style="display:table-row;"';
                        }
                        else if(!$void && isset($element->video_type) && $element->video_type=='H') {
                            $html5_style = 'style="display:table-row;"';
                        }
                        ?>
                        <!-- Youtube block start -->
                        <tr class="as-youtube-search as-video-search" <?php echo $youtube_style; ?>>
                            <td class="as-name"><?php _e('Enter Youtube ID or URL ', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-youtube-video-link" type="text" value="<?php echo (!$void && isset($element->video_type) && $element->video_type=='Y') ? (isset($element->video_link) ? trim($element->video_link) : '') : ''  ?>" />
                                <a href="javascript:void(0);" class="as-button as-is-primary as-search-youtube-video"><?php _e('Search', AIRSLIDER_TEXTDOMAIN); ?></a>
                            </td>
                            <td class="as-description">
                                <?php _e('example: E5ln4uR4TwQ ', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
                        <tr class="as-video-block as-youtube-option" <?php echo (!$void) ? $youtube_style : ''; ?>>
                            <td class="as-name as-label-for" data-label-for=".as-element-video-full-width"><?php _e('Full Width', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <?php
                                $yt_full_width = $video_wh = '';

                                if(!$void && isset($element->video_type) && $element->video_type == 'Y' && isset($element->video_full_width) && $element->video_full_width == 'Y')
                                {
                                    $yt_full_width = 'checked="checked"';
                                    $video_wh = 'style="display:none;"';
                                }
                                ?>

                                <input class="as-element-video-full-width" type="checkbox" value="Y" <?php echo $yt_full_width; ?> />

                                <!-- video width -->
                                <label <?php echo $video_wh; ?> class="as-video-wh"><?php _e('Width', AIRSLIDER_TEXTDOMAIN); ?> &nbsp;&nbsp;<input class="as-element-video-width" type="text" value="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'Y') ? (isset($element->video_width) ? $element->video_width : '320') : '320' ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('px', AIRSLIDER_TEXTDOMAIN); ?></label>

                                <!-- video height -->
                                <label <?php echo $video_wh; ?> class="as-video-wh"><?php _e('Height', AIRSLIDER_TEXTDOMAIN); ?> &nbsp;&nbsp;<input class="as-element-video-height" type="text" value="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'Y') ? (isset($element->video_height) ? $element->video_height : '240') : '240' ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('px', AIRSLIDER_TEXTDOMAIN); ?></label>
                            </td>
                            <td class="as-description">
                                <?php _e('Checked full width checkbox for get full width video which will neglate width and height which you have enter. If full width is not checked then video will take width and height from textbox.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
			<tr class="as-video-block as-youtube-option" <?php echo (!$void) ? $youtube_style : ''; ?>>
                            <td class="as-name"><?php _e('Set Preview image', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-preview-image-element-upload-button as-button as-is-primary" data-src="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'Y') ? (isset($element->video_preview_img_src) ? $element->video_preview_img_src : '') : '' ?>" data-alt="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'Y') ? (isset($element->video_preview_img_alt) ? $element->video_preview_img_alt : '') : '' ?>" data-is-preview="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'Y') ? (isset($element->video_is_preview_set) ? $element->video_is_preview_set : '') : '' ?>" type="button" value="<?php _e('Set Preview', AIRSLIDER_TEXTDOMAIN) ?>" />&nbsp;&nbsp;
                                <input class="as-remove-preview-image-element-upload-button as-button as-is-danger" type="button" value="<?php _e('Remove Preview', AIRSLIDER_TEXTDOMAIN) ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Set the preivew image for video and remove preview image on select remove preview button.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
                        <!-- Youtube block end -->
                        
                        <!-- Vimeo block start -->
			<tr class="as-vimeo-search as-video-search" <?php echo $vimeo_style; ?>>
                            <td class="as-name"><?php _e('Enter Vimeo ID or URL ', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-vimeo-video-link" type="text" value="<?php echo (!$void && isset($element->video_type) && $element->video_type=='V') ? (isset($element->video_link) ? $element->video_link : '') : '' ?>" />
                                <a href="javascript:void(0);" class="as-button as-is-primary as-search-vimeo-video"><?php _e('Search', AIRSLIDER_TEXTDOMAIN); ?></a>
                            </td>
                            <td class="as-description">
                                <?php _e('example: 6370469 ', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
                        
                        <tr class="as-video-block as-vimeo-option" <?php echo $vimeo_style; ?>>
                            <td class="as-name as-label-for" data-label-for=".as-element-video-full-width"><?php _e('Full Width', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <?php
                                $vm_full_width = $video_wh = '';

                                if(!$void && isset($element->video_type) && $element->video_type == 'V' && isset($element->video_full_width) && $element->video_full_width == 'Y')
                                {
                                    $vm_full_width = 'checked="checked"';
                                    $video_wh = 'style="display:none;"';
                                }
                                ?>

                                <input class="as-element-video-full-width" type="checkbox" value="Y" <?php echo $vm_full_width; ?> />

                                <!-- video width -->
                                <label <?php echo $video_wh; ?> class="as-video-wh"><?php _e('Width', AIRSLIDER_TEXTDOMAIN); ?> &nbsp;&nbsp;<input class="as-element-video-width" type="text" value="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'V') ? (isset($element->video_width) ? $element->video_width : '320') : '320' ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('px', AIRSLIDER_TEXTDOMAIN); ?></label>

                                <!-- video height -->
                                <label <?php echo $video_wh; ?> class="as-video-wh"><?php _e('Height', AIRSLIDER_TEXTDOMAIN); ?> &nbsp;&nbsp;<input class="as-element-video-height" type="text" value="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'V') ? (isset($element->video_height) ? $element->video_height : '240') : '240' ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('px', AIRSLIDER_TEXTDOMAIN); ?></label>
                            </td>
                            <td class="as-description">
                                <?php _e('Checked full width checkbox for get full width video which will neglate width and height which you have enter. If full width is not checked then video will take width and height from textbox.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
			<tr class="as-video-block as-vimeo-option" <?php echo $vimeo_style; ?>>
                            <td class="as-name"><?php _e('Set Preview image', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-preview-image-element-upload-button as-button as-is-primary" data-src="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'V') ? (isset($element->video_preview_img_src) ? $element->video_preview_img_src : '') : '' ?>" data-alt="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'V') ? (isset($element->video_preview_img_alt) ? $element->video_preview_img_alt : '') : '' ?>" data-is-preview="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'V') ? (isset($element->video_is_preview_set) ? $element->video_is_preview_set : '') : '' ?>" type="button" value="<?php _e('Set Preview', AIRSLIDER_TEXTDOMAIN) ?>" />&nbsp;&nbsp;
                                <input class="as-remove-preview-image-element-upload-button as-button as-is-danger" type="button" value="<?php _e('Remove Preview', AIRSLIDER_TEXTDOMAIN) ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Set the preivew image for video and remove preview image on select remove preview button.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
                        <!-- Vimeo block end -->
                        
                        <!-- Html5 block start -->
                        <tr class="html5_search as-video-search" <?php echo $html5_style; ?>>
                            <td class="as-name"><?php _e('Enter Poster Image Url', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-html5-poster-url" type="text" value="<?php echo (!$void && isset($element->video_type) && $element->video_type=='H') ? (isset($element->video_html5_poster_url) ? $element->video_html5_poster_url : '') : '' ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Example: http://video-js.zencoder.com/oceans-clip.png', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
			<tr class="html5_search as-video-search" <?php echo $html5_style; ?>>
                            <td class="as-name as-no-border"><?php _e('Enter MP4 Url', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content as-no-border">
                                <input class="as-element-html5-mp4-video-link" type="text" value="<?php echo (!$void && isset($element->video_type) && $element->video_type=='H') ? (isset($element->video_html5_mp4_video_link) ? $element->video_html5_mp4_video_link : '') : '' ?>" />
                            </td>
                            <td class="as-description as-no-border">
                                <?php _e('Example: http://video-js.zencoder.com/oceans-clip.mp4', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
			<tr class="html5_search as-video-search" <?php echo $html5_style; ?>>
                            <td class="as-name as-no-border"><?php _e('Enter WEBM Url', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content as-no-border">
                                <input class="as-element-html5-webm-video-link" type="text" value="<?php echo (!$void && isset($element->video_type) && $element->video_type=='H') ? (isset($element->video_html5_webm_video_link) ? $element->video_html5_webm_video_link : '') : '' ?>" />
                            </td>
                            <td class="as-description as-no-border">
                                <?php _e('Example: http://video-js.zencoder.com/oceans-clip.webm', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
			<tr class="html5_search as-video-search" <?php echo $html5_style; ?>>
                            <td class="as-name"><?php _e('Enter OGV Url', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-html5-ogv-video-link" type="text" value="<?php echo (!$void && isset($element->video_type) && $element->video_type=='H') ? (isset($element->video_html5_ogv_video_link) ? $element->video_html5_ogv_video_link : '') : '' ?>" />
                                <br/>
                                <a href="javascript:void(0);" class="as-button as-is-primary search_html5_video mt5"><?php _e('Search', AIRSLIDER_TEXTDOMAIN); ?></a>
                            </td>
                            <td class="as-description">
                                <?php _e('Example: http://video-js.zencoder.com/oceans-clip.ogv', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
                        
                        <tr class="as-video-block as-html5-option" <?php echo $html5_style; ?>>
                            <td class="as-name as-label-for" data-label-for=".as-element-video-full-width"><?php _e('Full Width', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <?php
                                $h5_full_width = $video_wh = '';

                                if(!$void && isset($element->video_type) && $element->video_type == 'H' && isset($element->video_full_width) && $element->video_full_width == 'Y')
                                {
                                    $h5_full_width = 'checked="checked"';
                                    $video_wh = 'style="display:none;"';
                                }
                                ?>

                                <input class="as-element-video-full-width" type="checkbox" value="Y" <?php echo $h5_full_width; ?> />

                                <!-- video width -->
                                <label <?php echo $video_wh; ?> class="as-video-wh"><?php _e('Width', AIRSLIDER_TEXTDOMAIN); ?> &nbsp;&nbsp;<input class="as-element-video-width" type="text" value="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'H') ? (isset($element->video_width) ? $element->video_width : '320') : '320' ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('px', AIRSLIDER_TEXTDOMAIN); ?></label>

                                <!-- video height -->
                                <label <?php echo $video_wh; ?> class="as-video-wh"><?php _e('Height', AIRSLIDER_TEXTDOMAIN); ?> &nbsp;&nbsp;<input class="as-element-video-height" type="text" value="<?php echo (!$void && isset($element->video_type) && $element->video_type == 'H') ? (isset($element->video_height) ? $element->video_height : '240') : '240' ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('px', AIRSLIDER_TEXTDOMAIN); ?></label>
                            </td>
                            <td class="as-description">
                                <?php _e('Checked full width checkbox for get full width video which will neglate width and height which you have enter. If full width is not checked then video will take width and height from textbox.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
			</tr>
                        <!-- Html5 block end -->
                        
                        <tr>
                            <td class="as-name"><?php _e('Left', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-left" type="text" value="<?php echo ($void) ? '0' : (isset($element->data_left) ? $element->data_left : '0') ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('px', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('Left distance in px from the start width.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Top', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-top" type="text" value="<?php echo ($void) ? '0' : (isset($element->data_top) ? $element->data_top : '0') ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('px', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('Top distance in px from the start height.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Z - index', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-z-index" type="number" min="0" value="<?php echo ($void) ? '1' : (isset($element->z_index) ? $element->z_index : '1'); ?>" onkeypress="return isNumberKey(event);" />
                            </td>
                            <td class="as-description">
                                <?php _e('An element with an high z-index will cover an element with a lower z-index if they overlap.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="as-element-type-block as-ele-video-animation-parameter">
                <table class="as-element-settings-list as-text-element-settings-list as-table">
                    <tbody>
			<tr>
                            <td class="as-name"><?php _e('Delay', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-delay" type="text" value="<?php echo ($void) ? '0' : (isset($element->data_delay) ? $element->data_delay : '0'); ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('How long will the element wait before the entrance. Default:0ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Time', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-time" type="text" value="<?php echo ($void) ? 'all' : (isset($element->data_time) ? $element->data_time : 'all') ?>" />&nbsp;<?php _e('ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('How long will the element be displayed during the slide execution. Write "all" to set the entire time. Default:all', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('In Animation', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <select class="as-element-data-in">
                                    <?php
                                    foreach($animations as $key => $value) {
                                        echo '<option value="' . $key . '"';
                                        if(($void && $value[1]) || (!$void && isset($element->data_in) && $element->data_in == $key)) {
                                            echo ' selected';
                                        }
                                        echo '>' . $value[0] . '</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                            <td class="as-description">
                                <?php _e('The in animation of the element.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Out Animation', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <select class="as-element-data-out">
                                    <?php
                                    foreach($animations as $key => $value) {
                                        echo '<option value="' . $key . '"';
                                        if(($void && $value[1]) || (!$void && isset($element->data_out) && $element->data_out == $key)) {
                                            echo ' selected';
                                        }
                                        echo '>' . $value[0] . '</option>';
                                    }
                                    ?>
                                </select>
                                <br />
                                <label><input class="as-element-data-ignoreEaseOut" type="checkbox" <?php echo (!$void) ? 'checked="checked"' : '' ?> /><?php _e('Disable synchronization with slide out animation', AIRSLIDER_TEXTDOMAIN) ?></label>
                            </td>
                            <td class="as-description">
                                <?php _e('The out animation of the element.<br /><br />Disable synchronization with slide out animation: if not checked, the slide out animation won\'t start until all the elements that have this option unchecked are animated out.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Ease In', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-easeIn" type="text" value="<?php echo ($void) ? '300' : (isset($element->data_easeIn) ? $element->data_easeIn : '300') ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('How long will the in animation take. Default:300ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Ease Out', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-data-easeOut" type="text" value="<?php echo ($void) ? '300' : (isset($element->data_easeOut) ? $element->data_easeOut : '300') ?>" onkeypress="return isNumberKey(event);" />&nbsp;<?php _e('ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                            <td class="as-description">
                                <?php _e('How long will the out animation take. Default:300ms', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="as-element-type-block as-ele-video-advanced-parameter">
                <table class="as-element-settings-list as-text-element-settings-list as-table">
                    <tbody>
                        <tr>
                            <td class="as-name"><?php _e('Attribute ID', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-id" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_id) ? $element->attr_id : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add ID attribute to element.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Attribute Classes', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-class" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_class) ? $element->attr_class : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Class attribute to element.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Attribute Title', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-title" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_title) ? $element->attr_title : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Title attribute to element.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Attribute Rel', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <input class="as-element-attr-rel" type="text" value="<?php echo ($void) ? '' : (isset($element->attr_rel) ? $element->attr_rel : ''); ?>" />
                            </td>
                            <td class="as-description">
                                <?php _e('Add Rel attribute to element.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="as-name"><?php _e('Custom CSS', AIRSLIDER_TEXTDOMAIN); ?></td>
                            <td class="as-content">
                                <textarea class="as-element-custom-css"><?php echo ($void) ? '' : (isset($element->custom_css) ? stripslashes($element->custom_css) : '')?></textarea>
                            </td>
                            <td class="as-description">
                                <?php _e('Style the element.', AIRSLIDER_TEXTDOMAIN); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
	<?php
    }
}
?>