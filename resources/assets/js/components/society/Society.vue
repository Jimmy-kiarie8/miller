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
         <v-btn color="primary" flat @click="openUser">Add Society</v-btn>
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
       :items="Allsociety"
       :search="search"
       hide-actions
       counter
       class="elevation-1"
       >
       <template slot="items" slot-scope="props">
        <td>
          {{ props.item.name }}
        </td>
        <td class="text-xs-right">{{ props.item.email }}</td>
        <td class="text-xs-right">{{ props.item.phone }}</td>
         <td class="text-xs-right">{{ props.item.location }}</td>
           <td class="text-xs-right">{{ props.item.status }}</td>
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
          <v-btn flat color="pink darken-2"  @click="deleteItem(props.item)">Delete</v-btn>
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
<AddSociety @closeRequest="close" :openAddRequest="dispAdd" @alertRequest="showAlert"></AddSociety>
<EditSociety @closeRequest="close" :openEditRequest="pdialog2" :editedItemCon="editedItem" @alertRequest="showAlert"></EditSociety>
<!-- <ShowUserProfile @closeRequest="close" :openProRequest="docsdialog2" :users="Allsociety" :docsPass="seeDocuments"></ShowUserProfile> -->
</div>
</template>

<script>
let AddSociety = require('./AddSociety.vue')
// let ShowUserProfile = require('./ShowUserProfile.vue')
let EditSociety = require('./EditSociety.vue')
export default {
  props: ['user', 'role'],
  components: {
    AddSociety, EditSociety
    // , ShowUserProfile
  }, 
  data() {
    return{
      rating: 4,
      headers: [
      { text: 'Name', align: 'left', value: 'name'},
      { text: 'email', value: 'email' },
      { text: 'Phone Number', value: 'phone' },
      { text: 'Location', value: 'location' },
    { text: 'Status', value: 'status' },
    { text: 'Actions', value: 'name', sortable: false }
    ],
    feedback: {},
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
    Allsociety: [],
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
    this.editedIndex = this.Allsociety.indexOf(item)
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
      axios.delete(`/users/${id}`)
      .then((response) => {
        this.Allsociety.splice(index, 1)
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
  axios.post('getSociety')
  .then((response) => {
    this.loader=false
    this.Allsociety = response.data
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