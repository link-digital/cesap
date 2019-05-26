(function(){
  var $ = jQuery;
  var controller = new ScrollMagic.Controller();

  function scrollAnimations(){
    $('.entrance').each(function(){
      var self = this;
      new ScrollMagic.Scene({triggerElement: self})
            .addTo(controller)
            .triggerHook('.65')
            .on('enter', function(e){
              $(self).addClass(self.dataset.animation);
            })
            ;
    });
  }

  function fixedMenu(){
    new ScrollMagic.Scene({triggerElement: "DIV#header-container"})
            .setClassToggle("DIV#header-container #header-bar-lg", "fixed-menu")
            .triggerHook('onLeave')
            .offset(100)
            .addTo(controller);

  }

  function mobileMenu(){
    $menu = $('#main-nav-sm');
    $menu.find('.btn-primary').on('click', function(){
      $menu.toggleClass('show');
      $(document.body).toggleClass('modal-open');
    });

    $menu.find('#main-menu-mobile A').on('click', function(){
      if(this.href.match(/#;/)) return;
      $menu.toggleClass('show');
      $(document.body).toggleClass('modal-open');
    });
  }

  $(function(){
    fixedMenu();
    scrollAnimations();
    mobileMenu();
  });

}());
