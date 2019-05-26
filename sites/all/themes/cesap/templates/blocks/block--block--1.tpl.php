<div class="bg-img-1 block-1 sports-links">
  <div class="text-center">
    <h3 class="font-size-j font-roboto-cnd color-green-1 uppercase title title-decoration-left text-center">Reservas</h3>
  </div>
  <div class="container container-sm text-center color-white font-size-xn">
    <?php print $content ?>
  </div>
  <div class="container">
    <div class="flex flex-items">

      <div class="flex-col">
        <a class="item" href="<?php print url('salones-eventos') ?>">
          <div class="image">
            <?php print _chipcha_helper_render_theme_image('bg-events-img.jpg') ?>
          </div>
          <div class="item-content color-white text-center">
            <?php print _chipcha_helper_render_theme_image('ico/events.png') ?>
            <h2 class="font-roboto-cnd uppercase font-size-xxl">Eventos</h2>
          </div>
          <div class="overlay"></div>
        </a>
      </div>

      <div class="flex-col">
        <a class="item" href="<?php print url('hotel') ?>">
          <div class="image">
            <?php print _chipcha_helper_render_theme_image('bg-hotel-img.jpg') ?>
          </div>
          <div class="item-content color-white text-center">
            <?php print _chipcha_helper_render_theme_image('ico/hotel.png') ?>
            <h2 class="font-roboto-cnd uppercase font-size-xxl">Hotel</h2>
          </div>
          <div class="overlay"></div>
        </a>
      </div>

      <div class="flex-col">
        <a class="item" href="<?php print url('deportes') ?>">
          <div class="image">
            <?php print _chipcha_helper_render_theme_image('bg-sports-img.jpg') ?>
          </div>
          <div class="item-content color-white text-center">
            <?php print _chipcha_helper_render_theme_image('ico/sports.png') ?>
            <h2 class="font-roboto-cnd uppercase font-size-xxl">Deportes</h2>
          </div>
          <div class="overlay"></div>
        </a>
      </div>

    </div>
  </div>
</div>
