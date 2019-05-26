    <div class="top-left-flag"></div>
    <header>
      <div id="header-container">
        <div id="header-bar-lg">
          <div id="top-menu-container">
            <div class="container">
            <?php print render($page['top_bar']) ?>
            </div>
          </div>

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
                <?php if($user->uid === 0):  ?>
                <a class="btn btn-green-1-blue-1" href="<?php print url('user') ?>">Ingresar <i class="fa fa-angle-right"></i></a>
                <?php else: ?>
                <a class="btn btn-green-1-blue-1" href="<?php print url('user/' . $user->uid) ?>">Perfil <i class="fa fa-angle-right"></i></a>
                <?php endif ?>
              </div>
            </div>
          </div>
        </div>
        <?php if ($main_menu): ?>
        <div id="header-bar-sm">
          <nav id="main-nav-sm" class="color-blue-1">
            <button class="btn-primary">
              <div></div>
              <div></div>
              <div></div>
            </button>
            <a href="<?php print base_path() ?>" class="logo-link">
              <?php if(!empty($logo_header_sm)): ?>
              <img src="<?php print $logo_header_sm ?>" class="logo logo-sm" alt="logo">
              <?php else: ?>
              <img src="<?php print $logo ?>" class="logo logo-sm" alt="logo">
              <?php endif; ?>
            </a>
            <div id="mobile-menu-wrapper" class="uppercase font-roboto-cnd">
              <?php print theme('links__system_main_menu', array('links' => $main_menu, 'attributes' => array('id' => 'main-menu-mobile', 'class' => array('clean clean-a')))); ?>

              <div id="top-bar-sm" class="clean-a">
                <?php print render($page['top_bar']) ?>
              </div>

              <div class="login font-roboto-cnd font-bold uppercase">
                <?php if($user->uid === 0):  ?>
                <a class="btn btn-blue-1-blue-2" href="<?php print url('user') ?>">Ingresar <i class="fa fa-angle-right"></i></a>
                <?php else: ?>
                <a class="btn btn-blue-1-blue-2" href="<?php print url('user/logout') ?>">Cerrar sesión <i class="fa fa-angle-right"></i></a>
                <?php endif ?>
              </div>

            </div>
          </nav>
        </div>
        <?php endif ?>
      </div>
    </header>