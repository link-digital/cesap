<div class="node-image">
  <?php print render($content['field_image_1']) ?>
</div>
<div class="container">
  <div class="row">
    <div class="col sm-5 lg-4 col-form-reservation">
      <div id="app-fixer">
        <div id="app" class="bg-blue-1 form-container">

          <h2 class="font-size-m uppercase text-center color-white font-roboto-cnd">Cotizar</h2>
    
          <form @submit.prevent="send" class="reservation row color-white" name="reservation">
    
            <div class="col">
              <div class="field">
                <div class="custom-select">
                  <select name="guest" v-model="input.user">
                    <option value="">Tipo de usuario</option>
                    <?php foreach(taxonomy_get_tree(1) as $t): ?>
                    <option value="<?php print $t->name ?>"><?php print $t->name ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
            </div>
    
            <div class="col">
              <div class="field">
                <div class="custom-select">
                  <select name="space" v-model="input.space">
                    <option value="">Salón o zona</option>
                    <?php foreach(taxonomy_get_tree(2) as $t): ?>
                    <option value="<?php print $t->name ?>"><?php print $t->name ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
            </div>
    
            <div class="col row-datepicker">
              <div class="field">
                <div class="label font-size-xxs uppercase">Fecha del evento</div>
                <div class="checkin">{{input.date}}&nbsp;</div>
              </div>

              <div class="datepicker-trigger">
                <div type="text" id="trigger-range"></div>
                <div class="datepicker-container color-blue-1">
                  <div :class="{show: pickerOpen}" class="triangle triangle-white"></div>
                  <div :class="{show: pickerOpen}" class="triangle triangle-green"></div>
                  <airbnb-style-datepicker
                    :trigger-element-id="'trigger-range'"
                    :date-one="input.date"
                    :min-date="new Date()"
                    :fullscreen-mobile="true"
                    :mode="'single'"
                    :months-to-show="1"
                    @date-one-selected="function(val) { input.date = val }"
                    @opened="pickerOpened"
                    @closed="pickerClosed"
                  ></airbnb-style-datepicker>
                </div>
              </div>
            </div>

            <div class="col">
              <div class="field">
                <label class="flex flex-field">
                  <div class="label">Cantidad de asistentes</div>
                  <div class="input">
                    <input type="text" name="attendants" @keydown="onlyNumeric" v-model="input.attendants">
                  </div>
                </label>
              </div>
            </div>
    
            <div class="col">
              <div class="field">
                <label>
                  <div class="label">Describa el evento</div>
                  <textarea name="description" type="text" v-model="input.description"></textarea>
                </label>
              </div>
            </div>
    
            <div class="col tn-6 text-center">
              <div class="m-tb-15">Requiere alimentos</div>
              <label>
                <input type="checkbox" name="foods" class="hidden" value="Sí" v-model="inputFoods"><div class="check"></div>
              </label>
            </div>
    
            <div class="col tn-6 text-center">
              <div class="m-tb-15">Requiere bebidas</div>
              <label>
                <input type="checkbox" name="drinks" class="hidden" value="Sí" v-model="inputDrinks"><div class="check"></div>
              </label>
            </div>
    
            <div class="col">
              <div class="form-messages text-center js-messages" :class="[formMessagesClass]" :style="{maxHeight: messagesMaxHeight}">{{formMessage}}</div>
            </div>
    
            <div class="col">
              <div class="actions m-t-20">
                <button :disabled="sending" type="submit" class="btn btn-green-1-blue-2 uppercase fullwidth">{{submitText}}</button>
              </div>
            </div>
    
          </form>
        </div>
      </div>
    </div>

    <div class="col sm-7 lg-8 col-content">
      <div class="js-content">
        <h1 id="page-title" class="font-size-j font-roboto-cnd color-blue-1"><?php print $node->title ?></h1>
        <?php print render($content['body']) ?>
        <div class="row">
          <div class="col sm-7">
            <?php print render($content['field_longtext_1']) ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php 

  include( __DIR__ . '/../partial/nuestras-instalaciones.tpl.php');

?>

<script>
(function(){

  var datepickerOptions = {
  sundayFirst: true,
  days: [
    'Lunes',
    'Martes',
    'Miércoles',
    'Jueves',
    'Viernes',
    'Sábado',
    'Domingo',
  ],
  daysShort: [
    'Lun',
    'Mar',
    'Mié',
    'Jue',
    'Vie',
    'Sáb',
    'Dom',
  ],
  monthNames: [
    'Enero',
    'Febrero',
    'Marzo',
    'Abril',
    'Mayo',
    'Junio',
    'Julio',
    'Agosto',
    'Septiembre',
    'Octubre',
    'Noviembre',
    'Diciembre',
  ],
  colors: {
    selected: '#c0e055',
    inRange: '#c0e055',
    selectedText: '#fff',
    text: '#28424e',
    inRangeBorder: '#c0e055',
    disabled: '#fff',
  },
  texts: {
    apply: 'Aceptar',
    cancel: 'Cancelar',
  }
}
// install plugin
Vue.use(window.AirbnbStyleDatepicker, datepickerOptions)

var app = new Vue({
  el: '#app',
  components: {

  },

  data: function() {
    return{
      pickerOpen: false,
      formMessage: '',
      formMessagesClass: '',
      messagesMaxHeight: '',
      sending: false,
      submitText: 'Solicitar reserva',

      user: {
        uid: <?php print $user->uid ?>
      },

      inputFoods: false,
      inputDrinks: false,

      input: {
        user: '',
        space: '',
        date: '',
        attendants: '',
        description: '',
        foods: 'No',
        drinks: 'No',
      }
    }
  },

  methods: {
    send: function(){

      if(this.user.uid === 0){
        alert('Debe iniciar sesión para realizar reservas');
        return false;
      } 

      var _this = this;
      var error = false;
      ['user', 'space', 'date', 'attendants', 'description'].forEach(function(i,v){
        if(_this.input[i] == '' || _this.input[i] == '0') error = 'Por favor llene todos los campos.';
      });

      if(error){
        this.formMessagesClass = 'message-error';
        this.formMessage = error;
        this.messagesMaxHeight = '60px';
      }
      else {
        
        this.formMessagesClass = 'message-success';
        this.formMessage = 'Momento...';
        this.messagesMaxHeight = '60px';
        
        this.sending = true;
        this.submitText = '...';
        events_request('salones_eventos', this.input)
          .done(function(j){
            _this.formMessagesClass = 'message-success';
            _this.formMessage = 'Su mensaje fue enviado. Pronto nos pondremos en contacto.';
            _this.messagesMaxHeight = '60px';
          })
          .fail(function(e){
            _this.formMessagesClass = 'message-error';
            _this.formMessage = 'Error. Intente de nuevo más tarde.';
            _this.messagesMaxHeight = 'initial';
          })
          .always(function(){
            _this.sending = false;
            _this.submitText = 'Solicitar reserva';
          });

      }

    },

    pickerOpened: function(){
      this.pickerOpen = true;
    },

    pickerClosed: function(){
      this.pickerOpen = false;
    },

    onlyNumeric(e){
      if(e.key.replace(/[^\d]/, '') == ''){
        e.preventDefault();
        return false;
      }
      // return false;
      // this.input.attendants.replace(/[^\d]/, '');
    }
  },

  watch: {
    inputFoods(){
      this.input.foods = this.inputFoods ? 'Sí' : 'No';
    },

    inputDrinks(){
      this.input.drinks = this.inputDrinks ? 'Sí' : 'No';
    }
  }
});

}());

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

