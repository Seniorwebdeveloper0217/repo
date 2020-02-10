<template>
  <div class="single-product">
    <div v-if="loaded">
      <div class="card">
        <div class="card-header">Equipment Page</div>
        <div class="card-body">
          <div class="form-row">
            <div class="col-md-4">
              <label for>Name</label>
              <input type="text" class="form-control" v-model="equipmentData.name">
            </div>
            <div class="col-md-4">
              <label for>Equipment Class</label>
              <select name id class="form-control" v-model="equipmentData.equipment_class_id">
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
              <button type="button" class="btn btn-primary" @click="saveEquipment()">Save</button>
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
  name: "EquipmentPage",
  data() {
    return {
      loaded: false,
      data_types: [],
      equipments: [],

      equipmentData: {
        name: "",
        equipment_class_id: "",
       
      }
    };
  },
  created() {
    this.beforeCreate();
  },
  methods: {
    async beforeCreate() {
      if (this.$route.params.id) {
        const equipmentData = await api.getEq(this.$route.params.id);
        this.equipmentData = {
            id: equipmentData.id,
          name: equipmentData.name,
          equipment_class_id: equipmentData.equipment_class_id,
     
        };
      }

      const equipmentsArray = await api.getEqClasss();
      equipmentsArray.forEach(equipment => {
        this.equipments.push({
          id: equipment.id,
          description: equipment.description
        });
      });

      this.loaded = true;
    },
   async doCreate(){
        await api.createEq(this.equipmentData)
    },
    async doUpdate(){
        await api.updateEq(this.equipmentData)
    },
    async saveEquipment(){
        this.loaded = false
         if(this.equipmentData.id)
        await this.doUpdate()
      else
        await this.doCreate()
        Swal.fire(
        "SUCCESS!",
        "Data Saved ",
        "success"
      );
        this.loaded = true
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
