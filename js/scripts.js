/*!
    * Start Bootstrap - Creative v6.0.3 (Modified by CodingLife Dev)
    * Copyright 2013-2020 Start Bootstrap
    * Licensed under MIT
    */
(function($) {
  "use strict";

  // Smooth scrolling using jQuery easing
  $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: (target.offset().top - 72)
        }, 1000, "easeInOutExpo");
        return false;
      }
    }
  });

  // Closes responsive menu when a scroll trigger link is clicked
  $('.js-scroll-trigger').click(function() {
    $('.navbar-collapse').collapse('hide');
  });

  // Activate scrollspy to add active class to navbar items on scroll
  $('body').scrollspy({
    target: '#mainNav',
    offset: 75
  });

  // Collapse Navbar
  var navbarCollapse = function() {
    if ($("#mainNav").offset().top > 100) {
      $("#mainNav").addClass("navbar-scrolled");
    } else {
      $("#mainNav").removeClass("navbar-scrolled");
    }
  };
  navbarCollapse();
  $(window).scroll(navbarCollapse);

  // Back to Top button visibility
  var backToTop = $('#backToTop');
  $(window).scroll(function() {
    if ($(this).scrollTop() > 400) {
      backToTop.addClass('visible');
    } else {
      backToTop.removeClass('visible');
    }
  });

  // Scroll animation for elements
  var animateOnScroll = function() {
    $('.service-box, .card, .partner-card, .contact-box').each(function() {
      var elementTop = $(this).offset().top;
      var elementVisible = 150;
      var windowHeight = $(window).height();
      var scrollTop = $(window).scrollTop();

      if (elementTop < scrollTop + windowHeight - elementVisible) {
        $(this).addClass('fade-in-up');
      }
    });
  };

  $(window).on('scroll', animateOnScroll);
  $(window).on('load', animateOnScroll);

  // Navbar brand text toggle on scroll
  $(window).scroll(function() {
    if ($(this).scrollTop() > 50) {
      $('.brand-text').css('color', '#1a1a2e');
    } else {
      $('.brand-text').css('color', '#1a1a2e');
    }
  });

  // Magnific popup calls
  if ($('#portfolio').length) {
    $('#portfolio').magnificPopup({
      delegate: 'a',
      type: 'image',
      tLoading: 'Loading image #%curr%...',
      mainClass: 'mfp-img-mobile',
      gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0, 1]
      },
      image: {
        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
      }
    });
  }

  // Preloader (optional - remove if not needed)
  $(window).on('load', function() {
    $('.preloader').fadeOut('slow', function() {
      $(this).remove();
    });
  });

})(jQuery);
