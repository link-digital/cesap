<div id="app">
  <h2 class="font-roboto-cnd font-size-xl color-blue-1 uppercase">Mis reservas activas</h2>

  <div class="loading" v-show="processing"></div>

  <div v-show="!processing" v-for="(app, index) in appointments" :key="index" class="appointment">
    <div class="m-b-5">
      <span class="uppercase font-size-m color-blue-1 font-roboto-cnd font-bold">Reserva</span><br>
      <span class="font-size-m font-bold">{{app.id}}</span>
    </div>

    <div class="">
      <span class="font-roboto-cnd font-bold color-blue-1 uppercase">Deporte:</span> 
      <span>{{services[app.serviceId].category}}</span>
    </div>

    <div class="">
      <span class="font-roboto-cnd font-bold color-blue-1 uppercase">Espacio:</span> 
      <span>{{services[app.serviceId].name}}</span>
    </div>

    <div class="">
      <span class="font-roboto-cnd font-bold color-blue-1 uppercase">Fecha:</span> 
      <span>{{app.date_start}}</span>
    </div>

    <div class="">
      <span class="font-roboto-cnd font-bold color-blue-1 uppercase">Hora de inicio:</span> 
      <span>{{app.time_start}}</span>
    </div>

    <div class="">
      <span class="font-roboto-cnd font-bold color-blue-1 uppercase">Hora de fin:</span> 
      <span>{{app.time_end}}</span>
    </div>

    <div class="">
      <span class="font-roboto-cnd font-bold color-blue-1 uppercase">Costo:</span> 
      <span>{{services[app.serviceId].price_formatted}}</span>
    </div>

  </div>

</div>
<script>
var app = new Vue({
  el: '#app',
  data: function() {
    return{
      title: 'title mio',
      appointments: [],
      services: {},
      processing: false,
    }
  },

  created: function(){
    var _this = this;
    _this.processing = true;
    jQuery
      .getJSON('/cesap/ezapp/appointments')
      .done(function(d){
        _this.appointments = d.appointments;
        _this.services = d.services;
        _this.processing = false;
      })
      ;
  }
});
</script>