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
              v-model="editedItemCon.name"
              :rules="rules.name"
              color="purple darken-2"
              label="Buyer name"
              required
              ></v-text-field>
              <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small>  -->
            </v-flex>
            <v-flex xs12 sm6>
              <v-text-field
              v-model="editedItemCon.email"
              :rules="emailRules"
              color="blue darken-2"
              label="Email"
              required
              ></v-text-field>
              <!-- <small class="has-text-danger" v-if="errors.email">{{ errors.email[0] }}</small> -->
            </v-flex>
            <v-flex xs12 sm6>
              <v-text-field
              v-model="editedItemCon.location"
              :rules="rules.name"
              color="blue darken-2"
              label="Location"
              required
              ></v-text-field>
              <!-- <small class="has-text-danger" v-if="errors.location">{{ errors.location[0] }}</small>  -->
            </v-flex>
          <v-flex xs12 sm6>
            <v-text-field
            v-model="editedItemCon.phone"
            :rules="rules.name"
            color="blue darken-2"
            label="Phone"
            required
            ></v-text-field>
            <!-- <small class="has-text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small> -->
          </v-flex>
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
  props: ['editedItemCon', 'openEditRequest'],
  data() {
    return{
      loader: false,
      loading:false,
      list: {},
      emailRules: [
        v => {
          return !!v || 'E-mail is required'
        },
        v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
      ],
      rules: {
        name: [val => (val || '').length > 0 || 'This field is required']
      },
    }
  },
  methods: {
    update() {
      this.loading=true
      axios.patch(`/buyers/${this.editedItemCon.id}`, this.editedItemCon)
      .then((response) => {
        // console.log(response);
            this.loading=false
            this.close;
            // this.resetForm();
            Object.assign(this.$parent.AllBuyers[this.$parent.editedIndex], this.$parent.editedItem)
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
