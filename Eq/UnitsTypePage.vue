<template>
  <div class="single-product">
    <div v-if="loaded">
      <div class="card">
        <div class="card-header">Unit Type</div>
        <div class="card-body">
          <div class="form-row">
            <div class="col-md-8">
              <label for>Name</label>
              <input type="text" class="form-control" v-model="unitData.name">
            </div>
           
          </div>

          <div class="form-row">
            <div class="col-md-4">
              <button type="button" class="btn btn-primary" @click="saveType()">Save</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <h3>Loading...</h3>
    </div>
  </div>
</template>

<script>
import api from "@/api";
import Swal from "sweetalert2";
export default {
  name: "UnitsTypePage",

  data() {
    return {
      loaded: false,
      data_types:[],

      unitData: {
        name: "",
      }
    };
  },
  created() {
    this.beforeCreate();
  },
  methods: {
    async beforeCreate() {
      if (this.$route.params.id) {
        const unitData = await api.getUnit(this.$route.params.id);
        this.unitData = {
          id: unitData.id,
          name: unitData.name,
          type: unitData.type
        };
      }

      const data_typesArray = await api.getUnitTypes();
      data_typesArray.forEach(data_types => {
        this.data_types.push({
          id: data_types.id,
          name: data_types.name
        });
      });

      this.loaded = true;
    },
    async doCreate() {
      await api.createUnitType(this.unitData);
    },
    async doUpdate() {
      await api.updateUnitType(this.unitData);
    },
    async saveType() {
      this.loaded = false;
      if (this.unitData.id) await this.doUpdate();
      else await this.doCreate();
      Swal.fire("SUCCESS!", "Data Saved ", "success");
      this.loaded = true;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  text-align: center;
  margin-top: 30px;
  margin-bottom: 20px;
}
</style>
