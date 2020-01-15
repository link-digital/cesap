<div class="node-image">
  <?php print render($content['field_image_1']) ?>
</div>
<div class="container container-sm">
  <div class="row">
    <div class="col col-content">
      <div class="js-content">
        <h1 id="page-title" class="font-size-j font-roboto-cnd color-blue-1"><?php print $node->title ?></h1>
        <?php print render($content['body']) ?>
        <div class="row">
          <div class="col sm-7">
            <?php print render($content['field_longtext_1']) ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php 

  include( __DIR__ . '/../partial/nuestras-instalaciones.tpl.php');

?>

