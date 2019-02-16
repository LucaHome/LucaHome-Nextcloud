import Vue from 'vue'
import App from './App.vue'

import store from './store/store'

import VueMaterial from 'vue-material'
import Vuelidate from 'vuelidate'

import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default-dark.css'

Vue.use(VueMaterial)
Vue.use(Vuelidate)

new Vue({
  el: '#app',
  store,
  render: h => h(App)
})