import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import { createRouter, createWebHistory } from 'vue-router'


export const routes = [
    {path: '/',  component: () => import('@/views/Home.vue')},
    {path: '/About', component: () => import('@/views/About.vue')},
    {path: '/inventory', component: () => import('@/views/Inventory.vue')}
];

const router = createRouter({
    history: createWebHistory(),
    routes,
})
createApp(App).use(router).mount('#app')
