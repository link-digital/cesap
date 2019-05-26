<div class="carousel-hero-container">
  <div id="carousel-<?php print $node->nid?>" class="carousel carousel-hero">
    <?php foreach(element_children($content['field_items_1']) as $delta):
            $item = $content['field_items_1'][$delta];
      ?>
    <div class="item">
      <div class="banner flex" style="background-image: url(<?php print render($item['field_image_1']) ?>)">
        <div class="container">
          <div class="caption color-white">
            <div class="head"><?php print render($item['field_article_head']) ?></div>
            <h2 class="title"><?php print render($item['field_article_title']) ?></h2>
            <div class="lead"><?php print render($item['field_article_lead']) ?></div>
            <?php if($url = render($item['field_url_1'])):
                  $label = render($item['field_label_1']);
              ?>
            <div class="actions">
              <a class="btn btn-green-1-blue-1 font-size-m" href="<?php print url($url) ?>"><?php print $label ? $label : 'Más información' ?></a>
            </div>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach ?>
  </div>
</div>

<script>
tns({
  container: '#carousel-<?php print $node->nid?>',
  // controlsText: ["<i class=\"angle-left angle-left-gray\"><\/i>","<i class=\"angle-right angle-right-gray\"><\/i>"],
  controls: 0,
  mouseDrag: true,
  autoplay: 0,
  autoplayButtonOutput: 0,
  nav: 1
});
</script>