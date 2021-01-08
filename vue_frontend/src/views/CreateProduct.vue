<template>
  <b-container class="create-product">
    <b-row>
      <b-col>
        <b-card header-tag="header" footer-tag="footer" align="left">
          <template #header>
            <div>
              <h6 class="mb-0">create new Product:</h6>
            </div>
          </template>

          <b-form-group
            id="fieldset-1"
            description="Let us know product name."
            label="Enter Product Name:"
            label-for="input-1"
            valid-feedback="Thank you!"
            :invalid-feedback="invalidFeedback1"
            :state="state1"
          >
            <b-form-input
              id="input-1"
              v-model="form.ProductName"
              :state="state1"
              trim
              :type="'text'"
            ></b-form-input>
          </b-form-group>

          <b-form-group
            id="fieldset-2"
            description="Let us know the price of one unit."
            label="Enter Product Unit Price:"
            label-for="input-2"
            valid-feedback="Thank you!"
            :invalid-feedback="invalidFeedback2"
            :state="state2"
          >
            <b-form-input
              id="input-2"
              v-model="form.UnitPrice"
              :state="state2"
              trim
              :type="'number'"
            ></b-form-input>
          </b-form-group>

          <b-form-group
            id="fieldset-3"
            description="Let us know who is the supplier."
            label="Choose Supplier:"
            label-for="input-3"
            valid-feedback="Thank you!"
            :invalid-feedback="invalidFeedback3"
            :state="state3"
          >
            <b-form-select
              id="input-3"
              v-model="form.SupplierId"
              :options="options"
              :state="state3"
              trim
            ></b-form-select>
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
      form: {
        ProductName: "",
        UnitPrice: null,
        SupplierId: null,
      },
      suppliers: [],
    };
  },
  computed: {
    state1() {
      return (
        this.form.ProductName.length >= 4 && this.form.ProductName.length <= 50
      );
    },
    invalidFeedback1() {
      if (
        this.form.ProductName.length > 0 &&
        this.form.ProductName.length <= 50
      ) {
        return "Enter at least 4 characters.";
      } else if (this.form.ProductName.length > 50) {
        return "Enter at max 50 characters.";
      }
      return "Please enter something.";
    },
    state2() {
      return this.form.UnitPrice > 0;
    },
    invalidFeedback2() {
      if (this.form.UnitPrice <= 0) {
        return "Enter a price greater than 0.";
      }
      return "Please enter something.";
    },
    state3() {
      return this.form.SupplierId != null;
    },
    invalidFeedback3() {
      if (this.form.SupplierId == null) {
        return "Choose a Supplier.";
      }
      return "Please enter something.";
    },
    active() {
      return this.state1 && this.state2 && this.state3;
    },

    options() {
      return this.suppliers.map((obj) => ({
        value: obj.id,
        text: obj.CompanyName + " : " + obj.ContactName,
      }));
    },
  },
  methods: {
    getSuppliers() {
      let self = this;
      axios
        .get(this.$apiAdress + "/api/suppliers")
        .then(function (response) {
          console.log(response);
          self.suppliers = response.data.suppliers;
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
      formData.set("ProductName", this.form.ProductName);
      formData.set("SupplierId", this.form.SupplierId);
      formData.set("UnitPrice", this.form.UnitPrice);

      console.log(this.form);
      let self = this;
      axios
        .post(this.$apiAdress + "/api/products", formData)
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
    this.getSuppliers();
  },
};
</script>

<style>
</style>