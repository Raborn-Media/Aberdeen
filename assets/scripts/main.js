// Import everything from autoload folder
import './autoload/**/*'; // eslint-disable-line
/*global  ajax_object*/
// Import local dependencies
import './plugins/lazyload';
import './plugins/modernizr.min';
import 'slick-carousel';
import 'jquery-match-height';
import objectFitImages from 'object-fit-images';
// import '@fancyapps/fancybox/dist/jquery.fancybox.min';
// import { jarallax, jarallaxElement } from 'jarallax';
// import ScrollOut from 'scroll-out';

/**
 * Import scripts from Custom Divi blocks
 */
// eslint-disable-next-line import/no-unresolved
// import '../blocks/divi/**/index.js';

/**
 * Import scripts from Custom Elementor widgets
 */
// eslint-disable-next-line import/no-unresolved
// import '../blocks/elementor/**/index.js';

/**
 * Import scripts from Custom ACF Gutenberg blocks
 */
// eslint-disable-next-line import/no-unresolved
// import '../blocks/gutenberg/**/index.js';

/**
 * Init foundation
 */
$(document).foundation();

/**
 * Fit slide video background to video holder
 */
function resizeVideo() {
  let $holder = $('.videoHolder');
  $holder.each(function () {
    let $that = $(this);
    let ratio = $that.data('ratio') ? $that.data('ratio') : '16:9';
    let width = parseFloat(ratio.split(':')[0]);
    let height = parseFloat(ratio.split(':')[1]);
    $that.find('.video').each(function () {
      if ($that.width() / width > $that.height() / height) {
        $(this).css({
          width: '100%',
          height: 'auto',
        });
      } else {
        $(this).css({
          width: ($that.height() * width) / height,
          height: '100%',
        });
      }
    });
  });
}

/**
 * Scripts which runs after DOM load
 */
$(document).on('ready', function () {
  /*
  Ajax Filter Activities
   */
  let filters = $('.tax-filter');
  filters.on('change', function () {
    let activity = $('#activity_types option:selected').attr('title');
    let accessibility = $('#accessibility option:selected').attr('title');
    let duration = $('#duration option:selected').attr('title');
    $.ajax({
      type: 'POST',
      url: ajax_object.ajax_url, // get from wp_localize_script()
      data: {
        action: 'filter_posts', // action for wp_ajax_ & wp_ajax_nopriv_
        activity_types: activity,
        accessibility: accessibility,
        duration: duration,
        paged: 1,
      },

      beforeSend: function () {
        // button.text('Loading...'); // change the button text, you can also add a preloader image
      },
      success: function (data) {
        $('.activities-wrap').html(data.data); // insert new posts
      },
    });
  });

  // Add event listener for pagination links
  // $(document).on('click', '.pagination a', function (e) {
  //   e.preventDefault();
  //   let page = $(this).text(); // Extract page number from link
  //   if ($(this).hasClass('next')) {
  //     page = parseInt($('.pagination .current').text()) + 1;
  //   }
  //   if ($(this).hasClass('prev')) {
  //     page = parseInt($('.pagination .current').text()) - 1;
  //   }
  //   let activity = $('#activity_types option:selected').attr('title');
  //   let accessibility = $('#accessibility option:selected').attr('title');
  //   let duration = $('#duration option:selected').attr('title');
  //
  //   $.ajax({
  //     type: 'POST',
  //     url: ajax_object.ajax_url, // get from wp_localize_script()
  //     data: {
  //       action: 'filter_posts', // action for wp_ajax_ & wp_ajax_nopriv_
  //       activity_types: activity,
  //       accessibility: accessibility,
  //       duration: duration,
  //       paged: page,
  //     },
  //     beforeSend() {},
  //     success: function (data) {
  //       $('.activities-wrap').html(data.data); // insert new posts
  //     },
  //   });
  // });
  // Add event listener for pagination links
  $(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    let page = $(this).text(); // Extract page number from link
    if ($(this).hasClass('next')) {
      page = parseInt($('.pagination .current').text()) + 1;
    }
    if ($(this).hasClass('prev')) {
      page = parseInt($('.pagination .current').text()) - 1;
    }

    let activity = $('#activity_types option:selected').attr('title');
    let accessibility = $('#accessibility option:selected').attr('title');
    let duration = $('#duration option:selected').attr('title');

    $.ajax({
      type: 'POST',
      url: ajax_object.ajax_url, // get from wp_localize_script()
      data: {
        action: 'filter_posts', // action for wp_ajax_ & wp_ajax_nopriv_
        activity_types: activity,
        accessibility: accessibility,
        duration: duration,
        paged: page,
      },
      beforeSend() {},
      success: function (data) {
        $('.activities-wrap').html(data.data); // insert new posts

        // Update pagination info
        const pagination = document.querySelector('.pagination');
        const currentPage = parseInt(
          pagination.getAttribute('data-current-page'),
          10
        );
        const totalPages = parseInt(
          pagination.getAttribute('data-total-pages'),
          10
        );
        const paginationInfo = document.getElementById('pagination-info');
        paginationInfo.innerHTML = `Page ${currentPage} of ${totalPages}`;
      },
    });
  });

  const pagination = document.querySelector('.pagination');

  // Get current page and total pages from data attributes
  const currentPage = parseInt(
    pagination.getAttribute('data-current-page'),
    10
  );
  const totalPages = parseInt(pagination.getAttribute('data-total-pages'), 10);

  // Get reference to the pagination info div
  const paginationInfo = document.getElementById('pagination-info');

  // Update the text content of the elements with the current and total pages
  paginationInfo.innerHTML = `Page ${currentPage} of ${totalPages}`;
  /**
   * News/Events slider
   */
  $('.post-slider').slick({
    dots: false,
    infinite: true,
    arrows: true,
    speed: 300,
    slidesToShow: 3,
    slidesToScroll: 1,
    // nextArrow: '.slick-next',
    // prevArrow: '.slick-prev',
  });
  // Get all elements of the flexible content
  var $flexibleSections = $('.flexible-section');

  // Check if there are flexible sections
  if ($flexibleSections.length > 0) {
    // Remove padding from all sections to reset
    // $flexibleSections.css('padding-bottom', '0');

    // Add padding-bottom only to the last section
    $flexibleSections.last().css('padding-bottom', '474px');
  }

  $('.search-button-show').on('click', function () {
    $('.search-form').toggleClass('show');
  });
  /**
   * Make elements equal height
   */
  $('.matchHeight').matchHeight();

  /**
   * IE Object-fit cover polyfill
   */
  if ($('.of-cover').length) {
    objectFitImages('.of-cover');
  }

  /**
   * Add fancybox to images
   */
  // $('.gallery-item')
  //   .find('a[href$="jpg"], a[href$="png"], a[href$="gif"]')
  //   .attr('rel', 'gallery')
  //   .attr('data-fancybox', 'gallery');
  // $(
  //   '.fancybox, a[rel*="album"], a[href$="jpg"], a[href$="png"], a[href$="gif"]'
  // ).fancybox({
  //   minHeight: 0,
  //   helpers: {
  //     overlay: {
  //       locked: false,
  //     },
  //   },
  // });

  /**
   * Init parallax
   */
  // jarallaxElement();
  // jarallax(document.querySelectorAll('.jarallax'), {
  //   speed: 0.5,
  // });

  /**
   * Detect element appearance in viewport
   */
  // ScrollOut({
  //   offset: function() {
  //     return window.innerHeight - 200;
  //   },
  //   once: true,
  //   onShown: function(element) {
  //     if ($(element).is('.ease-order')) {
  //       $(element)
  //         .find('.ease-order__item')
  //         .each(function(i) {
  //           let $this = $(this);
  //           $(this).attr('data-scroll', '');
  //           window.setTimeout(function() {
  //             $this.attr('data-scroll', 'in');
  //           }, 300 * i);
  //         });
  //     }
  //   },
  // });

  /**
   * Remove placeholder on click
   */
  const removeFieldPlaceholder = () => {
    $('input, textarea').each((i, el) => {
      $(el)
        .data('holder', $(el).attr('placeholder'))
        .on('focusin', () => {
          $(el).attr('placeholder', '');
        })
        .on('focusout', () => {
          $(el).attr('placeholder', $(el).data('holder'));
        });
    });
  };

  removeFieldPlaceholder();

  $(document).on('gform_post_render', () => {
    removeFieldPlaceholder();
  });

  /**
   * Scroll to Gravity Form confirmation message after form submit
   */
  $(document).on('gform_confirmation_loaded', function (event, formId) {
    let $target = $('#gform_confirmation_wrapper_' + formId);
    if ($target.length) {
      $('html, body').animate({ scrollTop: $target.offset().top - 50 }, 500);
      return false;
    }
  });

  /**
   * Hide gravity forms required field message on data input
   */
  $('body').on(
    'change keyup',
    '.gfield input, .gfield textarea, .gfield select',
    function () {
      let $field = $(this).closest('.gfield');
      if ($field.hasClass('gfield_error') && $(this).val().length) {
        $field.find('.validation_message').hide();
      } else if ($field.hasClass('gfield_error') && !$(this).val().length) {
        $field.find('.validation_message').show();
      }
    }
  );

  /**
   * Add `is-active` class to menu-icon button on Responsive menu toggle
   * And remove it on breakpoint change
   */
  $(window)
    .on('toggled.zf.responsiveToggle', function () {
      $('.menu-icon').toggleClass('is-active');
    })
    .on('changed.zf.mediaquery', function () {
      $('.menu-icon').removeClass('is-active');
    });

  /**
   * Close responsive menu on orientation change
   */
  $(window).on('orientationchange', function () {
    setTimeout(function () {
      if ($('.menu-icon').hasClass('is-active') && window.innerWidth < 641) {
        $('[data-responsive-toggle="main-menu"]').foundation('toggleMenu');
      }
    }, 200);
  });

  resizeVideo();
});

/**
 * Scripts which runs after all elements load
 */
$(window).on('load', function () {
  // jQuery code goes here

  let $preloader = $('.preloader');
  if ($preloader.length) {
    $preloader.addClass('preloader--hidden');
  }
});

/**
 * Scripts which runs at window resize
 */
$(window).on('resize', function () {
  // jQuery code goes here

  resizeVideo();
});

/**
 * Scripts which runs on scrolling
 */
$(window).on('scroll', function () {
  // jQuery code goes here
});
/* global google */

/**
 * initMap
 *
 * Renders a Google Map onto the selected jQuery element
 *
 * @date    22/10/19
 * @since   5.8.6
 *
 * @param   jQuery $el The jQuery element.
 * @return  object The map instance.
 */
function initMap($el) {
  // Find marker elements within map.
  var $markers = $el.find('.marker');

  // Create gerenic map.
  var mapArgs = {
    zoom: $el.data('zoom') || 16,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
  };
  var map = new google.maps.Map($el[0], mapArgs);

  // Add markers.
  map.markers = [];
  $markers.each(function () {
    initMarker($(this), map);
  });

  // Center map based on markers.
  centerMap(map);

  // Return map instance.
  return map;
}

/**
 * initMarker
 *
 * Creates a marker for the given jQuery element and map.
 *
 * @date    22/10/19
 * @since   5.8.6
 *
 * @param   jQuery $el The jQuery element.
 * @param   object The map instance.
 * @return  object The marker instance.
 */
function initMarker($marker, map) {
  // Get position from marker.
  var lat = $marker.data('lat');
  var lng = $marker.data('lng');
  var latLng = {
    lat: parseFloat(lat),
    lng: parseFloat(lng),
  };

  // Create marker instance.
  var marker = new google.maps.Marker({
    position: latLng,
    map: map,
  });

  // Append to reference for later use.
  map.markers.push(marker);

  // If marker contains HTML, add it to an infoWindow.
  if ($marker.html()) {
    // Create info window.
    var infowindow = new google.maps.InfoWindow({
      content: $marker.html(),
    });

    // Show info window when marker is clicked.
    google.maps.event.addListener(marker, 'click', function () {
      infowindow.open(map, marker);
    });
  }
}

/**
 * centerMap
 *
 * Centers the map showing all markers in view.
 *
 * @date    22/10/19
 * @since   5.8.6
 *
 * @param   object The map instance.
 * @return  void
 */
function centerMap(map) {
  // Create map boundaries from all map markers.
  var bounds = new google.maps.LatLngBounds();
  map.markers.forEach(function (marker) {
    bounds.extend({
      lat: marker.position.lat(),
      lng: marker.position.lng(),
    });
  });

  // Case: Single marker.
  if (map.markers.length == 1) {
    map.setCenter(bounds.getCenter());

    // Case: Multiple markers.
  } else {
    map.fitBounds(bounds);
  }
}

// Render maps on page load.
$(document).ready(function () {
  $('.contact__map').each(function () {
    initMap($(this));
  });
});
