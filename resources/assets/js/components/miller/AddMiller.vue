<template>
  <v-layout row justify-center>
    <v-dialog v-model="openAddRequest" persistent max-width="700px">
      <v-card>
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
                      v-model="form.code"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Code"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
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
                      v-model="form.no_of_bags"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Number Of Bags"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="form.no_of_pockets"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Number Of Pockets"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="form.start_weight"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Weight (KG)"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12>
                      <v-text-field
                      v-model="form.remarks"
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
  props: ['openAddRequest'],
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
      axios.post('/millers', this.$data.form).
      then((response) => {
        this.loading=false
        console.log(response.data);
        // this.close;
        // this.resetForm();
        // this.$emit('closeRequest');
        this.$emit('alertRequest');
        this.$parent.AllMillers.push(response.data) 

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
         this.form.remarks &&
         this.form.no_of_pockets &&
         this.form.no_of_bags &&
         this.form.grower_name &&
         this.form.code 
       )
   },
 },
 mounted() {
 }
}
</script>
