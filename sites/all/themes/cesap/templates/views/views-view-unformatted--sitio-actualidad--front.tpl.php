<div class="text-center">
  <h3 class="font-size-j font-roboto-cnd color-blue-1 uppercase title title-decoration-left text-center"><?php print $view->get_title() ?></h3>
</div>
<div class="container">
  <div class="row row-items color-white">
  <?php 
    foreach($rows as $row):
  ?>
    <div class="col sm-6">
      <?php print $row ?>
    </div>
  <?php 
  
    endforeach ?>
  </div>
</div>