<template>
  <v-layout row justify-center>
    <v-dialog v-model="openAddRequest" persistent max-width="900px">
      <v-card>
        <v-card-title fixed>
          <span class="headline">Add Derivery</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-form ref="form" @submit.prevent>
                <v-container grid-list-xl fluid>
                  <v-layout wrap>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="form.grower_name"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Grower Name"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="form.code"
                      color="blue darken-2"
                      label="Code"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="form.no_of_bags"
                      color="blue darken-2"
                      label="Number Of Bags"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="form.vihicle_reg"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Vihicle Regestration"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="form.weight"
                      color="blue darken-2"
                      label="Weight"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <div class="form-group col-md-6">
                      <label for="password" class="col-md-4 col-form-label text-md-right">Units</label>
                      <div class="col-md-6">
                          <select class="custom-select" v-model="form.unit">
                            <option v-for="unit in units" data-subtext="" :value="unit.id">{{unit.title}}</option>
                          </select>
                      </div>
                    </div>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="form.pammit_no"
                      color="blue darken-2"
                      label="Pammit Number"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="form.weighing_bridge"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Weighng Bridge"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="form.clerks_name"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Clerks Name"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="form.grower_rep"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Grower Representative"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <div class="form-group col-md-6">
                      <label for="password" class="col-md-4 col-form-label text-md-right">Select Society</label>
                      <div class="col-md-6">
                          <select class="custom-select" v-model="form.society">
                            <option v-for="element in society" data-subtext="" :value="element.id">{{element.name}}</option>
                          </select>
                      </div>
                    </div>
                  <div class="form-group col-md-6">
                    <label for="password" class="col-md-4 col-form-label text-md-right">Coffee Types</label>
                    <div class="col-md-6">
                        <select class="custom-select" v-model="form.coffee_types">
                          <option v-for="item in coffeeType" data-subtext="" :value="item.id">{{item.type}}</option>
                        </select>
                    </div>
                  </div>
                </v-layout>
              </v-container>
              <v-card-actions>
                <v-btn flat @click="resetForm">reset</v-btn>
                <v-btn flat @click="close">Close</v-btn>
                <v-spacer></v-spacer>
                <v-btn
                :disabled="loading"
                :loading="loading"
                flat
                color="primary"
                @click="save"
                >Submit</v-btn>
              </v-card-actions>
            </v-form>
          </v-layout>
        </v-container>
      </v-card-text>
    </v-card>
  </v-dialog>
</v-layout>
</template>

<script>
export default {
  props: ['openAddRequest', 'society', 'coffeeType', 'units'],
  components: {
  },
  data() {
    const defaultForm = Object.freeze({
      grower_rep: '',
      grower_name: '',
      clerks_name: '',
      weight: '',
      weighing_bridge: '',
      pammit_no: '',
      vihicle_reg: '',
      no_of_bags: '',
      code: '',
      society: null,
      coffee_types: '',
      units: '',
    })
    return{
      errors: {},
      defaultForm,
      loading: false,
      form: Object.assign({}, defaultForm),
      rules: {
        name: [val => (val || '').length > 0 || 'This field is required']
      },
    }
  },
  methods: {
    save() {
      this.loading=true
      axios.post('/derivery', this.$data.form).
      then((response) => {
        this.loading=false
        console.log(response.data);
        // this.close;
        // this.resetForm();
        // this.$emit('closeRequest');
        this.$emit('alertRequest');
        this.$parent.Allderivery.push(response.data) 

      })
      .catch((error) => {
        this.errors = error.response.data.errors
        this.loading=false
      })
    },
    resetForm () {
      this.form = Object.assign({}, this.defaultForm)
      this.$refs.form.reset()
    },
    close() {
      this.$emit('closeRequest')
    },

  },
  computed: {
   formIsValid () {
     return (
        this.form.grower_rep &&
        this.form.grower_name &&
        this.form.clerks_name &&
        this.form.weight &&
        this.form.weighing_bridge &&
        this.form.pammit_no &&
        this.form.vihicle_reg &&
        this.form.no_of_bags &&
        this.form.code 
      )
   },
 },
 mounted() {
 }
}
</script>
