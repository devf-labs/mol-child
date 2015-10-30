<?php
/**
 * The default template for displaying summary for portfolio
 *
 * @package ThemeMove
 */
?>	


	<article id="post-<?php the_ID(); ?>" <?php post_class(array('clearfix', 'col-sm-4')); ?>>
		<div class="content-wrapper">

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="post-thumbnail clearfix">
				
				<?php $portfolio_custom_url = get_post_meta( get_the_ID(), 'mega_portfolio_custom_url', true ); ?>
				
				<a href="<?php if ( ! empty( $portfolio_custom_url ) ) echo $portfolio_custom_url; else the_permalink(); ?>" rel="bookmark">
						
						<?php the_post_thumbnail( 'medium', array('class' => 'attachment-thumbnail post-thumbnail wp-post-image') ); ?>
						<div class="mask"></div>
						
								
						<div class="portfolio-view-wrapper">
							<div class="portfolio-view">
								<div class="portfolio-view-content">
									
									<header class="entry-header">
										<?php $portfolio_meta = ot_get_option( 'portfolio_meta' ); ?>
										<?php if ( $portfolio_meta == 'categories' ) { ?>
											<h4 style="text-align:center;"><?php echo custom_taxonomies_terms_links(); ?></h4>
										<?php } ?>
										<h2><?php the_title(); ?></h2>
									</header><!-- .entry-header -->
									
								</div>
							</div>
						</div>
					</a>
				</div>
			<?php endif; // End if ( has_post_thumbnail() ) ?>

		</div><!-- .content-wrapper -->
	</article><!-- #post-<?php the_ID(); ?> -->
