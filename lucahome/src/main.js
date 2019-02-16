import Vue from 'vue'
import App from './App.vue'

import axiosService from './services/axios.service'
import store from './store/store'

import VueMaterial from 'vue-material'
import Vuelidate from 'vuelidate'

import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default-dark.css'

Vue.use(VueMaterial)
Vue.use(Vuelidate)

Vue.prototype.OC = OC;

new Vue({
  el: '#lucahome',
  axiosService,
  store,
  render: h => h(App)
})