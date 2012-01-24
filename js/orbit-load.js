/**
 * @file
 * This file provides whatever javascript logic and functions are necessary for
 * the Foundation Orbit plugin in the re_contextlibraries module.
 *
 * Developed by the Zurb Foundation people.
 *
 * @see http://foundation.zurb.com/docs/orbit.php
 * @see http://www.zurb.com/playground/orbit-jquery-image-slider
 */
(function ($) {
  Drupal.behaviors.orbit = {
    attach: function(context) {



      $('#block-views-slideshow-block .view-id-slideshow').css({
        height: '300px',
      });

            
      
      $('#featured').orbit({
        animation: 'fade', // fade, horizontal-slide, vertical-slide, horizontal-push
        animationSpeed: 100, // how fast animtions are
        timer: true, // true or false to have the timer
        advanceSpeed: 4000, // if timer is enabled, time between transitions
        pauseOnHover: false, // if you hover pauses the slider
        startClockOnMouseOut: false, // if clock should start on MouseOut
        startClockOnMouseOutAfter: 1000, // how long after MouseOut should the timer start again
        directionalNav: true, // manual advancing directional navs
        captions: true, // do you want captions?
        captionAnimation: 'slideOpen', // fade, slideOpen, none
        captionAnimationSpeed: 800, // if so how quickly should they animate in
        bullets: false, // true or false to activate the bullet navigation
        bulletThumbs: false, // thumbnails for the bullets
        bulletThumbLocation: '', // location from this file where thumbs will be
        afterSlideChange: function(){}, // empty function
        fluid: true // or set a aspect ratio for content slides (ex: '4x3')
      });

      $('#photo_gallery').orbit({
        animation: 'horizontal-slide', // fade, horizontal-slide, vertical-slide, horizontal-push
        animationSpeed: 800, // how fast animtions are
        timer: true, // true or false to have the timer
        advanceSpeed: 4000, // if timer is enabled, time between transitions
        pauseOnHover: false, // if you hover pauses the slider
        startClockOnMouseOut: false, // if clock should start on MouseOut
        startClockOnMouseOutAfter: 1000, // how long after MouseOut should the timer start again
        directionalNav: true, // manual advancing directional navs
        captions: true, // do you want captions?
        captionAnimation: 'fade', // fade, slideOpen, none
        captionAnimationSpeed: 800, // if so how quickly should they animate in
        bullets: true, // true or false to activate the bullet navigation
        bulletThumbs: false, // thumbnails for the bullets
        bulletThumbLocation: '', // location from this file where thumbs will be
        afterSlideChange: function(){}, // empty function
        fluid: '4x3' // or set a aspect ratio for content slides (ex: '4x3')
      });
      /* we need this fix for images FOR BOTH PHOTO GALLERIES AND FRONTPAGE */
      $('.orbit-slide img').css({
        height: '100%'
      });
      
    }
  }; /* Drupal.behaviors.orbit */
})(jQuery);