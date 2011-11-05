<?php
function cogito_form_system_theme_settings_alter(&$form, &$form_state) {

  /**
   * Breadcrumb settings
   * Copied from Boron and previously from Zen
   */
  $form['breadcrumb'] = array(
   '#type' => 'fieldset',
   '#title' => t('Breadcrumb'),
  );
  $form['breadcrumb']['breadcrumb_display'] = array(
   '#type' => 'select',
   '#title' => t('Display breadcrumb'),
   '#default_value' => theme_get_setting('breadcrumb_display'),
   '#options' => array(
     'yes' => t('Yes'),
     'no' => t('No'),
   ),
  );
  $form['breadcrumb']['breadcrumb_separator'] = array(
   '#type'  => 'textfield',
   '#title' => t('Breadcrumb separator'),
   '#description' => t('Text only. Dont forget to include spaces.'),
   '#default_value' => theme_get_setting('breadcrumb_separator'),
   '#size' => 8,
   '#maxlength' => 10,
  );
  $form['breadcrumb']['breadcrumb_home'] = array(
   '#type' => 'checkbox',
   '#title' => t('Show the homepage link in breadcrumbs'),
   '#default_value' => theme_get_setting('breadcrumb_home'),
  );
  $form['breadcrumb']['breadcrumb_trailing'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Append a separator to the end of the breadcrumb'),
    '#default_value' => theme_get_setting('breadcrumb_trailing'),
    '#description'   => t('Useful when the breadcrumb is placed just before the title.'),
  );
  $form['breadcrumb']['breadcrumb_title'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Append the content title to the end of the breadcrumb'),
    '#default_value' => theme_get_setting('breadcrumb_title'),
    '#description'   => t('Useful when the breadcrumb is not placed just before the title.'),
  );
  
  $numbers = array(
     '1' => t('One'),
     '2' => t('Two'),
     '3' => t('three'),
     '4' => t('four'),
     '5' => t('five'),
     '6' => t('six'),    
     '7' => t('seven'),
     '8' => t('eight'),
     '9' => t('nine'),
     '10' => t('ten'),
     '11' => t('eleven'),
     '12' => t('twelve')
   );
  /**
   * Main layout Settings (3 Col setup)
   */

  $form['3col'] = array(
   '#type' => 'fieldset',
   '#title' => t('3 Column Layout'),
   '#description' => t('These must add up to \'Twelve\'. Don\'t make me come over there and validate you!'),
  );

  
  $form['3col']['left_Sidebar'] = array(
   '#type' => 'select',
   '#title' => t('Left Sidebar'),
   '#default_value' => theme_get_setting('3col_left'),
   '#options' =>   $numbers,
  );

  $form['3col']['content'] = array(
   '#type' => 'select',
   '#title' => t('Content'),
   '#default_value' => theme_get_setting('3col_center'),
   '#options' =>   $numbers,
  );


  $form['3col']['right_sidebar'] = array(
   '#type' => 'select',
   '#title' => t('Right Sidebar'),
   '#default_value' => theme_get_setting('3col_right'),
   '#options' =>   $numbers,
  );
  

  /**
   * Main layout Settings
   */

  $form['2col'] = array(
   '#type' => 'fieldset',
   '#title' => t('2 Column Layout'),
   '#description' => t('For a two column layout there is the content and one sidebar. These must add up to \'Twelve\'. too!'),
  );

  $form['2col']['left'] = array(
   '#type' => 'fieldset',
   '#title' => t('Left Sidebar + content'),
  );
  
   $form['2col']['right'] = array(
   '#type' => 'fieldset',
   '#title' => t('Content + Right Sidebar'),
  );

  
  $form['2col']['left']['left_Sidebar'] = array(
   '#type' => 'select',
   '#title' => t('Left Sidebar'),
   '#default_value' => theme_get_setting('2col_lsb_left'),
   '#options' =>   $numbers,
  );

  $form['2col']['left']['content'] = array(
   '#type' => 'select',
   '#title' => t('Content'),
   '#default_value' => theme_get_setting('2col_lsb_center'),
   '#options' =>   $numbers,
  );
  $form['2col']['right']['content'] = array(
   '#type' => 'select',
   '#title' => t('Content'),
   '#default_value' => theme_get_setting('2col_rsb_center'),
   '#options' =>   $numbers,
  );
  $form['2col']['right']['right_sidebar'] = array(
   '#type' => 'select',
   '#title' => t('Right Sidebar'),
   '#default_value' => theme_get_setting('2col_rsb_right'),
   '#options' =>   $numbers,
  );

}

