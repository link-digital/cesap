<div class="container">
  <h2 class="uppercase font-size-l color-blue-1 font-roboto-cnd">Detalle de la contratación</h2>
  <div class="process-detail">
    <?php foreach(element_children($content) as $delta):
            $item = $content[$delta];
            if(empty($item['#theme']) || $item['#theme'] != 'field')
            {
              continue;
            }
  
            $item['#label_display'] = 'hidden';
        ?>
    <div class="flex process-row">
      <div class="col-1 font-roboto-cnd uppercase color-blue-1 font-bold"><?php print $item['#title'] ?>:</div>
      <div class="col-2"><?php print render($item) ?></div>
    </div>
    <?php endforeach ?>
  </div>
  <div class="actions">
    <button href="<?php print url('contratacion') ?>" class="btn btn-green-1-blue-1" onclick="javascript:history.back()">Regresar</button>
  </div>
</div>
