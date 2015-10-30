<?php
    add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
    function theme_enqueue_styles() {
        wp_enqueue_style( 'parent-style', get_stylesheet_directory_uri() . '/style.css' );

    }


    /**
     * Set the content width based on the theme's design and stylesheet.
     */
    if ( ! isset( $content_width ) )
        $content_width = 678;

    /**
     * Options Tree.
     */
     
    /**
     * Optional: set 'ot_show_pages' filter to false.
     * This will hide the settings & documentation pages.
     */
    add_filter( 'ot_show_pages', '__return_false' );

    /**
     * Optional: set 'ot_show_new_layout' filter to false.
     * This will hide the "New Layout" section on the Theme Options page.
     */
    add_filter( 'ot_show_new_layout', '__return_false' );

    /**
     * Required: set 'ot_theme_mode' filter to true.
     */
    add_filter( 'ot_theme_mode', '__return_true' );

    /**
     * Required: include OptionTree.
     */
    include_once( trailingslashit( get_stylesheet_directory() ) . 'option-tree/ot-loader.php' );

    include_once( trailingslashit( get_stylesheet_directory() ) . 'inc/theme-options.php' );

    /**
     * Tell WordPress to run mega_setup() when the 'after_setup_theme' hook is run.
     */
    add_action( 'after_setup_theme', 'mega_setup' );

    if ( ! function_exists( 'mega_setup' ) ):
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     */
    function mega_setup() {

        /* Make Razzo available for translation.
         * Translations can be added to the /languages/ directory.
         */
        load_theme_textdomain( 'mega', get_stylesheet_directory() . '/languages' );

        $locale = get_locale();
        $locale_file = get_stylesheet_directory() . "/languages/$locale.php";
        if ( is_readable( $locale_file ) )
            require_once( $locale_file );

        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();

        require( get_stylesheet_directory() . '/inc/widgets.php' );
        
        // Load up our theme shortcodes and related code.
        require( get_stylesheet_directory() . '/inc/shortcodes.php' );
        require( get_stylesheet_directory() . '/inc/tinymce/tinymce.php' );

        // Add default posts and comments RSS feed links to <head>.
        add_theme_support( 'automatic-feed-links' );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menu( 'primary', __( 'Primary Menu', 'mega' ) );

        // Add support for a variety of post formats
        add_theme_support( 'post-formats', array( 'gallery', 'image', 'quote', 'video', 'audio' ) );

        // This theme uses Featured Images (also known as post thumbnails)
        add_theme_support( 'post-thumbnails' );
        
        if ( function_exists( 'add_image_size' ) ) {
            add_image_size( 'single-post-image', 678, '', true ); // Image for Blog
            add_image_size( 'single-portfolio-image', 959, '', true ); // Image for Single Portfolio Page
            add_image_size( 'related-projects-image', 236, 157, true ); // Image for Related projects
        }
        
        // Declare WooCommerce support
        add_theme_support( 'woocommerce' );
        
        // Sidebar
        //remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
        
        // Remove Related
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

        // Columns
        global $woocommerce_loop;
        $woocommerce_loop['columns'] = 3;
     
        // Display number products per page.
        add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 15;' ), 20 );
        
        // Disable breadcrumbs
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
        
        // Ensure cart contents update when products are added to the cart via AJAX
        add_filter( 'add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
         
        function woocommerce_header_add_to_cart_fragment( $fragments ) {
            global $woocommerce;
            
            ob_start();
            
            ?>
            <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><?php _e( 'Cart', 'mega' ); ?> (<?php echo $woocommerce->cart->cart_contents_count; ?>) - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
            <?php
            
            $fragments['a.cart-contents'] = ob_get_clean();
            
            return $fragments;
            
        }
        
        // Srring for add to cart messages.
        function custom_woocommerce_add_to_cart_message( $message ) {
            if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) :
                $newButtonString = 'Continue Shopping <i class="icon-circle-arrow-right"></i>';
            else :
                $newButtonString = 'View Shopping Cart <i class="icon-circle-arrow-right"></i>';
            endif;
            $replaceString = '<a$1class="button">' . $newButtonString .'</a>';
            $message = preg_replace('#<a(.*?)class="button">(.*?)</a>#', $replaceString, $message);
            return $message;
        }
        add_filter( 'woocommerce_add_to_cart_message', 'custom_woocommerce_add_to_cart_message', 999 );
        
        // Footer(remove demo store notice text)
        remove_action( 'wp_footer', 'woocommerce_demo_store', 10 );
        
        
        
        add_filter( 'single_add_to_cart_text', 'woo_custom_cart_button_text' );
     
        // Change add to cart button text
        function woo_custom_cart_button_text() {
            return __( 'Add to Cart', 'mega' );
        }
        
        add_action( 'woocommerce_after_single_product_summary', 'woocommerce_single_navigation', 16 );
        
        if ( ! function_exists( 'woocommerce_single_navigation' ) ) {

        /**
         * Next/prev navigation.
         */
        function woocommerce_single_navigation() {
        ?>
            <nav id="nav-single" class="clearfix">
                <div class="nav-next"><?php next_post_link_plus( array(
                
                             'tooltip' => '%title',
                             
                             'link' => 'Next Product &raquo;',
                             
                             'format' => '%link',
                             
                             'loop' => true,

                             'in_same_cat' => true

                        ) );?>
                </div>
                
                <div class="nav-previous"><?php previous_post_link_plus( array(
                
                             'tooltip' => '%title',
                             
                             'link' => '&laquo; Previous Product',
                             
                             'format' => '%link',
                             
                             'loop' => true,

                             'in_same_cat' => true,

                        ) );?>
                </div>
            </nav><!-- #nav-single -->
        <?php
        }
    }
        
    }
    endif; // mega_setup

        // Auto plugin activation
        require_once( get_stylesheet_directory() . '/inc/class-tgm-plugin-activation.php' );
        add_action( 'tgmpa_register', 'mega_register_required_plugins' );
        function mega_register_required_plugins() {
            $plugins = array(
                array(
                'name'      => 'Contact Form 7',
                'slug'      => 'contact-form-7',
                'required'  => false
                ),
                array(
                    'name'      => 'AddThis Share',
                    'slug'      => 'addthis',
                    'required'  => false
                ),
                array(
                    'name'      => 'WooCommerce',
                    'slug'      => 'woocommerce',
                    'required'  => false
                ),
                array(
                'name'                  => 'revslider', // The plugin name
                'slug'                  => 'revslider', // The plugin slug (typically the folder name)
                'source'                => get_stylesheet_directory() . '/inc/plugins/revslider.zip', // The plugin source
                'required'              => false, // If false, the plugin is only 'recommended' instead of required
                'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or mega, otherwise a notice is presented
                'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation'    => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'          => '', // If set, overrides default API URL and points to an external URL
            ),
            );

            // Change this to your theme text domain, used for internationalising strings
            $theme_text_domain = 'mega';

            /**
             * Array of configuration settings. Amend each line as needed.
             * If you want the default strings to be available under your own theme domain,
             * leave the strings uncommented.
             * Some of the strings are added into a sprintf, so see the comments at the
             * end of each line for what each argument will be.
             */
            $config = array(
                'domain'            => $theme_text_domain,          // Text domain - likely want to be the same as your theme.
                'default_path'      => '',                          // Default absolute path to pre-packaged plugins
                'parent_menu_slug'  => 'themes.php',                // Default parent menu slug
                'parent_url_slug'   => 'themes.php',                // Default parent URL slug
                'menu'              => 'install-required-plugins',  // Menu slug
                'has_notices'       => true,                        // Show admin notices or not
                'is_automatic'      => true,                        // Automatically activate plugins after installation or not
                'message'           => '',                          // Message to output right before the plugins table
                'strings'           => array(
                    'page_title'                                => __( 'Install Required Plugins', 'mega' ),
                    'menu_title'                                => __( 'Install Plugins', 'mega' ),
                    'installing'                                => __( 'Installing Plugin: %s', 'mega' ), // %1$s = plugin name
                    'oops'                                      => __( 'Something went wrong with the plugin API.', 'mega' ),
                    'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
                    'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
                    'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
                    'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
                    'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
                    'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
                    'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
                    'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
                    'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
                    'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
                    'return'                                    => __( 'Return to Required Plugins Installer', 'mega' ),
                    'plugin_activated'                          => __( 'Plugin activated successfully.', 'mega' ),
                    'complete'                                  => __( 'All plugins installed and activated successfully. %s', 'mega' ), // %1$s = dashboard link
                    'nag_type'                                  => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
                )
            );

            tgmpa($plugins, $config);
    }

    /**
     * Registering a post type called "Portfolios".
     */
    function create_portfolio_type() {
        register_post_type( 'portfolio',
            array(
                'labels' => array(
                    'name' => __( 'Portfolios', 'mega' ),
                    'singular_name' => __( 'Portfolio', 'mega' ),
                    'add_new' => _x( 'Add New', 'portfolio', 'mega' ),
                    'add_new_item' => __( 'Add New Portfolio', 'mega' ),
                    'edit_item' => __( 'Edit Portfolio', 'mega' ),
                    'new_item' => __( 'New Portfolio', 'mega' ),
                    'all_items' => __( 'All Portfolios', 'mega' ),
                    'view_item' => __( 'View Portfolio', 'mega' ),
                    'search_items' => __( 'Search Portfolio', 'mega' ),
                    'not_found' =>  __( 'No portfolios found', 'mega' ),
                    'not_found_in_trash' => __( 'No portfolios found in Trash', 'mega' )
                ),
                'publicly_queryable' => true,
                'show_ui' => true, 
                'show_in_menu' => true,
                'show_in_nav_menus' => true,
                'query_var' => true,
                'rewrite' => array( 'slug' => 'portfolio', 'with_front' => false ),
                'capability_type' => 'post',
                'has_archive' => false,
                'public' => true,
                'hierarchical' => false,
                'menu_position' => 5,
                'exclude_from_search' => false,
                'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'author' )
            )
        );
    }
    add_action( 'init', 'create_portfolio_type' );

    // create taxonomy, categories for the post type "Portfolios"
    function create_portfolio_taxonomies() {
        $labels = array(
            'name' => __( 'Portfolio Categories', 'mega' ),
            'singular_name' => __( 'Category', 'mega' ),
            'all_items' => __( 'All Categories', 'mega' ),
        ); 
        register_taxonomy( 'portfolio-category', array( 'portfolio' ), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_tagcloud' => false,
            'show_in_nav_menus' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'portfolio-category' )
        ) );
    }
    add_action( 'init', 'create_portfolio_taxonomies' );

    // add filter to ensure the text Portfolio, or portfolio, is displayed when user updates a portfolio 
    function portfolio_updated_messages( $messages ) {
      global $post, $post_ID;

      $messages['portfolio'] = array(
        0 => '', // Unused. Messages start at index 1.
        1 => sprintf( __('Portfolio updated. <a href="%s">View portfolio</a>', 'mega'), esc_url( get_permalink($post_ID) ) ),
        2 => __('Custom field updated.', 'mega'),
        3 => __('Custom field deleted.', 'mega'),
        4 => __('Portfolio updated.', 'mega'),
        /* translators: %s: date and time of the revision */
        5 => isset($_GET['revision']) ? sprintf( __('Portfolio restored to revision from %s', 'mega'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6 => sprintf( __('Portfolio published. <a href="%s">View portfolio</a>', 'mega'), esc_url( get_permalink($post_ID) ) ),
        7 => __('Portfolio saved.', 'mega'),
        8 => sprintf( __('Portfolio submitted. <a target="_blank" href="%s">Preview portfolio</a>', 'mega'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        9 => sprintf( __('Portfolio scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview portfolio</a>', 'mega'),
          // translators: Publish box date format, see http://php.net/date
          date_i18n( __( 'M j, Y @ G:i', 'mega' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
        10 => sprintf( __('Portfolio draft updated. <a target="_blank" href="%s">Preview portfolio</a>', 'mega'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
      );

      return $messages;
    }
    add_filter( 'post_updated_messages', 'portfolio_updated_messages' );

    // display contextual help for Portfolio

    function portfolio_add_help_text( $contextual_help, $screen_id, $screen ) {
      // $contextual_help .= var_dump( $screen ); // use this to help determine $screen->id
      if ( 'portfolio' == $screen->id ) {
        $customize_display = '<p>' . __('The title field and the big Portfolio Editing Area are fixed in place, but you can reposition all the other boxes using drag and drop, and can minimize or expand them by clicking the title bar of each box. Use the Screen Options tab to unhide more boxes (Excerpt, Send Trackbacks, Custom Fields, Discussion, Slug, Author) or to choose a 1- or 2-column layout for this screen.', 'mega') . '</p>';

        get_current_screen()->add_help_tab( array(
            'id'      => 'customize-display',
            'title'   => __('Customizing This Display', 'mega'),
            'content' => $customize_display,
        ) );

        $title_and_editor  = '<p>' . __('<strong>Title</strong> - Enter a title for your portfolio. After you enter a title, you&#8217;ll see the permalink below, which you can edit.', 'mega') . '</p>';
        $title_and_editor .= '<p>' . __('<strong>Portfolio editor</strong> - Enter the text for your portfolio. There are two modes of editing: Visual and HTML. Choose the mode by clicking on the appropriate tab. Visual mode gives you a WYSIWYG editor. Click the last icon in the row to get a second row of controls. The HTML mode allows you to enter raw HTML along with your portfolio text. You can insert media files by clicking the icons above the portfolio editor and following the directions. You can go to the distraction-free writing screen via the Fullscreen icon in Visual mode (second to last in the top row) or the Fullscreen button in HTML mode (last in the row). Once there, you can make buttons visible by hovering over the top area. Exit Fullscreen back to the regular portfolio editor.', 'mega') . '</p>';

        get_current_screen()->add_help_tab( array(
            'id'      => 'title-portfolio-editor',
            'title'   => __('Title and Portfolio Editor', 'mega'),
            'content' => $title_and_editor,
        ) );

        $publish_box = '<p>' . __('<strong>Publish</strong> - You can set the terms of publishing your portfolio in the Publish box. For Status, Visibility, and Publish (immediately), click on the Edit link to reveal more options. Visibility includes options for password-protecting a portfolio or making it stay at the top of your blog indefinitely (sticky). Publish (immediately) allows you to set a future or past date and time, so you can schedule a portfolio to be published in the future or backdate a portfolio.', 'mega') . '</p>';

        if ( current_theme_supports( 'post-thumbnails' ) && post_type_supports( 'post', 'thumbnail' ) ) {
            $publish_box .= '<p>' . __('<strong>Featured Image</strong> - This allows you to associate an image with your portfolio without inserting it. This is usually useful only if your theme makes use of the featured image as a portfolio thumbnail on the home page, a custom header, etc.', 'mega') . '</p>';
        }

        get_current_screen()->add_help_tab( array(
            'id'      => 'publish-box',
            'title'   => __('Publish Box', 'mega'),
            'content' => $publish_box,
        ) );

        $discussion_settings  = '<p>' . __('<strong>Send Trackbacks</strong> - Trackbacks are a way to notify legacy blog systems that you&#8217;ve linked to them. Enter the URL(s) you want to send trackbacks. If you link to other WordPress sites they&#8217;ll be notified automatically using pingbacks, and this field is unnecessary.', 'mega') . '</p>';
        $discussion_settings .= '<p>' . __('<strong>Discussion</strong> - You can turn comments and pings on or off, and if there are comments on the portfolio, you can see them here and moderate them.', 'mega') . '</p>';

        get_current_screen()->add_help_tab( array(
            'id'      => 'discussion-settings',
            'title'   => __('Discussion Settings', 'mega'),
            'content' => $discussion_settings,
        ) );

        get_current_screen()->set_help_sidebar(
                '<p>' . sprintf(__('You can also create portfolio with the <a href="%s">Press This bookmarklet</a>.'), 'mega') . '</p>' .
                '<p><strong>' . __('For more information:', 'mega') . '</strong></p>' .
                '<p>' . __('<a href="http://codex.wordpress.org/Posts_Add_New_Screen" target="_blank">Documentation on Writing and Editing Posts</a>', 'mega') . '</p>' .
                '<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>', 'mega') . '</p>'
        );
      }
      return $contextual_help;
    }
    add_action( 'contextual_help', 'portfolio_add_help_text', 10, 3 );

    function get_related_projects( $post_id ) {
        $query = new WP_Query();
        
        $args = '';

        $item_cats = get_the_terms( $post_id, 'portfolio-category' );
        if ( $item_cats ) :
        foreach ( $item_cats as $item_cat ) {
            $item_array[] = $item_cat->term_id;
        }
        endif;

        $args = wp_parse_args($args, array(
            'showposts' => 4,
            'post__not_in' => array( $post_id ),
            'ignore_sticky_posts' => 0,
            'post_type' => 'portfolio',
            'orderby' => 'rand',
            'tax_query' => array(
                array(
                    'taxonomy' => 'portfolio-category',
                    'field' => 'id',
                    'terms' => $item_array
                )
            ),
        ));
        
        $query = new WP_Query($args);
        
        return $query;
    }

    /**
     * Sets the post excerpt length to 40 words.
     *
     * To override this length in a child theme, remove the filter and add your own
     * function tied to the excerpt_length filter hook.
     */
    function mega_excerpt_length( $length ) {
        return 40;
    }
    add_filter( 'excerpt_length', 'mega_excerpt_length' );

    if ( ! function_exists( 'mega_continue_reading_link' ) ) :
    /**
     * Returns a "Continue Reading" link for excerpts
     */
    function mega_continue_reading_link() {
        return ' <a class="more-link" href="'. esc_url( get_permalink() ) . '">' . __( '[+]', 'mega' ) . '</a>';
    }
    endif; // mega_continue_reading_link

    /**
     * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and mega_continue_reading_link().
     *
     * To override this in a child theme, remove the filter and add your own
     * function tied to the excerpt_more filter hook.
     */
    function mega_auto_excerpt_more( $more ) {
        return ' &hellip;' . mega_continue_reading_link();
    }
    add_filter( 'excerpt_more', 'mega_auto_excerpt_more' );

    /**
     * Adds a pretty "Continue Reading" link to custom post excerpts.
     *
     * To override this link in a child theme, remove the filter and add your own
     * function tied to the get_the_excerpt filter hook.
     */
    function mega_custom_excerpt_more( $output ) {
        if ( has_excerpt() && ! is_attachment() ) {
            $output .= mega_continue_reading_link();
        }
        return $output;
    }
    //add_filter( 'get_the_excerpt', 'mega_custom_excerpt_more' );

    /**
     * Get taxonomies terms links.
     */
    function custom_taxonomies_terms_links() {
        global $post, $post_id;
        // get post by post id
        $post = &get_post( $post->ID );
        // get post type by post
        $post_type = $post->post_type;
        // get post type taxonomies
        $taxonomies = get_object_taxonomies( $post_type );
        foreach ( $taxonomies as $taxonomy ) {
            // get the terms related to post
            $terms = get_the_terms( $post->ID, $taxonomy );
            if ( !empty( $terms ) ) {
                $out = array();
                foreach ( $terms as $term ) {
                    $out[] = $term->name;
                }
                $return = '<div class="entry-category">' . join( ', ', $out ) . '</div><!-- .entry-category -->';
                return $return;
            }
        }
    }

    /**
     * Remove title attribute from images.
     */
    function wp_get_attachment_image_attributes_title_filter( $attr ) {
        unset( $attr['title'] );
        return $attr;
    }
    add_filter( 'wp_get_attachment_image_attributes', 'wp_get_attachment_image_attributes_title_filter' );

    /**
     * Modify default The Gallery shortcode.
     */

    add_filter( 'post_gallery', 'mega_gallery_shortcode', 10, 2 );

    function mega_gallery_shortcode( $output, $attr ) {
        global $post, $wp_locale;;

        static $instance = 0;
        $instance++;

        // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
        if ( isset( $attr['orderby'] ) ) {
            $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
            if ( !$attr['orderby'] )
                unset( $attr['orderby'] );
        }
        
        if ( ! is_single() && 'post' == get_post_type() ) {
            $gallery_size = 'blog-thumb';
        } else {
            $gallery_size = 'large';
        }

        extract(shortcode_atts(array(
            'order'      => 'ASC',
            'orderby'    => 'menu_order ID',
            'id'         => $post->ID,
            'itemtag'    => 'div',
            'captiontag' => 'figure',
            'columns'    => 1,
            'size'       => $gallery_size,
            'include'    => '',
            'exclude'    => '',
        ), $attr));

        $id = intval($id);
        if ( 'RAND' == $order )
            $orderby = 'none';

        if ( !empty($include) ) {
            $include = preg_replace( '/[^0-9,]+/', '', $include );
            $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

            $attachments = array();
            foreach ( $_attachments as $key => $val ) {
                $attachments[$val->ID] = $_attachments[$key];
            }
        } elseif ( !empty($exclude) ) {
            $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
            $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
        } else {
            $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
        }

        if ( empty($attachments) )
            return '';

        if ( is_feed() ) {
            $output = "\n";
            foreach ( $attachments as $att_id => $attachment )
                $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
            return $output;
        }

        $itemtag = tag_escape($itemtag);
        $captiontag = tag_escape($captiontag);
        $columns = intval($columns);

        $selector = "gallery-{$instance}";

        $size_class = sanitize_html_class( $size );
        $gallery_div_wrapper = "<div id='$selector' class='gallery-shortcode royalSlider rsDefault'>";
        $output .= $gallery_div_wrapper;

        $i = 0;
        foreach ( $attachments as $id => $attachment ) {
            $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
            
            $output .= "<{$itemtag} class='rsContent'>";
            $output .= "$link";
            if ( $captiontag && trim($attachment->post_excerpt) ) {
                $output .= "
                    <{$captiontag} class='wp-caption-text gallery-caption rsABlock infoBlock rsNoDrag' data-fade-effect='' data-move-offset='10' data-move-effect='bottom' data-speed='200'>" . wptexturize($attachment->post_excerpt) . "</{$captiontag}>";
            }
            $output .= "</{$itemtag}>";
        }

        $output .= "
            </div>\n";
            
        // Remove link
        if ( $attr['link'] == "none" ) {
            $output = preg_replace( array('/<a[^>]*>/', '/<\/a>/'), '', $output) ;
        }

        return $output;
    }

    /**
     * Register our sidebars and widgetized areas.
     */
    function mega_widgets_init() {

        register_widget( 'twitter' );

        register_sidebar( array(
            'name' => __( 'Journal Sidebar', 'mega' ),
            'id' => 'sidebar-1',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ) );
        register_sidebar( array(
            'name' => __( 'Page Sidebar', 'mega' ),
            'id' => 'sidebar-2',
            'description' => __( 'An optional widget area for your pages', 'mega' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ) );
        register_sidebar( array(
            'name' => __( 'Shop Sidebar', 'mega' ),
            'id' => 'sidebar-3',
            'description' => __( 'An optional widget area for your shop page', 'mega' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ) );
        register_sidebar( array(
            'name' => __( 'Footer Area One', 'mega' ),
            'id' => 'sidebar-4',
            'description' => __( 'An optional widget area for your site footer', 'mega' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );
        register_sidebar( array(
            'name' => __( 'Footer Area Two', 'mega' ),
            'id' => 'sidebar-5',
            'description' => __( 'An optional widget area for your site footer', 'mega' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );
        register_sidebar( array(
            'name' => __( 'Footer Area Three', 'mega' ),
            'id' => 'sidebar-6',
            'description' => __( 'An optional widget area for your site footer', 'mega' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );
        register_sidebar( array(
            'name' => __( 'Footer Area Four', 'mega' ),
            'id' => 'sidebar-7',
            'description' => __( 'An optional widget area for your site footer', 'mega' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );
        
        register_sidebar( array(
            'name' => __( 'Footer Shop Area One', 'mega' ),
            'id' => 'sidebar-8',
            'description' => __( 'An optional widget area for your shop footer', 'mega' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );
        register_sidebar( array(
            'name' => __( 'Footer Shop Area Two', 'mega' ),
            'id' => 'sidebar-9',
            'description' => __( 'An optional widget area for your shop footer', 'mega' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );
        register_sidebar( array(
            'name' => __( 'Footer Shop Area Three', 'mega' ),
            'id' => 'sidebar-10',
            'description' => __( 'An optional widget area for your shop footer', 'mega' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );
        register_sidebar( array(
            'name' => __( 'Footer Shop Area Four', 'mega' ),
            'id' => 'sidebar-11',
            'description' => __( 'An optional widget area for your shop footer', 'mega' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );
    }
    add_action( 'widgets_init', 'mega_widgets_init' );

    if ( ! function_exists( 'mega_content_nav' ) ) :
    /**
     * Display navigation to next/previous pages when applicable
     */
    function mega_content_nav( $nav_id ) {
        global $wp_query;

        if ( $wp_query->max_num_pages > 1 ) : ?>
            <nav id="<?php echo $nav_id; ?>">
                <h3 class="assistive-text"><?php _e( 'Post navigation', 'mega' ); ?></h3>
                <div class="nav-previous"><?php next_posts_link( __( '<i class="icon-chevron-left"></i> Older Entries', 'mega' ) ); ?></div>
                <div class="nav-next"><?php previous_posts_link( __( 'Newer Entries <i class="icon-chevron-right"></i>', 'mega' ) ); ?></div>
            </nav><!-- #nav-above -->
        <?php endif;
    }
    endif; // mega_content_nav

    if ( ! function_exists( 'mega_pagination_content_nav' ) ) :
    /**
     * Display navigation to next/previous pages with pagination when applicable
     */
    function mega_pagination_content_nav( $nav_id ) {
        global $wp_query;

        if ( $wp_query->max_num_pages > 1 ) : ?>
            <nav id="<?php echo $nav_id; ?>">
                <h3 class="assistive-text"><?php _e( 'Post navigation', 'mega' ); ?></h3>
                
                <?php $big = 999999999; // need an unlikely integer

                echo paginate_links( array(
                    'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
                    'format' => '?paged=%#%',
                    'current' => max( 1, get_query_var('paged') ),
                    'total' => $wp_query->max_num_pages,
                    'prev_text' => __('<span class="meta-nav">&#171;</span> Prev', 'mega'),
                    'next_text' => __('Next <span class="meta-nav">&#187;</span>', 'mega'),
                    'end_size' => 3
                ) ); ?>
            </nav><!-- #nav-above -->
        <?php endif;
    }
    endif; // mega_pagination_content_nav

    /**
     * Return the URL for the first link found in the post content.
     *
     * @return string|bool URL or false when no link is present.
     */
    function mega_url_grabber() {
        if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
            return false;

        return esc_url_raw( $matches[1] );
    }

    /**
     * Count the number of footer sidebars to enable dynamic classes for the footer
     */
    function mega_footer_sidebar_class() {
        $count = 0;

        if ( is_active_sidebar( 'sidebar-4' ) )
            $count++;

        if ( is_active_sidebar( 'sidebar-5' ) )
            $count++;
            
        if ( is_active_sidebar( 'sidebar-6' ) )
            $count++;
            
        if ( is_active_sidebar( 'sidebar-7' ) )
            $count++;
            
            
        if ( is_active_sidebar( 'sidebar-8' ) )
            $count++;

        if ( is_active_sidebar( 'sidebar-9' ) )
            $count++;
            
        if ( is_active_sidebar( 'sidebar-10' ) )
            $count++;
            
        if ( is_active_sidebar( 'sidebar-11' ) )
            $count++;

        $class = '';

        switch ( $count ) {
            case '1':
                $class = 'one clearfix';
                break;
            case '2':
                $class = 'two clearfix';
                break;
            case '3':
                $class = 'three clearfix';
                break;
            case '4':
                $class = 'four clearfix';
                break;
                
            case '8':
                $class = 'one clearfix';
                break;
            case '9':
                $class = 'two clearfix';
                break;
            case '10':
                $class = 'three clearfix';
                break;
            case '11':
                $class = 'four clearfix';
                break;
        }

        if ( $class )
            echo 'class="' . $class . '"';
    }

    if ( ! function_exists( 'mega_comment' ) ) :
    /**
     * Template for comments and pingbacks.
     */
    function mega_comment( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment;
        switch ( $comment->comment_type ) :
            case 'pingback' :
            case 'trackback' :
        ?>
        <li class="post pingback">
            <p><?php _e( 'Pingback:', 'mega' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'mega' ), '<span class="edit-link">', '</span>' ); ?></p>
        <?php
                break;
            default :
        ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <article id="comment-<?php comment_ID(); ?>" class="comment">
                <footer class="comment-meta">
                    <div class="avatar vcard">
                        <?php
                            $avatar_size = 45;

                            echo get_avatar( $comment, $avatar_size );

                        ?>

                    </div><!-- .comment-author .vcard -->

                    <?php if ( $comment->comment_approved == '0' ) : ?>
                        <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'mega' ); ?></em>
                        <br />
                    <?php endif; ?>

                </footer>

                <div class="comment-content">
                <div class="comment-author vcard">
                        <?php

                            // translators: 1: comment author, 2: date and time */
                            printf( __( '%1$s on %2$s <span class="says"> - </span>', 'mega' ),
                                
                                sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
                                sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
                                    esc_url( get_comment_link( $comment->comment_ID ) ),
                                    get_comment_time( 'c' ),
                                    /* translators: 1: date, 2: time */
                                    sprintf( __( '%1$s %2$s', 'mega' ), get_comment_date('M j, Y'), get_comment_time() )
                                )
                            );
                            
                            comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'mega' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
                                $show_sep = true;
                                if ( $show_sep ) :
                                    $sep = '<span class="sep"> &middot; </span>';
                                endif; // End if $show_sep
                                edit_comment_link( __( 'Edit', 'mega' ), '' . $sep . '<span class="edit-link">', '</span>' );
                        ?>

                </div><!-- .comment-author .vcard -->
                    
                <?php comment_text(); ?>
                
                </div>

            </article><!-- #comment-## -->

        <?php
                break;
        endswitch;
    }
    endif; // ends check for mega_comment()

    if ( ! function_exists( 'mega_posted_on' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function mega_posted_on() {
        printf( __( '<p><time class="entry-date" datetime="%2$s">%3$s</time></p><span class="by-author"> <span class="sep"> | </span> <span class="author vcard"><a class="url fn n" href="%4$s" title="%5$s" rel="author">%6$s</a></span></span>', 'mega' ),
            esc_attr( get_the_time() ),
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() ),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_attr( sprintf( __( 'View all posts by %s', 'mega' ), get_the_author() ) ),
            get_the_author()
        );
    }
    endif;

    /**
     * Using a Custom Walker Function for wp_nav_menu with descriptions.
     */
    class Walker_Nav_Menu_Description extends Walker_Nav_Menu {
        function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

            $class_names = $value = '';

            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

            $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

            $output .= $indent . '<li' . $id . $value . $class_names .'>';

            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
            
            $prepend = '';
            $append = '';
            $description  = ! empty( $item->description ) ? '<span class="menu-item-description">'. esc_attr( $item->description ) .'</span>' : '';

            //if ( $depth != 0 ) {
                //$description = $append = $prepend = "";
            //}

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before.$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
            $item_output .= '</a>';
            $item_output .= $description.$args->link_after;
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    }

        /**
         * Create WP3 menu areas.
         */
        register_nav_menus( array( 'primary' => 'Primary Menu', 'mobile_menu' => 'Mobile Menu' ) );

    /**
     * Using a Custom Walker Function for wp_list_categories for portfolio.
     */
    class Walker_Portfolio_Category extends Walker_Category {
       function start_el(&$output, $category, $depth, $args) {
          extract($args);
          $cat_name = esc_attr( $category->name);
          $cat_name = apply_filters( 'list_cats', $cat_name, $category );
          $link = '<a href="#" data-filter=".'.$category->slug.'" ';
          if ( ! ( $use_desc_for_title == 0 || empty($category->description) ) )
             $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
          $link .= '>';
          $link .= $cat_name;
          $link .= '</a>';
          if ( (! empty($feed_image)) || (! empty($feed)) ) {
             $link .= ' ';
             if ( empty($feed_image) )
                $link .= '(';
             $link .= '<a href="' . get_category_feed_link($category->term_id, $feed_type) . '"';
             if ( empty($feed) )
                $alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s', 'mega' ), $cat_name ) . '"';
             else {
                $title = ' title="' . $feed . '"';
                $alt = ' alt="' . $feed . '"';
                $name = $feed;
                $link .= $title;
             }
             $link .= '>';
             if ( empty($feed_image) )
                $link .= $name;
             else
                $link .= "<img src='$feed_image'$alt$title" . ' />';
             $link .= '</a>';
             if ( empty($feed_image) )
                $link .= ')';
          }
          if ( isset($show_count) && $show_count )
             $link .= ' (' . intval($category->count) . ')';
          if ( isset($show_date) && $show_date ) {
             $link .= ' ' . gmdate('Y-m-d', $category->last_update_timestamp);
          }
          if ( isset($current_category) && $current_category )
             $_current_category = get_category( $current_category );
          if ( 'list' == $args['style'] ) {
              $output .= '<li class="segment-'.rand(2, 99).'"';
              $class = 'cat-item cat-item-'.$category->term_id;
              if ( isset($current_category) && $current_category && ($category->term_id == $current_category) )
                 $class .=  ' current-cat';
              elseif ( isset($_current_category) && $_current_category && ($category->term_id == $_current_category->parent) )
                 $class .=  ' current-cat-parent';
              $output .=  '';
              $output .= ">$link\n";
           } else {
              $output .= "\t$link<br />\n";
           }
       }
    }

    /**
     * Adds custom classes to the posts.
     */
    if ( ! function_exists( 'custom_post_class' ) ) {

        function custom_post_class( $classes, $class, $ID ) {

                // Adds custom taxonomies to the post class.
                if ( ( 'portfolio' == get_post_type() ) ) {
        
                    $taxonomy = 'portfolio-category';
                
                }
                
                if ( ! empty( $taxonomy ) ) {

                    $terms = get_the_terms( (int) $ID, $taxonomy );
                    
                        if ( ! empty( $terms ) ) {

                            foreach( (array) $terms as $order => $term ) {
                           
                                if ( ! in_array( $term->slug, $classes ) ) {

                                    $classes[] = 'element ' . $term->slug . '';

                                }
                            
                            }

                        }
                    
                }
                
                // Adds custom the portfolio's thumbnail width to the post class.
                if ( ( 'portfolio' == get_post_type() && ! is_singular( 'portfolio' ) ) ) {
                    $portfolio_thumbnail_width = get_post_meta( get_the_ID(), 'mega_portfolio_thumbnail_width', true );
                            
                    if ( $portfolio_thumbnail_width == 'Small (25%)' ) {
                        $classes[] = 'portfolio-thumbnail-small';
                    }
                    else if ( $portfolio_thumbnail_width == 'Medium (50%)' ) {
                        $classes[] = 'portfolio-thumbnail-medium';
                    }
                    
                }

                return $classes;

            }

        }
    add_filter( 'post_class', 'custom_post_class', 10, 3 );

    /**
     * Adds two classes to the array of body classes.
     * The first is if the site has only had one author with published posts.
     * The second is if a singular post being displayed
     */
    function mega_body_classes( $classes ) {

        if ( function_exists( 'is_multi_author' ) && ! is_multi_author() )
            $classes[] = 'single-author';

        if ( is_singular() && ! is_home() )
            $classes[] = 'singular';
            
        global $is_iphone;
        if ( $is_iphone )
            $classes[] = 'iOS';

        return $classes;
    }
    add_filter( 'body_class', 'mega_body_classes' );

    /**
     * Loads a set of CSS and/or Javascript documents. 
     */
    function mega_enqueue_admin_scripts( $hook ) {
        wp_register_style( 'ot-admin-additional', get_stylesheet_directory_uri() . '/inc/css/ot-admin-additional.css' );
        if ( $hook == 'appearance_page_ot-theme-options' ) {
            wp_enqueue_style( 'ot-admin-additional' );
        }

        wp_register_script( 'jquery.admin.custom', get_stylesheet_directory_uri() . '/inc/jquery.admin.custom.js', array( 'jquery' ) );
        if ( $hook != 'edit.php' && $hook != 'post.php' && $hook != 'post-new.php' ) 
            return;
        wp_enqueue_script( 'jquery.admin.custom' );
    }
    add_action( 'admin_enqueue_scripts', 'mega_enqueue_admin_scripts' );

    /**
     * A safe way to add/enqueue a CSS/JavaScript. 
     */
     function mega_enqueue_scripts() {
        
        // A safe way to register a JavaScript file.
        wp_register_script( 'jquery.shortcodes', get_stylesheet_directory_uri() . '/js/jquery.shortcodes.js', array( 'jquery-ui-tabs', 'jquery-ui-accordion' ) );
        wp_register_script( 'jquery.isotope.min', get_stylesheet_directory_uri() . '/js/jquery.isotope.min.js', array(), false, true );
        wp_register_script( 'jquery.portfolio', get_stylesheet_directory_uri() . '/js/jquery.portfolio.js', array(), false, true );
        wp_register_script( 'jquery.home-portfolio', get_stylesheet_directory_uri() . '/js/jquery.home-portfolio.js', array( 'jquery' ), false, true );
        wp_register_script( 'jquery.jtweetsanywhere-1.3.1.min', get_stylesheet_directory_uri() . '/js/jquery.jtweetsanywhere-1.3.1.min.js', array( 'jquery' ), false, true );
        wp_register_script( 'jquery.jplayer.min', get_stylesheet_directory_uri() . '/js/jquery.jplayer.min.js', array(), false, true );
        
        wp_register_script( 'jquery.fancybox.pack', get_stylesheet_directory_uri() . '/js/jquery.fancybox.pack.js', array(), false, true );
        
        wp_register_script( 'jquery.mega', get_stylesheet_directory_uri() . '/js/jquery.mega.js', array( 'jquery' ), false, true );

        if ( ! is_404() ) {
            
            $portfolio_present = get_posts( array( 'post_type' => 'portfolio', 'posts_per_page' => -1 ) );
            if ( is_page_template( 'page-portfolio.php' ) && $portfolio_present ) :
                    wp_enqueue_script( 'jquery.isotope.min' );
                    wp_enqueue_script( 'jquery.portfolio' );
            endif;
            
            if ( is_page_template( 'page-front.php' ) && $portfolio_present ) :
                wp_enqueue_script( 'jquery.isotope.min');
                wp_enqueue_script( 'jquery.home-portfolio');
            endif;
            
            wp_enqueue_script( 'jquery.shortcodes' );
            
            if ( is_active_widget( false, false, 'widget_recent_twitter_updates', true ) ) {
                wp_enqueue_script( 'jquery.jtweetsanywhere-1.3.1.min' );
            }
            
            wp_enqueue_script( 'jquery.mega' );
        
        }
        
    }
    add_action( 'wp_enqueue_scripts', 'mega_enqueue_scripts' ); 

    /**
     * Initialize jQuery Plugins.
     */
    function mega_initialize_jquery_plugins() {
        
    ?>
        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <?php
        global $wp_the_query;
        $pageid = $wp_the_query->get_queried_object_id();
        $mediaType = get_post_meta( $pageid, 'mega_portfolio_type', true );
        $project_slideshow = get_post_meta( $pageid, 'mega_portfolio_slideshow', true );
        
        $autoplay = ot_get_option( 'autoplay' );
        $pause_on_hover = ot_get_option( 'pause_on_hover' );
        $delay = ot_get_option( 'delay' );
        $control_navigation = ot_get_option( 'control_navigation' );
        
        if ( ! empty( $autoplay ) ) {
            $autoplay = 'true';
        } else {
            $autoplay = 'false';
        }
                
        if ( ! empty( $pause_on_hover ) ) {
            $pause_on_hover = 'true';
        } else {
            $pause_on_hover = 'false';
        }
                
        if ( empty( $delay ) ) {
            $delay = 4500;
        }
        
        ?>
        
        <?php $home_slider = ot_get_option( 'home_slider_list', array() ); ?>
        <?php $home_slider_height = ot_get_option( 'home_slider_height' ); ?>
        <?php if ( is_page_template( 'page-front.php' ) && ! empty( $home_slider ) || is_page_template( 'page-front-shop.php' ) && ! empty( $home_slider ) ) { ?>
                <script>
                jQuery(document).ready(function($) {
                    var homeSlider = jQuery('#home-slider').royalSlider({
                        arrowsNav: false,
                        slidesSpacing: 5,
                        numImagesToPreload: 5,
                        loop: true,
                        keyboardNavEnabled: true,
                        autoScaleHeight: true,
                        arrowsNavAutoHide: false,
                        autoScaleSlider: true,
                        autoScaleSliderWidth: 959,
                        autoScaleSliderHeight: <?php echo $home_slider_height; ?>,
                        imageScalePadding: 0,
                        globalCaption: false,
                        controlNavigation: 'bullets',
                        thumbs: {
                            arrows: false,
                            spacing: 5,
                            firstMargin: false,
                            autoCenter: false
                        },
                        autoPlay: {
                            enabled: <?php echo $autoplay; ?>,
                            pauseOnHover: <?php echo $pause_on_hover; ?>,
                            delay: <?php echo $delay; ?>
                        },
                        fadeInAfterLoaded: true,
                        fadeinLoadedSlide: true,
                        autoHeight: false,
                        imageScaleMode: 'none',
                        imageAlignCenter: false,
                        startSlideId: 0,
                        transitionSpeed: 600,
                        randomizeSlides: false,
                        navigateByClick: true
                    });
                });
            </script>
        <?php } ?>

        <?php   
        global $wp_the_query;
        $pageid = $wp_the_query->get_queried_object_id();
        $portfolio_slider_height = get_post_meta( $pageid, 'mega_portfolio_slider_height', true );
        if ( empty( $portfolio_slider_height ) )
            $portfolio_slider_height = 600;
        ?>
        <?php if ( is_singular( 'portfolio' ) && $mediaType == 'Images' && $project_slideshow == 'Yes' ) { ?>
                <script>
                jQuery(document).ready(function($) {            
                    var portfolioSlider = jQuery('#portfolio-slider').royalSlider({
                        arrowsNav: true,
                        arrowsNavHideOnTouch: true,
                        slidesSpacing: 5,
                        numImagesToPreload: 15,
                        loop: true,
                        keyboardNavEnabled: true,
                        autoScaleHeight: true,
                        autoHeight: false,
                        arrowsNavAutoHide: false,
                        autoScaleSlider: true,
                        autoScaleSliderWidth: 940,
                        autoScaleSliderHeight: <?php echo $portfolio_slider_height; ?>, //can be commented out for even height
                        imageScalePadding: 30,
                        globalCaption: true,
                        controlNavigation: 'none',
                        autoPlay: true,
                        fadeInAfterLoaded: true,
                        fadeinLoadedSlide: true,
                        startSlideId: 0,
                        transitionSpeed: 600,
                        randomizeSlides: false,
                        navigateByClick: true,
                        fullscreen: {
                            enabled: false,
                            nativeFS: true
                        },
                        visibleNearby: {
                            enabled: false,
                            centerArea: 0.75,
                            center: true,
                            breakpoint: 650,
                            breakpointCenterArea: 0.64,
                            navigateByCenterClick: true
                        }
                    });
                });
            </script>
        <?php } ?>
        
        
        <script>
        jQuery(document).ready(function($) {
        var $royalSlider = $('.gallery-shortcode');
        $royalSlider.imagesLoaded( function(){
            $royalSlider.royalSlider({
                arrowsNav: true,
                        arrowsNavHideOnTouch: true,
                        slidesSpacing: 5,
                        numImagesToPreload: 15,
                        loop: true,
                        keyboardNavEnabled: true,
                        autoScaleHeight: true,
                        autoHeight: false,
                        arrowsNavAutoHide: false,
                        autoScaleSlider: true,
                        autoScaleSliderWidth: 940,
                        autoScaleSliderHeight: 600,
                        imageScalePadding: 30,
                        globalCaption: false,
                        controlNavigation: 'none',
                        autoPlay: true,
                        fadeInAfterLoaded: true,
                        fadeinLoadedSlide: true,
                        startSlideId: 0,
                        transitionSpeed: 600,
                        randomizeSlides: false,
                        navigateByClick: true,
                        fullscreen: {
                            enabled: false,
                            nativeFS: true
                        }

            });
        });
        $(".gallery-shortcode img").addClass("rsImg");
        });
        </script>
        
        <?php $tracking_code = ot_get_option( 'tracking_code' ); ?>
        <?php if ( ! empty( $tracking_code ) ) { ?>
            <?php echo $tracking_code; ?>
        <?php } ?>
    <?php
    }
    add_action( 'wp_footer', 'mega_initialize_jquery_plugins' );

    /**
     * Load up our theme meta boxes and related code.
     */
        require( get_stylesheet_directory() . '/inc/meta-functions.php' );
        require( get_stylesheet_directory() . '/inc/meta-box-post.php' );
        require( get_stylesheet_directory() . '/inc/meta-box-portfolio.php' );
        require( get_stylesheet_directory() . '/inc/meta-box-page.php' );
       
    /**
     * Get Attachement ID from URL.
     */
    function mega_get_attachment_id( $url ) {

        $dir = wp_upload_dir();
        $dir = trailingslashit($dir['baseurl']);

        if( false === strpos( $url, $dir ) )
            return false;

        $file = basename($url);

        $query = array(
            'post_type' => 'attachment',
            'fields' => 'ids',
            'meta_query' => array(
                array(
                    'value' => $file,
                    'compare' => 'LIKE',
                )
            )
        );

        $query['meta_query'][0]['key'] = '_wp_attached_file';
        $ids = get_posts( $query );

        foreach( $ids as $id )
            if( $url == array_shift( wp_get_attachment_image_src($id, 'full') ) )
                return $id;

        $query['meta_query'][0]['key'] = '_wp_attachment_metadata';
        $ids = get_posts( $query );

        foreach( $ids as $id ) {

            $meta = wp_get_attachment_metadata($id);

            foreach( $meta['sizes'] as $size => $values )
                if( $values['file'] == $file && $url == array_shift( wp_get_attachment_image_src($id, $size) ) ) {
                    return $id;
                }
        }

        return false;
    }

    /**
     * Get Vimeo & YouTube Thumbnail.
     */
    function mega_get_video_image($url){
        if(preg_match('/youtube/', $url)) {         
            if(preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches)) {
                return "http://img.youtube.com/vi/".$matches[1]."/default.jpg";  
            }
        }
        elseif(preg_match('/vimeo/', $url)) {           
            if(preg_match('~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~', $url, $matches))    {
                    $id = $matches[1];  
                    if (!function_exists('curl_init')) die('CURL is not installed!');
                    $url = "http://vimeo.com/api/v2/video/".$id.".php";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                    $output = unserialize(curl_exec($ch));
                    $output = $output[0]["thumbnail_medium"]; 
                    curl_close($ch);
                    return $output;
            }
        }       
    }

    /**
     * Retrieve YouTube/Vimeo iframe code from URL.
     */
    function mega_get_video( $postid, $width = 940, $height = 308 ) {
        $video_url = get_post_meta( $postid, 'mega_youtube_vimeo_url', true );  
        if(preg_match('/youtube/', $video_url)) {           
            if(preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $video_url, $matches)) {
                $output = '<iframe width="'. $width .'" height="'. $height .'" src="http://www.youtube.com/embed/'.$matches[1].'?wmode=transparent&showinfo=0&rel=0" frameborder="0" allowfullscreen></iframe> ';
            }
            else {
                $output = __( 'Sorry that seems to be an invalid YouTube URL.', 'mega' );
            }           
        }
        elseif(preg_match('/vimeo/', $video_url)) {         
            if(preg_match('~^https://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~', $video_url, $matches)) {               
                $output = '<iframe src="http://player.vimeo.com/video/'. $matches[1] .'?title=0&amp;byline=0&amp;portrait=0" width="'. $width .'" height="'. $height .'" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>';          
            }
            else {
                $output = __( 'Sorry that seems to be an invalid Vimeo URL.', 'mega' );
            }           
        }
        else {
            $output = __( 'Sorry that seems to be an invalid YouTube or Vimeo URL.', 'mega' );
        }   
        echo $output;   
    }

    /**
     * Get Image Percentage Size.
     */
    function mega_get_image_size_percentage( $width, $height ) {
        $percent= 100;
        $ratio =  $width / $height ;
        
        if ( $ratio < 0.75 ) $percent = 37.5;
        else if ( $ratio < 0.92 ) $percent = 47;
        else if ( $ratio < 1.17 ) $percent = 56.3;
        else if ( $ratio < 1.42 ) $percent = 75;
        else if ( $ratio < 1.64 ) $percent = 84.5;
        else $percent = 100;
            
        return $percent;
    }

    /**
     * Remove the WordPress Image Caption Extra 10px Width.
     */
    class fixImageMargins{
        public $xs = 0; //change this to change the amount of extra spacing

        public function __construct(){
            add_filter('img_caption_shortcode', array(&$this, 'fixme'), 10, 3);
        }
        public function fixme($x=null, $attr, $content){

            extract(shortcode_atts(array(
                    'id'    => '',
                    'align'    => 'alignnone',
                    'width'    => '',
                    'caption' => ''
                ), $attr));

            if ( 1 > (int) $width || empty($caption) ) {
                return $content;
            }

            if ( $id ) $id = 'id="' . $id . '" ';

        return '<div ' . $id . 'class="wp-caption ' . $align . '" style="width: ' . ((int) $width + $this->xs) . 'px">'
        . $content . '<p class="wp-caption-text">' . $caption . '</p></div>';
        }
    }
    $fixImageMargins = new fixImageMargins();

    /**
     * Filter Primary Typography Fields.
     */
    function filter_typography_fields( $array, $field_id ) {
      if ( $field_id == 'primary_typography' ) {
        $array = array(
            'font-family'
        );
      }
      
      return $array;
    }
    add_filter( 'ot_recognized_typography_fields', 'filter_typography_fields', 10, 2 );

    /**
     * Filter Header Typography Fields.
     */
    function filter_header_typography_fields( $array, $field_id ) {
      if ( $field_id == 'header_typography' ) {
        $array = array(
            'font-family'
        );
      }
      
      return $array;
    }
    add_filter( 'ot_recognized_typography_fields', 'filter_header_typography_fields', 10, 2 );

    // Remove WooCommerce styles and scripts unless inside the store.
    function woo_scripts() {
        //if ( 'product' !== get_post_type() && !is_page( 'cart' ) && !is_page( 'checkout' ) ) {
            wp_dequeue_script( 'prettyPhoto' );
            wp_dequeue_script( 'prettyPhoto-init' );
            wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
        //}
        global $woocommerce;
        if ( $woocommerce ) {
            if ( is_product() ) {
                wp_enqueue_script( 'jquery.fancybox.pack' );
            }
        }
    }
    add_action( 'wp_enqueue_scripts', 'woo_scripts', 99 );

    // Convert Hex Color to RGB
    function hex2rgb($hex) {
       $hex = str_replace("#", "", $hex);

       if(strlen($hex) == 3) {
          $r = hexdec(substr($hex,0,1).substr($hex,0,1));
          $g = hexdec(substr($hex,1,1).substr($hex,1,1));
          $b = hexdec(substr($hex,2,1).substr($hex,2,1));
       } else {
          $r = hexdec(substr($hex,0,2));
          $g = hexdec(substr($hex,2,2));
          $b = hexdec(substr($hex,4,2));
       }
       $rgb = array($r, $g, $b);
       //return implode(",", $rgb); // returns the rgb values separated by commas
       return $rgb; // returns an array with the rgb values
    }

    function string_limit_words($string, $word_limit)
    {
        $words = explode(' ', $string, ($word_limit + 1));
        
        if(count($words) > $word_limit) {
            array_pop($words);
        }
        
        return implode(' ', $words);
    }

    /*
     * Enqueue the Droid Sans font.
    function custom_fonts() {
      $protocol = is_ssl() ? 'https' : 'http';
        wp_enqueue_style( 'mytheme-droidsans', "$protocol://fonts.googleapis.com/css?family=Dosis:400,700' rel='stylesheet' type='text/css'" );
    }
    add_action( 'wp_enqueue_scripts', 'custom_fonts' );
    */

    // Function which shows Font AvenirBlack in the toolbar on the Tiny MCE editor
    function myformatTinyMCE($in)
    {
    $in['theme_advanced_fonts']='AvenirBlack=AvenirBlack' ;
    return $in;
    }
    add_filter('tiny_mce_before_init', 'myformatTinyMCE' );


    //  Removestupid p tags around images
    function filter_ptags_on_images($content){
       return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
    }

    add_filter('the_content', 'filter_ptags_on_images');

    //Add filter to remove reviews site-wide 
    add_filter( 'woocommerce_product_tabs', 'sb_woo_remove_reviews_tab', 98);
    function sb_woo_remove_reviews_tab($tabs) {

     unset($tabs['reviews']);

     return $tabs;
    }

    //parse PHP in a widget

    add_filter('widget_text', 'php_text', 99);

    function php_text($text) {
     if (strpos($text, '<' . '?') !== false) {
     ob_start();
     eval('?' . '>' . $text);
     $text = ob_get_contents();
     ob_end_clean();
     }
     return $text;
    }
    add_filter( 'widget_text', 'do_shortcode' );

    // ADD CUSTOM POST TYPES TO RSS FEED //
     
    function add_cpts_to_rss_feed( $args ) {
      if ( isset( $args['feed'] ) && !isset( $args['post_type'] ) )
        $args['post_type'] = array('post', 'portfolio');
      return $args;
    }
    add_filter( 'request', 'add_cpts_to_rss_feed' );
    ?>