<div class="row row-node-gallery color-blue-1">
  <div class="col col-1 md-9">
    <?php print render($content['field_images_1']) ?>
  </div>
  <div class="col col-2 md-3 bg-green-1 flex flex-align-items-end">
    <div class="font-size-s">
      <div class="font-size-l font-medium font-roboto-cnd uppercase"><?php print $node->title ?></div>
      <?php print render($content['field_longtext_1']) ?>
      <?php if($pdf = render($content['field_archivo'])): ?>
      <div class="text-center">
        <a href="<?php print $pdf ?>" target="_blank" class="btn btn-blue-1-blue-2">Tarifas</a>
      </div>
      <?php endif ?>
    </div>
  </div>
</div>