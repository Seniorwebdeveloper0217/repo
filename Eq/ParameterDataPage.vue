<template>
  <div class="single-product">
    <div v-if="loaded">
      <div class="card">
        <div class="card-header">Parameter Data page</div>
        <div class="card-body">
          <div class="form-row">
            <div class="col-md-12">
              <label for>Value</label>
              <input type="text" class="form-control" v-model="parameterData.value">
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6">
              <label for>Equipment</label>
              <select name id class="form-control" v-model="parameterData.eq">
                <option
                  :value="equipment.id"
                  v-for="(equipment,index) in equipments"
                  :key="index"
                >{{ equipment.name }}</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for>Parameter</label>
              <select name id class="form-control" v-model="parameterData.par">
                <option
                  :value="parameter.id"
                  v-for="(parameter,index) in parameters"
                  :key="index"
                >{{ parameter.name }}</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-4">
              <button type="button" class="btn btn-primary" @click="saveParameterData()">Save</button>
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
  name: "ParameterPage",
  data() {
    return {
      loaded: false,
      data_types: [],
      equipments: [],
      parameters: [],

      parameterData: {
        id: "",
        value: "",
        eq: "",
        par: ""
      }
    };
  },
  created() {
    this.beforeCreate();
  },
  methods: {
    async beforeCreate() {
      if (this.$route.params.id) {
        const parameterData = await api.getParameterData(this.$route.params.id);
        this.parameterData = {
          id: parameterData.id,
          value: parameterData.value,
          eq: parameterData.eq,
          par: parameterData.par
        };
      }

      const equipmentsArray = await api.getEqs();
      equipmentsArray.forEach(equipment => {
        this.equipments.push({
          id: equipment.id,
          name: equipment.name
        });
      });
      const parametersArray = await api.getParameters();

      parametersArray.forEach(parameter => {
        this.parameters.push({
          id: parameter.id,
          name: parameter.name
        });
      });

      this.loaded = true;
    },
    async doCreate() {
      await api.createParameterData(this.parameterData);
    },
    async doUpdate() {
      await api.updateParameterData(this.parameterData);
    },
    async saveParameterData() {
      this.loaded = false;
      if (this.parameterData.id) await this.doUpdate();
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
