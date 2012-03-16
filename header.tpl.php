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
