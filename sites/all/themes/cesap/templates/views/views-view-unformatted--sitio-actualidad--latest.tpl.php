<div class="carousel-view-latest">
  <div class="carousel-<?php print $view->name ?>">
    <?php foreach($rows as $row):
      ?>
      <div class="item row-items">
        <?php print $row ?>
      </div>
      <?php endforeach ?>
  </div>
</div>

<script>
tns({
  container: '.carousel-<?php print $view->name ?>',
  controls: 0,
  mouseDrag: true,
  autoplay: 1,
  autoplayButtonOutput: 0,
  nav: 1
});
</script>
