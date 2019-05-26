<div class="container">
  <h3 class="color-green-1 uppercase font-size-n font-medium"><?php print node_type_get_name($node) ?></h3>
  <h1 id="page-title" class="font-size-j font-roboto-cnd color-black"><?php print $node->title ?></h1>
  <div class="font-size-s"><?php print format_date($node->created, 'fecha_corto') ?></div>
  <h2 class="font-size-m font-regular"><?php print render($content['field_article_lead']) ?></h2>
  <div class="article-image"><?php print render($content['field_image_1']) ?></div>
  <?php print render($content['body']) ?>
</div>
