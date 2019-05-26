<?php $coord = array_map('trim', explode(',', strip_tags($node->field_coords[LANGUAGE_NONE][0]['safe_value']))); ?>
<div class="item branch" data-lon="<?php print $coord[1] ?>" data-lat="<?php print $coord[0] ?>">
  <div class="item-text text-center">
    <h3 class="font-size-m uppercase font-roboto-cnd"><?php print render($title) ?></h3>
  </div>
</div>

