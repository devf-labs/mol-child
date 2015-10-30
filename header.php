<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 *  @package ThemeMove
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="shortcut icon" href="<?php echo get_theme_mod('favicon_image',favicon_image); ?>">
<link rel="apple-touch-icon" href="<?php echo get_theme_mod('apple_touch_icon',apple_touch_icon); ?>"/>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="header-wrapper">
  <header <?php header_class(); ?>>
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-lg-offset-1 col-md-3 col-sm-6 col-xs-12">
        <div class="site-branding">
          <?php
          global $infinity_custom_logo;
          if($infinity_custom_logo){ ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
              <img src="<?php echo esc_url($infinity_custom_logo); ?>" alt="logo" style="max-height:70px;"/>
            </a>
          <?php }else{ ?>
            <?php if(get_theme_mod( 'logo_image', logo_image)){ ?>
              <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                <img src="<?php echo get_theme_mod('logo_image',logo_image); ?>" alt="logo" style="max-height:70px;"/>
              </a>
            <?php }else{ ?>
              <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php } ?>
          <?php } ?>
        </div>
      </div>
      <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
        <div class="row middle-sm site-branding">
          <div class="last-sm first-lg col-sm-3 col-lg-12">
            <button class="menu-link"><span class="lines"></span></button>
              <?php
              if ( class_exists( 'TM_Walker_Nav_Menu' ) && has_nav_menu( 'primary' ) ) {
                ?>
            <nav class="nav">
              <?php
                wp_nav_menu(
                  array(
                    'theme_location' => 'primary',
                    'after'          => '<i class="sub-menu-toggle fa fa-angle-down"></i>',
                    'walker'         => new TM_Walker_Nav_Menu()
                  )
                );
              ?>
            </nav><!-- .site-navigation -->

            <?php
              } else {
            ?>
            <div id="navbar" class="navbar">
              <nav id="site-navigation" class="nav" role="navigation">
            <?php
                wp_nav_menu( array( 'theme_location' => 'primary',
                                    'menu_class' => 'menu',
                                    'menu_id' => 'primary-menu' ) ); ?>
              </nav><!-- #site-navigation -->
              </div><!-- #navbar -->
            <?php  }
              ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
</div><!-- .header-wrapper -->
<div id="page" class="hfeed site animsition">
