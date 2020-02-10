<template>
  <div class="single-product">
    <div v-if="loaded">
      <div class="card">
        <div class="card-header">Unit</div>
        <div class="card-body">
          <div class="form-row">
            <div class="col-md-4">
              <label for>Name</label>
              <input type="text" class="form-control" v-model="unitData.name">
            </div>
            <div class="col-md-4">
              <label for>Type</label>
              <select name id class="form-control" v-model="unitData.type">
                <option
                  :value="data.id"
                  v-for="(data,index) in data_types"
                  :key="index"
                >{{ data.name }}</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="col-md-4">
              <button type="button" class="btn btn-primary" @click="saveUnit()">Save</button>
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
  name: "UnitsPage",

  data() {
    return {
      loaded: false,
      data_types:[],

      unitData: {
        name: "",
        type: ""
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
      await api.createUnit(this.unitData);
    },
    async doUpdate() {
      await api.updateUnit(this.unitData);
    },
    async saveUnit() {
      this.loaded = true;
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
