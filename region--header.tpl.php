<?php // TITLE / LOGO and DESCRIPTION  ?>
<hgroup id="header-wrapper" class="row hide-on-phones">    
  <?php if ($logo): ?>
    <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo" class="columns two">
      <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
    </a>
  <?php endif; ?>   
  <div class="columns ten">
    <div class="row">
      <div id="site-name-description-wrap" class="columns eight">        
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

		  <?php if ($site_slogan): ?>
        <h4 id="site-slogan"><?php print $site_slogan; ?></h4>
      <?php endif; //if ($site_slogan) ?>
      </div>
      <div id="header-region" class="columns four">
        <?php // Actual Header Region Here ?>
        <?php if ($content){
                    print $content;
              }
        ?>
      </div>
    </div> 
  </div><?php // columns ten?>
</hgroup>


<?php // TITLE / LOGO and DESCRIPTION  (MOBILE?>
<hgroup id="header-wrapper" class="row show-on-phones">    
      <div id="site-name-description-wrap" class="columns twelve">        
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

		  <?php if ($site_slogan): ?>
        <h4 id="site-slogan"><?php print $site_slogan; ?></h4>
      <?php endif; //if ($site_slogan) ?>
      </div>
</hgroup>