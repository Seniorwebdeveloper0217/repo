<template>
  <div class="single-product">
    <div v-if="loaded">
      <div class="card">
        <div class="card-header">header</div>
        <div class="card-body">
          <div class="form-row">
            <div class="col-md-4">
              <label for>Name</label>
              <input type="text" class="form-control" v-model="parameterData.name">
            </div>
            <div class="col-md-4">
              <label for>Equipment Class</label>
              <select name id class="form-control" v-model="parameterData.equipment_class_id">
                <option
                  :value="equipment.id"
                  v-for="(equipment,index) in equipments"
                  :key="index"
                >{{ equipment.description }}</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-4">
              <label for>Units</label>

              <select name id class="form-control" v-model="parameterData.units_id">
                <option :value="unit.id" v-for="(unit,index) in units" :key="index">{{ unit.name }}</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for>Type</label>
              <select name id class="form-control" v-model="parameterData.type_id">
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
              <button type="button" class="btn btn-primary" @click="saveParameter()">Save</button>
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
      units: [],

      parameterData: {
        name: "",
        equipment_class_id: "",
        units_id: "",
        type_id: ""
      }
    };
  },
  created() {
    this.beforeCreate();
  },
  methods: {
    async beforeCreate() {
      if (this.$route.params.id) {
        const parameterData = await api.getParameter(this.$route.params.id);
        this.parameterData = {
          id: parameterData.id,
          name: parameterData.name,
          equipment_class_id: parameterData.equipment_class_id,
          units_id: parameterData.units_id,
          type_id: parameterData.type_id
        };
      }
      let eq = this.$route.params.eq
      const equipmentsArray = await api.getEqClasss();
      equipmentsArray.forEach(equipment => {
        this.equipments.push({
          id: equipment.id,
          description: equipment.description
        });
        if(eq==equipment.eq)
          this.parameterData.equipment_class_id = equipment.id
      });

      const data_typesArray = await api.getDataTypes();
      data_typesArray.forEach(data_types => {
        this.data_types.push({
          id: data_types.id,
          name: data_types.name
        });
      });

      const unitsArray = await api.getUnits();
      unitsArray.forEach(unit => {
        this.units.push({
          id: unit.id,
          name: unit.name
        });
      });

      this.loaded = true;
    },
    async doCreate() {
      await api.createParameter(this.parameterData);
    },
    async doUpdate() {
      await api.updateParameter(this.parameterData);
    },
    async saveParameter() {
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
