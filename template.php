<?php

/**
 * @file
 * Contains theme override functions and preprocess functions for the Boron theme.
 */

/*****************************************************************************************************************************/
/* WARNING!!!! NEVER CHANGE ANYTHING IN THIS FOLDER!!! USE A CHILD THEME! CHECK OUT "STARTER-CHILD" FOLDER FOR INSTRUCTIONS  */
/*****************************************************************************************************************************

/**
 * Changes the default meta content-type tag to the shorter HTML5 version
 */
function cogito_html_head_alter(&$head_elements) {
  $head_elements['system_meta_content_type']['#attributes'] = array(
    'charset' => 'utf-8'
  );
}


function cogito_preprocess_block(&$vars){
  $region_orient = theme_get_setting('region');
  $region = $vars['elements']['#block']->region;
  $orientation = $region_orient[$region];
  if ($orientation == "h"){
    $vars['classes_array'][] = "columns";
  }
}

function cogito_preprocess_page(&$vars){

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
    	$vars['rsb_size'] = cogito_foundation_sizer(theme_get_setting('two_columns_rsb_right'));
    	$vars['lsb_size'] = "";
    	$vars['content_size'] = cogito_foundation_sizer(theme_get_setting('two_columns_rsb_content'));
    	break;
    case "2col_lsb":
    	$vars['rsb_size'] = "";
    	$vars['lsb_size'] = cogito_foundation_sizer(theme_get_setting('two_columns_lsb_left'));
    	$vars['content_size'] = cogito_foundation_sizer(theme_get_setting('two_columns_lsb_content'));
    	break;
    case "1col":
    	$vars['rsb_size'] = "";
    	$vars['lsb_size'] = "";
    	$vars['content_size'] = cogito_foundation_sizer(theme_get_setting('one_column_content')) . " centered";
    	break;
    //four is a nice small number that will still show something      
    default:
    	$vars['rsb_size'] = cogito_foundation_sizer(theme_get_setting('three_columns_right'));
    	$vars['lsb_size'] = cogito_foundation_sizer(theme_get_setting('three_columns_left'));
    	$vars['content_size'] = cogito_foundation_sizer(theme_get_setting('three_columns_content'));
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
	//$vars['element']['#attributes']['class'][] = "button black";
}
	
/**
 * Implements theme_breadcrumb().
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

/**
 * Implements theme_status_messages().
 *
 * Squash drupal's status messages to fit with foundation
 */

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


/**
 * Helper Function: You say "3", I say "three"
 *
 */

function cogito_foundation_sizer($num){
  $nums = Array ("denada", "one","two", "three","four","five", "six", "seven", "eight", "nine", "ten", "eleven", "twelve");
	return $nums[$num];
}


/**
 * Implements theme_pager().
 *
 * Drupal's pager system is terrible so this is a first stab at a rewrite.
 * Basically we're squashing it into a shape that Foundation Pager likes
 */

function cogito_pager($variables) {
  $tags = $variables['tags'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $quantity = $variables['quantity'];
  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  $li_first = theme('pager_first', array('text' => (isset($tags[0]) ? $tags[0] : t('« first')), 'element' => $element, 'parameters' => $parameters));
  $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('‹ previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('next ›')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_last = theme('pager_last', array('text' => (isset($tags[4]) ? $tags[4] : t('last »')), 'element' => $element, 'parameters' => $parameters));

  if ($pager_total[$element] > 1) {
    if ($li_first) {
      $items[] = array(
        'class' => array('pager-first'), 
        'data' => $li_first,
      );
    }
    if ($li_previous) {
      $items[] = array(
        'class' => array('pager-previous'), 
        'data' => $li_previous,
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 1) {
        $items[] = array(
          'class' => array('pager-ellipsis'), 
          'data' => '…',
        );
      }
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => array('pager-item'), 
            'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => array('current'), 
            'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => array('pager-item'), 
            'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
          );
        }
      }
      if ($i < $pager_max) {
        $items[] = array(
          'class' => array('pager-ellipsis'), 
          'data' => '…',
        );
      }
    }
    
    // End generation.
    if ($li_next) {
      $items[] = array(
        'class' => array('pager-next'), 
        'data' => $li_next,
      );
    }
    if ($li_last) {
      $items[] = array(
        'class' => array('pager-last'), 
        'data' => $li_last,
      );
    }
    return '<div class="row cogito_paginate"><h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
      'items' => $items, 
      'attributes' => array('class' => array('pagination')),
    )) . "</div>";
  }
}


/**
 * Implements theme_button().
 *
 * This is how we force drupal to use Foundation's buttons
 */
function cogito_button($variables) {
  $variables['element']['#attributes']['class'][] = 'nice small button black';
  return theme_button($variables);
}


/**
 * Implements theme_form().
 *
 * Forcing Drupal to use foundation's "nice" forms elements
 */

function cogito_form($variables) {
  $variables['element']['#attributes']['class'][] = 'nice';
  return theme_form($variables);
  
}

//Not working yet: need to add input-text class to all relevant inputs
function cogito_form_element($variables) {
  //kpr($variables);
  return theme_form_element($variables);
}