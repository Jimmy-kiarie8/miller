<template>
 <div>
  <v-content>
   <v-container fluid fill-height>
    <div v-show="loader" style="text-align: center; width: 100%; margin-top: 200px;">
      <v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
    </div>
    <v-layout justify-center align-center v-show="!loader">
     <div class="container">
       <!-- users display -->
       <div>
        <v-card-title>
         <v-btn color="primary" flat @click="openUser">Add Milling</v-btn>
         <v-spacer></v-spacer>
         <v-text-field
         v-model="search"
         append-icon="search"
         label="Search"
         single-line
         hide-details
         ></v-text-field>
       </v-card-title>
       <v-data-table
       :headers="headers"
       :items="AllMillers"
       :search="search"
       hide-actions
       counter
       class="elevation-1"
       >
       <template slot="items" slot-scope="props">
        <td>
          {{ props.item.code }}
        </td>
        <td class="text-xs-right">{{ props.item.grower_name }}</td>
        <td class="text-xs-right">{{ props.item.remarks }}</td>
        <td class="text-xs-right">{{ props.item.no_of_bags }}</td>
        <td class="text-xs-right">{{ props.item.no_of_pockets }}</td>
        <td class="text-xs-right">{{ props.item.created_at }}</td>
           <td class="justify-center layout px-0">
             <!-- <v-btn icon class="mx-0" @click="editItem(props.item)">
              <v-icon color="blue darken-2">edit</v-icon>
            </v-btn>
          <v-btn icon class="mx-0" @click="deleteItem(props.item)">
            <v-icon color="pink darken-2">delete</v-icon>
          </v-btn>
         <v-btn icon class="mx-0" @click="seeDocs(props.item)">
            <v-icon color="blue darken-2">visibility</v-icon>
          </v-btn> -->
          <v-btn flat color="blue darken-2" @click="editItem(props.item)">Edit</v-btn>
          <!-- <v-btn flat color="pink darken-2"  @click="deleteItem(props.item)">Delete</v-btn> -->
          <!-- <v-btn></v-btn> -->
          
        </td> 
      </template>
      <v-alert slot="no-results" :value="true" color="error" icon="warning">
       Your search for "{{ search }}" found no results.
     </v-alert>
     <template slot="pageText" slot-scope="{ pageStart, pageStop }">
       From {{ pageStart }} to {{ pageStop }}
     </template>
   </v-data-table>
 </div>
</div>
<!-- Data table -->
</v-layout>
</v-container>
<v-snackbar
:timeout="timeout"
bottom
:color="color"
left
v-model="snackbar"
>
{{ message }}
<!-- <v-icon dark right>check_circle</v-icon> -->
<v-btn>close</v-btn>
</v-snackbar>
</v-content>
<AddMiller @closeRequest="close" :openAddRequest="dispAdd" @alertRequest="showAlert"></AddMiller>
<EditMiller @closeRequest="close" :openEditRequest="pdialog2" @alertRequest="showAlert" :editedItemCon="editedItem"></EditMiller>
<!-- <ShowMiller @closeRequest="close" :openProRequest="docsdialog2" :users="AllMillers" :docsPass="seeDocuments"></ShowMiller> -->
</div>
</template>

<script>
let AddMiller = require('./AddMiller.vue')
// let ShowMiller = require('./ShowMiller.vue')
let EditMiller = require('./EditMiller.vue')
export default {
  props: ['user', 'role'],
  components: {
    AddMiller, EditMiller
    // , ShowMiller
  }, 
  data() {
    return{
      headers: [
      { text: 'Code', align: 'left', value: 'code'},
      { text: 'Grower Name', value: 'grower_name' },
      { text: 'Remarks', value: 'remarks' },
      { text: 'Number Of Porkets', value: 'no_of_pockets' },
      { text: 'Number Of Bags', value: 'no_of_bags' },
      { text: 'Date and Time', value: 'created_at' },
    { text: 'Actions', value: 'name', sortable: false }
    ],
    search: '',
    loader: false,
    loading: false,
    dispAdd: false,
    docsdialog2: false,
    pdialog2: false,
    snackbar: false,
    timeout: 5000,
    color: '',
    message: '',
    AllMillers: [],
    editedItem: {},
    emailRules: [
    v => {
      return !!v || 'E-mail is required'
    },
    v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
    ],
    rules: {
      age: [
      val => val < 10 || `I don't believe you!`
      ],
      name: [val => (val || '').length > 0 || 'This field is required']
    },
  }
},
methods: {  
  openUser(){
    this.dispAdd  = true
  },
  editItem(item) {
    this.editedItem = Object.assign({}, item)
    this.editedIndex = this.AllMillers.indexOf(item)
    // console.log(this.editedItem);
    this.pdialog2 = true
  },

  showAlert(){
    this.message = 'Successifully Added';
    this.snackbar = true;
    this.color = 'indigo';
  },
  del(key, id) {
    if (confirm('Are you sure you want to delete this item?')) {
      this.loader = true
      axios.delete(`/millers/${id}`)
      .then((response) => {
        this.AllMillers.splice(index, 1)
        this.loader = false
        this.message = 'deleted successifully'
        this.color = 'red'
        this.snackbar = true
      })
      .catch((error) => {
        this.errors = error.response.data.errors
        this.loader = false
        this.message = 'something went wrong'
        this.color = 'red'
        this.snackbar = true
      })
    }
  },
  close() {
    this.dispAdd= this.docsdialog2 = this.pdialog2 = false
  },

  // documents
},
mounted() {
  this.loader=true
  axios.post('getMiller')
  .then((response) => {
    this.loader=false
    this.AllMillers = response.data
  })
  .catch((error) => {
    this.loader=false
    this.errors = error.response.data.errors
  })
},
 /*beforeRouteEnter(to, from, next) {
   next(vm => {
    if (vm.role === 'Admin' || vm.role === 'companyAdmin') {
      next(); 
    } else {
      next('/');
    }
  })
}*/
}
</script>


<style scoped>
.content--wrap{
 margin-top: -100px
}
#profile { 
 width: 70px;
 height: 60px;
 border-radius: 50%;
 margin-left: 80px;
 margin-top: -30px;
}
i{
 padding: 7px;
 background: #f0f0f0;
 border-radius: 50%;
}
.list-group-item:hover, .list-group-item:focus {
 z-index: 1;
 background: #f9f9f9;
 text-decoration: none;
}
</style>