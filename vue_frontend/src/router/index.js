import Vue from "vue";
import Router from "vue-router";

const Home = () => import("@/components/HelloWorld");
const Products = () => import("@/views/Products");
const CreateProduct = () => import("@/views/CreateProduct");
const UpdateProduct = () => import("@/views/UpdateProduct");
const Orders = () => import("@/views/Orders");
const CreateOrder = () => import("@/views/CreateOrder");
const UpdateOrder = () => import("@/views/UpdateOrder");

const routes = [
  {
    path: "/",
    name: "Home",
    component: Home,
  },
  {
    path: "/products",
    component: {
      render(c) {
        return c("router-view");
      },
    },
    children: [
      {
        path: "",
        name: "Products",
        component: Products,
      },
      {
        path: "create",
        name: "CreateProduct",
        component: CreateProduct,
      },
      {
        path: ":id/edit",
        name: "UpdateProduct",
        component: UpdateProduct,
      },
    ],
  },
  {
    path: "/orders",
    component: {
      render(c) {
        return c("router-view");
      },
    },
    children: [
      {
        path: "",
        name: "Orders",
        component: Orders,
      },
      {
        path: "create",
        name: "CreateOrder",
        component: CreateOrder,
      },
      {
        path: ":id/edit",
        name: "UpdateOrder",
        component: UpdateOrder,
      },
    ],
  },
];

const router = new Router({
  routes,
});

Vue.use(Router);

export default router;
