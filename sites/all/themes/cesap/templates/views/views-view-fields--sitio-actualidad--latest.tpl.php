<div class="row node-sitio-actualidad-teaser <?php print $zebra ?>">
  <div class="col col-image">
    <?php print $fields['field_image_1']->content ?>
  </div>
  <div class="col col-text">
    <div class="type m-b-15 font-size-s color-green-1 uppercase font-medium">
      <?php print $fields['type']->content ?>
    </div>
    <div class="created m-b-15 font-size-s uppercase">
      <?php print $fields['created']->content ?>
    </div>
    <div class="title m-b-15 clean-a">
      <?php print $fields['title']->content ?>
    </div>
    <div class="actions clean-a">
      <a href="<?php print url('node/' . $row->nid) ?>" class="font-size-s"><i class="fa fa-angle-right"></i> Leer más</a>
    </div>
  </div>
</div>