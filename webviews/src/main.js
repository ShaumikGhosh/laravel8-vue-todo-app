import Vue from 'vue'
import App from './App.vue'
import router from './router'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import VueToast from 'vue-toast-notification';
import axios from 'axios'


Vue.prototype.$axios = axios;
Vue.prototype.$base_path = 'http://localhost:90/laravel8-vue-todo-app';

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueToast);

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import 'vue-toast-notification/dist/theme-sugar.css';

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
  router,
}).$mount('#app')
