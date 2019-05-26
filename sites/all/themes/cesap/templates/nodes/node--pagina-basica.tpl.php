<div class="container">
  <?php 
/*    <h1 id="page-title" class="font-size-j font-roboto-cnd color-blue-1"><?php print $node->title ?></h1>*/ 
 ?>
  <h2 class="font-size-m font-regular"><?php print render($content['field_article_lead']) ?></h2>
  <div class="article-image"><?php print render($content['field_image_1']) ?></div>
  <?php print render($content['body']) ?>
</div>