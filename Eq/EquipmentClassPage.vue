<template>
  <div class="single-product">
    <div v-if="loaded">
      <div class="card">
        <div class="card-header">Equipment Class Page</div>
        <div class="card-body">
          <div class="form-row">
            <div class="col-md-4">
              <label for>Eq</label>
              <input type="text" class="form-control" v-model="equipmentData.eq">
            </div>
            <div class="col-md-8">
              <label for>Description</label>
              <input type="text" class="form-control" v-model="equipmentData.description">
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
  name: "EquipmentClassPage",
  data() {
    return {
      loaded: false,
      data_types: [],
      equipments: [],

      equipmentData: {
        eq: "",
        description: "",
       
      }
    };
  },
  created() {
    this.beforeCreate();
  },
  methods: {
    async beforeCreate() {
      if (this.$route.params.id) {
        const equipmentData = await api.getEqClass(this.$route.params.id);
        this.equipmentData = {
            id: equipmentData.id,
          eq: equipmentData.eq,
          description: equipmentData.description,
     
        };
      }

    

      this.loaded = true;
    },
   async doCreate(){
        await api.createEqClass(this.equipmentData)
    },
    async doUpdate(){
        await api.updateEqClass(this.equipmentData)
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
