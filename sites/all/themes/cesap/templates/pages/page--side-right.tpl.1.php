  <div id="page">

    <header>
      <div id="top-menu-container">
        <div class="container">
        <?php print render($page['top_bar']) ?>
        </div>
      </div>
      <div id="header-container">
        <div id="header-bar-lg">
          <div class="container">
            <div class="flex flex-header">
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
              <?php print theme('links__system_main_menu', array('links' => $main_menu, 'attributes' => array('id' => 'main-menu-desk', 'class' => array('clean', 'clean-a', 'flex', 'uppercase')))); ?>
              </nav>
              <?php endif ?>
              <div class="login font-roboto-cnd font-bold uppercase">
                <a class="btn btn-green-1-blue-1" href="<?php print url('user') ?>">Ingresar <i class="fa fa-angle-right"></i></a>
              </div>
            </div>
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
      <?php if ($title): ?>
        <div class="bg-page-title">
          <div class="container color-white clean-a flex flex-middle">
            <div>
              <h1 class="title font-roboto-cnd font-size-j uppercase" id="page-title"><?php print $title; ?></h1>
              <?php print $breadcrumb  ?>
            </div>
          </div>
        </div>
      <?php endif; ?>
      <?php print render($title_suffix); ?>
      <?php print render($page['help']); ?>
      <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
      <div class="container container-main">
        <div class="row">
          <div class="col sm-9">
            <?php print render($page['content']); ?>
          </div>
          <div class="col sm-3">
            <?php print render($page['sidebar_right']); ?>
          </div>
        </div>
      </div>
    </main> <!-- /.section, /#content -->

    <footer>
      <div class="container color-white">
        <div class="row">
          <div class="col md-6">
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
          </div>
  
          <div class="col sm-6 md-3">
            <div class="uppercase footer-title font-bold m-b-10">Contacto</div>
            <div class="contact-data color-gray-99 font-size-s">
              <?php print variable_get('site_address') ?><br>
              <?php print variable_get('site_phones') ?><br>
              <?php print nl2br(variable_get('site_phones_ext')) ?>
            </div>
          </div>
          
          <div class="col sm-6 md-3">
            <div class="uppercase footer-title font-bold m-b-10">Certificaciones</div>
            <?php print theme('image_style', array('style_name' => 's_1', 'path' => file_load(variable_get('site_certs'))->uri, 'getsize' => FALSE)); ?>
          </div>
          
        </div>
      </div>
      
    </footer>


  </div>
