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
              <li class="breadcrumb-item">
                <a href="/equipments-class">Equipment Class</a>
              </li>
              <li class="breadcrumb-item">{{ $route.params.eq }}</li>
            </ol>
          </nav>
          <div></div>
        </div>
      </div>

      <div class="card-body">
        <div class="card text-left">
          <div class="card-header mid-menu">
            <ul class="nav nav-tabs card-header-tabs">
              <li class="nav-item">
                <a
                  class="nav-link active"
                  href="#parameters"
                  role="tab"
                  data-toggle="tab"
                  v-on:click="tabDisplay('parameters')"
                >Parameters</a>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  href="#equipments"
                  role="tab"
                  data-toggle="tab"
                  v-on:click="tabDisplay('equipments')"
                >Equipments</a>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  href="#datas"
                  role="tab"
                  data-toggle="tab"
                  v-on:click="tabDisplay('datas')"
                >Data</a>
              </li>
            </ul>
          </div>
        </div>
        <div v-if="parameterView">
          <div class="form-row">
            <div class="col-md-2">
              <button
                type="button"
                class="btn btn-primary"
                style="margin-top:40px;margin-bottom:10px"
                @click="newParameter()"
              >New Parameter</button>
            </div>
            <div class="col-md-2">
              <button
                type="button"
                class="btn btn-info"
                style="margin-top:40px;margin-bottom:10px"
                @click="saveParameter()"
              >Save Parameter</button>
            </div>
            <div class="col-md-2">
              <button
                type="button"
                class="btn btn-danger"
                style="margin-top:40px;margin-bottom:10px"
                @click="getFormula()"
              >Calculate</button>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Equipment Class</th>
                  <th>units</th>
                  <th>type</th>
                  <th>Is Formula</th>
                  <th>Formula</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="parameter in parameters" v-bind:key="parameter.id">
                  <td>
                    <input type="text" class="form-control" v-model="parameter.name">
                  </td>

                  <td>
                    <select name id class="form-control" v-model="parameter.equipment_class_id">
                      <option
                        :value="eq.id"
                        v-for="(eq, index) in equipmentsClass"
                        :key="index"
                      >{{ eq.eq }}</option>
                    </select>
                  </td>
                  <td>
                    <select name id class="form-control" v-model="parameter.units_id">
                      <option
                        :value="unit.id"
                        v-for="(unit, index) in units"
                        :key="index"
                      >{{ unit.name }}</option>
                    </select>
                  </td>
                  <td>
                    <select name id class="form-control" v-model="parameter.type_id">
                      <option
                        :value="data_type.id"
                        v-for="(data_type, index) in data_types"
                        :key="index"
                      >{{ data_type.name }}</option>
                    </select>
                  </td>
                  <td>
                    <select name id class="form-control" v-model="parameter.is_formula">
                      <option value="1">Ye</option>
                      <option value="0">No</option>
                    </select>
                  </td>
                  <td>
                    <input type="text" class="form-control" v-model="parameter.formula">
                  </td>
                  <td>
                    <a
                      href="javascript:void(0)"
                      v-on:click="deleteParameter(parameter)"
                      class="icon"
                    >
                      <i class="fa fa-trash"></i>
                    </a>
                    <!-- <router-link
                      :to="{name:'ParameterPage',params:{id: parameter.id}}"
                      class="icon"
                    >
                      <i class="fa fa-pencil"></i>
                    </router-link>-->
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div v-if="equipmentView">
          <div class="form-row">
            <div class="col-md-2">
              <button
                type="button"
                class="btn btn-primary"
                style="margin-top:40px;margin-bottom:10px"
                @click="newEquipment()"
              >New Equipment</button>
            </div>
            <div class="col-md-2">
              <button
                type="button"
                class="btn btn-info"
                style="margin-top:40px;margin-bottom:10px"
                @click="saveEquipment()"
              >Save Equipment</button>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Equipment Class</th>

                  <!-- <th>Construction</th> -->
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="equipment in equipments" v-bind:key="equipment.id">
                  <td>
                    <input type="text" class="form-control" v-model="equipment.name">
                  </td>

                  <td>
                    <select name id class="form-control" v-model="equipment.equipment_class_id">
                      <option
                        :value="eq.id"
                        v-for="(eq, index) in equipmentsClass"
                        :key="index"
                      >{{ eq.eq }}</option>
                    </select>
                  </td>

                  <td>
                    <a href="#" v-on:click="deleteEquipment(equipment)" class="icon">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div v-if="dataView">
          <div class="form-row">
            <div class="col-md-2">
              <button
                type="button"
                class="btn btn-primary"
                style="margin-top:40px;margin-bottom:10px"
                @click="newData()"
              >New Data</button>
            </div>
            <!-- <div class="col-md-2">
              <button
                type="button"
                class="btn btn-info"
                style="margin-top:40px;margin-bottom:10px"
                @click="testFormula()"
              >Calculate</button>
            </div>-->
            <div class="col-md-2">
              <button
                type="button"
                class="btn btn-success"
                style="margin-top:40px;margin-bottom:10px"
                @click="saveDatas()"
              >Save Datas</button>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Parameter</th>
                  <th>Equipment</th>
                  <th>Value</th>

                  <!-- <th>Construction</th> -->
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(data,index) in parameters_data" v-bind:key="index">
                  <td>
                    <select name id class="form-control" v-model="data.par">
                      <option
                        :value="parameter.id"
                        v-for="(parameter, index) in parameters"
                        :key="index"
                      >{{ parameter.name }}</option>
                    </select>
                  </td>

                  <td>
                    <select name id class="form-control" v-model="data.eq">
                      <option
                        :value="eq.id"
                        v-for="(eq, index) in equipments"
                        :key="index"
                      >{{ eq.name }}</option>
                    </select>
                  </td>
                  <td>{{ data.value }}</td>

                  <td>
                    <a href="javascript:void(0)" v-on:click="deleteData(data)" class="icon">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
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
import Swal from "sweetalert2";
import axios from "axios";
import { forEachOf } from "async-es";

export default {
  name: "tabEquipments",

  data() {
    return {
      editId: "",
      loaded: false,
      parameterView: true,
      equipmentView: false,
      dataView: false,
      eq: "",
      parameters_data: [],
      parameters_dependences: [],
      parameters: [],
      formulas: [],
      parameters_data: [],
      equipments: [],
      equipmentsClass: [],
      units: [],
      data_types: []
    };
  },
  async created() {
    if (localStorage.getItem("role_id") == "5d668107e7179a084ef4f684") {
      return this.$router.push({ name: "clickpump" });
    }
    this.getParameters();
    this.getEquipments();
    this.getEquipmentsClass();
    this.getUnits();
    this.getDataTypes();
    this.getParameterDatas();
    this.loaded = true;
  },
  computed: {},
  methods: {
    async testFormula() {
      this.loaded = false;
      let index = 0;
      await this.parameters_data.forEach(data => {
        if (data.par && data.eq) {
          this.getFormula(data.par, index);
        }
        index++;
      });

      this.loaded = true;
    },
    async saveDatas() {
      await api.saveParameterDataList(this.parameters_data);
      Swal.fire("SUCCESS!", "Parameters Calculated and saved ", "success");
    },
    selectFormula(parameter) {
      let result = "";
     
      const formulas = this.formulas;

      formulas.forEach(formula => {
      
        if (formula.parameter == parameter) result = formula.formula;
      });
      return result;
    },
    async convertParameter(value, parameter) {
      let params = [];
      let new_value = value;
      for (let index = 0; index < value.length; index++) {
        if (value[index] === "@") {
          index++;
          let param = "";
          while (
            value[index] !== " " &&
            value[index] !== "+" &&
            value[index] !== "-" &&
            value[index] !== "*" &&
            value[index] !== "/" &&
            value[index] !== ">" &&
            value[index] !== "<" &&
            value[index] !== "(" &&
            value[index] !== ")"
          ) {
            param += value[index];
            index++;
            if (index > value.length) break;
          }
          param = param.replace("undefined", "");
          params.push({
            parameter: "@" + param,
            result: this.selectFormula(param)
          });
          // new_value = value.replace("@" + param, this.selectFormula(param));
        }
      }
      params.forEach(par => {
        new_value = new_value.replace(par.parameter, par.result);
      });
      this.formulas.push({
        parameter: parameter.name,
        formula: new_value
      });
      return new_value;
    },
    getValue(value) {
      console.log(Object.values(value));
    },
    async getFormula() {
      var t0 = performance.now();
      this.parameters_data = [];
      var is_formula = 0;
      let formula = null;
      this.parameters.forEach(async parameter => {
        if (parameter.formula) if (parameter.is_formula == 1) is_formula++;
      });
      var parameters = this.parameters;
      var formulas = [];
      var parameters_data = [];
      var parameters_dependences = [];
      let resolve_size = 0;
      let promisseTest = new Promise((resolve, reject) => {
        parameters.forEach(async parameter => {
          if (parameter.formula)
            if (parameter.is_formula == 1) {
              if (!parameter.formula.includes("@")) {
                //

                axios
                  .get(
                    "http://ec2-18-189-171-196.us-east-2.compute.amazonaws.com/calc/excel2?formula=" +
                      encodeURIComponent(parameter.formula)
                  )
                  .then(async resp => {
                    resolve_size++;
                    parameters_data.push({
                      id: "",
                      par: parameter.id,
                      eq: 7,
                      value: JSON.stringify(resp.data.result)
                    });

 let result = ''
                    if(resp.data.result.float)
                      result = resp.data.result.float
                    else if(resp.data.result.list)
                      result = resp.data.result.list
                    else if(resp.data.result.int)
                      result = resp.data.result.int
                    else if(resp.data.result.float64)
                      result = resp.data.result.float64
                    else if(resp.data.result.str)
                      result = resp.data.result.str
                    else if(resp.data.result.double)
                      result = resp.data.result.double
                    else if(resp.data.result.str)
                      result = resp.data.result.str


                    this.formulas.push({
                      parameter: parameter.name,
                      formula: parameter.formula
                    });
                    if (resolve_size == is_formula)
                      resolve([
                        parameters,
                        formulas,
                        parameters_data,
                        parameters_dependences
                      ]);

                    //     // await api.createParameterData({
                    //     //   id: "",
                    //     //   par: parameter.id,
                    //     //   eq: 7,
                    //     //   value: JSON.stringify(resp.data.result)
                    //     // });
                  });
              } else {
                //  await this.convertParameter(parameter.formula);
                resolve_size++;
                this.parameters_dependences.push(parameter);

                if (resolve_size == is_formula)
                  resolve([
                    parameters,
                    formulas,
                    parameters_data,
                    parameters_dependences
                  ]);
              }
            } else {
              this.parameters_data.push({
                id: "",
                par: parameter.id,
                eq: 7,
                value: parameter.formula
              });
              await this.formulas.push({
                parameter: parameter.name,
                formula: parameter.formula
              });
              // await api.createParameterData({
              //   id: "",
              //   par: parameter.id,
              //   eq: 7,
              //   value: parameter.formula
              // });
            }
        });
      });

      await promisseTest;
      promisseTest.then(data => {
        this.parameters = data[0];
        this.formulas = data[1];
        this.parameters_data = data[2];
        this.parameters_dependences = data[3];
      });

      var t1 = performance.now();

      alert(
        "time of execution is  " +
          (t1 - t0) +
          " milliseconds. tbe  number of formulas is " +
          is_formula
      );
      var parameter_name = "";
      var formula_result = "";
      let formulaPromisse = new Promise((resolve, reject) => {
        this.formulas.push({
          parameter: parameter_name,
          formula: formula_result
        });
      });

      Swal.fire("SUCCESS!", "Parameters Calculated and saved ", "success");
      //  this.dependeces();

      var dependeces_size = this.parameters_dependences.length;
      let promise_size = 0;
      let promisseDependeces = new Promise((resolve, reject) => {
        this.parameters_dependences.forEach(async parameter => {
          let formula = await this.convertParameter(parameter.formula, parameter);
          await this.setFormulas(formula, parameter);
          axios
            .get(
              "http://ec2-18-189-171-196.us-east-2.compute.amazonaws.com/calc/excel2?formula=" +
                encodeURIComponent(formula)
            )
            .then(async resp => {
              this.formulas.push({
                parameter: parameter.name,
                formula: formula
              });
              promise_size++;

              this.parameters_data.push({
                id: "",
                par: parameter.id,
                eq: 7,
                value: JSON.stringify(resp.data.result)
              });
              if (promise_size == dependeces_size) resolve();
            });
        });
      });
      await promisseDependeces;

      await api.saveParameterDataList(this.parameters_data);
      this.dataView = true;
      this.parameterView = false;
    },
    setFormulas(formula, parameter) {
      this.formulas.push({
        parameter: parameter.name,
        formula: formula
      });

      console.log({
        parameter: parameter.name,
        formula: formula
      });
    },
    dependeces() {
      // await api.saveParameterDataList(this.parameters_data);
    },
    async getUnits() {
      const unitsArray = await api.getUnits();
      unitsArray.forEach(unit => {
        this.units.push({
          id: unit.id,
          name: unit.name,
          type: unit.type,
          type_name: unit.type_name
        });
      });
    },
    newEquipment() {
      this.equipments.push({
        id: "",
        name: "",
        equipment_class_id: this.eq
      });
    },
    async deleteData(data) {
      if (data.id != "") await api.deleteParameterData(data.id);

      this.parameters_data.splice(this.parameters_data.indexOf(data), 1);
    },
    async deleteParameter(parameter) {
      if (parameter.id != "") await api.deleteParameter(parameter.id);

      this.parameters.splice(this.parameters.indexOf(parameter), 1);
    },
    async saveParameter() {
      let success = await api.saveParameterList(this.parameters);
      if (success) {
        Swal.fire("SUCCESS!", "Datas Saved ", "success");
      } else {
        Swal.fire("Error!", "Datas Saved ", "error");
      }
    },
    async saveEquipment() {
      let success = await api.saveEquipmentList(this.equipments);
      if (success) {
        Swal.fire("SUCCESS!", "Datas Saved ", "success");
      } else {
        Swal.fire("Error!", "Datas Saved ", "error");
      }
    },

    async deleteEquipment(equipment) {
      if (equipment.id != "") await api.deleteEq(equipment.id);

      this.equipments.splice(this.equipments.indexOf(equipment), 1);
    },
    async saveParameter() {
      let success = await api.saveParameterList(this.parameters);
      if (success) {
        Swal.fire("SUCCESS!", "Datas Saved ", "success");
      } else {
        Swal.fire("Error!", "Datas Saved ", "error");
      }
    },
    newParameter() {
      this.parameters.push({
        id: "",
        name: "",
        equipment_class_id: this.eq,
        units_id: "",
        type_id: "",
        is_formula: 1,
        formula: ""
      });
    },

    tabDisplay(value) {
      if (value == "parameters") {
        this.parameterView = true;
        this.equipmentView = false;
        this.dataView = false;
      } else if (value == "equipments") {
        this.parameterView = false;
        this.equipmentView = true;
        this.dataView = false;
      } else if (value == "datas") {
        this.dataView = true;
        this.parameterView = false;
        this.equipmentView = false;
      }
    },
    newData() {
      this.parameters_data.push({
        id: "",
        par: "",
        eq: "",
        value: ""
      });
    },

    async getDataTypes() {
      const data_typesArray = await api.getDataTypes();
      data_typesArray.forEach(data_types => {
        this.data_types.push({
          id: data_types.id,
          name: data_types.name
        });
      });
    },
    async getParameterDatas() {
      let parametersArray = [];
      let eq = this.$route.params.eq;

      parametersArray = await api.getParameterDatasByEq(eq);
      console.log(parametersArray);
      parametersArray.forEach(parameter => {
        this.parameters_data.push({
          id: parameter.id,
          value: parameter.value,
          par: parameter.par,
          eq: parameter.eq
        });
      });
    },
    async getEquipmentsClass() {
      let equipmentsArray = [];
      let eq = this.$route.params.eq;

      equipmentsArray = await api.getEqClasss();
      equipmentsArray.forEach(equipment => {
        this.equipmentsClass.push({
          id: equipment.id,
          eq: equipment.eq,
          description: equipment.description
        });
        if (equipment.eq == eq) this.eq = equipment.id;
      });
    },

    async getParameters() {
      let parametersArray = [];
      if (this.$route.params.eq) {
        let eq = this.$route.params.eq;
        this.eq = eq;

        parametersArray = await api.listByEq(eq);
      } else {
        parametersArray = await api.getParameters();
      }

      parametersArray.forEach(parameter => {
        this.parameters.push({
          id: parameter.id,
          name: parameter.name,
          equipment_class_id: parameter.equipment_class_id,
          units_id: parameter.units_id,
          type_id: parameter.type_id,
          is_formula: parameter.is_formula,
          formula: parameter.formula
        });
      });
    },
    async getEquipments() {
      let equipmentsArray = [];

      if (this.$route.params.eq) {
        let eq = this.$route.params.eq;

        equipmentsArray = await api.listEquipmentByEqClass(eq);
      } else {
        equipmentsArray = await api.getEqs();
      }

      equipmentsArray.forEach(equipment => {
        this.equipments.push({
          id: equipment.id,
          name: equipment.name,
          equipment_class_id: equipment.equipment_class_id
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
  /* border: none; */
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
  /* border: none; */
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
