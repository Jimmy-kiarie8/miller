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
              <v-flex xs12 sm12>
                <v-text-field
                v-model="editedItemCon.type"
                :rules="rules.name"
                color="purple darken-2"
                label="Coffee Type"
                required
                ></v-text-field>
                <!-- <small class="has-text-danger" v-if="errors.name">{{ errors.name[0] }}</small>  -->
              </v-flex>
              <v-flex xs12>
                <v-text-field
                v-model="editedItemCon.description"
                color="blue"
                multi-line
                >
                <div slot="label">
                  Description 
                </div>
              </v-text-field>
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
      rules: {
        name: [val => (val || '').length > 0 || 'This field is required']
      },
    }
  },
  methods: {
    update() {
      this.loading=true
      axios.patch(`/millers/${this.editedItemCon.id}`, this.editedItemCon)
      .then((response) => {
        // console.log(response);
        this.loading=false
        this.close;
            // this.resetForm();
            Object.assign(this.$parent.AllMillers[this.$parent.editedIndex], this.$parent.editedItem)
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
