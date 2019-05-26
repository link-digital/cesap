  <div id="page">

    <header>
    <?php print render($page['header']) ?>
      <div id="header-container">
        <div id="header-bar-lg">
	        <div class="container">
	          <a href="<?php print base_path() ?>" class="logo-link">
	            <?php if(!empty($logo_header_lg)): ?>
	            <img src="<?php print $logo_header_lg ?>" class="logo logo-lg" alt="logo">
	            <?php else: ?>
	            <img src="<?php print $logo ?>" class="logo logo-lg" alt="logo">
	            <?php endif;
	                  if(!empty($logo_header_sm)): ?>
	            <img src="<?php print $logo_header_sm ?>" class="logo logo-sm" alt="logo">
	            <?php else: ?>
	            <img src="<?php print $logo ?>" class="logo logo-sm" alt="logo">
	            <?php endif; ?>
	          </a>
	          <?php if ($main_menu): ?>
	          <nav id="main-nav-lg">
	          <?php print theme('links__system_main_menu', array('links' => $main_menu, 'attributes' => array('id' => 'main-menu-desk', 'class' => array('clean', 'clearfix', 'clean-a', 'horizontal')))); ?>
	          </nav>
	          <?php endif ?>
	        </div>
        </div>
        <?php if ($main_menu): ?>
        <div id="header-bar-sm">
          <nav id="main-nav-sm">
            <button class="btn-primary">
              <div></div>
              <div></div>
              <div></div>
            </button>
            <a class="logo-link">
              <?php if(!empty($logo_header_sm)): ?>
              <img src="<?php print $logo_header_sm ?>" class="logo logo-sm" alt="logo">
              <?php else: ?>
              <img src="<?php print $logo ?>" class="logo logo-sm" alt="logo">
              <?php endif; ?>
            </a>
            <div id="mobile-menu-wrapper">
              <?php print theme('links__system_main_menu', array('links' => $main_menu, 'attributes' => array('id' => 'main-menu-mobile', 'class' => array('clean clean-a')))); ?>
            </div>
          </nav>
        </div>
        <?php endif ?>
      </div>
    </header>

    <div class="container">
      <?php print $messages; ?>
    </div>

    <main id="content">
      <a id="main-content"></a>
      <?php if ($tabs): ?><div class="tabs"><?php print render($tabs); ?></div><?php endif; ?>
      <?php print render($title_prefix); ?>
      <?php if ($title): ?><h1 class="title" id="page-title"><?php print $title; ?></h1><?php endif; ?>
      <?php print render($title_suffix); ?>
      <?php print render($page['help']); ?>
      <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
      <?php print render($page['content']); ?>
      <?php print $feed_icons; ?>
    </main> <!-- /.section, /#content -->

    <footer>
      <a href="<?php print base_path() ?>" class="logo-link">
        <?php if(!empty($logo_footer_lg)): ?>
        <img src="<?php print $logo_footer_lg ?>" class="logo-lg" alt="logo">
        <?php else: ?>
        <img src="<?php print $logo ?>" class="logo-lg" alt="logo">
        <?php endif;
              if(!empty($logo_footer_sm)): ?>
        <img src="<?php print $logo_footer_sm ?>" class="logo-sm" alt="logo">
        <?php endif ?>
      </a>
      <?php print render($page['footer']); ?>
    </footer>


  </div>
