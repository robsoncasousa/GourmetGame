require('./bootstrap');

window.Vue = require('vue');

import game from './components/GameComponent.vue';

const app = new Vue({
    el: '#app',
    components: {
        game
    }
});
