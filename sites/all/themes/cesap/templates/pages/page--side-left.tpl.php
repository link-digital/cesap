  <div id="page">

    <?php require __DIR__ . '/../partial/header.tpl.php' ?>

    <div class="container">
      <?php print $messages; ?>
    </div>

    <main id="content">
      <a id="main-content"></a>
      <?php if ($tabs): ?><div class="tabs"><?php print render($tabs); ?></div><?php endif; ?>
      <?php print render($title_prefix); ?>
      <?php if ($title): ?>
        <div class="bg-page-title">
          <div class="container color-white clean-a flex flex-middle">
            <div>
              <h1 class="title font-roboto-cnd font-size-j uppercase" id="page-title"><?php print $title; ?></h1>
              <?php print $breadcrumb  ?>
            </div>
          </div>
        </div>
      <?php endif; ?>
      <?php print render($title_suffix); ?>
      <?php print render($page['help']); ?>
      <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
      <div class="container container-main">
        <div class="row">
          <div class="col sm-3">
            <?php print render($page['sidebar_left']); ?>
          </div>
          <div class="col sm-9">
            <div class="js-content">
              <?php print render($page['content']); ?>
            </div>
          </div>
        </div>
      </div>
    </main> <!-- /.section, /#content -->

    <?php require __DIR__ . '/../partial/footer.tpl.php' ?>

  </div>
<script>
(function($){
  var controller = new ScrollMagic.Controller();
  $bar_content = $('.region.region-sidebar-left').first();
  var scene = new ScrollMagic.Scene({triggerElement: '.region.region-sidebar-left', offset: -100, duration: 200})
        .addTo(controller)
        .triggerHook('onLeave')
        .setPin($bar_content.get(0))
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
      var duration = $('.js-content').height() - $bar_content.height();
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