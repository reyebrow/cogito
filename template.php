<?php

/**
 * @file
 * Contains theme override functions and preprocess functions for the Boron theme.
 */

/**
 * Changes the default meta content-type tag to the shorter HTML5 version
 */
function cogito_html_head_alter(&$head_elements) {
  $head_elements['system_meta_content_type']['#attributes'] = array(
    'charset' => 'utf-8'
  );
}

/**
 * Changes the search form to use the HTML5 "search" input attribute
 */

function cogito_preprocess_search_block_form(&$vars) {

  $vars['search_form'] = str_replace('type="text"', 'type="search"', $vars['search_form']);
  $vars['search_form'] = str_replace('class="form-submit"', 'class="form-submit button black"', $vars['search_form']);
}

function cogito_preprocess_block(&$vars) {
kpr($vars);
}

function cogito_preprocess_page(&$vars) {
kpr($vars);
}


/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return
 *   A string containing the breadcrumb output.
 */
function cogito_breadcrumb($vars) {
  $breadcrumb = $vars['breadcrumb'];
  // Determine if we are to display the breadcrumb.
  $show_breadcrumb = theme_get_setting('breadcrumb_display');
  if ($show_breadcrumb == 'yes') {

    // Optionally get rid of the homepage link.
    $show_breadcrumb_home = theme_get_setting('breadcrumb_home');
    if (!$show_breadcrumb_home) {
      array_shift($breadcrumb);
    }

    // Return the breadcrumb with separators.
    if (!empty($breadcrumb)) {
      $separator = filter_xss(theme_get_setting('breadcrumb_separator'));
      $trailing_separator = $title = '';

      // Add the title and trailing separator
      if (theme_get_setting('breadcrumb_title')) {
        if ($title = drupal_get_title()) {
          $trailing_separator = $separator;
        }
      }
      // Just add the trailing separator
      elseif (theme_get_setting('breadcrumb_trailing')) {
        $trailing_separator = $separator;
      }

      // Assemble the breadcrumb
      return implode($separator, $breadcrumb) . $trailing_separator . $title;
    }
  }
  // Otherwise, return an empty string.
  return '';
}



function cogito_foundation_sizer($num){
	switch ($num) {
    case 1:
        return "one";
    case 2:
        return "two";
    case 3:
        return "three";
    case 4:
        return "four";
    case 5:
        return "five";        
    case 6:
        return "six";
    case 7:
        return "seven";
    case 8:
        return "eight";       
    case 9:
        return "nine";
    case 10:
        return "ten";
    case 11:
        return "eleven";
    case 11:
        return "twelve";  
    //four is a nice small number that will still show something      
    default:
    	return "four";
	}
	
}