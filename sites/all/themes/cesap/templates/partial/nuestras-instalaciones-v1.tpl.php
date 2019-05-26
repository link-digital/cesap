<?php 
  
  if(false && !empty($node->field_images_1)):

    $items = element_children($content['field_images_1']);
    $chunks = array_chunk($items, 6);
?>
<div class="bg-gray-ef gallery-container">

  <div class="text-center">
    <h2 class="font-size-j font-roboto-cnd color-blue-1 uppercase title title-decoration-left">Nuestras instalaciones</h2>
  </div>
  <div class="container">

    <div id="carousel-<?php print $node->nid?>" class="carousel carousel-gallery">
      <?php 
      
            foreach($chunks as $chunk):
        ?>
      <div class="item">
        <div class="row">
            <?php 
              foreach($chunk as $delta):
                $item = $content['field_images_1'][$delta];
            ?>
            <div class="col tn-6 sm-4"><?php print render($item) ?></div>
            <?php
              endforeach;
            ?>
        </div>
      </div>
      <?php endforeach ?>
    </div>

  </div>
</div>

<script>
  tns({
    container: '#carousel-<?php print $node->nid ?>',
    controls: 0,
    mouseDrag: true,
    autoplay: 1,
    autoplayButtonOutput: 0,
    nav: 1
  });
</script>
<?php 



endif ?>