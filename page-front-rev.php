<?php
/**
 * Template Name: Front Page Rev
 *
 * @package ThemeMove
 * @subpackage Lily Child
 */

get_header(); ?>

    <div id="main" class="clearfix">

        <div id="primary">
            <div id="content" role="main">      
                <div id="block-rev-slider" class="clearfix">
                    
                    <?php $revAlias = get_post_meta( $post->ID, 'mega_revslider_alias', true ); ?>
                    <?php putRevSlider( $revAlias ) ?>
                            
                </div><!-- #block-rev-slider -->

                <div class="latest-stories margin-40 clearfix">
                    <div class="before"></div>
                    <h4>A quality of Lifestyle Magazine and Global Marketplace</h4>
                </div>
                
                <?php $enable_home_banners_shop = ot_get_option( 'enable_home_banners_shop' ); ?>
                <?php if ( ! empty( $enable_home_banners_shop ) ) { ?>
                    <?php $home_banners_shop = ot_get_option( 'home_banners_shop_list', array() ); ?>
                            
                    <?php if ( ! empty( $home_banners_shop ) ) { ?>
                        <div id="home-banners-wrapper" class="clearfix">
                            <div id="home-banners" class="clearfix">
                                            
                                <?php foreach( $home_banners_shop as $banner ) : ?>
                                    <div class="banner">
                                        <?php if ( ! empty( $banner['home_banner_link'] ) ) { ?>
                                            <a href="<?php echo $banner['home_banner_link']; ?>">
                                        <?php } ?>
                                        
                                        <?php if ( ! empty( $banner['home_banner_image'] ) ) { ?>
                                            <img src="<?php echo $banner['home_banner_image']; ?>" alt="<?php echo $banner['title']; ?>" class="rsImg" data-rsTmb="<?php echo $banner['home_banner_image']; ?>" />
                                        <?php } ?>
                                        
                                        <?php if ( ! empty( $banner['title'] ) || ! empty( $banner['home_banner_description'] ) || ! empty( $banner['home_banner_link'] ) ) { ?>
                                            <?php $rgb = hex2rgb( $banner['home_banner_highlight_color'] ); ?>
                                            <div class="banner-info-wrapper" style="background-color: <?php echo $banner['home_banner_highlight_color']; ?>">
                                                <div class="banner-info clearfix">
                                                    <?php if ( ! empty( $banner['title'] ) ) { ?>
                                                        <h2><?php echo $banner['title']; ?></h2>
                                                    <?php } ?>
                                                        
                                                    <?php if ( ! empty( $banner['home_banner_description'] ) ) { ?>
                                                        <p class="home-banner-description"><?php echo $banner['home_banner_description']; ?></p>
                                                    <?php } ?>  
                                                </div><!-- .banner-info -->
                                            </div><!-- .banner-info-wrapper -->
                                        <?php } ?>
                                        
                                        <?php if ( ! empty( $banner['home_banner_link'] ) ) { ?>
                                            </a>
                                        <?php } ?>
                                    </div><!-- .banner -->
                                        
                                <?php endforeach; ?>
                                        
                            </div><!-- #home-banners -->
                        </div><!-- #home-banners-wrappper -->
                                
                    <?php } else { ?>
                            
                    <?php } // End if ( ! empty( $home_slider_shop ) ) ?>
                <?php } // End if ( ! empty( $enable_home_slider_shop ) ) ?>
                
                
                <div id="home-portfolio-wrapper" class="clearfix row">
                        
                        
                        <div id="home-portfolio" class="home-portfolio-home">
                            <div class="row">
                                
                        <?php
                            $home_portfolios_per_page = ot_get_option( 'home_portfolios_per_page' );

                            $travel_portfolios = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => 1, 'no_found_rows' => true, 'post_status' => 'publish', 'portfolio-category' => 'travel'));  

                            $culture_portfolios = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => 1, 'no_found_rows' => true, 'post_status' => 'publish', 'portfolio-category' => 'culture')); 

                            $meet_portfolios = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => 1, 'no_found_rows' => true, 'post_status' => 'publish', 'portfolio-category' => 'meet')); 

                            $shop_portfolios = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => 1, 'no_found_rows' => true, 'post_status' => 'publish', 'portfolio-category' => 'find')); 
                            
                        ?>  

                                <?php /* Start the Loops */ ?>
                                    
                                <?php while ( $travel_portfolios->have_posts() ) : $travel_portfolios->the_post(); ?>
                                    <!-- <div class="col-md-4"> -->
                                        <?php get_template_part( 'template-parts/content-portfolio' ); ?>
                                    <!-- </div> -->
                                <?php endwhile; ?>
                                
                                <?php while ( $culture_portfolios->have_posts() ) : $culture_portfolios->the_post(); ?>
                                    <!-- <div class="col-md-4"> -->
                                        <?php get_template_part( 'template-parts/content-portfolio' ); ?>
                                    <!-- </div> -->
                                <?php endwhile; ?>
                                
                                <?php while ( $meet_portfolios->have_posts() ) : $meet_portfolios->the_post(); ?>
                                    <!-- <div class="col-md-4"> -->
                                        <?php get_template_part( 'template-parts/content-portfolio' ); ?>
                                    <!-- </div> -->
                                <?php endwhile; ?>
                                
                                <?php while ( $shop_portfolios->have_posts() ) : $shop_portfolios->the_post(); ?>
                                    <!-- <div class="col-md-4"> -->
                                        <?php get_template_part( 'template-parts/content-portfolio' ); ?>
                                    <!-- </div> -->
                                <?php endwhile; ?>

                                <?php wp_reset_query(); ?>
                                <?php  if ( !empty( $post->post_content ) ) : ?>
                                    <div class="home-content col-sm-4">
                                        <?php the_content(); ?>
                                    </div>
                                <?php endif; ?>
                                <?php wp_reset_query(); ?>

                                <?php

                                    $wellness_portfolios = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => 1, 'no_found_rows' => true, 'post_status' => 'publish', 'portfolio-category' => 'wellness')); 
                                    $design_portfolios = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => 1, 'no_found_rows' => true, 'post_status' => 'publish', 'portfolio-category' => 'design')); 
                                    $food_portfolios = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => 1, 'no_found_rows' => true, 'post_status' => 'publish', 'portfolio-category' => 'food')); 
                                    $mom = new WP_Query(array('post_type' => 'post', 'posts_per_page' => 1, 'no_found_rows' => true, 'post_status' => 'publish', 'category' => 'journal')); 
                                
                                ?>

                                <?php while ( $wellness_portfolios->have_posts() ) : $wellness_portfolios->the_post(); ?>
                                    <!-- <div class="col-md-4"> -->
                                        <?php get_template_part( 'template-parts/content-portfolio' ); ?>
                                    <!-- </div> -->
                                <?php endwhile; ?>

                                <?php while ( $design_portfolios->have_posts() ) : $design_portfolios->the_post(); ?>
                                    <!-- <div class="col-md-4"> -->
                                        <?php get_template_part( 'template-parts/content-portfolio' ); ?>
                                    <!-- </div> -->
                                <?php endwhile; ?>

                                <?php while ( $food_portfolios->have_posts() ) : $food_portfolios->the_post(); ?>
                                    <!-- <div class="col-md-4"> -->
                                        <?php get_template_part( 'template-parts/content-portfolio' ); ?>
                                    <!-- </div> -->
                                <?php endwhile; ?>

                                <?php while ( $mom->have_posts() ) : $mom->the_post(); ?>
                                    <!-- <div class="col-md-4"> -->
                                        <?php get_template_part( 'template-parts/content-portfolio' ); ?>
                                    <!-- </div> -->
                                <?php endwhile; ?>
                                                        
                            <?php wp_reset_query(); ?>
                            
                            </div>
                        </div><!-- #home-portfolio -->
                    </div><!-- #home-portfolio-wrapper -->
                    

                    
            </div><!-- #content -->
        </div><!-- #primary -->
    
<?php get_footer(); ?>