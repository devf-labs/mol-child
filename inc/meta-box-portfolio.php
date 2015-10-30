<?php
/**
 * Define the custom box for Portfolios.
 */

$prefix = 'mega_';

$meta_box_portfolio = array(
	'id' => 'mega-meta-box-portfolio',
	'title' =>  __( 'Portfolio Settings', 'mega' ),
	'page' => 'portfolio',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
    	   'name' => __( 'Portfolio Client', 'mega' ),
    	   'desc' => __( "Enter the client's name", 'mega' ),
    	   'id' => $prefix.'portfolio_client',
    	   'type' => 'text',
    	   'std' => ''
    	),
    	array(
    	   'name' => __( 'Portfolio Date', 'mega' ),
    	   'desc' => __( 'Enter the date of the project achievement', 'mega' ),
    	   'id' => $prefix.'portfolio_date',
    	   'type' => 'text',
    	   'std' => ''
    	),    	
    	array(
    	   'name' => __( 'Portfolio URL', 'mega' ),
    	   'desc' => __( 'Enter the url of the project', 'mega' ),
    	   'id' => $prefix.'portfolio_url',
    	   'type' => 'text',
    	   'std' => ''
    	),
		array(
			'name' =>  __( 'Portfolio Type', 'mega' ),
			'desc' => __( "Select the portfolio's type", 'mega' ),
			'id' => $prefix.'portfolio_type',
			"type" => "select",
			'std' => __( 'Images', 'mega' ),
			'options' => array( 'Images', 'Video' )
		),
		array(
			'name' =>  __( 'Thumbnail width', 'mega' ),
			'desc' => __( "Select the portfolio's thumbnail width", 'mega' ),
			'id' => $prefix.'portfolio_thumbnail_width',
			'type' => "select",
			'std' => __( 'Images', 'mega' ),
			'options' => array( __( 'Small (25%)', 'mega' ), __( 'Medium (50%)', 'mega' ) )
		)
	)
);
 
$meta_box_portfolio_images = array(
	'id' => 'mega-meta-box-portfolio-images',
	'title' =>  __( 'Images Settings', 'mega' ),
	'page' => 'portfolio',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __( 'Enable Slideshow', 'mega' ),
			'desc' => __( 'Enable slideshow or not?', 'mega' ),
			'id' => $prefix.'portfolio_slideshow',
			'type' => "select",
			'std' => __( 'Yes', 'mega' ),
			'options' => array( __( 'Yes', 'mega' ), __( 'No', 'mega' ) )
    	),
		array(
    	   'name' => __( 'Slider Height', 'mega' ),
    	   'desc' => __( 'Customize height of slideshow.', 'mega' ),
    	   'id' => $prefix.'portfolio_slider_height',
    	   'type' => 'text',
    	   'std' => 600
    	),
		array(
			'name' => __( 'Uploads/Manage Images', 'mega' ),
			'desc' => __( "Here's the list of the images. Each image must be the same height and 719px (959px if slideshow is disabled) width.", 'mega' ),
			'type' => 'attachments',
			'std' => ''
		)		
	)	
);


$meta_box_portfolio_video = array(
	'id' => 'mega-meta-box-portfolio-video',
	'title' => __( 'Video Settings', 'mega' ),
	'page' => 'portfolio',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(	"desc" => __( 'Video sharing website:', 'mega' ),
				"type" => "info"
		),
		array(
			'name' => __( 'YouTube or Vimeo URL', 'mega' ),
			'desc' => __( 'Enter the YouTube or Vimeo URL here. <br/> http://www.youtube.com/watch?v=VIDEO_ID <br/>or<br/> http://vimeo.com/VIDEO_ID', 'mega' ),
			'id' => $prefix.'youtube_vimeo_url',
			'type' => 'text',
			'std' => ''
		),
		array(
			'name' => __( 'Embed Code', 'mega' ),
			'desc' => __( 'If you are using other video sharing website, paste the embed code here.', 'mega' ),
			'id' => $prefix . 'video_embed_code',
			'type' => 'textarea',
			'std' => ''
		),
		array(	"desc" => __( 'Aspect Ratio (default 16:9):', 'mega' ),
				"type" => "info"
		),
		array(
			'name' => __( 'Video Width', 'mega' ),
			'desc' => __( "Enter the video's width", 'mega' ),
			'id' => $prefix . 'video_ratio_width',
			'type' => 'text',
			'std' => ''
		),
		array(
			'name' => __( 'Video Height', 'mega' ),
			'desc' => __( "Enter the video's height", 'mega' ),
			'id' => $prefix . 'video_ratio_height',
			'type' => 'text',
			'std' => ''
		)
		
	)
);

$meta_box_portfolio_custom_url = array(
	'id' => 'mega-meta-box-portfolio-custom-url',
	'title' =>  __( 'Portfolio Custom URL', 'mega' ),
	'page' => 'portfolio',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
    	   'name' => __( 'Custom URL', 'mega' ),
    	   'desc' => __( 'If you want to link the portfolio item to a custom url, enter the url here', 'mega' ),
    	   'id' => $prefix.'portfolio_custom_url',
    	   'type' => 'text',
    	   'std' => ''
    	)
	)
);

/**
 * Add metabox .
 */
add_action( 'admin_menu', 'mega_add_boxes_portfolio' );
 
function mega_add_boxes_portfolio() {
	global $meta_box_portfolio, $meta_box_portfolio_images, $meta_box_portfolio_video, $meta_box_portfolio_custom_url;
	add_meta_box($meta_box_portfolio['id'], $meta_box_portfolio['title'], 'mega_show_box_portfolio', $meta_box_portfolio['page'], $meta_box_portfolio['context'], $meta_box_portfolio['priority']);
	add_meta_box($meta_box_portfolio_images['id'], $meta_box_portfolio_images['title'], 'mega_show_box_portfolio_images', $meta_box_portfolio_images['page'], $meta_box_portfolio_images['context'], $meta_box_portfolio_images['priority']);
	add_meta_box($meta_box_portfolio_video['id'], $meta_box_portfolio_video['title'], 'mega_show_box_portfolio_video', $meta_box_portfolio_video['page'], $meta_box_portfolio_video['context'], $meta_box_portfolio_video['priority']);
	add_meta_box($meta_box_portfolio_custom_url['id'], $meta_box_portfolio_custom_url['title'], 'mega_show_box_portfolio_custom_url', $meta_box_portfolio_custom_url['page'], $meta_box_portfolio_custom_url['context'], $meta_box_portfolio_custom_url['priority']);
}

/**
 * Callback function to show fields in meta box.
 */
function mega_show_box_portfolio() {
	global $meta_box_portfolio, $post;
 	
	echo '<p style="padding:10px 0 0 0;">'.__( 'Fill in the project details and select the type of portfolio. Set a featured image that will be used as the portfolio thumbnail. Each featured image must be <strong>236px (small thumbnail)</strong> or <strong>477px (medium thumbnail)</strong> width but can be any height. Note: The optimal height for your featured images is <strong>157px</strong> or <strong>319px</strong>.', 'mega' ).'</p>';
	// Use nonce for verification
	echo '<input type="hidden" name="mega_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
 
	echo '<table class="form-table mega-custom-table">';
 
	foreach ($meta_box_portfolio['fields'] as $field) {
	
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		switch ($field['type']) {
			
			//If Text
			case 'text':	
				echo '<tr style="border-top:1px solid #eeeeee;">',
					'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="display:block; color:#666; margin:5px 0 0 0; line-height:18px; ">'. $field['desc'].'</span></label></th>',
					'<td>';
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'],'" size="30" style="width:90%; margin-right: 20px; float:left;" />';
				echo '</td>',
				'</tr>';
			break;
 
			//If Select
			case 'select':
				echo '<tr style="border-top:1px solid #eeeeee;">',
					'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="display:block; color:#666; margin:5px 0 0 0; line-height: 18px;">'. $field['desc'].'</span></label></th>',
					'<td>';
				echo '<select id="' . $field['id'] . '" name="'.$field['id'].'">';
				foreach ($field['options'] as $option) {
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

function mega_show_box_portfolio_images() {
	global $meta_box_portfolio_images, $post;
 	
	echo '<p style="padding:10px 0 0 0;">'.__( 'These settings enable you to manage the images displayed in the portfolio. Upload your images and use "Manage Images" to edit, reorder and delete images.', 'mega' ).'</p>';
	// Use nonce for verification
	echo '<input type="hidden" name="mega_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
 
	echo '<table class="form-table mega-custom-table">';
 
	foreach ($meta_box_portfolio_images['fields'] as $field) {
	
		// get current post meta data
		if (isset ($field['id']))
			$meta = get_post_meta($post->ID, $field['id'], true);
			
		switch ($field['type']) {
		
			//If Select
			case 'select':	
				echo '<tr style="border-top:1px solid #eeeeee;">',
					'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="display:block; color:#666; margin:5px 0 0 0; line-height: 18px;">'. $field['desc'].'</span></label></th>',
					'<td>';
				echo '<select id="' . $field['id'] . '" name="'.$field['id'].'">';		
				foreach ($field['options'] as $option) {
					echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
				}
				echo'</select>';
				echo '</td>',
				'</tr>';	
			break;
		
			//If Text
			case 'text':
				echo '<tr style="border-top:1px solid #eeeeee;">',
					'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="display:block; color:#666; margin:5px 0 0 0; line-height:18px; ">'. $field['desc'].'</span></label></th>',
					'<td>';
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'],'" size="30" style="width:90%; margin-right: 20px; float:left;" />';
				echo '</td>',
				'</tr>';
			break;
			
			//If Attachments
			case 'attachments':
				echo '<tr style="border-top:1px solid #eeeeee;">',
				'<th style="width:25%"><label><strong>', $field['name'], '</strong><span style="display:block; color:#666; margin:5px 0 0 0; line-height: 18px;">'. $field['desc'].'</span></label></th>',
				'<td>';
				
				$args = array(
					'post_type' => 'attachment',
					'post_status' => 'inherit',
					'post_parent' => $post->ID,
					'post_mime_type' => 'image',
					'posts_per_page' => '-1',
					'order' => 'ASC',
					'orderby' => 'menu_order',
					'exclude' => get_post_thumbnail_id()
				);
				
				$intro = '<p><a href="media-upload.php?post_id=' . $post->ID .'&amp;type=image&amp;TB_iframe=1&amp;width=640&amp;height=715" id="add_images" class="thickbox" title="' . __( 'Upload Images', 'mega' ) . '">' . __( 'Upload Images', 'mega' ) . '</a> | <a href="media-upload.php?post_id=' . $post->ID .'&amp;type=image&amp;tab=gallery&amp;TB_iframe=1&amp;width=640&amp;height=715" id="manage_images" class="thickbox" title="' . __( 'Manage Images', 'mega' ) . '">' . __( 'Manage Images', 'mega' ) . '</a></p>';
				echo $intro;
				
				$return = '';
				$attachments = get_posts( $args );
				
					$return .= '<div class="mega_attachments">';
						if( empty( $attachments ) )
							$return .= '<p>'. __( 'No images.', 'mega' ). '</p>';
						else {
							foreach( $attachments as $image ):
								$thumbnail = wp_get_attachment_image_src( $image->ID, 'thumbnail');
								$return .= '<img style="margin-right:5px;" width="100" height="100" src="' . $thumbnail[0] . '" alt="' . apply_filters('the_title', $image->post_title). '"/>';
							endforeach;
						}
					$return .= '</div>';
				echo $return;
				
				echo '</td>',
				'</tr>';		
			break;
			
		}

	}
 
	echo '</table>';
}


function mega_show_box_portfolio_video() {
	global $meta_box_portfolio_video, $post;
 	
	echo '<p style="padding:10px 0 0 0;">'.__( 'These settings enable you to add video to your portfolio. You have the choice between YouTube, Vimeo or any other video sharing websites.', 'mega' ).'</p>';
	// Use nonce for verification
	echo '<input type="hidden" name="mega_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
 
	echo '<table class="form-table mega-custom-table">';
 
	foreach ($meta_box_portfolio_video['fields'] as $field) {
	
		// get current post meta data
		if (isset ($field['id']))
			$meta = get_post_meta($post->ID, $field['id'], true);
			
		switch ($field['type']) {
			
			//If Info
			case 'info':
				echo '<tr style="border-top:1px solid #eeeeee;">',
					'<th style="width:25%;"><span style="display:inline-block;margin:5px 0;font-weight:bold;text-transform:uppercase;border-bottom:1px solid #666;">'. $field['desc'].'<strong></th>',
					'<td></td></tr>';
			break;
			
			//If Text	
			case 'text':		
				echo '<tr style="border-top:1px solid #eeeeee;">',
					'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="display:block; color:#666; margin:5px 0 0 0; line-height:18px; ">'. $field['desc'].'</span></label></th>',
					'<td>';
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'],'" size="30" style="width:90%; margin-right: 20px; float:left;" />';
				echo '</td>',
				'</tr>';
			break;
			
			//If textarea		
			case 'textarea':
			
				echo '<tr style="border-top:1px solid #eeeeee;">',
					'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="display:block; color:#666; margin:5px 0 0 0; line-height: 18px;">'. $field['desc'].'</span></label></th>',
					'<td>';
				echo '<textarea name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'],'" rows="8" cols="5" style="width:90%; margin-right: 20px; float:left;">', $meta ? $meta : stripslashes(htmlspecialchars(( $field['std']), ENT_QUOTES)), '</textarea>';
				echo '</td>',
				'</tr>';
			break;
 
		}

	}
 
	echo '</table>';
}

function mega_show_box_portfolio_custom_url() {
	global $meta_box_portfolio_custom_url, $post;
 	
	// Use nonce for verification
	echo '<input type="hidden" name="mega_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
 
	echo '<table class="form-table mega-custom-table">';
 
	foreach ($meta_box_portfolio_custom_url['fields'] as $field) {
	
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);
		switch ($field['type']) { 
			
			//If Text		
			case 'text':			
				echo '<tr>',
					'<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style="display:block; color:#666; margin:5px 0 0 0; line-height:18px; ">'. $field['desc'].'</span></label></th>',
					'<td>';
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'],'" size="30" style="width:90%; margin-right: 20px; float:left;" />';
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
add_action( 'save_post', 'mega_save_data_portfolio' );
 
function mega_save_data_portfolio($post_id) {
	global $meta_box_portfolio, $meta_box_portfolio_images, $meta_box_portfolio_video, $meta_box_portfolio_custom_url;
 
	if ( isset($_POST['mega_meta_box_nonce'])) {
		// verify nonce
		if (!wp_verify_nonce($_POST['mega_meta_box_nonce'], basename(__FILE__))) {
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
		
				
		foreach ($meta_box_portfolio['fields'] as $field) {
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[$field['id']];
	 
			if ($new && $new != $old) {
				update_post_meta($post_id, $field['id'], stripslashes(htmlspecialchars($new)));
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		}
		
		foreach ($meta_box_portfolio_images['fields'] as $field) {
			if(isset($field['id'])){
				$old = get_post_meta($post_id, $field['id'], true);
				$new = $_POST[$field['id']];
		 
				if ($new && $new != $old) {
					update_post_meta($post_id, $field['id'], stripslashes(htmlspecialchars($new)));
				} elseif ('' == $new && $old) {
					delete_post_meta($post_id, $field['id'], $old);
				}
			}
		}
	 
		foreach ($meta_box_portfolio_video['fields'] as $field) {
			if(isset($field['id'])){
				$old = get_post_meta($post_id, $field['id'], true);
				$new = $_POST[$field['id']];
		 
				if ($new && $new != $old) {
					update_post_meta($post_id, $field['id'], stripslashes(htmlspecialchars($new)));
				} elseif ('' == $new && $old) {
					delete_post_meta($post_id, $field['id'], $old);
				}
			}
		}
		
		foreach ($meta_box_portfolio_custom_url['fields'] as $field) {
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[$field['id']];
	 
			if ($new && $new != $old) {
				update_post_meta($post_id, $field['id'], stripslashes(htmlspecialchars($new)));
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		}
		
	}
}