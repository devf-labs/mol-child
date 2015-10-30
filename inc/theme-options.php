<?php
/**
 * Initialize the custom theme options.
 */
add_action( 'admin_init', 'custom_theme_options' );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  
  /**
   * Custom settings array that will eventually be 
   * passed to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'sidebar'       => ''
    ),
    'sections'        => array( 
      array(
        'id'          => 'general',
        'title'       => 'General'
      ),
      array(
        'id'          => 'style',
        'title'       => 'Style'
      ),
      array(
        'id'          => 'homepage_settings',
        'title'       => 'Homepage Settings'
      ),
      array(
        'id'          => 'home_slider',
        'title'       => 'Home Slider'
      ),
      array(
        'id'          => 'portfolio_settings',
        'title'       => 'Portfolio Settings'
      ),
      array(
        'id'          => 'slider_settings',
        'title'       => 'Global Slider Settings'
      ),
      array(
        'id'          => 'blog',
        'title'       => 'Blog'
      ),
      array(
        'id'          => 'social',
        'title'       => 'Social Accounts'
      ),
      array(
        'id'          => 'contact_settings',
        'title'       => 'Contact Infos'
      ),
      array(
        'id'          => 'woocommerce_settings',
        'title'       => 'WooCommerce'
      )
    ),
    'settings'        => array( 
      array(
        'id'          => 'logo',
        'label'       => 'Logo',
        'desc'        => 'Upload a logo for your site.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'full_width_menu',
        'label'       => 'Full Width Menu',
        'desc'        => 'Enable full width menu or not?',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'yes',
            'label'       => 'Full Width Menu',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'favicon',
        'label'       => 'Favicon',
        'desc'        => 'Upload a favicon for your site.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'enable_top_bar',
        'label'       => 'Enable Top Bar',
        'desc'        => 'Enable top bar or not?',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'yes',
            'label'       => 'Enable Top Bar',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'top_bar_info',
        'label'       => 'Top Bar Info',
        'desc'        => 'Enter the info you would like to display in top bar of your site.',
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'header_info',
        'label'       => 'Header Info',
        'desc'        => 'Enter the info you would like to display in the header of your site.',
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'info_under_the_footer',
        'label'       => 'Info Under the Footer',
        'desc'        => '<p>Enter the info you would like to display under the footer of your site.</p>',
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'footer_info',
        'label'       => 'Footer Info',
        'desc'        => 'Enter the info you would like to display in the footer of your site.',
        'std'         => 'Copyright &copy; 2012. All Rights Reserved.',
        'type'        => 'textarea',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'sub_footer_info',
        'label'       => 'Sub-Footer Info',
        'desc'        => 'Enter the info you would like to display in the sub-footer of your site.',
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'tracking_code',
        'label'       => 'Tracking Code',
        'desc'        => 'Paste your Google Analytics (or other) tracking code here.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'primary_typography',
        'label'       => 'Primary Typography',
        'desc'        => 'The Primary Typography option type is for adding typographic styles to your site. The most important one though is Google Fonts to create custom font stacks. Default color is #111111.',
         'std'         => array(
          'font-color' => '#111111'
        ),
        'type'        => 'typography',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'google_font_family',
        'label'       => 'Google Web Font Primary Typography',
        'desc'        => '<p class="warning">Paste Google Web Font link to your website.</p><p><b>Read more:</b> <a href="http://www.google.com/webfonts" target="_blank"><code>http://www.google.com/webfonts</code></a></p>',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'google_font_name',
        'label'       => 'Google Web Font Name for Primary Typography',
        'desc'        => 'Enter the Google Web Font name for primary typography.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'header_typography',
        'label'       => 'Header Typography',
        'desc'        => 'The Header Typography option type is for adding typographic styles for headers to your site. The most important one though is Google Fonts to create custom font stacks. Default color is #111111.',
        'std'         => '',
        'type'        => 'typography',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'header_google_font_family',
        'label'       => 'Google Web Font Header Typography',
        'desc'        => '<p class="warning">Paste Google Web Font link for headings to your website.</p><p><b>Read more:</b> <a href="http://www.google.com/webfonts" target="_blank"><code>http://www.google.com/webfonts</code></a></p>',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'header_google_font_name',
        'label'       => 'Google Web Font Name for Header Typography',
        'desc'        => 'Enter the Google Web Font name for header typography.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'primary_link_color',
        'label'       => 'Primary Link Color',
        'desc'        => 'Choose a color for primary link color. Default value is #ababab.',
        'std'         => '#ababab',
        'type'        => 'colorpicker',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'secondary_link_color',
        'label'       => 'Secondary Link Color',
        'desc'        => 'Choose a value for secondary link color. Default value is #111111.',
        'std'         => '#111111',
        'type'        => 'colorpicker',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'secondary_link_color_hover',
        'label'       => 'Secondary Link Color &mdash; Hover/Active',
        'desc'        => 'Choose a value for secondary link color &mdash; hover/active. Default value is #bca474.',
        'std'         => '#bca474',
        'type'        => 'colorpicker',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'navigation_link_color',
        'label'       => 'Navigation Link Color &mdash; Hover/Active',
        'desc'        => 'Choose a value for navigation link color &mdash; hover/active. Default value is #bca474.',
        'std'         => '#bca474',
        'type'        => 'colorpicker',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'secondary_text_color',
        'label'       => 'Secondary Text Color',
        'desc'        => 'Choose a value for secondary text color. Default value is #777777.',
        'std'         => '#777777',
        'type'        => 'colorpicker',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'primary_borders_color',
        'label'       => 'Primary Borders Color',
        'desc'        => 'Choose a value for primary borders color. Default value is #cfcfcf.',
        'std'         => '#cfcfcf',
        'type'        => 'colorpicker',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'background',
        'label'       => 'Background',
        'desc'        => 'Upload a background for your site.',
        'std'         => '',
        'type'        => 'background',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'custom_css',
        'label'       => 'Custom CSS',
        'desc'        => 'Quickly add some CSS to your theme by adding it to this block.',
        'std'         => '',
        'type'        => 'css',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'home_welcome_message',
        'label'       => 'Home Welcome Message',
        'desc'        => '<p>The large welcome message that appears above the slider.</p>',
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'homepage_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'home_portfolios_per_page',
        'label'       => 'Portfolio Items',
        'desc'        => 'Enter the amount of portfolio items you would like to show on the homepage.',
        'std'         => '16',
        'type'        => 'text',
        'section'     => 'homepage_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'view_more_projects_text',
        'label'       => '&ldquo;View more projects&rdquo; link',
        'desc'        => 'Enter the title of the &ldquo;View more projects&rdquo; link.',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'homepage_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'enable_home_slider',
        'label'       => 'Enable Slideshow',
        'desc'        => 'Enable slideshow or not?',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'home_slider',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'yes',
            'label'       => 'Enable Slideshow',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'home_slider_height',
        'label'       => 'Slider Height',
        'desc'        => '<p>Customize height of slideshow.</p><p>Note: The optimal dimensions for your slideshow images are 959px wide by 370px high.</p>',
        'std'         => '370',
        'type'        => 'text',
        'section'     => 'home_slider',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'home_slider_list',
        'label'       => 'Home Slider',
        'desc'        => '<p>You can create as many slides as your project requires and use them how you see fit.</p><p>All of the slides can be sorted and rearranged to your liking with Drag &amp; Drop. Don\'t worry about the order in which you create your slides, you can always reorder them.</p>',
        'std'         => '',
        'type'        => 'list-item',
        'section'     => 'home_slider',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'settings'    => array( 
          array(
            'id'          => 'home_slider_image',
            'label'       => 'Image',
            'desc'        => '',
            'std'         => '',
            'type'        => 'upload',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => ''
          ),
          array(
            'id'          => 'home_slider_highlight_color',
            'label'       => 'Title highlight color',
            'desc'        => 'Choose a value for title highlight color. Default value is #111111.',
            'std'         => '#111111',
            'type'        => 'colorpicker',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => ''
          ),
          array(
            'id'          => 'home_slider_link',
            'label'       => 'Link',
            'desc'        => '',
            'std'         => 'javascript:void(null);',
            'type'        => 'text',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => ''
          ),
          array(
            'id'          => 'home_slider_description',
            'label'       => 'Description',
            'desc'        => '',
            'std'         => '',
            'type'        => 'textarea',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => ''
          )
        )
      ),
      array(
        'id'          => 'portfolio_message',
        'label'       => 'Portfolio Message',
        'desc'        => '<p>The large message that appears above the portfolio items.</p>',
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'portfolio_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'portfolios_per_page',
        'label'       => 'Portfolio pages show at most',
        'desc'        => 'Enter the number of Portfolios to show per page.',
        'std'         => '12',
        'type'        => 'text',
        'section'     => 'portfolio_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'portfolio_filtering',
        'label'       => 'Portfolio Filtering',
        'desc'        => 'Display portfolio filtering or not?',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'portfolio_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'yes',
            'label'       => 'Portfolio Filtering',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'portfolio_meta',
        'label'       => 'Portfolio Meta',
        'desc'        => 'Select what information to display for each portfolio item on the portfolio page just under their title.',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'portfolio_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'categories',
            'label'       => 'Categories',
            'src'         => ''
          ),
          array(
            'value'       => 'none',
            'label'       => 'None',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'portfolio_page',
        'label'       => 'Portfolio Page',
        'desc'        => 'Select the portfolio page. Used for the "Back to portfolio" link.',
        'std'         => '',
        'type'        => 'page-select',
        'section'     => 'portfolio_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'autoplay',
        'label'       => 'Autoplay',
        'desc'        => '<p>Enable autoplay or not?</p>',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'slider_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'yes',
            'label'       => 'Autoplay',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'pause_on_hover',
        'label'       => 'Pause on Hover',
        'desc'        => '<p>Pause autoplay on hover?</p>',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'slider_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'yes',
            'label'       => 'Pause on Hover',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'delay',
        'label'       => 'Delay between slides in ms',
        'desc'        => '<p>Delay between items in ms.</p>',
        'std'         => '4500',
        'type'        => 'text',
        'section'     => 'slider_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'control_navigation',
        'label'       => 'Control Navigation',
        'desc'        => '<p>Select navigation type.</p>',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'slider_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'bullets',
            'label'       => 'Bullets',
            'src'         => ''
          ),
          array(
            'value'       => 'thumbnails',
            'label'       => 'Thumbnails',
            'src'         => ''
          ),
          array(
            'value'       => 'none',
            'label'       => 'None',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'enable_blog_title',
        'label'       => 'Enable Title / Welcome Message',
        'desc'        => 'Enable Title / Welcome Message or not?',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'blog',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'yes',
            'label'       => 'Enable Title / Welcome Message',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'blog_message',
        'label'       => 'Blog Message',
        'desc'        => '<p>The large message that appears above posts.</p>',
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'blog',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'social_accounts',
        'label'       => 'Social Accounts',
        'desc'        => '<p>Which links would you like to display?</p>',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'facebook',
            'label'       => 'Facebook',
            'src'         => ''
          ),
          array(
            'value'       => 'twitter',
            'label'       => 'Twitter',
            'src'         => ''
          ),
          array(
            'value'       => 'gplus',
            'label'       => 'Google Plus',
            'src'         => ''
          ),
          array(
            'value'       => 'linkedin',
            'label'       => 'LinkedIn',
            'src'         => ''
          ),
          array(
            'value'       => 'dribbble',
            'label'       => 'Dribbble',
            'src'         => ''
          ),
          array(
            'value'       => 'pinterest',
            'label'       => 'Pinterest',
            'src'         => ''
          ),
          array(
            'value'       => 'foursquare',
            'label'       => 'Foursquare',
            'src'         => ''
          ),
          array(
            'value'       => 'instagram',
            'label'       => 'Instagram',
            'src'         => ''
          ),
          array(
            'value'       => 'vimeo',
            'label'       => 'Vimeo',
            'src'         => ''
          ),
          array(
            'value'       => 'flickr',
            'label'       => 'Flickr',
            'src'         => ''
          ),
          array(
            'value'       => 'github',
            'label'       => 'GitHub',
            'src'         => ''
          ),
          array(
            'value'       => 'tumblr',
            'label'       => 'Tumblr',
            'src'         => ''
          ),
          array(
            'value'       => 'forrst',
            'label'       => 'Forrst',
            'src'         => ''
          ),
          array(
            'value'       => 'lastfm',
            'label'       => 'Last.fm',
            'src'         => ''
          ),
          array(
            'value'       => 'stumbleupon',
            'label'       => 'StumbleUpon',
            'src'         => ''
          ),
          array(
            'value'       => 'feed',
            'label'       => 'RSS',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'facebook_url',
        'label'       => 'Facebook Address (URL)',
        'desc'        => '',
        'std'         => 'http://www.facebook.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'twitter_url',
        'label'       => 'Twitter Address (URL)',
        'desc'        => '',
        'std'         => 'https://twitter.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'gplus_url',
        'label'       => 'Google Plus Address (URL)',
        'desc'        => '',
        'std'         => 'https://plus.google.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'linkedin_url',
        'label'       => 'LinkedIn Address (URL)',
        'desc'        => '',
        'std'         => 'http://www.linkedin.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'dribbble_url',
        'label'       => 'Dribbble Address (URL)',
        'desc'        => '',
        'std'         => 'http://dribbble.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'pinterest_url',
        'label'       => 'Pinterest Address (URL)',
        'desc'        => '',
        'std'         => 'http://pinterest.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'foursquare_url',
        'label'       => 'Foursquare Address (URL)',
        'desc'        => '',
        'std'         => 'https://foursquare.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'instagram_url',
        'label'       => 'Instagram Address (URL)',
        'desc'        => '',
        'std'         => 'http://instagram.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'vimeo_url',
        'label'       => 'Vimeo Address (URL)',
        'desc'        => '',
        'std'         => 'https://vimeo.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'flickr_url',
        'label'       => 'Flickr Address (URL)',
        'desc'        => '',
        'std'         => 'http://www.flickr.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'github_url',
        'label'       => 'GitHub Address (URL)',
        'desc'        => '',
        'std'         => 'https://github.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'tumblr_url',
        'label'       => 'Tumblr Address (URL)',
        'desc'        => '',
        'std'         => 'https://www.tumblr.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'forrst_url',
        'label'       => 'Forrst Address (URL)',
        'desc'        => '',
        'std'         => 'http://forrst.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'lastfm_url',
        'label'       => 'Last.fm Address (URL)',
        'desc'        => '',
        'std'         => 'http://www.lastfm.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'stumbleupon_url',
        'label'       => 'StumbleUpon Address (URL)',
        'desc'        => '',
        'std'         => 'http://www.stumbleupon.com/',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'feed_url',
        'label'       => 'RSS Address (URL)',
        'desc'        => '',
        'std'         => 'javascript:void(null);',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'contact_message',
        'label'       => 'Contact Message',
        'desc'        => '<p>The large message that appears above the map.</p>',
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'contact_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'map_address',
        'label'       => 'Adress',
        'desc'        => '<p>Insert your Adress here. Example:</p><p>13/2 Elizabeth Street, Melbourne VIC 3000</p>',
        'std'         => '3/2 Elizabeth Street, Melbourne VIC 3000',
        'type'        => 'text',
        'section'     => 'contact_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'map_height',
        'label'       => 'Map Height',
        'desc'        => 'Insert map height.',
        'std'         => '401',
        'type'        => 'text',
        'section'     => 'contact_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'map_content',
        'label'       => 'Map Info Content',
        'desc'        => 'Insert Map Info Content here. Example:<p>Envato (FlashDen Pty Ltd) 13/2 Elizabeth Street, Melbourne VIC 3000 (03) 9023 0074 &middot; envato.com</p>',
        'std'         => 'Envato (FlashDen Pty Ltd) 13/2 Elizabeth Street, Melbourne VIC 3000 (03) 9023 0074 &middot; envato.com',
        'type'        => 'textarea-simple',
        'section'     => 'contact_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'map_grayscale',
        'label'       => 'Grayscale',
        'desc'        => '<p>Enable grayscale or not?</p>',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'contact_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'yes',
            'label'       => 'Grayscale',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'map_custom_marker',
        'label'       => 'Custom Marker',
        'desc'        => 'Upload a custom marker for your address.',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'contact_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'woo_account',
        'label'       => 'Display My Account link',
        'desc'        => '<p>Displays a link to the user account section?</p><br><p>If the user is not logged in the link will display &ldquo;Login / Registration&rdquo; and take the use to the login / signup page. If the user is logged in the link will display &ldquo;My account&rdquo; and take them directly to their account.</p>',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'woocommerce_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'yes',
            'label'       => 'Account',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'enable_home_banners_shop',
        'label'       => 'Enable Banners',
        'desc'        => 'Enable banners or not?',
        'std'         => '',
        'type'        => 'checkbox',
        'section'     => 'woocommerce_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'choices'     => array( 
          array(
            'value'       => 'yes',
            'label'       => 'Enable Banners',
            'src'         => ''
          )
        ),
      ),
      array(
        'id'          => 'home_banners_shop_list',
        'label'       => 'Banners',
        'desc'        => '<p>You can create as many banners as your project requires and use them how you see fit.</p><p>Note: The optimal dimensions for your banner images are 300px wide by 280px high.</p><p>All of the banners can be sorted and rearranged to your liking with Drag &amp; Drop. Don\'t worry about the order in which you create your slides, you can always reorder them.</p>',
        'std'         => '',
        'type'        => 'list-item',
        'section'     => 'woocommerce_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => '',
        'settings'    => array( 
          array(
            'id'          => 'home_banner_image',
            'label'       => 'Image',
            'desc'        => '',
            'std'         => '',
            'type'        => 'upload',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => ''
          ),
          array(
            'id'          => 'home_banner_highlight_color',
            'label'       => 'Title highlight color',
            'desc'        => 'Choose a value for title highlight color. Default value is #E0CE79.',
            'std'         => '#E0CE79',
            'type'        => 'colorpicker',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => ''
          ),
          array(
            'id'          => 'home_banner_link',
            'label'       => 'Link',
            'desc'        => '',
            'std'         => '',
            'type'        => 'text',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => ''
          ),
          array(
            'id'          => 'home_banner_description',
            'label'       => 'Description',
            'desc'        => '',
            'std'         => '',
            'type'        => 'textarea-simple',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'class'       => ''
          )
        )
      ),
      array(
        'id'          => 'account_benefits_info',
        'label'       => 'Account Benefits Info',
        'desc'        => 'Enter the info you would like to display under the <strong>&ldquo;Create an account&rdquo;</strong> form of your site.',
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'woocommerce_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      ),
      array(
        'id'          => 'returning_customer_info',
        'label'       => 'Returning Customer Info',
        'desc'        => 'Enter the info you would like to display under the <strong>&ldquo;Returning Customer Info&rdquo;</strong> form of your site.',
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'woocommerce_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'class'       => ''
      )
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( 'option_tree_settings_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings ); 
  }
  
}