<?php
/**
 * The default template for displaying content
 *
 * @package ThemeMove
 * @subpackage Lily
 */
?>
<?php echo $as ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
		
		<div class="entry-content-meta-wrapper">
			<header class="entry-header">
				<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permanent Link to %s', 'mega' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

				<?php if ( 'post' == get_post_type() ) : ?>
				<div class="entry-meta">
					<i class="pictogram">&#128213;</i>
					<span class="sep"> | </span>
					<?php mega_posted_on(); ?>
				</div><!-- .entry-meta -->
				<?php endif; ?>

			</header><!-- .entry-header -->
		
			<div class="entry-content">
				<?php the_content( __( 'Continue reading article <span class="meta-nav">&rarr;</span>', 'mega' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'mega' ) . '</span>', 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
				
			<footer class="entry-meta">
		
				<?php $show_sep = false; ?>
				<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
				<?php
					/* translators: used between list items, there is a space after the comma */
					$categories_list = get_the_category_list( __( ', ', 'mega' ) );
					if ( $categories_list ):
				?>
				<span class="cat-links">
					<?php printf( __( '<span class="%1$s"><i class="pictogram">&#59392;</i></span> %2$s', 'mega' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
					$show_sep = true; ?>
				</span>
				<?php endif; // End if categories ?>
				<?php
					/* translators: used between list items, there is a space after the comma */
					$tags_list = get_the_tag_list( '', __( ', ', 'mega' ) );
					if ( $tags_list ):
					if ( $show_sep ) : ?>
				<span class="sep"> | </span>
					<?php endif; // End if $show_sep ?>
				<span class="tag-links">
					<?php printf( __( '<span class="%1$s"><i class="pictogram">&#59148;</i></span> %2$s', 'mega' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
					$show_sep = true; ?>
				</span>
				<?php endif; // End if $tags_list ?>
				<?php endif; // End if 'post' == get_post_type() ?>

				<?php if ( comments_open() ) : ?>
				<?php if ( $show_sep ) : ?>
				<span class="sep"> | </span>
				<?php endif; // End if $show_sep ?>
				<span class="comments-link"><?php comments_popup_link( '<i class="pictogram">&#59160;</i> '. __( 'Comment', 'mega' ) .'', __( '<i class="pictogram">&#59160;</i> <b>1</b> Comment', 'mega' ), __( '<i class="pictogram">&#59160;</i> <b>%</b> Comments', 'mega' ) ); ?></span>
				<?php endif; // End if comments_open() ?>

				<?php if ( $show_sep ) : ?>
					<?php $sep = '<span class="sep"> | </span>' ?>
				<?php endif; // End if $show_sep ?>
				
				<?php edit_post_link( __( '<i class="pictogram">&#9998;</i> Edit', 'mega' ), '' . $sep . '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- #entry-meta -->
		</div><!-- .entry-content-meta-wrapper -->
		
		<?php if ( is_single() ) : // Checks if any single post is being displayed ?>
			<nav id="nav-single">
				<h3 class="assistive-text"><?php _e( 'Post navigation', 'mega' ); ?></h3>
				<span class="nav-previous"><?php previous_post_link( '%link', __( 'Older <i class="icon-chevron-right"></i>', 'mega' ) ); ?></span>
				<span class="sep"> | </span>
				<span class="nav-next"><?php next_post_link( '%link', __( '<i class="icon-chevron-left"></i> Newer', 'mega' ) ); ?></span>
			</nav><!-- #nav-single -->
			
			<?php comments_template( '', true ); ?>
		<?php endif; // End if ( is_single() ) ?>
		
	</article><!-- #post-<?php the_ID(); ?> -->
	