<template>
  <b-container class="create-order">
    <b-row>
      <b-col>
        <b-card header-tag="header" footer-tag="footer" align="left">
          <template #header>
            <div>
              <h6 class="mb-0">create new order:</h6>
            </div>
          </template>

          <b-form-group
            id="fieldset-1"
            description="Let us know Order Date."
            label="Enter Order Date:"
            label-for="input-1"
            valid-feedback="Thank you!"
            :invalid-feedback="invalidFeedback1"
            :state="state1"
          >
            <b-form-datepicker
              id="input-1"
              v-model="OrderDate"
              :state="state1"
              trim
              :type="'date'"
            ></b-form-datepicker>
          </b-form-group>

          <!-- <b-form-group
            id="fieldset-2"
            description="Let us know the time of that order."
            label="Enter Order Time:"
            label-for="input-2"
            valid-feedback="Thank you!"
            :invalid-feedback="invalidFeedback2"
            :state="state2"
          >
            <b-form-timepicker
              id="input-2"
              v-model="time"
              :state="state2"
              :hour12="false"
              trim
            ></b-form-timepicker>
          </b-form-group> -->
          <!--
          <b-form-group
            id="fieldset-3"
            description="Let us know the TotalAmount."
            label="Enter Product Unit Price:"
            label-for="input-3"
            valid-feedback="Thank you!"
            :invalid-feedback="invalidFeedback3"
            :state="state3"
          >
            <b-form-input
              id="input-3"
              v-model="form.TotalAmount"
              :state="state3"
              trim
              :type="'number'"
            ></b-form-input>
          </b-form-group> -->

          <b-form-group
            id="fieldset-4"
            description="Let us know who is the customer."
            label="Choose Customer:"
            label-for="input-4"
            valid-feedback="Thank you!"
            :invalid-feedback="invalidFeedback4"
            :state="state4"
          >
            <b-form-select
              id="input-4"
              v-model="CustomerId"
              :options="options"
              :state="state4"
              trim
            ></b-form-select>
          </b-form-group>

          <b-form-group
            id="fieldset-5"
            description="Let us know the products that you orderd."
            label="Choose products:"
            label-for="input-5"
            valid-feedback="Thank you!"
            :invalid-feedback="invalidFeedback5"
            :state="state5"
          >
            <!-- <b-form-select
              id="input-5"
              v-model="form.selectedProducts"
              multiple="true"
              :options="options"
              :state="state4"
              :select-size="4"
              trim
            ></b-form-select> -->
            <!-- <multiselect
              v-model="SelectedProducts"
              placeholder="Please Choose Tags"
              label="keyword"
              track-by="value"
              :hideSelected="true"
              openDirection="bottom"
              :options="products"
              :multiple="true"
              :state="state5"
            >
            </multiselect> -->
            <b-table
              striped
              hover
              outlined
              responsive="sm"
              :items="products"
              :fields="fields"
            >
              <template #cell(index)="data">
                {{ data.index + 1 }}
              </template>
              <template #cell(quantity)="data">
                <b-form-input
                  id="input-7"
                  v-model="SelectedProducts[data.item.id]"
                  trim
                  :type="'number'"
                ></b-form-input>
              </template>
              <template #cell(delete)="data">
                <b-button @click="deleteProduct(data.item.id)" variant="danger"
                  >delete</b-button
                >
              </template>
            </b-table>
          </b-form-group>

          <template #footer>
            <b-button @click="goBack()" variant="danger" class="mr-2"
              >Back</b-button
            >
            <b-button
              v-if="active"
              @click="store()"
              variant="primary"
              class="mr-2"
              >Save</b-button
            >

            <b-button v-if="!active" disabled class="mr-2">Save</b-button>
          </template>
        </b-card>
      </b-col>
    </b-row>
  </b-container>
</template>
    
          

<script>
import axios from "axios";
export default {
  name: "CreateProduct",
  data() {
    return {
      name: "",
      OrderDate: new Date(),
      // OrderNumber: null,
      // TotalAmount: null,
      CustomerId: null,
      SelectedProducts: [],

      // date: this.dateString(),
      // time: this.timeString(),
      customers: [],
      products: [],
      fields: [
        "index",
        "ProductName",
        "UnitPrice",
        { key: "quantity", label: "Quantity" },
        // { key: "check", label: "Choose Prodcut" },
      ],
    };
  },
  computed: {
    formattedProducts() {
      const objectsArray = [];
      this.SelectedProducts.forEach((elem, index) => {
        if (elem !== undefined && elem !== "") {
          const obj = {
            id: index,
            UnitPrice: this.products[index - 1].UnitPrice,
            Quantity: elem,
          };
          objectsArray.push(obj);
        }
      });
      return objectsArray;
    },
    state1() {
      // if (this.date == new Date().toISOString().split("T")[0]) {
      //   return true;
      // } else {
      return new Date(this.OrderDate) > new Date();
      // }
    },
    invalidFeedback1() {
      if (new Date(this.OrderDate) < new Date()) {
        return "we cant travel back in time.";
      }
      return "Please enter something.";
    },

    // state2() {
    //   return new Date(this.date + " " + this.time) > new Date();
    // },
    // invalidFeedback2() {
    //   if (
    //     this.date == new Date().toISOString().split("T")[0] &&
    //     new Date(this.date + " " + this.time) < new Date()
    //   ) {
    //     return "we cant travel back in time.";
    //   }
    //   return "Please enter something.";
    // },

    state4() {
      return this.CustomerId != null;
    },
    invalidFeedback4() {
      if (this.CustomerId == null) {
        return "Choose a Customer.";
      }
      return "Please enter something.";
    },

    state5() {
      return this.formattedProducts.length != 0;
    },
    invalidFeedback5() {
      if (this.formattedProducts.length == 0) {
        return "Choose a product and add a quantity.";
      }
      return "Please enter something.";
    },
    active() {
      return this.state1 && this.state5 && this.state4;
    },

    options() {
      return this.customers.map((obj) => ({
        value: obj.id,
        text: obj.FirstName + " " + obj.LastName,
      }));
    },
  },
  methods: {
    // timeString() {
    //   let chunks = new Date().toTimeString().split(" ");
    //   return chunks[0];
    // },
    // dateString() {
    //   let chunks = new Date().toISOString().split("T");
    //   return chunks[0];
    // },
    getCustomers() {
      let self = this;
      axios
        .get(this.$apiAdress + "/api/customers")
        .then(function (response) {
          console.log(response);
          self.customers = response.data.customers;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    getProducts() {
      let self = this;
      axios
        .get(this.$apiAdress + "/api/products")
        .then(function (response) {
          console.log(response);
          self.products = response.data.products;
          /* .map((obj) => ({
            value: obj.id,
            keyword: obj.ProductName,
            UnitPrice: obj.UnitPrice,
          })); */
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    goBack() {
      this.$router.go(-1);
    },

    store() {
      const formData = new FormData();
      formData.set("OrderDate", this.OrderDate);
      formData.set("CustomerId", this.CustomerId);
      formData.set("Products", JSON.stringify(this.formattedProducts));

      for (var pair of formData.entries()) {
        console.log(pair[0] + ", " + pair[1]);
      }
      let self = this;
      axios
        .post(this.$apiAdress + "/api/orders", formData)
        .then(function (response) {
          console.log(response);
          self.goBack();
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
  mounted() {
    this.getCustomers();
    this.getProducts();
  },
};
</script>

<style scoped>
.multiselect__tags {
  border: 0.5px solid #827c7c !important;
}
</style>
