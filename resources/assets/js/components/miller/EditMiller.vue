<template>
  <v-layout row justify-center>
    <v-dialog v-model="openEditRequest" persistent max-width="700px">
      <v-card v-if="openEditRequest">
        <v-card-title fixed>
          <span class="headline">Add Milling</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-form ref="form" @submit.prevent>
                <v-container grid-list-xl fluid>
                  <v-layout wrap>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="editedItemCon.code"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Code"
                      required
                      disabled
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="editedItemCon.grower_name"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Grower Name"
                      required
                      disabled
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="editedItemCon.no_of_bags"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Number Of Bags"
                      required
                      disabled
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="editedItemCon.no_of_pockets"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Number Of Pockets"
                      required
                      disabled
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="editedItemCon.start_weight"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Start Weight (KG)"
                      required
                      disabled
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="editedItemCon.end_weight"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="End Weight (KG)"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12>
                      <v-text-field
                      v-model="editedItemCon.remarks"
                      color="blue"
                      multi-line
                      >
                      <div slot="label">
                        Remark 
                      </div>
                    </v-text-field>
                  </v-flex>
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
  props: ['openEditRequest', 'editedItemCon'],
  components: {
  },
  data() {
    const defaultForm = Object.freeze({
      remarks: '',
      no_of_pockets: '',
      no_of_bags: '',
      grower_name: '',
      code: '',
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
      axios.patch(`/millers/${this.editedItemCon.id}`, this.editedItemCon).
      then((response) => {
        this.loading=false
        console.log(response.data);
        // this.close;
        // this.resetForm();
        // this.$emit('closeRequest');
        this.$emit('alertRequest');
        Object.assign(this.$parent.AllMillers[this.$parent.editedIndex], this.$parent.editedItem)
        // this.$parent.AllMillers.push(response.data) 

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
 mounted() {
 }
}
</script>
