<template>
  <div class="parameters" v-if="loaded">
    <!-- <h3>Product Parameter</h3> -->
    <div class="card mt-5">
      <div class="card-header">
        <div class="d-flex justify-content-between">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/">Centrifugal Pump</a>
              </li>
              <li class="breadcrumb-item">Product Parameter List</li>
            </ol>
          </nav>
          <div></div>
          <div>
            <router-link :to="{name:'ParameterPage',params:{id: null, eq:eq}}" class="icon">
              <button type="button" class="btn btn-primary">New Product Parameter</button>
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
                <th>Equipment Class</th>
                <th>units</th>
                <th>type</th>
                <!-- <th>Construction</th> -->
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="parameter in sortedParameters" v-bind:key="parameter.id">
                <td>{{parameter.name}}</td>

                <td>{{parameter.equipment.description}}</td>
                <td>{{parameter.units}}</td>
                <td>{{parameter.type.name}}</td>
                <td>
                 

                  <a href="#" v-on:click="onDelete(parameter.id)" class="icon">
                    <i class="fa fa-trash"></i>
                  </a>
                  <router-link :to="{name:'ParameterPage',params:{id: parameter.id}}" class="icon">
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
  name: "ParametersList",

  data() {
    return {
      editId: "",
      loaded: false,
      eq:'',

      parameters: []
    };
  },
  async created() {
    if (localStorage.getItem("role_id") == "5d668107e7179a084ef4f684") {
      return this.$router.push({ name: "clickpump" });
    }
    this.getParameters();
    this.loaded = true;
  },
  computed: {
    sortedParameters() {
      return this.parameters.slice().sort((a, b) => {
        return a.name - b.name;
      });
    }
  },
  methods: {
    async getParameters() {
      let parametersArray = [];
      if (this.$route.params.eq) {
        let eq = this.$route.params.eq;
        this.eq = eq

        parametersArray = await api.listByEq(eq);
      } else {
        parametersArray = await api.getParameters();
      }

      parametersArray.forEach(parameter => {
        this.parameters.push({
          id: parameter.id,
          name: parameter.name,
          equipment: parameter.equipment,
          units: parameter.units,
          type: parameter.type
        });
      });
    },

    async onDelete(id) {
      if (confirm("Are you sure you want to delete this Product Parameter?")) {
        this.loaded = false;
        await api.deleteParameter(id);
        await this.getParameters();
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
