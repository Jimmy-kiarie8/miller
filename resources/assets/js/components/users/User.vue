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
         <v-btn color="primary" flat @click="openUser">Add User</v-btn>
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
       :items="Allusers"
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
        <td class="text-xs-right">{{ props.item.id_no }}</td>
        <td class="text-xs-right">{{ props.item.phone }}</td>
         <td class="text-xs-right">{{ props.item.location }}</td>
         <!--   <td class="text-xs-right">{{ props.item.current_status }}</td> -->
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
<AddUser @closeRequest="close" :openAddRequest="dispAdd" @alertRequest="showAlert"></AddUser>
<EditUser @closeRequest="close" :openEditRequest="pdialog2" @alertRequest="showAlert" :editedItemCon="editedItem"></EditUser>
<!-- <ShowUserProfile @closeRequest="close" :openProRequest="docsdialog2" :users="Allusers" :docsPass="seeDocuments"></ShowUserProfile> -->
</div>
</template>

<script>
let AddUser = require('./AddUser.vue')
// let ShowUserProfile = require('./ShowUserProfile.vue')
let EditUser = require('./EditUser.vue')
export default {
  props: ['user', 'role'],
  components: {
    AddUser, EditUser
    // , ShowUserProfile
  }, 
  data() {
    return{
      rating: 4,
      headers: [
      { text: 'Name', align: 'left', value: 'name'},
      { text: 'email', value: 'email' },
      { text: 'Id Number', value: 'id_no' },
      { text: 'Phone Number', value: 'phone' },
      { text: 'Location', value: 'location' },
    // { text: 'Location', value: 'location' },
    // { text: 'Current Status', value: 'current_status' },
    { text: 'Status', value: 'status' },
    { text: 'Actions', value: 'name', sortable: false }
    ],
    feedback: {},
    search: '',
    e1: true,
    loader: false,
    loading: false,
    dispAdd: false,
    docsdialog2: false,
    pdialog2: false,
    snackbar: false,
    commdialog2: false,
    pdialog: false,
    timeout: 5000,
    color: '',
    message: '',
    Allusers: [],
    docNo: {},
    Alldocs: [],
    editedItem: {},
    seeDocuments: {},
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
    this.editedIndex = this.Allusers.indexOf(item)
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
        this.Allusers.splice(index, 1)
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

  // Ratings && Comments
  commdialog() {
    this.loading = true
    axios.post(`/comments/${this.feedback.id}`, this.feedback)
    .then((response) => {
        this.loading = false
        this.message = 'Commented'
        this.color = 'indigo'
        this.snackbar = true
    })
      .catch((error) => {
        this.loading = false
        this.errors = error.response.data.errors
        this.message = 'something went wrong'
        this.color = 'red'
        this.snackbar = true
      })
  },
  ratingMec(item) {
    this.feedback = Object.assign({}, item)
    this.editedIndex = this.Allusers.indexOf(item)
    // console.log(this.editedItem);
    this.commdialog2 = true
  },

  // documents
},
mounted() {
  this.loader=true
  axios.post('getUsers')
  .then((response) => {
    this.loader=false
    this.Allusers = response.data
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