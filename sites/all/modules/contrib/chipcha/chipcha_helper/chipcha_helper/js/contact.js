(function($){
  
  Drupal.behaviors.pageContact = {
    attach: function(context, settings) {

      $(document.forms.contact).on('submit', function(e){
        e.preventDefault();
        
        $form = $(this);
        $form.addClass('submitted');
        
        if (this.checkValidity && !this.checkValidity()) {
          $form.find('.contact-messages').html('<span style="color:red">Los campos resaltados son obligatorios.</span>');
          return false;
        }
        
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if(!re.test(this.elements['Email'].value))
        {
          $form.find('.contact-messages').html('<span style="color:red">La dirección de correo electrónico es incorrecta.</span>');
          return;
        }

        $form.find('.contact-messages').html('<span style="color:green">Enviando.</span>');
        var data = new FormData(this);
        
        $.post('ajax/sendmail',  $(this).serialize(), function(data){
          if(data=='[OK]'){
            $form.find('.contact-messages').html('<span style="color:green">El mensaje fue enviado; pronto nos pondremos en contacto.</span>');
            $form.get(0).reset();
            $form.removeClass('submitted');
          }
          else
            $form.find('.contact-messages').html('<span style="color:red">Lo siento, ocurrió un error. Inténtalo de nuevo</span>');
        }).fail(
          function(){
            $form.find('.contact-messages').html('<span style="color:red">Lo siento, ocurrió un error. Inténtalo de nuevo</span>');
          }
        ).always(
          function(){
            setTimeout(function() {
              $form.find('.contact-messages').html('');
            }, 10000);
          }
        );
        
        return false;
      });

    }
  }
  
}(jQuery));

