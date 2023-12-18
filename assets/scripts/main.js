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
import ScrollOut from 'scroll-out';

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
  // Get all elements of the flexible content
  var $flexibleSections = $('.flexible-section');

  // Check if there are flexible sections
  if ($flexibleSections.length > 0) {
    // Remove padding from all sections to reset
    // $flexibleSections.css('padding-bottom', '0');

    // Add padding-bottom only to the last section
    $flexibleSections.last().css('padding-bottom', '474px');
  }
  /**
   * News/Events slider
   */
  $('.post-slider').slick({
    dots: true,
    infinite: true,
    arrows: true,
    speed: 300,
    slidesToShow: 3,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          infinite: true,
          dots: true,
          arrows: false,
        },
      },
      {
        breakpoint: 640,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false,
        },
      },
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
    ],
  });

  /**
   * Show Retire modal
   */
  $('.retire-reasons-list .card').click(function () {
    $('.card-modal').removeClass('card-modal-visible');
    $(this).find('.card-modal').addClass('card-modal-visible');
    // $('.card-modal').slideUp();
    // $(this).find('.card-modal').slideToggle();
  });

  // Hide modal on back-btn click
  $('.retire-reasons-list .card .card-modal .back').click(function (event) {
    event.stopPropagation(); // Prevent the click event from propagating to the card
    $(this).closest('.card-modal').removeClass('card-modal-visible');
  });

  /**
   * Show Header modals
   */
  $('.header-modals').hide();

  // Show Explore modal on Explore button click
  $('.explore-button').click(function () {
    $('.header-modals.move-links-modal').slideUp();
    $('.header-modals.explore-links-modal').slideToggle();
    event.stopPropagation(); // Prevent the event from bubbling up
  });

  // Show Move modal on Move button click
  $('.move-button').click(function () {
    $('.header-modals.explore-links-modal').slideUp();
    $('.header-modals.move-links-modal').slideToggle();
    event.stopPropagation(); // Prevent the event from bubbling up
  });

  // Hide modals when clicking outside of the modals
  $(document).click(function (event) {
    if (!$(event.target).closest('.header-modal-buttons').length) {
      $('.header-modals').slideUp();
    }
  });

  /**
   * Search
   */
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
  ScrollOut({
    offset: function () {
      return window.innerHeight - 200;
    },
    once: false,
    onShown: function (element) {
      if ($(element).is('.ease-order')) {
        $(element)
          .find('.ease-order__item')
          .each(function (i) {
            let $this = $(this);
            $(this).attr('data-scroll', '');
            window.setTimeout(function () {
              $this.attr('data-scroll', 'in');
            }, 300 * i);
          });
      }
    },
  });

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
  $('.menu-icon').on('click', function () {
    var headerHeight = $('.header').outerHeight();
    $('.top-bar').css('top', headerHeight);
    if ($('body').hasClass('admin-bar')) {
      $('.top-bar').css('top', headerHeight + 46);
    }
    // $('body').toggleClass('body-fixed');
  });

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
    // success: function (data) {
    //   $('.activities-wrap').html(data.data); // insert new posts
    // },
    success: function (data) {
      $('.activities-wrap').html(data.data); // insert new posts

      // Update pagination info if pagination is present
      const pagination = document.querySelector('.pagination');
      if (pagination) {
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
      }
    },
  });
});
if (!$('.search-results-section').length) {
  $(document).on('click', '.pagination a', function (e) {
    e.preventDefault();
    let page = $(this).text(); // Extract page number from link
    if ($(this).hasClass('next')) {
      page = parseInt($('.pagination .current').text()) + 1;
    }
    if ($(this).hasClass('prev')) {
      page = parseInt($('.pagination .current').text()) - 1;
    }
    let postType = $('.institutions-list').data('post-type');

    $.ajax({
      type: 'POST',
      url: ajax_object.ajax_url, // get from wp_localize_script()
      data: {
        action: 'ajax_institutions_pagination', // action for wp_ajax_ & wp_ajax_nopriv_
        postType: postType,
        paged: page,
      },
      beforeSend() {},
      success: function (data) {
        $('.institutions-list-wrap').html(data.data); // insert new posts

        // Update pagination info if pagination is present
        const pagination = document.querySelector('.pagination');
        if (pagination) {
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
        }
      },
    });
  });
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

        // Update pagination info if pagination is present
        const pagination = document.querySelector('.pagination');
        if (pagination) {
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
        }
      },
    });
  });
}

const pagination = document.querySelector('.pagination');

// Update the text content of the elements with the current and total pages
if (pagination) {
  // Get current page and total pages from data attributes
  const currentPage = parseInt(
    pagination.getAttribute('data-current-page'),
    10
  );
  const totalPages = parseInt(pagination.getAttribute('data-total-pages'), 10);

  // Get reference to the pagination info div
  const paginationInfo = document.getElementById('pagination-info');

  paginationInfo.innerHTML = `Page ${currentPage} of ${totalPages}`;
}
