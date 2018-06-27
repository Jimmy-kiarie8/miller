<template>

  <!-- Edit User -->
  <v-dialog v-model="openEditRequest" max-width="800px" persistent>
    <v-card>
      <v-card-title>
        {{ editedItemCon.name }}
      </v-card-title>
      <v-card-text>
        <v-form ref="form" @submit.prevent="update">
          <v-container grid-list-xl fluid>
            <v-layout wrap>
              <v-flex xs12 sm6>
                <v-text-field
                v-model="editedItemCon.grower_name"
                :rules="rules.name"
                color="blue darken-2"
                label="Grower Name"
                required
                ></v-text-field>
                <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
              </v-flex>
              <v-flex xs12 sm6>
                <v-text-field
                v-model="editedItemCon.code"
                color="blue darken-2"
                label="Code"
                required
                ></v-text-field>
                <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
              </v-flex>
              <v-flex xs12 sm6>
                <v-text-field
                v-model="editedItemCon.no_of_bags"
                color="blue darken-2"
                label="Number Of Bags"
                required
                ></v-text-field>
                <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
              </v-flex>
              <v-flex xs12 sm6>
                <v-text-field
                v-model="editedItemCon.vihicle_reg"
                :rules="rules.name"
                color="blue darken-2"
                label="Vihicle Regestration"
                required
                ></v-text-field>
                <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
              </v-flex>
              <v-flex xs12 sm6>
                <v-text-field
                v-model="editedItemCon.weight"
                color="blue darken-2"
                label="Weight"
                required
                ></v-text-field>
                <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
              </v-flex>
              <div class="form-group  col-md-6">
                <label for="password" class="col-md-4 col-form-label text-md-right">Units</label>
                <div class="col-md-6">
                    <select class="custom-select" v-model="editedItemCon.units">
                      <option v-for="unit in units" data-subtext="" :value="unit.id">{{unit.title}}</option>
                    </select>
                </div>
              </div>
              <v-flex xs12 sm6>
                <v-text-field
                v-model="editedItemCon.pammit_no"
                color="blue darken-2"
                label="Pammit Number"
                required
                ></v-text-field>
                <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
              </v-flex>
              <v-flex xs12 sm6>
                <v-text-field
                v-model="editedItemCon.weighing_bridge"
                :rules="rules.name"
                color="blue darken-2"
                label="Weighng Bridge"
                required
                ></v-text-field>
                <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
              </v-flex>
              <v-flex xs12 sm6>
                <v-text-field
                v-model="editedItemCon.clerks_name"
                :rules="rules.name"
                color="blue darken-2"
                label="Clerks Name"
                required
                ></v-text-field>
                <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
              </v-flex>
              <v-flex xs12 sm6>
                <v-text-field
                v-model="editedItemCon.grower_rep"
                :rules="rules.name"
                color="blue darken-2"
                label="Grower Representative"
                required
                ></v-text-field>
                <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
              </v-flex>
              <div class="form-group  col-md-6">
                <label for="password" class="col-md-4 col-form-label text-md-right">Select Society</label>
                <div class="col-md-6">
                    <select class="custom-select" v-model="editedItemCon.society">
                      <option v-for="element in society" data-subtext="" :value="element.id">{{element.name}}</option>
                    </select>
                </div>
              </div>

              <div class="form-group  col-md-6">
                <label for="password" class="col-md-4 col-form-label text-md-right">Coffee Types</label>
                <div class="col-md-6">
                    <select class="custom-select" v-model="editedItemCon.coffee_types">
                      <option v-for="item in coffeeType" data-subtext="" :value="item.id">{{item.type}}</option>
                    </select>
                </div>
              </div>
            </v-layout>
          </v-container>
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-btn color="primary" flat @click.stop="close">Close</v-btn>
        <v-spacer></v-spacer>
        <v-btn 
        color="primary" 
        flat 
        @click="update"
        :loading="loading"
        :disabled="loading"
        >Update</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
  <!-- Edit User -->

</template>

<script>
export default {
  props: ['editedItemCon', 'openEditRequest', 'society', 'coffeeType', 'units'],
  data() {
    return{
      loader: false,
      loading:false,
      list: {},
      rules: {
        name: [val => (val || '').length > 0 || 'This field is required']
      },
    }
  },
  methods: {
    update() {
      this.loading=true
      axios.patch(`/derivery/${this.editedItemCon.id}`, this.editedItemCon)
      .then((response) => {
        // console.log(response);
        this.loading=false
        this.close;
            // this.resetForm();
            Object.assign(this.$parent.Allderivery[this.$parent.editedIndex], this.$parent.editedItem)
            this.$emit('closeRequest');
            this.$emit('alertRequest');

          })
      .catch((error) => {
        this.errors = error.response.data.errors
        this.loading=false
      })
    },
    /*resetForm () {
        this.form = Object.assign({}, this.defaultForm)
        this.$refs.form.reset()
      },*/
      close() {
        this.$emit('closeRequest')
      },
    },
    mounted() {

    }
  }
  </script>
