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

function cogito_preprocess_region(&$vars){

}

function cogito_preprocess_page(&$vars){
	drupal_set_message(t('Dummy.'), "status");
	drupal_set_message(t('Dummy.'), "warning");
	drupal_set_message(t('Dummy.'), "error");
	
	kpr($vars);
  /**
   * WE need to do a little work to figure out the widths of things
   */
   $page = &$vars['page'];
  
  if ($page['right_sidebar'] && $page['left_sidebar']){
  	$cols = "3col";
  }
  elseif (!$page['right_sidebar'] && !$page['left_sidebar']){
  	$cols = "1col";
  }
  elseif ($page['left_sidebar']){
  	$cols = "2col_lsb";
  }
  elseif ($page['right_sidebar']){
  	$cols = "2col_rsb";
  }
  else {
  	$cols = "1col";
  }
  
  	switch ($cols) {
      case "2col_rsb":
      	$vars['rsb_size'] = cogito_foundation_sizer(theme_get_setting('2col_rsb_right'));
      	$vars['lsb_size'] = "";
      	$vars['content_size'] = cogito_foundation_sizer(theme_get_setting('2col_rsb_center'));
      	break;
      case "2col_lsb":
      	$vars['rsb_size'] = "";
      	$vars['lsb_size'] = cogito_foundation_sizer(theme_get_setting('2col_lsb_left'));
      	$vars['content_size'] = cogito_foundation_sizer(theme_get_setting('2col_lsb_center'));
      	break;
      case "1col":
      	$vars['rsb_size'] = "";
      	$vars['lsb_size'] = "";
      	$vars['content_size'] = "ten centered";
      	break;
      //four is a nice small number that will still show something      
      default:
      	$vars['rsb_size'] = cogito_foundation_sizer(theme_get_setting('3col_right'));
      	$vars['lsb_size'] = cogito_foundation_sizer(theme_get_setting('3col_left'));
      	$vars['content_size'] = cogito_foundation_sizer(theme_get_setting('3col_center'));
      	break;
  }
}


/**
 * Changes the search form to use the HTML5 "search" input attribute
 */

function cogito_preprocess_search_block_form(&$vars) {

  $vars['search_form'] = str_replace('type="text"', 'type="search"', $vars['search_form']);
  $vars['search_form'] = str_replace('class="form-submit"', 'class="form-submit button black"', $vars['search_form']);
}

function cogito_preprocess_menu_link(&$vars) {
	$vars['element']['#attributes']['class'][] = "button black";
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


function cogito_status_messages(&$variables){
  $display = $variables['display'];
  $output = '';

  $status_heading = array(
    'status' => t('Status message'), 
    'error' => t('Error message'), 
    'warning' => t('Warning message'),
  );
  
  $equiv = Array(
  'status' => 'success',
  'warning' => 'warning',
  'error' => 'error');
  
  foreach (drupal_get_messages($display) as $type => $messages) {
    $output .= "<div class=\"messages alert-box $equiv[$type]\">\n";
    if (!empty($status_heading[$type])) {
      $output .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
    }
    if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        $output .= '  <li>' . $message . "</li>\n";
      }
      $output .= " </ul>\n";
    }
    else {
      $output .= $messages[0];
    }
    $output .= "<a href=\"#\" class=\"close\">&times;</a></div>\n";
  }
  return $output;
}


function cogito_foundation_sizer($num){
  $nums = Array ("denada", "one","two", "three","four","five", "six", "seven", "eight", "nine", "ten", "eleven", "twelve");
	return $nums[$num];
}