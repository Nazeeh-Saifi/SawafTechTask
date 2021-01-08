<template>
  <b-container class="list-products">
    <b-row>
      <b-col>
        <b-card header-tag="header" footer-tag="footer" align="left">
          <template #header>
            <div style="display: flex; justify-content: space-between">
              <h6 class="mb-0">Products List:</h6>
              <b-button @click="addProduct()" variant="outline-primary"
                >Add Product</b-button
              >
            </div>
          </template>
          <b-table
            striped
            hover
            outlined
            responsive="sm"
            :items="items"
            :fields="fields"
          >
            <template #cell(index)="data">
              {{ data.index + 1 }}
            </template>
            <template #cell(modify)="data">
              <b-button @click="editProduct(data.item.id)" variant="primary"
                >modify</b-button
              >
            </template>
            <template #cell(delete)="data">
              <b-button @click="deleteProduct(data.item.id)" variant="danger"
                >delete</b-button
              >
            </template>
          </b-table>

          <!-- <b-card-text>Header and footers using slots.</b-card-text>
          <b-button href="#" variant="primary">Go somewhere</b-button>
          <template #footer>
            <em>Footer Slot</em>
          </template> -->
        </b-card>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import axios from "axios";
export default {
  name: "Products",
  data() {
    return {
      fields: [
        "index",
        "ProductName",
        "UnitPrice",
        { key: "modify", label: "" },
        { key: "delete", label: "" },
      ],

      items: [],
    };
  },
  methods: {
    getProducts() {
      let self = this;
      axios
        .get(this.$apiAdress + "/api/products")
        .then(function (response) {
          console.log(response);
          self.items = response.data.products;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    addProduct() {
      this.$router.push({ path: "products/create" });
    },
    editProduct(id) {
      console.log("trying to modify :" + id);
      this.$router.push({ path: `products/${id.toString()}/edit` });
    },
    deleteProduct(id) {
      console.log("trying to delete :" + id);
      // let self = this;
      axios
        .delete(this.$apiAdress + "/api/products/" + id)
        .then((response) => {
          console.log(response);
          if (response.status == 200) {
            this.getProducts();
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.getProducts();
  },
};
</script>

<style>
</style>