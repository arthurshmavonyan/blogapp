require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import posts from "./components/Posts.vue";
import home from "./components/Home.vue";
import user from "./components/User.vue";
import post from "./components/Post.vue";
import postedit from "./components/PostEdit.vue";
import postcreate from "./components/PostCreate.vue";

const routes = [
    // Tabs

    { path: '/', component: home },
    { path: '/posts', component: posts },

    // Shows

    { path: '/post/:id', component: post, props: true },
    { path: '/user/:id', component: user, props: true },

    // Creates

    { path: '/create/post', component: postcreate},

    // Edits

    { path: '/edit/post/:id', component: postedit, props: true}
];

const router = new VueRouter({
    routes
});

const app = new Vue({
    router
}).$mount('#app');
