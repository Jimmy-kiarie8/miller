<template>
  <v-layout row justify-center>
    <v-dialog v-model="openAddRequest" persistent max-width="700px">
      <v-card>
        <v-card-title fixed>
          <span class="headline">Add Packaging Units</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-form ref="form" @submit.prevent>
                <v-container grid-list-xl fluid>
                  <v-layout wrap>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="form.title"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Units Title"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="form.abbreviation"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Abbreviation"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
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
      coffee: '',
      abbreviation: '',
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
      axios.post('/coffee', this.$data.form).
      then((response) => {
        this.loading=false
        console.log(response.data);
        // this.close;
        // this.resetForm();
        // this.$emit('closeRequest');
        this.$emit('alertRequest');
        this.$parent.AllUnits.push(response.data) 

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
         this.form.coffee &&
         this.form.abbreviation
       )
   },
 },
 mounted() {
 }
}
</script>
