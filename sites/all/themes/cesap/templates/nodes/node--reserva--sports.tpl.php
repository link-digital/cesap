<?php 

  global $user;

?>
<div class="container container-app">
  <h1 id="page-title" class="font-size-xxxl color-blue-1 font-roboto-cnd text-center uppercase">Reserva de zonas deportivas</h1>
  <div id="app">

    <div class="flex flex-steps">
      <div @click="back('step-1')" class="flex" :class="{active: (appStep == 'step-1'), pointer: step1}">
        <div class="number">1</div>
        <div class="label">Seleccione el deporte</div>
      </div>
      <div @click="back('step-2')" class="flex" :class="{active: (appStep == 'step-2'), pointer: step2}">
        <div class="number">2</div>
        <div class="label">Fecha y hora de reserva</div>
      </div>
      <div @click="back('step-3')" class="flex" :class="{active: (appStep == 'step-3')}">
        <div class="number">3</div>
        <div class="label">Confirmación de reserva</div>
      </div>
    </div>

    <transition name="slide-fade" mode="out-in">
      <div v-if="appStep === 'step-1'" class="row row-spaces" key="step-1">
        <div class="col tn-6 sm-4 md-3" v-for="(item, index) in spaces" :key="index">
          <div @click="onSelectCategory(item.cid)" class="space">
            <div class="image">
              <img :src="item.ico">
            </div>
            <div class="label">
              {{item.name}}
            </div>
          </div>
        </div>
      </div>

      <div v-if="appStep === 'step-2'" class="row" key="step-2">

        <div class="col sm-5 md-4 col-calendar">
          <div class="datepicker-trigger">
            <div type="text" id="trigger-range"></div>
            <airbnb-style-datepicker
                mode="single"
                :trigger-element-id="'trigger-range'"
                :min-date="'<?php print date('Y-m-d', strtotime('today')) ?>'"
                :inline="true"
                :months-to-show="1"
                :date-one="input.date"
                @date-one-selected="onDateSelected"
              ></airbnb-style-datepicker>
          </div>
        </div>
        <div class="col sm-7 md-8">
          <div class="space-selector flex flex-middle">
            <div class="label">Seleccione el lugar</div>
            <div class="input">
              <div class="custom-select">
                <select @change="onSpaceSelected($event.target.value)" name="service" id="serviceId" ref="serviceId">
                  <option :value="index" v-for="(item, index) in services" :key="index">{{item.name}}</option>
                </select>
              </div>
            </div>
          </div>

          <div class="space-description">{{ spaceDescription }}</div>

          <div class="availabilities">
            <div v-if="loadingAvailabilities"><div class="lf-loading"></div></div>
            <div v-else class="">
              <div class="flex flex-item flex-middle" v-for="(item, index) in avail" :key="index">
                <div class="hour">{{item}} - {{endTime(item)}}</div>
                <div class="price">{{services[input.serviceId].price_formatted}}</div>
                <div class="actions">
                  <button @click="onTimeSelected($event.target.value)" :value="item" class="btn btn-green-1-blue-1 uppercase font-roboto-cnd">Reservar</button>
                </div>
              </div>
            </div>
            <div v-if="avail.length == 0 && !loadingAvailabilities">No hay disponibilidad para la fecha</div>
          </div>
        </div>

      </div>

      <div v-if="appStep === 'step-3'" class="text-center step-3-container" key="step-3">
        <div v-if="loadingSend" class="m-tb-10 loading-send"><div class="lf-loading"></div></div>
        <div :class="{opaque3: loadingSend}">
          <div class="color-green-1 font-roboto-cnd uppercase font-size-xxl">Hola</div>
          <p class="font-size-m font-roboto-cnd color-black">Si confirmas la reserva de este espacio deportivo, estás aceptando los términos y condiciones del reglamento de este deporte.</p>
          <div class="color-green-1 font-roboto-cnd uppercase font-size-l">Detalle de la reserva</div>
          <div class="detail color-black font-size-m font-roboto-cnd">
            <p>Deporte: <b>{{spaceName}}</b></p>
            <p>Espacio deportivo: <b>{{services[input.serviceId].name}}</b></p>
            <p>Descripción: <b>{{ spaceDescription }}</b></p>
            <p>Fecha: <b>{{input.date}}</b></p>
            <p>Hora de inicio: <b>{{input.time}}</b></p>
            <p>Hora de finalización: <b>{{endTime(input.time)}}</b></p>
            <p>Costo: <b>{{services[input.serviceId].price_formatted}}</b></p>
            <div class="actions">
              <button @click="send" class="btn btn-green-1-blue-1 font-size-l font-roboto-cnd uppercase">Confirmar</button>
            </div>
          </div>
        </div>
      </div>

      <div v-if="appStep === 'step-0'" class="text-center font-roboto-cnd step-0-container" key="step-0">
        <div class="uppercase color-blue-1 font-bold font-size-m">Reserva exitosa</div>
        <div class="uppercase color-gray-35 font-size-m">Código de la reserva</div>
        <div class="uppercase color-blue-1 font-bold font-size-xxl m-b-20">{{createdId}}</div>
        <p class="success-message font-size-m">Puedes consultar sus reservas en la sección <br>
          <span class="uppercase font-bold">Mis reservas</span> de su cuenta.
        </p>
      </div>
    </transition>
  
  </div>
</div>

<script>

var csrfToken = '';
function ezapp_request(resource, data){
  var method = data ? 'POST' : 'GET';
  return jQuery.ajax({
    dataType: "json",
    url: Drupal.settings.basePath + 'ezapp/' + resource,
    data: JSON.stringify(data),
    method: method,
    headers: {
      'X-CSRF-Token': csrfToken
    },
    contentType: 'application/json',
  });

  // return jQuery.getJSON(Drupal.settings.basePath + 'ezapp/' + resource, JSON.stringify(data));
}

var dateFormat = function(date){
  var y = date.getFullYear();
  var m = date.getMonth() + 1;
  var d = date.getDate();

  m = m < 9 ? '0'+m : m;
  d = d < 9 ? '0'+d : d;

  return y + '-' + m + '-' + d;
}

var endTime = function(start, duration){
  var parts = start.split(':');
  var minutes = parseInt(parts[0]) * 60 + parseInt(parts[1]);
  var end = minutes+duration;
  var h = end / 60;
  var m = Math.floor(end % 60);
  h = h < 9 ? '0'+h : h;
  m = m < 9 ? '0'+m : m;
  return h + ':' + m;
}

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

Vue.use(window.AirbnbStyleDatepicker, datepickerOptions)

var app = new Vue({
  el: '#app',
  data: {
    appStep: 'step-1',

    user: {
      uid: <?php print $user->uid ?>
    },

    spaces: <?php print _cesap_spaces_json() ?>,

    loadingAvailabilities: false,
    loadingSend: false,

    services: [],

    avail: [],

    step1: false,
    step2: false,
    step3: false,

    createdId: '',

    input: {
      date: dateFormat(new Date()),
      time: '',
      categoryId: 0,
      serviceId: 0,
    }
  },

  computed: {
    spaceDescription(){
      var desc = this.services&&this.services[this.input.serviceId]&&this.services[this.input.serviceId].description;
      return desc||'';
    },
    
    spaceName(){
      var self=this, space;
      if(this.spaces){
        space = this.spaces.find(function(e){
          return e.cid == self.input.categoryId;
        });
      }

      return space&&space.name||'#N/A';
    }
  },

  methods:{
    endTime: function(start){
      return endTime(start, this.services[this.input.serviceId].duration)
    },

    send: function(){

      console.log('step-0');
      var appointment = {
              serviceId: this.input.serviceId,
              _date: this.input.date,
              _time: this.input.time,
              start: this.input.date + ' ' + this.input.time + ':00',
          };
      var _this = this;
      _this.loadingSend = true;

      events_request('appointments', appointment)
      .done(function(j){
        _this.createdId = j.id;
        _this.next('step-0');
      })
      .always(function(){
        _this.loadingSend = false;
      });
    },

    next: function(page){
      this.appStep = page;
      switch(page){
        case 'step-1':
          this.step1 = false;
          this.step2 = false;
          this.step3 = false;
          break;
        case 'step-2':
          this.step1 = true;
          this.step2 = false;
          this.step3 = false;
          break;
        case 'step-3':
          this.step1 = true;
          this.step2 = true;
          this.step3 = false;
          break;
        default:
          this.step1 = false;
          this.step2 = false;
          this.step3 = false;
          break;
      }
    },

    back: function(page){
      if(this.appStep > page){
        this.appStep = page;
      }
    },

    onSelectCategory: function(cid){

      if(this.user.uid === 0){
        alert('Debe iniciar sesión para realizar reservas');
      } else {
        this.input.categoryId = cid;
        // this.step1 = true;
        this.loadServices();
        this.next('step-2');
      }
    },

    onDateSelected: function(val){
      this.input.date = val;
      this.loadAvailabilities(this.input.serviceId, this.input.date);
    },

    onSpaceSelected: function(val){
      this.input.serviceId = val;
      this.loadAvailabilities(this.input.serviceId, this.input.date);
    },

    onTimeSelected: function(val){
      this.input.time = val;
      this.next('step-3');
    },

    loadServices: function(){
      var _this = this;
      ezapp_request('services/?categoryId=' + this.input.categoryId).done(function(j){
        _this.services = j;
        var a = Object.keys(j);
        if(a.length > 0){
          _this.loadAvailabilities(a[0], _this.input.date);
        } 
      });
    },

    loadAvailabilities: function(sid, date){
      var _this = this;
      this.input.serviceId = sid;
      this.loadingAvailabilities = true;

      ezapp_request('availabilities/?serviceId=' + sid + '&date=' + date).done( function(j){
          _this.avail = j;
        })
        .always(function(){
          _this.loadingAvailabilities = false;
        });
    }
  },

  mounted: function(){
    var _self = this;
    ezapp_request('user/token', true).done( function(j){
      csrfToken = j.token;
    });
  }

});

</script>

<?php 

  include( __DIR__ . '/../partial/nuestras-instalaciones.tpl.php');

?>
