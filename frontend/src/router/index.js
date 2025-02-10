import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/views/Home.vue';
import Sellers from '@/views/Sellers.vue';
import SellerSales from '@/views/SellerSales.vue';
import CreateSale from '@/views/CreateSale.vue';
import CreateSeller from '@/views/CreateSeller.vue';
import JobRunner from "@/views/JobRunner.vue";

const routes = [
    { path: '/', component: Home },
    { path: '/sellers', component: Sellers },
    { path: '/sellers/create', component: CreateSeller },
    { path: "/sales/create", component: CreateSale },
    { path: '/sales/:sellerId', component: SellerSales, props: true },
    { path: "/run-job", component: JobRunner },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
