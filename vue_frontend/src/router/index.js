import Vue from "vue";
import Router from "vue-router";

const Products = () => import("@/views/Products");
const CreateProduct = () => import("@/views/CreateProduct");
const UpdateProduct = () => import("@/views/UpdateProduct");
const Home = () => import("@/components/HelloWorld");
// const Bar = { template: "<div>bar</div>" };

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
];

const router = new Router({
  routes,
});

Vue.use(Router);

export default router;
