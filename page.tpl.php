<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/garland.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 */

include_once('modals.php');
/**
 * WE need to do a little work to figure out the widths of things
 */

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

//print "<div style='padding-top: 30px;'>$cols:".theme_get_setting('3col_right')."</div>";

	switch ($cols) {
    case "2col_rsb":
    	$rsb_size = cogito_foundation_sizer(theme_get_setting('2col_rsb_right'));
    	$lsb_size = "";
    	$content_size = cogito_foundation_sizer(theme_get_setting('2col_rsb_center'));
    	break;
    case "2col_lsb":
    	$rsb_size = "";
    	$lsb_size = cogito_foundation_sizer(theme_get_setting('2col_lsb_left'));
    	$content_size = cogito_foundation_sizer(theme_get_setting('2col_lsb_center'));
    	break;
    case "1col":
    	$rsb_size = "";
    	$lsb_size = "";
    	$content_size = "twelve";
    	break;
    //four is a nice small number that will still show something      
    default:
    	$rsb_size = cogito_foundation_sizer(theme_get_setting('3col_right'));
    	$lsb_size = cogito_foundation_sizer(theme_get_setting('3col_left'));
    	$content_size = cogito_foundation_sizer(theme_get_setting('3col_center'));
    	break;
}

?>
<?php if ( $is_front ): ?>
		<script>
		  jQuery(window).load(function() {
		    jQuery('.view-frontpage-slideshow .view-content').orbit({
		         animation: 'horizontal-push'
		     });
		     });
		</script>
<?php endif; ?>



<div id="page" class="container">




  <header id="header" role="banner" class="row">
	<div class="columns twelve">
    <?php if ($logo): ?>
      <a class="columns two" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
      </a>
    <?php endif; ?>

    <?php if ($site_name || $site_slogan): ?>
      <div id="name-and-slogan" class="columns ten">
        <?php if ($site_name): ?>
          <?php if ($title): ?>
            <div id="site-name"><strong>
              <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
            </strong></div>
          <?php else: /* Use h1 when the content title is empty */ ?>
            <h1 id="site-name">
              <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
            </h1>
          <?php endif;
          endif; 
          
 
         if ($site_slogan): ?>
          <div id="site-slogan"><?php print $site_slogan; ?></div>
        <?php endif; ?>
      </div> <!-- /#name-and-slogan -->
    <?php endif; 
    
    print render($page['header']);
    
    if ($main_menu): ?>
      <p id="skip-link" class="hide-on-desktops"><em><a href="#navigation">Skip to Navigation</a></em> &darr;</p>
    <?php endif; ?>

 </div>
</header> <!-- /.section, /#header -->





    <?php if ($page['nav']): ?>
      <nav id="navigation" role="navigation" class="row"><div class="section">
      	<?php print render($page['nav']); ?>
      </div></nav> <!-- /.section, /#navigation -->
    <?php endif; ?>





  <div id="main" class="row">
  
  
    <?php if ($page['left_sidebar']): ?>
      <aside id="left-sidebar" class="columns <?php print $lsb_size; ?>" role="complementary">
        <?php print render($page['left_sidebar']); ?>
     </aside> <!-- /.section, /#sidebar-first -->
    <?php endif; ?>
  
  
  

    <div id="content" class="columns <?php print $content_size; ?>" role="main">
    
	      <?php if ($page['highlighted']): ?>
	        <div id="highlighted"><?php print render($page['highlighted']); ?></div>
	      <?php endif; 
	      if ($breadcrumb): ?>
	        <div id="breadcrumb panel"><?php print $breadcrumb; ?></div>
	      <?php endif; 
	      print $messages; 
	      print render($title_prefix);
	      if ($title): ?>
	        <h1 class="title" id="page-title"><?php print $title; ?></h1>
	      <?php endif; 
	      print render($title_suffix);
	      if ($tabs): ?>
	        <div class="tabs"><?php print render($tabs); ?></div>
	      <?php endif; 
	      print render($page['help']); 
	      if ($action_links): ?>
	        <ul class="action-links"><?php print render($action_links); ?></ul>
	      <?php endif; 
	      print render($page['content']);
	      print $feed_icons; ?>
	      
    </div> <!-- /.section, /#content -->


    <?php if ($page['right_sidebar']): ?>
      <aside id="sidebar-right" class="columns <?php print $rsb_size; ?>" role="complementary">
        <?php print render($page['right_sidebar']); ?>
      </aside> <!-- /.section, /#sidebar-second -->
    <?php endif; ?>


  </div> <!-- /#main, /#main-wrapper -->
  
  
  
  <footer id="footer" role="contentinfo" class="container">
	  <div class="section row">
	    <?php print render($page['footer']); ?>
	  </div>
  </footer> <!-- /.section, /#footer -->



</div> <!-- /#page, /#page-wrapper -->
