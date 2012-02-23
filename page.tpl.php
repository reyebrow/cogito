<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * Available variables:

          <?php kpr(get_defined_vars());?>
 */
?>

<div id="page" class="hfeed container" role="main">


  <?php // Header  ?>
	<header id="branding" role="banner" class="row">
	
	
	 <div class="eleven columns centered"><?php //This just gives a little room on the edges.?>
    <div class="row">
      <?php // TITLE / LOGO and DESCRIPTION  ?>
			<hgroup class="columns eight">

				<h1 id="site-title">
            <?php if ($logo): ?>
              <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
                <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
              </a>
            <?php endif; ?>
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
              endif;?>
				</h1>
				<h4 id="site-description" class="subheader">
				  <?php if ($site_slogan): ?>
            <div id="site-slogan"><?php print $site_slogan; ?></div>
          <?php endif; ?>
				</h4>
			</hgroup>

      <?php // Search Bar region  ?>
      <div class="columns four"><?php print render($page['header']) ?></div>
        <?php if ($main_menu): ?>
        <p id="skip-link" class="hide-on-desktops"><em><a href="#access">Skip to Navigation</a></em> &darr;</p>
        <?php endif; ?>
			</div>
			
		</div>
    </div><?php //This just gives a little room on the edges.?>

      <?php //MAIN MENU NAVBAR  ?>
      <?php if ($page['nav']): ?>
    		<nav id="access" role="navigation" class="row">
            	<?php print render($page['nav']); ?>
        </nav>
      <?php endif; ?>

  </header> <?php // /.section, /#header  ?>


  <?php // Main Row  ?>
  <div id="main" class="row">
  	<div class="columns eleven centered"><?php //This just gives a little room on the edges.?>
  	
    	
    	<?php // Left Sidebar  ?>
      <?php if ($page['sidebar_first']): ?>
        <aside id="sidebar-left" class="columns <?php print $lsb_size; ?>" role="complementary">
          <?php print render($page['sidebar_first']); ?>
       </aside> <?php // /.section, /#sidebar-first  ?>
      <?php endif; ?>
    
    
    
      <?php // Content Region  ?>
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
      </div> <?php // /.section, /#content  ?>
  
    
      <?php // Right Sidebar  ?>
      <?php if ($page['sidebar_second']): ?>
        <aside id="sidebar-right" class="columns <?php print $rsb_size; ?>" role="complementary">
          <?php print render($page['sidebar_second']); ?>
        </aside> <?php // /.section, /#sidebar-second  ?>
      <?php endif; ?>
  
  	</div> <?php //eleven centered columns for spacing  ?>
  </div> <?php // /#main, /#main-wrapper  ?>
  
  
  <?php // Footer  ?>
  <footer id="footer" role="contentinfo" class="row">
  	 <div class="eleven columns centered"><?php //This just gives a little room on the edges.?>
	    <?php print render($page['footer']); ?>
	   </div>
  </footer> <?php // /.section, /#footer  ?>



</div> <?php // /#page, /#page-wrapper  ?>
