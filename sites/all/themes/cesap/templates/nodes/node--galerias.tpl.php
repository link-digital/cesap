<div class="container container-sm text-center intro">
  <?php print render($content['body']) ?>
</div>

<?php 
  if(!empty($node->field_reference_gallery)):

    $items = element_children($content['field_reference_gallery']);
    // $chunks = array_chunk($items, 6);
?>
<div class="gallery-container">

  <div class="container">

      <div class="row">
        <?php 
          foreach($items as $delta):
            $item = $content['field_reference_gallery'][$delta];
            $gallery_content = array_shift($item['node']);
            $gallery_node = $gallery_content['#node'];
        ?>
        <div class="col tn-6 sm-4 js-gallery-item" data-nid="<?php print $gallery_node->nid ?>">
          <div class="gallery-item">
            <?php print render($gallery_content['field_images_1'][0]) ?>
            <div class="overlay">
              <div class="overlay-title font-size-l font-roboto-cnd font-bold color-white uppercase"><?php print $gallery_node->title ?></div>
            </div>
          </div>
        </div>
        <?php
          endforeach;
        ?>
      </div>
      
  </div>
</div>

<script>

jQuery('.gallery-container').on('click', '.js-gallery-item', function(){
    var $ = jQuery, nid = this.dataset.nid;
    LFModal.loading({className: 'gallery-modal'});
    jQuery
      .get(Drupal.settings.basePath + 'ajax/node/' + nid)
      .done(function(x){
        var $c = $('<div>');
        $c.append(x);
        var js = $c.find('script').html();
        LFModal.content($c.get(0));
        setTimeout(function(){
          eval(js);
        },0);
      });
  });
</script>
<?php 



endif ?>