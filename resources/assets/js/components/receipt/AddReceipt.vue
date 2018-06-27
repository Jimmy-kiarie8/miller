<template>
  <v-layout row justify-center>
    <v-dialog v-model="openAddRequest" persistent max-width="900px">
      <v-card>
        <v-card-title fixed>
          <span class="headline">Add Receipt</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-form ref="form" @submit.prevent>
                <v-container grid-list-xl fluid>
                  <v-layout wrap>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="form.receipt_no"
                      color="blue darken-2"
                      label="Receipt Number"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="form.due_date"
                      color="blue darken-2"
                      label="Due Date"
                      type='date'
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="form.receipt_date"
                      color="blue darken-2"
                      label="Receipt Date"
                      type='date'
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <v-flex xs12 sm6>
                      <v-text-field
                      v-model="form.grand_total"
                      :rules="rules.name"
                      color="blue darken-2"
                      label="Grand Total"
                      required
                      ></v-text-field>
                      <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small> -->
                    </v-flex>
                    <div class="form-group col-md-6">
                      <label for="password" class="col-md-4 col-form-label text-md-right">Select buyers</label>
                      <div class="col-md-6">
                          <select class="custom-select" v-model="form.client">
                            <option v-for="element in buyers" data-subtext="" :value="element.id">{{element.name}}</option>
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
  props: ['openAddRequest', 'buyers', 'coffeeType', 'units'],
  components: {
  },
  data() {
    const defaultForm = Object.freeze({
      grand_total: '',
      receipt_no: '',
      receipt_date: '',
      due_date: '',
      client: '',
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
      axios.post('/receipt', this.$data.form).
      then((response) => {
        this.loading=false
        console.log(response);
        // this.close;
        // this.resetForm();
        // this.$emit('closeRequest');
        this.$emit('alertRequest');
        this.$parent.receipts.push(response.data) 

      })
      .catch((error) => {
        this.loading=false
        this.errors = error.response.data.errors
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
        this.form.grand_total &&
        this.form.receipt_no &&
        this.form.receipt_date &&
        this.form.client &&
        this.form.due_date
      )
   },
 },
 mounted() {
 }
}
</script>
