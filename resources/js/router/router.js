import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        component: () => import("../Pages/Home.vue"),
    },
    {
        path: "/tasks",
        component: () => import("../Pages/Tasks/Index.vue"),
    },
    {
        path: "/tasks/create",
        name: "tasks.create",
        component: () => import("../Pages/Tasks/Create/Index.vue"),
    },
    {
        path: "/tasks/:id/edit",
        name: "tasks.edit",
        component: () => import("@/Pages/Tasks/Create/Index.vue"),
        props: true,
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
