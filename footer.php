<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package ThemeMove
 */

?>
</div>

  <!-- Footer
    ================================================== -->
  <footer id="colophon" role="contentinfo">
  
    <div class="greyLine"></div>
    <div id="site-generator-wrapper">
      <section id="site-generator" class="clearfix">
        
        
          
        <?php
        /*
         * Print the footer info.
         */
        $footer_info = ot_get_option( 'footer_info' );
        ?>

        <?php if ( ! empty( $footer_info ) ) { ?>
          <?php echo $footer_info; ?>
        <?php } ?>
        <?php get_template_part('template-parts/social-accounts' ); // Social accounts ?>
        <?php
        /*
         * Print the sub-footer info.
         */
        $sub_footer_info = ot_get_option( 'sub_footer_info' );
        ?>
        
        <div id="sub-footer-info">
          <?php if ( ! empty( $sub_footer_info ) ) { ?>
            <?php echo $sub_footer_info; ?>
          <?php } ?>
        </div>
      </section>
    </div><!-- #site-generator-wrapper -->
  </footer><!-- #colophon -->
</section>
<!-- Scroll to top -->
<?php if (get_theme_mod('enable_back_to_top', enable_back_to_top)) { ?>
  <a class="scrollup"><i class="fa fa-angle-up"></i><?php echo __('Go to top', 'thememove'); ?></a>
<?php } ?>

<?php wp_footer(); ?>
<script>
  var $ = jQuery;
  $(function(){
    $(".products").eq(1).find('h3').text("Other Products you might like");
    $('img').each(function(i, el){
      var $el = $(el);
      var src = $el.attr('src');
      var logoidx = src.indexOf('mol_logo');
      var idxof = src.indexOf('/wp-content/uploads/');
      if(idxof > 0 && logoidx === -1){
        var imgPath = src.substring(idxof);
        var newSrc = 'http://moodofliving.com' + imgPath;
        $el.attr('src', newSrc);
      }
    });

    $('.featured-post-link').each(function(i, el){
      var $el = $(el);
      var src = $el.css('background-image');
      // http://localhost/mood_of_living/wp-content/uploads/2015/07/New_LAYOUT_Slider-22.jpg
      src = src.replace('url(', '').replace(');', '').replace(')', '');
      var idxof = src.indexOf('/wp-content/uploads/');

      if(idxof > 0){
        var imgPath = src.substring(idxof);
        var newSrc = 'http://moodofliving.com' + imgPath;
        $el.css('background-image', 'url('+newSrc+')');
        // console.log($el.css('background-image'), newSrc)
      }
    });
  })
</script>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c56d6c507ed878" async="async"></script>
</body>
</html>
