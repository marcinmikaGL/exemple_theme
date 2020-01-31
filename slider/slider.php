<?php
    $slidelink_2_metabox = array( 
        'id' => 'slidelink',
        'title' => 'Slide Link',
        'page' => array('slides'),
        'context' => 'normal',
        'priority' => 'default',
        'fields' => array(
     
                     
                    array(
                        'name'          => 'Slide URL',
                        'desc'          => '',
                        'id'                => 'wptuts_slideurl',
                        'class'             => 'wptuts_slideurl',
                        'type'          => 'text',
                        'rich_editor'   => 0,            
                        'max'           => 0             
                    ),
                    )
    );          
                 
    add_action('admin_menu', 'wptuts_add_slidelink_2_meta_box');
    function wptuts_add_slidelink_2_meta_box() {
     
        global $slidelink_2_metabox;        
     
        foreach($slidelink_2_metabox['page'] as $page) {
            add_meta_box($slidelink_2_metabox['id'], $slidelink_2_metabox['title'], 'wptuts_show_slidelink_2_box', $page, 'normal', 'default', $slidelink_2_metabox);
        }
    }
     
    // function to show meta boxes
    function wptuts_show_slidelink_2_box()  {
        global $post;
        global $slidelink_2_metabox;
        global $wptuts_prefix;
        global $wp_version;
         
        // Use nonce for verification
        echo '<input type="hidden" name="wptuts_slidelink_2_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
         
        echo '<table class="form-table">';
     
        foreach ($slidelink_2_metabox['fields'] as $field) {
            // get current post meta data
     
            $meta = get_post_meta($post->ID, $field['id'], true);
            
            if(!empty($field['std'])) { $field['std'] = '';} 
            
            echo '<tr>',
                    '<th style="width:20%"><label for="', $field['id'], '">', stripslashes($field['name']), '</label></th>',
                    '<td class="wptuts_field_type_' . str_replace(' ', '_', $field['type']) . '">';
            switch ($field['type']) {
                case 'text':
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" /><br/>', '', stripslashes($field['desc']);
                    break;
            }
            echo    '<td>',
                '</tr>';
        }
         
        echo '</table>';
    }   
     
    // Save data from meta box
    add_action('save_post', 'wptuts_slidelink_2_save');
    function wptuts_slidelink_2_save($post_id) {
        global $post;
        global $slidelink_2_metabox;
         
        // verify nonce
        if (!wp_verify_nonce($_POST['wptuts_slidelink_2_meta_box_nonce'], basename(__FILE__))) {
            return $post_id;
        }
     
        // check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
     
        // check permissions
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
         
        foreach ($slidelink_2_metabox['fields'] as $field) {
         
            $old = get_post_meta($post_id, $field['id'], true);
            $new = $_POST[$field['id']];
             
            if ($new && $new != $old) {
                if($field['type'] == 'date') {
                    $new = wptuts_format_date($new);
                    update_post_meta($post_id, $field['id'], $new);
                } else {
                    if(is_string($new)) {
                        $new = $new;
                    } 
                    update_post_meta($post_id, $field['id'], $new);
                     
                     
                }
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }
        }
    }
    ?>