<template>
  <div class="types" v-if="loaded">
    <!-- <h3> Units</h3> -->
    <div class="card mt-5">
      <div class="card-header">
        <div class="d-flex justify-content-between">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/">Centrifugal Pump</a>
              </li>
              <li class="breadcrumb-item">Units List</li>
            </ol>
          </nav>
          <div></div>
          <div>
            <router-link :to="{name:'UnitsPage',params:{id: null}}" class="icon">
              <button type="button" class="btn btn-primary">New Units</button>
            </router-link>
          </div>
        </div>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Type</th>
                <!-- <th>Construction</th> -->
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="type in units" v-bind:key="type.id">
                <td>{{type.name}}</td>

                <td>{{type.type_name}}</td>
                <td>
                  <a href="#" v-on:click="onDelete(type.id)" class="icon">
                    <i class="fa fa-trash"></i>
                  </a>
                  <router-link :to="{name:'UnitsPage',params:{id: type.id}}" class="icon">
                    <i class="fa fa-pencil"></i>
                  </router-link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div v-else class="ml-auto text-center">
    <i class="fa fa-circle-o-notch fa-spin" style="font-size:48px"></i>
    <!--<h3>Loading...</h3>-->
  </div>
</template>

<script>
import api from "@/api";
export default {
  name: "UnitsList",

  data() {
    return {
      editId: "",
      loaded: false,
      units: [],
      types: []
    };
  },
  async created() {
    if (localStorage.getItem("role_id") == "5d668107e7179a084ef4f684") {
      return this.$router.push({ name: "clickpump" });
    }
    this.getUnits();
    this.loaded = true;
  },
  computed: {},
  methods: {
    async getUnits() {
      const unitsArray = await api.getUnits();
console.log(unitsArray)
      unitsArray.forEach(unit => {
        this.units.push({
          id: unit.id,
          name: unit.name,
          type: unit.type,
          type_name: unit.type_name
        });
      });
    },

    async onDelete(id) {
      if (confirm("Are you sure you want to delete this  Units?")) {
        this.loaded = false;
        await api.deleteUnits(id);
        await this.getUnits();
        this.loaded = true;
      }
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
.icon {
  margin-right: 10px;
}
.icon i {
  cursor: pointer;
}

.card {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
    Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
}

.mid-menu {
  background-color: #33cc66;
}

.sub-menu {
  background-color: #33cc66;
}

.nav-link {
  color: #fff;
  font-weight: bold;
  font-size: 14px;
}

.list {
  padding: 0px;
  margin: 10px;
  background-color: #fff;
}

.breadcrumb-item a {
  color: #29436a;
  font-weight: bold;
}

input {
  border: none;
}

h3 {
  text-align: center;
  margin-top: 30px;
  margin-bottom: 20px;
}

h6 {
  color: #33cc66;
  font-weight: bold;
}

.form-group {
  color: #29436a;
  font-weight: bold;
}

.btn-primary {
  background-color: #33cc66;
  font-weight: bold;
  border: none;
}

.btn-secondary {
  background-color: #fff;
  color: #33cc66;
  font-weight: bold;
  border: none;
}

select {
  border: none;
}

.row.vdivide [class*="col-"]:not(:last-child):after {
  background: #e0e0e0;
  width: 1px;
  content: "";
  display: block;
  position: absolute;
  top: 0;
  bottom: 0;
  right: 0;
  min-height: 70px;
}
</style>
