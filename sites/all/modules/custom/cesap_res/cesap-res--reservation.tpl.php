<div id="app">

  <div id="services-list" v-if="controlDisplay.loading">
    Aguante...
  </div>

  <div id="services-list" v-if="controlDisplay.menu">
    <div v-for="(item, cidx) in menu">
      <div class="menu-title">{{ item.name }}</div>
      <div v-for="(s, sidx) in item.services" :data-sid="s.id" :data-cidx="cidx" :data-sidx="sidx" class="menu-item">
        Servicio: {{ s.name }} - {{ s.id }}<br>
        Duración: {{ s.duration }}<br>
        Valor: ${{ s.price }}<br>
        <button @click="selectService">Deme uno</button>
      </div>
    </div>
  </div>

  <div v-if="controlDisplay.calendar">
    <table>
      <colgroup>
      <col>
      <col>
      <col width="100%'">
      </colgroup>
      <tr>
        <td><input type="text" id="calendar" v-model="appt._date" @change="changeDate" style="display:none"></td>
        <td>
          <div v-if="controlDisplay.timeLoading">Aguante...</div>
          <div v-if="controlDisplay.time" v-for="a in avail" :data-time="a" @click="selectDate" class="time-item">{{ a }}</div>
        </td>
        <td>
          <div v-if="appt.start">
            <b>{{category.name}}</b><br>
            {{service.name}}<br>
            Valor: ${{service.price}}<br>
            Duración: {{service.duration}} min<br>
            Fecha y hora: {{appt.start}}<br>
            <br>
            <button @click="send">Reservar now!</button>
          </div>
        </td>
      </tr>
    </table>
  </div>

  <div>
  </div>

</div>

<style>
  #app .menu-title {
    font-size: 1.2;
    font-weight: bold;
    margin-top: 20px;
  }
  #app .menu-item {
    margin-top: 15px;
  }
  #app .time-item {
    cursor: pointer;
  }
  #app .time-item:hover {
    color:red;
  }
</style>

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

var app = new Vue({
  el: '#app',
  data: {
    message: 'Hello Vue!',
    controlDisplay: {
      loading: true,
      menu: false,
      calendar: false,

      time: false,
      timeLoading: false,
    },
    showMenu: false,
    csrfToken: null,
    menu: [],
    avail: [],
    category: null,
    service: null,
    appt: {
      serviceId: 0,
      _date: '',
      _time: '',
      start: '',
    },
  },
  methods: {
    changeDate: function(v){
      this.controlDisplay.time = false;
      this.controlDisplay.timeLoading = true;
      setTimeout(function(){

        ezapp_request('availabilities/?serviceId=' + app.appt.serviceId + '&date=' + app.appt._date).done( function(j){
          app.avail = j;
          app.controlDisplay.time = true;
          app.controlDisplay.timeLoading = false;
        });

      });
    },
    selectService: function(e){
      var p = e.target.parentNode;
      this.appt.serviceId = p.dataset.sid;
      this.category = this.menu[p.dataset.cidx];
      this.service = this.menu[p.dataset.cidx].services[p.dataset.sidx];
      this.step(2);
      setTimeout(function(){
        flatpickr('#calendar', {
          inline: true
        });
      }, 50);
    },
    selectDate: function(e){
      this.appt._time = e.target.dataset.time;
      this.appt.start = this.appt._date + ' ' + this.appt._time + ':00';
    },
    step: function(s){
      switch(s){
        case 0:
          this.controlDisplay.loading = true;
          this.controlDisplay.menu = false;
          this.controlDisplay.calendar = false;
          break;
        case 1:
          this.controlDisplay.loading = false;
          this.controlDisplay.menu = true;
          this.controlDisplay.calendar = false;
          break;
        case 2:
          this.controlDisplay.menu = false;
          this.controlDisplay.calendar = true;
          break;
      }
    },
    
    send: function(){
      console.log('sending');
      ezapp_request('appointments', this.appt);
    }
  },
  mounted: function(){
    var _self = this;
    ezapp_request('user/token', true).done( function(j){
      csrfToken = j.token;
    });
    ezapp_request('menu').done( function(j){
      _self.menu = j;
      _self.step(1);
    });
  }
});


// flatpickr('#calendar', {
//   inline: false
// });

</script>