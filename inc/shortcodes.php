<?php
/**
 * Razzo shortcodes
 *
 * @package WordPress
 * @subpackage Razzo
 * @since Razzo 1.0
 */

// Actual processing of the shortcode happens here
function pre_process_shortcode( $content ) {
    global $shortcode_tags;
 
    // Backup current registered shortcodes and clear them all out
    $orig_shortcode_tags = $shortcode_tags;
    remove_all_shortcodes();
 
    add_shortcode( 'one_half', 'mega_one_half' );
	add_shortcode( 'one_third', 'mega_one_third' );
	add_shortcode( 'two_third', 'mega_two_third' );
	add_shortcode( 'one_fourth', 'mega_one_fourth' );
	add_shortcode( 'three_fourth', 'mega_three_fourth' );
	add_shortcode( 'button', 'mega_button' );
	add_shortcode( 'accordion', 'mega_accordion' );
	add_shortcode( 'tabgroup', 'mega_tabgroup' );
	add_shortcode( 'dropcap', 'mega_dropcap' );
	add_shortcode( 'highlight', 'mega_highlight' );
	add_shortcode( 'hr', 'mega_hr' );
	add_shortcode( 'map', 'mega_map' );
	add_shortcode( 'recent_posts', 'mega_recent_posts' );
 
    // Do the shortcode (only the one above is registered)
    $content = do_shortcode( $content );
 
    // Put the original shortcodes back
    $shortcode_tags = $orig_shortcode_tags;
 
    return $content;
}
add_filter( 'the_content', 'pre_process_shortcode', 7 );

/*
 * Column Shortcodes
 */
function mega_one_half( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'last' => ''
    ), $atts ) );
	
	if ( $last == 'true' ) {
		return '<div class="column one-half column-last">' . do_shortcode( $content ) . '</div>';
	} else {
		return '<div class="column one-half">' . do_shortcode( $content ) . '</div>';
	}
}
add_shortcode( 'one_half', 'mega_one_half' );

function mega_one_third( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'last' => ''
    ), $atts ) );
	
	if ( $last == 'true' ) {
		return '<div class="column one-third column-last">' . do_shortcode( $content ) . '</div>';
	} else {
		return '<div class="column one-third">' . do_shortcode( $content ) . '</div>';
	}
}
add_shortcode( 'one_third', 'mega_one_third' );

function mega_two_third( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'last' => ''
    ), $atts ) );
	
	if ( $last == 'true' ) {
		return '<div class="column two-third column-last">' . do_shortcode( $content ) . '</div>';
	} else {
		return '<div class="column two-third">' . do_shortcode( $content ) . '</div>';
	}
}
add_shortcode( 'two_third', 'mega_two_third' );

function mega_one_fourth( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'last' => ''
    ), $atts ) );
	
	if ( $last == 'true' ) {
		return '<div class="column one-fourth column-last">' . do_shortcode( $content ) . '</div>';
	} else {
		return '<div class="column one-fourth">' . do_shortcode( $content ) . '</div>';
	}
}
add_shortcode( 'one_fourth', 'mega_one_fourth' );

function mega_three_fourth( $atts, $content = null ) {
   extract( shortcode_atts( array(
		'last' => ''
    ), $atts ) );
	
	if ( $last == 'true' ) {
		return '<div class="column three-fourth column-last">' . do_shortcode( $content ) . '</div>';
	} else {
		return '<div class="column three-fourth">' . do_shortcode( $content ) . '</div>';
	}
}
add_shortcode( 'three_fourth', 'mega_three_fourth' );

/*
 * Buttons
 */
function mega_button( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'url' => '#',
		'target' => '_self',
		'style' => 'white',
		'size' => 'small',
		'window' => ''
    ), $atts ) );
	
	if ( $window == 'true' ) {
		$target = 'target="_blank"';
	} else {
		$target = 'target="_self"';
	}
	
   return '<a class="button '. $size .' '. $style .'"'. $target .' href="'. $url .'">' . do_shortcode( $content ) . '</a>';
}
add_shortcode( 'button', 'mega_button' );

/*
 * jQuery UI Accordion
 */
function mega_accordion( $atts, $content = null ) {
		
        extract( shortcode_atts( array(
		'collapsible' => true,
		'framed' => false,
		'type' => '1'
		), $atts ) );
        
		if ( !preg_match_all( "/(.?)\[(section)\b(.*?)(?:(\/))?\](?:(.+?)\[\/section\])?(.?)/s", $content, $matches ) ) {
			return do_shortcode( $content );
		} else {
		
			$output = '';
		
			for ( $i = 0; $i < count( $matches[0]); $i++ ) {
				$matches[3][$i] = shortcode_parse_atts( $matches[3][$i] );
			}
			
			for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
				$output .= '<h2><a href="#">' . $matches[3][$i]['title'] . '</a></h2>
							<div>' . do_shortcode( $matches[5][$i] ) . '</div>';
			}
			
			$addClassCollapsible = '';
			if ( $collapsible == 'true' ) $addClassCollapsible = '_collapsible';
			
			$addClassFramed = '';
			if ( $framed == 'true' ) $addClassFramed = 'framed';
			
			$addClassType = '';
			if ( $type == '1' ) {
				$addClassType = 'default-type';
			} else if ( $type == '2' ) {
				$addClassType = 'faq-type';
			}
			
			return '<div class="accordion'. $addClassCollapsible .' '. $addClassFramed .' '. $addClassType .'">' . $output . '</div>';
		}
		
}
add_shortcode( 'accordion', 'mega_accordion' );

/*
 * jQuery UI Tabs
 */
function mega_tabgroup( $atts, $content = null ) {

	extract( shortcode_atts( array(), $atts));

	if ( !preg_match_all( "/(.?)\[(tab)\b(.*?)(?:(\/))?\](?:(.+?)\[\/tab\])?(.?)/s", $content, $matches ) ) {
			return do_shortcode( $content );
	} else {
	
		$output = '';
		
			for ( $i = 0; $i < count( $matches[0]); $i++ ) {
				$matches[3][$i] = shortcode_parse_atts( $matches[3][$i] );
			}
			
			$output .= '<ul class="tabs">';
			
			for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
				$output .= '<li><a href="#tabs-'. $i .'">' . $matches[3][$i]['title'] . '</a></li>';
			}
			
			$output .= '</ul>';
			
			$output .= '<div class="ui-tabs-panel-wrapper clearfix">';
			
			for($i = 0; $i < count($matches[0]); $i++) {
				$output .= '<div id="tabs-'. $i .'">' . do_shortcode( $matches[5][$i] ) . '</div>';
			}
			
			$output .= '</div>';
			
			return '<div class="tabs clearfix">' . $output . '</div>';
		}
	
}
add_shortcode( 'tabgroup', 'mega_tabgroup' );

/*
 * Dropcaps
 */

if ( ! function_exists( 'mega_dropcap' ) )
{
	function mega_dropcap( $atts, $content, $shortcodename ) {
		
		$output  = '<span class="' . $shortcodename . '">';
		$output .= $content;
		$output .= '</span>';	
		
		return $output;
	}
	add_shortcode( 'dropcap', 'mega_dropcap' );
}

/*
 * Highlights
 */
function mega_highlight( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'background' => 'yellow',
			'color' => '#111111'
		), $atts ) );
		
		return '<span class="highlight" style="background: '. $background .'; color: '. $color .'">'. do_shortcode( $content ) .'</span>';

}
add_shortcode( 'highlight', 'mega_highlight' );

/*
 * hr
 */
if ( ! function_exists( 'mega_hr' ) ) {
	function mega_hr( $atts, $content, $shortcodename ) {
		extract( shortcode_atts( array(
			'top' => 'false'
		), $atts ) );
	
		$output = '';
	
		if ( $top == 'true' ) $output .= '<p class="to-top clearfix"><small><a class="to-top" href="#">[top]</a></small></p>';
		
		$output .= '<hr class="'. $shortcodename .'" />';
	
		return $output;
	}
	add_shortcode( 'hr', 'mega_hr' );
}

/*
 * Google Maps
 */
if ( ! function_exists( 'mega_map' ) ) {
	function mega_map( $atts = null, $content = null ) {
		extract( shortcode_atts( array(
			'width' => '100%',
			'height' => '300',
			'zoom' => '8',
			'type' => 'ROADMAP'
		), $atts ) );
		
		STATIC $map_id = 0;
		$map_id++;
		
		$output = '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>';
		$output .= '<script>';
		$output .= 'jQuery(document).ready(function(){';
		
		$output .= 'var stylez'. $map_id .' = [';
			$output .= '{';
				$output .= 'featureType: "all",';
				$output .= 'elementType: "all",';
				$output .= 'stylers: [';
					$output .= '{ saturation: -100 }';
				$output .= ']';
			$output .= '}';
		$output .= '];';
		
		// Map Options
		$output .= 'var mapOptions'. $map_id .' = {';
		$output .= 'scrollwheel: false,';
		$output .= 'zoom: '. $zoom .',';
		$output .= 'controls: [],';
		$output .= 'draggable: false,';
		
		$output .= 'mapTypeId: google.maps.MapTypeId.'. $type;
		$output .= '};';
		
		// The Map Object
		$output .= 'var map'. $map_id .' = new google.maps.Map(document.getElementById("map-'. $map_id .'"), mapOptions'. $map_id .');';
		
		if ( !preg_match_all( '/(.?)\[(marker)\b(.*?)(?:(\/))?\](?:(.+?)\[\/marker\])?(.?)/s', $content, $matches ) ) {
	
			// Don't do anything if there are no markers.

		} else {
				
			for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
			
				$options = explode( '"', $matches[0][$i] );
				$address = $options[1];
			
				$search_string = $matches[0][$i];
				$url_search = str_replace( '[/marker]', '', $search_string );
				$info_content = substr( $url_search, strpos( $url_search, ']' ) + 1, strlen( $url_search ) );
				$info_content = trim( $info_content );
		
				$output .= 'var address'. $map_id .' = "";';
				$output .= 'var geocoder'. $map_id .' = new google.maps.Geocoder();';
				$output .= 'geocoder'. $map_id .'.geocode({ "address" : "'. $address .'" }, function (results, status) {';
					$output .= 'if (status == google.maps.GeocoderStatus.OK) {';
						$output .= 'address'. $map_id .' = results[0].geometry.location;';
						
						$output .= 'map'. $map_id .'.setCenter(results[0].geometry.location);';
						
						$output .= 'var marker'. $map_id .' = new google.maps.Marker({';
						$output .= 'position: address'. $map_id .','; 
						$output .= 'map: map'. $map_id .',';
						$output .= 'clickable: true,';
						$output .= 'animation: google.maps.Animation.DROP';
						$output .= '});'; 
						
						$output .= 'var infowindow'. $map_id .' = new google.maps.InfoWindow({ content: "'. $info_content .'" });';
						$output .= 'google.maps.event.addListener(marker'. $map_id .', "click", function() {';
						$output .= 'infowindow'. $map_id .'.open(map'. $map_id .', marker'. $map_id .');';
						$output .= '});';
						
					$output .= '}';
				$output .= '});';
			}
		}
		
		$output .= 'var mapType'. $map_id .' = new google.maps.StyledMapType(stylez'. $map_id .', { name:"Grayscale" });';
		$output .= 'map'. $map_id .'.mapTypes.set("gray", mapType'. $map_id .');';
		$output .= 'map'. $map_id .'.setMapTypeId("gray");';
		
		$output .= '});';
		$output .= '</script>';
		
		$output .= '<div id="map-'. $map_id .'" class = "map" style = "width: '. $width .'px; height: '. $height .'px;"></div>';
		
		return $output;
	}
	add_shortcode( 'map', 'mega_map' );
}

/*
 * Team
 */
function mega_person( $atts, $content = null ) {
	 extract( shortcode_atts( array(
			'image' => '',
			'name' => '',
			'title' => '',
			'facebook' => '',
	   		'twitter' => '',
			'google_plus' => '',
			'linkedin' => '',
			'dribbble' => '',
			'pinterest' => '',
			'foursquare' => '',
			'instagram' => '',
			'vimeo' => '',
			'flickr' => '',
			'github' => '',
			'tumblr' => '',
			'forrst' => '',
			'lastfm' => '',
			'stumbleupon' => '',
		), $atts ) ); 
		
	$output = '';
	$output .= '<div class="person">';
	$output .= '<div class="person-img-wrapper clearfix">';
		$output .= '<img class="person-img" src="' . $image . '" alt="' . $name . '" />';
	$output .= '</div>';
		$output .= '<div class="person-desc">';
			$output .= '<div class="person-author clearfix">';
				$output .= '<div class="person-author-wrapper"><h2 class="person-name">' . $name . '</h2>';
				$output .= '<span class="person-title">' . $title . '</span></div>';
				
			$output .= '</div>';
			$output .= '<div class="person-content">' . $content . '</div>';
			
			$output .= '<ul class="clearfix">';
				
				if ( ! empty( $facebook ) ) {
					$output .= '<li class="social-icon"><a href="' . $facebook . '">
						<span class="facebook social-icon"></span>
					</a></li>';
				}
					
				if ( ! empty( $twitter ) ) {
					$output .= '<li class="social-icon"><a href="' . $twitter . '">
						<span class="twitter social-icon"></span>
					</a></li>';
				}
				
				if ( ! empty( $google_plus ) ) {
					$output .= '<li class="social-icon"><a href="' . $google_plus . '">
						<span class="gplus social-icon"></span>
					</a></li>';
				}
					
				if ( ! empty( $linkedin ) ) {
					$output .= '<li class="social-icon"><a href="' . $linkedin . '">
						<span class="linkedin social-icon"></span>
					</a></li>';
				}
					
				if ( ! empty( $dribbble ) ) {
					$output .= '<li class="social-icon"><a href="' . $dribbble . '">
						<span class="dribbble social-icon"></span>
					</a></li>';
				}
				
				if ( ! empty( $pinterest ) ) {
					$output .= '<li class="social-icon"><a href="' . $pinterest . '">
						<span class="pinterest social-icon"></span>
					</a></li>';
				}
				
				if ( ! empty( $foursquare ) ) {
					$output .= '<li class="social-icon"><a href="' . $foursquare . '">
						<span class="foursquare social-icon"></span>
					</a></li>';
				}
				
				if ( ! empty( $instagram ) ) {
					$output .= '<li class="social-icon"><a href="' . $instagram . '">
						<span class="instagram social-icon"></span>
					</a></li>';
				}
				
				if ( ! empty( $vimeo ) ) {
					$output .= '<li class="social-icon"><a href="' . $vimeo . '">
						<span class="vimeo social-icon"></span>
					</a></li>';
				}
				
				if ( ! empty( $flickr ) ) {
					$output .= '<li class="social-icon"><a href="' . $flickr . '">
						<span class="flickr social-icon"></span>
					</a></li>';
				}
				
				if ( ! empty( $github ) ) {
					$output .= '<li class="social-icon"><a href="' . $github . '">
						<span class="github social-icon"></span>
					</a></li>';
				}
				
				if ( ! empty( $tumblr ) ) {
					$output .= '<li class="social-icon"><a href="' . $tumblr . '">
						<span class="tumblr social-icon"></span>
					</a></li>';
				}
				
				if ( ! empty( $forrst ) ) {
					$output .= '<li class="social-icon"><a href="' . $forrst . '">
						<span class="forrst social-icon"></span>
					</a></li>';
				}
				
				if ( ! empty( $lastfm ) ) {
					$output .= '<li class="social-icon"><a href="' . $lastfm . '">
						<span class="lastfm social-icon"></span>
					</a></li>';
				}
				
				if ( ! empty( $stumbleupon ) ) {
					$output .= '<li class="social-icon"><a href="' . $stumbleupon . '">
						<span class="stumbleupon social-icon"></span>
					</a></li>';
				}
				
			$output .= '</ul>';
		$output .= '</div>';
	$output .= '</div><!-- .person -->';

	return $output;
}
add_shortcode( 'person', 'mega_person' );

/*
 * Recent Posts
 */
function mega_recent_posts( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'number' => '2'
		), $atts ) ); 
	$output = '';
	$output .= '<ul class="recent-posts clearfix">';
	
	$recent_posts = new WP_Query(array('posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true));
	
	if ( $recent_posts->have_posts() ) :
	
		/* Start the Loop */
		while ( $recent_posts->have_posts() ) : $recent_posts->the_post();
		
			ob_start();
			$output .= '<li><a href="'. get_permalink() .'">'. get_the_title() .'</a>';
		
			$output .= '<div class="entry-content">';
					$output .= get_the_excerpt();
			$output .= '</div>';
			
			$output .= '<div class="entry-meta">'. get_the_date( '', get_the_ID() ) .'</div>';
			
			$output .= '</li>';
			$output .= ob_get_contents(); 			
			ob_end_clean();
		
		endwhile;
	
	else :
	
		$output .= '<div class="entry-content clearfix">';
			$output .= '<p class="no-found">'. _e( 'No posts found, please add some posts', 'mega' ) .'</p>';
		$output .= '</div>';
	
	endif;
	
	$output .= '</ul>';

	return $output;
}
add_shortcode( 'recent_posts', 'mega_recent_posts' );

/*
 * Enable shortcodes in widget areas
 */
add_filter( 'widget_text', 'do_shortcode' );
 