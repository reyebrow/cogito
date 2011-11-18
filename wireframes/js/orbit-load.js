(function ($) {
//This would be great as a context library
  Drupal.behaviors.orbit = {
    attach: function (context, settings) {
	  jQuery(window).load(function() {
	    jQuery('.view-frontpage-slideshow .view-content').orbit({
	         animation: 'horizontal-push'
	     });
	   });

    }
  };

}(jQuery));