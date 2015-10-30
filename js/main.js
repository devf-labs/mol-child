/*--------------------------------------------------------------
 Custom js
 --------------------------------------------------------------*/
jQuery(document).ready(function ($) {
  'use strict';

  // Fitvids
  $(".container").fitVids();

  //setup parallax
  $.stellar({
    horizontalScrolling: false,
    scrollProperty: 'scroll',
    responsive: true,
    positionProperty: 'position'
  });

  $('.gallery,.single-featured').magnificPopup({
    delegate: 'a', // child items selector, by clicking on it popup will open
    type: 'image',
    removalDelay: 300,
    mainClass: 'mfp-fade',
    gallery: {
      enabled: true
    }
  });

  $('.popup-video').magnificPopup({
    type: 'iframe',
    mainClass: 'mfp-fade',
    removalDelay: 160,
    preloader: false,
    fixedContentPos: false
  });

  //owl carousel
  $(".wpb_row .client").owlCarousel(
    {
      nav: true,
      dots: false,
      loop: true,
      autoplay: true,
      autoplayHoverPause: true,
      autoplayTimeout: 3000,
      autoHeight: true,
      margin: 20,
      responsive: {
        0: {
          items: 2
        },
        768: {
          items: 3
        },
        1024: {
          items: 6
        }
      }
    }
  );
  $(".single-project .gallery").owlCarousel(
    {
      nav: false,
      dots: false,
      loop: true,
      autoplay: true,
      autoplayHoverPause: true,
      autoplayTimeout: 3000,
      margin: 20,
      responsive: {
        0: {
          items: 2
        },
        768: {
          items: 3
        },
        1024: {
          items: 6
        }
      }
    }
  );

  $(".single-project .wpb_gallery .wpb_image_grid_ul").owlCarousel(
    {
      nav: false,
      dots: false,
      loop: true,
      autoplay: true,
      autoplayHoverPause: true,
      autoplayTimeout: 3000,
      margin: 10,
      responsive: {
        0: {
          items: 2
        },
        768: {
          items: 3
        },
        1024: {
          items: 6
        }
      }
    }
  );

  $(".wpb_row .testimonials-list").owlCarousel(
    {
      items: 1,
      nav: false,
      dots: true,
      loop: true,
      autoplay: true,
      autoplayHoverPause: true
    }
  );

  $(".post-gallery.slider").owlCarousel(
    {
      items: 1,
      nav: true,
      dots: false,
      loop: true,
      autoHeight:true,
      autoplay: true,
      autoplayHoverPause: true,
      autoplayTimeout: 3000,
      animateOut: 'fadeOut',
      animateIn: 'fadeIn'
    }
  );

  var $grid = $(".post-gallery.masonry").masonry({
    itemSelector: '.thumb-masonry-item',
    columnWidth: '.grid-thumb-sizer',
    percentPosition: true,
    gutter: 10
  });

  $grid.imagesLoaded().progress(function() {
    $grid.masonry('layout');
  })

  // mobile menu setup
  var $menu = $('.nav'),
    $menulink = $('.menu-link'), $subMenu = $(".sub-menu");

  $menulink.on('click', function () {
    $menulink.toggleClass('active');
    $menu.toggleClass('active');
  });

  $menu.find('#primary-menu > li > a').on('click', function(e){

      var parent = $(this).parent('li');

      if(parent.find('.sub-menu').length > 0){
        e.preventDefault();
      }

      var display = parent.find('.sub-menu').css("display");
      if (display === 'block') {
        parent.find('.sub-menu').css("display", "none");
      }else{
        parent.find('.sub-menu').css("display", "block");
      }
  });

  // $(document).on('click', function (e) {
  //   if ($(e.target).hasClass('.menu-link').length == 0) {
  //     $menulink.removeClass('active');
  //     $menu.removeClass('active');
  //   }
  // });

  // search in menu
  var $search_btn = $('.search-box > i'),
    $search_input = $('.search-field'),
    $search_form = $('form.search-form');

  $search_btn.on('click', function () {
    $search_form.toggleClass('active');
  });

  $search_input.focus(function () {
    $search_form.toggleClass('active');
  });

  $(document).on('click', function (e) {
    if ($(e.target).closest($search_btn).length == 0
      && $(e.target).closest('input.search-field').length == 0
      && $search_form.hasClass('active')) {
      $search_form.removeClass('active');
    }
  });

  // categories widget
  var $i = 0;
  $('.widget_categories').find('li').each(function () {
    var $li = $(this);
    if (0 != $li.children('ul.children').length) {
      $('ul.children').css('margin-left', -$i);
      $i += 40;
      $('ul.children > li').css('padding-left', $i);
    }
  });
});