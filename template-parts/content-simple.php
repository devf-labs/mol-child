<?php
/**
 * Template part for displaying posts.
 * Simple layout
 *  @package ThemeMove
 */
?>
<article <?php post_class('post-simple-item'); ?>>
  <?php if(has_post_thumbnail()) { ?>
    <div class="post-img">
      <a href="<?php echo get_permalink() ?>"><?php the_post_thumbnail('simple-thumb'); ?></a>
      <?php if(has_post_format('video')) { ?>
        <i class="fa fa-video-camera"></i>
      <?php } ?>
      <?php if(has_post_format('audio')) { ?>
        <i class="fa fa-music"></i>
      <?php } ?>
    </div>
  <?php } ?>

  <div class="entry-header">
    <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
    <div class="post-date">
      <?php infinity_posted_on(); ?>
    </div><!--post-date-->
  </div><!-- .entry-header -->
</article>