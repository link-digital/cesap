<h2 class="font-roboto-cnd font-size-xl color-blue-1 uppercase">Reservas</h2>
<div id="carousel-block-2" class="carousel sports-links">
  <div class="citem">

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

  <div class="citem">

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

  <div class="citem">

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

<script>
tns({
  container: '#carousel-block-2',
  controls: 0,
  mouseDrag: true,
  autoplay: 1,
  autoplayButtonOutput: 0,
  nav: 1
});
</script>
