<div class="node-image">
  <?php print render($content['field_image_1']) ?>
</div>
<div class="container">
  <div class="row">
    <div class="col sm-5 lg-4 col-form-reservation">
      <div id="app-fixer">
        <div id="app" class="bg-blue-1 form-container">

          <h2 class="font-size-m uppercase text-center color-white font-roboto-cnd">Reservas</h2>
          <a target="_blank" href="<?php print trim(variable_get('zeus_hotel_reservation_url')) ?>" class="btn btn-green-1-blue-2 uppercase fullwidth text-center">Reservar</a>

        </div>
      </div>
    </div>

    <div class="col sm-7 lg-8 col-content">
      <div class="js-content">
        <h1 id="page-title" class="font-size-j font-roboto-cnd color-blue-1"><?php print $node->title ?></h1>
        <?php print render($content['body']) ?>
      </div>
    </div>

  </div>
</div>

<?php 

  include( __DIR__ . '/../partial/nuestras-instalaciones.tpl.php');

?>

<script>

(function($){
  var controller = new ScrollMagic.Controller();
  $app = $('#app');
  var scene = new ScrollMagic.Scene({triggerElement: '#app-fixer', offset: -100, duration: 200})
        .addTo(controller)
        .triggerHook('onLeave')
        .setPin('#app')
        ;

  function setDuration(){
    var width = window.innerWidth;

    if(width <= 767){
      duration = 1;
      scene.duration(duration);
      scene.enabled(false);
    } else {
      if(!scene.enabled()){
        scene.enabled(true);
      }
      var duration = $('.js-content').height() - $app.height() + 45;
      if(duration <= 0){
        duration = 1;
        scene.duration(duration);
        scene.enabled(false);
      } else {
        scene.duration(duration);
      }
    }
  }

  $(window).resize(function(e){
    setDuration();
  });

  setDuration();

}(jQuery));
</script>

