<div class="node-image">
  <?php print render($content['field_image_1']) ?>
</div>
<div class="container">
  <div class="row">
    <div class="col sm-5 lg-4 col-form-reservation">
      <div id="app" class="bg-blue-1 form-container">

        <h2 class="font-size-m uppercase text-center color-white font-roboto-cnd">Reservas</h2>
  
        <form @submit.prevent="send" action="return false;" class="reservation row color-white">
  
          <div class="col">
            <div class="field">
              <div class="custom-select">
                <select name="type" v-model="input.type">
                  <option value="">Tipo de huésped</option>
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
                <select name="room" v-model="input.room">
                  <option value="">Tipo de habitación</option>
                  <?php foreach(taxonomy_get_tree(3) as $t): ?>
                  <option value="<?php print $t->name ?>"><?php print $t->name ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
          </div>

          <div class="col">

            <div class="row row-datepicker">
              <div class="col tn-6">
                <div class="field">
                  <div class="label font-size-xxs uppercase">Check in</div>
                  <div class="checkin">{{input.checkin}}&nbsp;</div>
                </div>
              </div>
      
              <div class="col tn-6">
                <div class="field">
                  <div class="label font-size-xxs uppercase">Check out</div>
                  <div class="checkout">{{input.checkout}}&nbsp;</div>
                </div>
              </div>
  
              <div class="datepicker-trigger">
                <div type="text" id="trigger-range"></div>
                <div class="datepicker-container color-blue-1">
                  <div :class="{show: pickerOpen}" class="triangle triangle-white"></div>
                  <div :class="{show: pickerOpen}" class="triangle triangle-green"></div>
                  <airbnb-style-datepicker
                    :trigger-element-id="'trigger-range'"
                    :date-one="input.checkin"
                    :date-two="input.checkout"
                    :min-date="new Date()"
                    :fullscreen-mobile="true"
                    @date-one-selected="function(val) { input.checkin = val }"
                    @date-two-selected="function(val) { input.checkout = val }"
                    @opened="pickerOpened"
                    @closed="pickerClosed"
                  ></airbnb-style-datepicker>
                </div>
              </div>
  
            </div>

          </div>

  
          <div class="col tn-6">
            <div class="flex flex-middle flex-updwn">
              <div class="type font-size-s">Adultos</div>
              <div @click="increment('adults', -1)" class="btn-updwn"><i class="fa fa-minus"></i></div>
              <div class="amount">{{input.adults}}</div>
              <div @click="increment('adults', 1)" class="btn-updwn"><i class="fa fa-plus"></i></div>
            </div>
          </div>
  
          <div class="col tn-6 col-guests">
            <div class="flex flex-middle flex-updwn">
              <div class="type font-size-s">Niños</div>
              <div @click="increment('children', -1)" class="btn-updwn"><i class="fa fa-minus"></i></div>
              <div class="amount">{{input.children}}</div>
              <div @click="increment('children', 1)" class="btn-updwn"><i class="fa fa-plus"></i></div>
            </div>
          </div>

          <div class="col" v-for="item in input.children">
            <div class="picture flex flex-middle">
              <div class="picture-title">
                Niño {{item}}
              </div>
              <div v-if="input.files[item-1]" class="picture-input text-right">{{files[item-1]}} <i @click="removeImage(item-1)" class="fa fa-close color-white"></i></div>
              <label v-else class="picture-input">
                <div class="text-right">Adjunte documento de identidad <i class="fa fa-camera color-white"></i></div>
                <input @change="pickPicture($event, item-1)" type="file" name="files" accept="image/*" class="hidden">
              </label>
            </div>
          </div>
  
          <div class="col">
            <div class="form-messages text-center js-messages" :class="[formMessagesClass]" :style="{maxHeight: messagesMaxHeight}">{{formMessage}}</div>
          </div>

          <div class="col">
            <div class="actions m-t-20">
              <button type="submit" class="btn btn-green-1-blue-2 uppercase fullwidth">Solicitar reserva</button>
            </div>
            <p class="font-size-xs text-center">
            Acepto lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi pellentesque posuere vehicula. Ut in efficitur turpis. Praesent sed ex magna. Fusce fermentum sem vel porttitor interdum.
            </p>
          </div>
  
        </form>
      </div>
    </div>

    <div class="col sm-7 lg-8 col-content">
      <h1 id="page-title" class="font-size-j font-roboto-cnd color-blue-1"><?php print $node->title ?></h1>

      <?php print render($content['body']) ?>

      <div class="row">
        <div class="col sm-7">
          <div class="font-size-m font-bold font-roboto-cnd color-blue-1 uppercase">Servicios para todas las habitaciones</div>
          <?php print render($content['field_longtext_1']) ?>
        </div>
        <div class="col sm-5">
          <div class="line-left-green-1">
            <div>
              <b class="font-roboto-cnd color-blue-1 uppercase">Check in:</b>
              <span><?php print render($content['field_check_in']) ?></span>
            </div>
            <div>
              <b class="font-roboto-cnd color-blue-1 uppercase">Check out:</b>
              <span><?php print render($content['field_check_out']) ?></span>
            </div>
            <div>
              <?php print render($content['field_text_1']) ?>
            </div>
          </div>
          <div class="line-left-green-1">
            <b class="font-roboto-cnd color-blue-1 uppercase">Importante:</b>
            <?php print render($content['field_longtext_2']) ?>
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
      files: [],
      formMessage: '',
      formMessagesClass: '',
      messagesMaxHeight: '',

      input: {
        type: '',
        room: '',
        checkin: '',
        checkout: '',
        adults: 0,
        children: 0,
        files: [],
        fileNames: '',
      }
    }
  },

  methods: {
    send: function(){
      var _this = this;
      var error = false;
      ['type', 'room', 'checkin', 'checkout'].forEach(function(i,v){
        if(_this.input[i] == '') error = 'Por favor llene todos los campos.';
      });

      if(!error){
        if(this.input.adults == 0){
          error = 'Debe asistir al menos un adulto.';
        }
      }

      if(!error){
        if(this.input.children != this.files.length){
          error = 'Debe adjuntar el documento de cada menor.';
        }
      }

      if(error){
        this.formMessagesClass = 'message-error';
        this.formMessage = error;
        this.messagesMaxHeight = '60px';
      }
      else {
        this.formMessagesClass = 'message-success';
        this.formMessage = 'Momento...';
        this.messagesMaxHeight = '60px';

        setTimeout(function(){
          _this.formMessagesClass = 'message-success';
          _this.formMessage = 'Su mensaje fue enviado. Pronto nos pondremos en contacto.';
          _this.messagesMaxHeight = '60px';
      }, 1000);

      }

    },

    pickerOpened: function(){
      this.pickerOpen = true;
    },
    pickerClosed: function(){
      this.pickerOpen = false;
    },
    increment: function(key, val){
      this.input[key] += val;
      if(this.input[key] < 0){
        this.input[key] = 0;
      }
    },

    pickPicture: function(e, idx){
      var file = e.target.files[0];
      console.log(file);
      var _this = this;

      this.files[idx] = file.name;

      var reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = function () {
        // _this.input.files[idx] = file.name;
        _this.input.files[idx] = reader.result;
        _this.input.fileNames = (new Date()).getTime();
      };

      reader.onerror = function (error) {
        console.log('Error: ', error);
      };

    },

    removeImage: function(idx){
      console.log(idx);
      this.input.files.splice(idx, 1);
      this.files.splice(idx, 1);
      this.input.children--;
    }
  }
});

}())
</script>

