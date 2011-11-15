<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * Available variables:

          <?php kpr(get_defined_vars());?>
 */

include_once('modals.php');
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
    <?php if ($logo): ?>
      <a class="columns three" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
      </a>
    <?php endif; ?>

    <?php if ($site_name || $site_slogan): ?>
        <?php if ($site_name): ?>
          <?php if ($title): ?>
            <div id="site-name" class="columns five"><strong>
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
        
    <?php endif; ?>
    
    <div class="columns four"><?php print render($page['header']) ?></div>
    
    <?php if ($main_menu): ?>
      <p id="skip-link" class="hide-on-desktops"><em><a href="#navigation">Skip to Navigation</a></em> &darr;</p>
    <?php endif; ?>
  </header> <!-- /.section, /#header -->


    <?php if ($page['nav']): ?>
    <nav class="row">
      	<?php print render($page['nav']); ?>
    </nav>
    <?php endif; ?>


  <div id="main" class="row">
  	<div class="columns eleven centered">
    <?php if ($page['left_sidebar']): ?>
      <aside id="left-sidebar" class="columns <?php print $lsb_size; ?>" role="complementary">
        <?php print render($page['left_sidebar']); ?>
     </aside> <!-- /.section, /#sidebar-first -->
    <?php endif; ?>
  

    <div id="content" class="columns <?php print $content_size; ?>" role="main">
	      <?php if ($page['highlighted']): ?>
	        <?php print render($page['highlighted']); ?>
	      <?php endif; 
	      if ($breadcrumb): ?>
	        <div id="breadcrumb" class="twelve columns"><?php print $breadcrumb; ?></div>
	      <?php endif; 
	      print $messages; 
	      print render($title_prefix);
	      if ($title): ?>
	        <h1 id="page-title"><?php print $title; ?></h1>
	      <?php endif; 
	      print render($title_suffix);
	      if ($tabs): ?>
	        <div class="drupal_tabs"><?php print render($tabs); ?></div>
	      <?php endif; 
	      print render($page['help']); 
	      if ($action_links): ?>
	        <ul class="action-links"><?php print render($action_links); ?></ul>
	      <?php endif;
	      print $feed_icons; ?>

     	<?php print render($page['content']);?>
	    
    </div> <!-- /.section, /#content -->


    <?php if ($page['right_sidebar']): ?>
      <aside id="sidebar-right" class="columns <?php print $rsb_size; ?>" role="complementary">
        <?php print render($page['right_sidebar']); ?>
      </aside> <!-- /.section, /#sidebar-second -->
    <?php endif; ?>

	</div>
  </div> <!-- /#main, /#main-wrapper -->
  
  
  <footer id="footer" role="contentinfo" class="row">
	    <?php print render($page['footer']); ?>
  </footer> <!-- /.section, /#footer -->



</div> <!-- /#page, /#page-wrapper -->
