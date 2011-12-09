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

<div id="page" class="hfeed container" role="main">


  <!-- Header -->
	<header id="branding" role="banner" class="row">
	
	
	 <div class="eleven columns centered"><?php //This just gives a little room on the edges.?>
	
      <!-- TITLE / LOGO and DESCRIPTION -->
			<hgroup class="columns eight">
				<h1 id="site-title">
            <?php if ($logo): ?>
              <a class="columns three" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
                <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
              </a>
            <?php endif; ?>
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
              endif;?>
				</h1>
				<h4 id="site-description" class="subheader">
				  <?php if ($site_slogan): ?>
            <div id="site-slogan"><?php print $site_slogan; ?></div>
          <?php endif; ?>
				</h4>
			</hgroup>

      <!-- Search Bar region -->
      <div class="columns four"><?php print render($page['header']) ?></div>
        <?php if ($main_menu): ?>
        <p id="skip-link" class="hide-on-desktops"><em><a href="#navigation">Skip to Navigation</a></em> &darr;</p>
        <?php endif; ?>
			</div>
			
      <!--MAIN MENU NAVBAR -->
      <?php if ($page['nav']): ?>
    		<nav id="access" role="navigation" class="row">
            	<?php print render($page['nav']); ?>
        </nav>
      <?php endif; ?>
			
    </div><?php //This just gives a little room on the edges.?>

  </header> <!-- /.section, /#header -->


  <!-- Main Row -->
  <div id="main" class="row">
  	<div class="columns eleven centered"><?php //This just gives a little room on the edges.?>
  	
    	
    	<!-- Left Sidebar -->
      <?php if ($page['left_sidebar']): ?>
        <aside id="sidebar-left" class="columns <?php print $lsb_size; ?>" role="complementary">
          <?php print render($page['left_sidebar']); ?>
       </aside> <!-- /.section, /#sidebar-first -->
      <?php endif; ?>
    
    
    
      <!-- Content Region -->
      <div id="content" class="columns <?php print $content_size; ?>" role="main">
  	      <?php if ($page['highlighted']): ?>
  	        <?php print render($page['highlighted']); ?>
  	      <?php endif; 
  	      if ($breadcrumb): ?>
  	        <div id="breadcrumb" class="twelve columns"><?php print $breadcrumb; ?></div>
  	      <?php endif; 
  	      print $messages; 
  	      if ($title): ?>
  	        <h1 id="page-title"><?php print $title; ?></h1>
  	      <?php endif; 
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
  
    
      <!-- Right Sidebar -->
      <?php if ($page['right_sidebar']): ?>
        <aside id="sidebar-right" class="columns <?php print $rsb_size; ?>" role="complementary">
          <?php print render($page['right_sidebar']); ?>
        </aside> <!-- /.section, /#sidebar-second -->
      <?php endif; ?>
  
  	</div>
  </div> <!-- /#main, /#main-wrapper -->
  
  
  <!-- Footer -->
  <footer id="footer" role="contentinfo" class="row">
  	 <div class="eleven columns centered"><?php //This just gives a little room on the edges.?>
	    <?php print render($page['footer']); ?>
	   </div>
  </footer> <!-- /.section, /#footer -->



</div> <!-- /#page, /#page-wrapper -->
