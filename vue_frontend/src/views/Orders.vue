<template>
  <b-container class="list-Orders">
    <b-row>
      <b-col>
        <b-card header-tag="header" footer-tag="footer" align="left">
          <template #header>
            <div style="display: flex; justify-content: space-between">
              <h6 class="mb-0">Orders List:</h6>
              <b-button @click="addOrder()" variant="outline-primary"
                >Add Order</b-button
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
              <b-button @click="editOrder(data.item.id)" variant="primary"
                >modify</b-button
              >
            </template>
            <template #cell(delete)="data">
              <b-button @click="deleteOrder(data.item.id)" variant="danger"
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
  name: "Orders",
  data() {
    return {
      fields: [
        "index",
        "OrderDate",
        "OrderNumber",
        "TotalAmount",
        { key: "modify", label: "" },
        { key: "delete", label: "" },
      ],

      items: [],
    };
  },
  methods: {
    getOrders() {
      let self = this;
      axios
        .get(this.$apiAdress + "/api/orders")
        .then(function (response) {
          console.log(response);
          self.items = response.data.orders;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    addOrder() {
      this.$router.push({ path: "orders/create" });
    },
    editOrder(id) {
      console.log("trying to modify :" + id);
      this.$router.push({ path: `orders/${id.toString()}/edit` });
    },
    deleteOrder(id) {
      console.log("trying to delete :" + id);
      // let self = this;
      axios
        .delete(this.$apiAdress + "/api/orders/" + id)
        .then((response) => {
          console.log(response);
          if (response.status == 200) {
            this.getOrders();
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.getOrders();
  },
};
</script>

<style>
</style>