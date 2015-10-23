<?php
/********************/
/** AJAX CALLBACKS **/
/********************/

/**
 * Add slider
 * 
 * @param array $_POST['datas'] which contain the slider name,alias and slider setting options
 * 
 * @return array/boolean/duplicate word last inserted slider id or status of insert/select operation or data is duplicate
*/
add_action('wp_ajax_airslider_addSlider', 'airslider_addSlider_callback');
function airslider_addSlider_callback() {
    
    global $wpdb;
    
    $options = $_POST['datas'];
    $table_name = $wpdb->prefix . 'air_sliders';
    $output = true;

    foreach ($options as $option) {

        //Get slider information which are already exists
        $slider_detail = $wpdb->get_results("SELECT * FROM $table_name where alias = '".trim($option['alias'])."'", ARRAY_A);
        if($slider_detail){

            $rowcount = $wpdb->num_rows;
            //Check slider already exists
            if($rowcount > 0){
                $output = 'duplicate';
            }
        }
        else
        {
            //insert slider
            $slider_option = json_decode(stripslashes($option['slider_option']));
            $slider_option = maybe_serialize($slider_option);
            $output = $wpdb->insert(
                $table_name,
                array(
                    'name' => trim($option['name']),
                    'alias' => $option['alias'],
                    'slider_option' => $slider_option,
                )
            );
            if($output !== false){
                $output = $wpdb->insert_id;
            }
        }
    }
    // Returning
    $output = json_encode($output);
    if(is_array($output))
        print_r($output);
    else 
        echo $output;

    die();
}

/**
 * Edit slider
 * 
 * @param array $_POST['datas'] which contain the slider name,alias and slider setting options
 * 
 * @return array/boolean status of update operation
*/
add_action('wp_ajax_airslider_editSlider', 'airslider_editSlider_callback');
function airslider_editSlider_callback() {
    
    global $wpdb;
   
    $options = $_POST['datas'];
    $table_name = $wpdb->prefix . 'air_sliders';
    $output = true;
    
    foreach ($options as $option) {

        //Get slider information which are already exists
        $slider_detail = $wpdb->get_results("SELECT * FROM $table_name where alias = '".trim($option['alias'])."' AND id <> ".$option['id'], ARRAY_A);

        if($slider_detail){
            $rowcount = $wpdb->num_rows;

            //check slider already exists
            if($rowcount > 0){
                $output = 'duplicate';
            }
        } 
        else
        {
            //update slider
            $slider_option = json_decode(stripslashes($option['slider_option']));
            $slider_option = maybe_serialize($slider_option);
            $output = $wpdb->update(
                $table_name,
                array(
                    'name' => trim($option['name']),
                    'alias' => $option['alias'],
                    'slider_option' => $slider_option,
                ),
                array('id' => $option['id'])
            );
            if($output !== false){
                $output = trim($option['name']);
            }
        }
    }

    // Returning
    $output = json_encode($output);
    if(is_array($output))
        print_r($output);
    else
        echo $output;

    die();
}

/**
 * Add/Edit slides and elements
 * 
 * @param array $_POST['datas'] which contain the slide's information and element setting
 * 
 * @return array/boolean status of insert/update operation
*/
add_action('wp_ajax_airslider_editSlide', 'airslider_editSlide_callback');
function airslider_editSlide_callback() {
    
    global $wpdb;
    
    $options = $_POST['datas'];
    $table_name = $wpdb->prefix . 'air_slides';
    $output = $real_output = true;

    // It's impossible to have 0 slides (jQuery checks it)
    // Insert row per row
    foreach($options as $option) {

        $slide_id = $option['slide_id'];
        $params = maybe_serialize($option['slide']);

        $layers = '';
        if(isset($option['layers'])){
            $layers = json_decode(stripslashes($option['layers']));
            $layers = maybe_serialize($layers);
        }

        if($slide_id == 0){
            $output = $wpdb->insert(
                $table_name,
                array(
                    'slider_parent' => $option['slider_parent'],
                    'position' => $option['position'],
                    'params' => $params,
                    'layers' => $layers
                )
            );
            if($output !== false){
                $output = $wpdb->insert_id;
            }
        }
        else
        {
            $output = $wpdb->update(
                $table_name,
                array(
                    'slider_parent' => $option['slider_parent'],
                    'position' => $option['position'],
                    'params' => $params,
                    'layers' => $layers
                ),
                array('id' => $slide_id)
            );
            if($output !== false){
                $output = 'update';
            }
        }
    }

    // Returning
    $output = json_encode($output);
    if(is_array($output))
        print_r($output);
    else
        echo $output;
    
    die();
}

/**
 * Delete slide
 * 
 * @param array $_POST['datas'] which contain the slides id
 * 
 * @return array/boolean status of delete operation
*/
add_action('wp_ajax_airslider_deleteSlide', 'airslider_deleteSlide_callback');
function airslider_deleteSlide_callback() {
    
    global $wpdb;
    
    $options = $_POST['datas'];
    $table_name = $wpdb->prefix . 'air_slides';
    $real_output = true;

    $output = $wpdb->delete($table_name, array('id' => $options['id']), array('%d'));
    if($output === false) {
        $real_output = false;
    }

    // Returning
    $real_output = json_encode($real_output);
    if(is_array($real_output))
        print_r($real_output);
    else
        echo $real_output;

    die();
}

/**
 * Update slides position
 * 
 * @param array $_POST['slide_pos_datas'] which contain the slides id
 * 
 * @return array/boolean status of update operation
*/
add_action('wp_ajax_airslider_updateSlidePos', 'airslider_updateSlidePos_callback');
function airslider_updateSlidePos_callback() {
    
    global $wpdb;
    
    $postion_options = $_POST['slide_pos_datas'];
    $table_name = $wpdb->prefix . 'air_slides';
    $output = true;

    //if all operation completed then update slides position
    if(count($postion_options) > 0){
        foreach($postion_options as $pos_option) {
            $output = $wpdb->update(
                $table_name,
                array(
                    'position' => $pos_option['position_pos'],
                ),
                array('id' => $pos_option['slide_id_pos'])
            );
            if($output !== false) {
                $output = true;
            }
        }
    }
    
    // Returning
    $output = json_encode($output);
    if(is_array($output))
        print_r($output);
    else
        echo $output;
    
    die();
}
/**
 * Delete slider, releated slides and elements
 * 
 * @param array $_POST['datas'] which contain the slider id
 * 
 * @return array/boolean status of delete operation
*/
add_action('wp_ajax_airslider_deleteSlider', 'airslider_deleteSlider_callback');
function airslider_deleteSlider_callback() {
    
    global $wpdb;
    
    $options = $_POST['datas'];
    $real_output = true;

    // Delete slider
    $table_name = $wpdb->prefix . 'air_sliders';		
    $output = $wpdb->delete($table_name, array('id' => $options['id']), array('%d'));
    if($output === false) {
        $real_output = false;
    }

    // Delete slides
    $table_name = $wpdb->prefix . 'air_slides';		
    $output = $wpdb->delete($table_name, array('slider_parent' => $options['id']), array('%d'));
    if($output === false) {
        $real_output = false;
    }

    // Returning
    $real_output = json_encode($real_output);
    if(is_array($real_output))
        print_r($real_output);
    else
        echo $real_output;

    die();
}
?>