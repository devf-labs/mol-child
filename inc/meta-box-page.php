<?php
/**
 * Define the custom box for pages.
 */
 
$prefix = 'mega_';

// RevSlider
if ( class_exists( 'RevSlider' ) ) {
	$slider = new RevSlider();
	$arrSliders = $slider->getArrSliders();
	$ids = array();
					
	foreach ( $arrSliders as $slider ) {

		$alias = $slider->getAlias();
		$ids[] = $alias;

	}
}

if ( empty( $ids ) ) {
	$ids = array( __( 'No slides found, please add some slides', 'mega' ) );
}
				
$meta_box_page_revolution = array(
	'id' => 'mega-meta-box-page-revolution',
	'title' =>  __( 'Revolution Slider Settings', 'mega' ),
	'page' => 'page',
	'context' => 'normal', 
	'priority' => 'default',
	'fields' => array(
		array( "name" => __( 'Revolution Slider', 'mega' ),
				"desc" => __( 'Choose Revolution Slider you would like to display.', 'mega' ),
				"id" => $prefix."revslider_alias",
				'type' => 'select',
				'std' => '',
				'options' => $ids
			),
	)
);


/**
 * Add metabox.
 */
add_action('admin_menu', 'mega_add_box_page');

function mega_add_box_page() {
	global $meta_box_page_revolution;
	add_meta_box($meta_box_page_revolution['id'], $meta_box_page_revolution['title'], 'mega_show_box_page_revolution', $meta_box_page_revolution['page'], $meta_box_page_revolution['context'], $meta_box_page_revolution['priority']);
}

function mega_show_box_page_revolution() {
	global $meta_box_page_revolution, $post;

	// Use nonce for verification
	echo '<input type="hidden" name="mega_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
 
	echo '<table class="form-table mega-custom-table">';
 
	foreach ( $meta_box_page_revolution['fields'] as $field ) {
		
		// get current post meta data
		if ( isset ( $field['id'] ) )
			$meta = get_post_meta( $post->ID, $field['id'], true );
		
		switch ( $field['type'] ) {
			
			//If Select	
			case 'select':
			
				echo '<tr>',
					'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="display:block; color:#666; margin:5px 0 0 0; line-height: 18px;">'. $field['desc'].'</span></label></th>',
					'<td>';
				echo '<select id="' . $field['id'] . '" name="'.$field['id'].'">';
				foreach ( $field['options'] as $option ) {
					echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
				}
				echo'</select>';
				echo '</td>',
				'</tr>';
			break;
	
		}
	}
	echo '</table>';
}

/**
 * Save data from meta box.
 */
add_action( 'save_post', 'mega_save_data_page' );

function mega_save_data_page($post_id) {
	global $meta_box_page_revolution;
 
	if ( isset( $_POST['mega_meta_box_nonce'] ) ) {
		// verify nonce
		if (!wp_verify_nonce($_POST['mega_meta_box_nonce'], basename(__FILE__))) {
			return $post_id;
		}
	 
		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}
	 
		// check permissions
		if ( 'page' == $_POST['post_type'] ) {
			if (!current_user_can('edit_page', $post_id)) {
				return $post_id;
			}
		} elseif ( !current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
		
		foreach ( $meta_box_page_revolution['fields'] as $field ) {
			if ( isset($field['id'] ) ) {
				$old = get_post_meta($post_id, $field['id'], true);
				$new = $_POST[$field['id']];
		 
				if ($new && $new != $old) {
					//update_post_meta($post_id, $field['id'], stripslashes(htmlspecialchars($new)));
					update_post_meta($post_id, $field['id'], stripslashes(html_entity_decode($new)));
				} elseif ('' == $new && $old) {
					delete_post_meta($post_id, $field['id'], $old);
				}
			}
		}
	}
}
