<template>
<div>
	<v-content>
		<v-container fluid fill-height>
			<div v-show="loader" style="text-align: center; width: 100%; margin-top: 200px;">
				<v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
			</div>
			<v-layout justify-center align-center v-show="!loader">
				<v-layout row wrap>
					<!-- Buyers Reports -->
					<v-flex sm6>
						<h4 class="text-center">Clients Reports</h4>
						<v-card>
							<v-form ref="form" @submit.prevent>
							  	<v-container grid-list-xl fluid>
							    	<v-layout wrap>
								      <v-flex xs12 sm6>
							        	  <v-text-field
							        	  v-model="form.start_date"
							        	  color="blue darken-2"
								          type="date"
								          required
								      ></v-text-field>
                    				<small class="has-text-danger" v-if="errors.start_date">{{ errors.start_date[0] }}</small>
								      </v-flex>

								      <v-flex xs12 sm6>
							        	  <v-text-field
							        	  v-model="form.end_date"
							        	  color="blue darken-2"
								          type="date"
								          required
								      ></v-text-field>
                    				<small class="has-text-danger" v-if="errors.end_date">{{ errors.end_date[0] }}</small>
								      </v-flex>
								      <div class="form-group col-md-6">
								        <label for="password" class="col-md-12 col-form-label text-md-right">Select Client</label>
								        <div class="col-md-12">
								            <select class="custom-select" v-model="form.client">
								              <option value="0">All</option>
								              <option v-for="element in buyers" data-subtext="" :value="element.id">{{element.name}}</option>
								            </select>
								        </div>
								      </div>
								  </v-layout>
								</v-container>
								<v-card-actions>
								  <v-btn
								  :disabled="loading"
								  :loading="loading"
								  flat
								  color="primary"
								  @click="getBuyerReport"
								  >Submit</v-btn>
								</v-card-actions>
							</v-form>
						</v-card>
					</v-flex>
					<!-- Buyers Reports -->


					<!-- Derivery Reports -->
					<v-flex sm6>
						<h4 class="text-center">Delivery Reports</h4>
						<v-card>
							<v-form ref="form" @submit.prevent>
							  	<v-container grid-list-xl fluid>
							    	<v-layout wrap>
								      <v-flex xs12 sm6>
							        	  <v-text-field
							        	  v-model="derivery.derivery_start_date"
							        	  color="blue darken-2"
								          label="Title"
								          type="date"
								          required
								      ></v-text-field>
                    				<small class="has-text-danger" v-if="errors.derivery_start_date">{{ errors.derivery_start_date[0] }}</small>
								      </v-flex>

								      <v-flex xs12 sm6>
							        	  <v-text-field
							        	  v-model="derivery.derivery_end_date"
							        	  color="blue darken-2"
								          label="Title"
								          type="date"
								          required
								      ></v-text-field>
                    				<small class="has-text-danger" v-if="errors.derivery_end_date">{{ errors.derivery_end_date[0] }}</small>
								      </v-flex>
								      <div class="form-group col-md-6">
								        <label for="password" class="col-md-12 col-form-label text-md-right">Select Society</label>
								        <div class="col-md-12">
								            <select class="custom-select" v-model="derivery.society">
								              <option value="0">All</option>
								              <option v-for="element in Allsociety" data-subtext="" :value="element.id">{{element.name}}</option>
								            </select>
								        </div>
								      </div>
								  </v-layout>
								</v-container>
								<v-card-actions>
								  <v-btn
								  :disabled="Dloading"
								  :loading="Dloading"
								  flat
								  color="primary"
								  @click="getDeriveryReport"
								  >Submit</v-btn>
								</v-card-actions>
							</v-form>
						</v-card>
					</v-flex>
					<!-- Derivery Reports -->

				</v-layout>
			</v-layout>
		</v-container>
	</v-content>
<ShowReport 
	@closeRequest="close" 
	:openRequest="showReport" 
	:editedItemCon="editedItem" 
	:report="NewReport"
	:stateR="state"
	:AllBuyers="buyers"
></ShowReport>
</div>
</template>

<script>
let ShowReport = require('./ShowReport.vue')
export default {
props: ['user'],
components: {
	ShowReport  
}, 
data() {
	return{
		loader: false,
		loading: false,
		Dloading: false,
		state: '',
		showReport: false,
		form: {
			client: '0',
			start_date: '',
			end_date: '',
		},
		derivery: {
			society: '0',
			start_date: '',
			end_date: '',
		},
		Allsociety: {},
		buyers: {},
		NewReport: {},
		editedItem: {},
		errors: {},
		rules: {
			age: [
			val => val < 10 || `I don't believe you!`
			],
			name: [val => (val || '').length > 0 || 'This field is required']
		},
	}
},
methods: {  
	editItem(item) {
	this.editedItem = Object.assign({}, item)
	this.editedIndex = this.Allsociety.indexOf(item)
	// console.log(this.editedItem);
	this.showReport = true
},

// Buyers
getBuyerReport() {
	this.loading = true
	this.state="client"
	axios.post(`getBuyersReport/${this.form.client}`, this.form)
		.then((response) => {
		this.loading=false
		this.NewReport = response.data
		this.showReport = true
	})
	.catch((error) => {
		this.loading=false
		this.errors = error.response.data.errors
	})
},
// Buyers

// Derivery
getDeriveryReport() {
	this.Dloading = true
	this.state="derivery"
	axios.post(`getDerivery/${this.derivery.society}`, this.derivery)
		.then((response) => {
		this.Dloading=false
		this.NewReport = response.data
		this.showReport = true
	})
	.catch((error) => {
		this.Dloading=false
		this.errors = error.response.data.errors
	})
},
// Derivery
showAlert(){
	this.message = 'Successifully Added';
	this.snackbar = true;
	this.color = 'indigo';
},
close() {
	this.dispAdd= this.docsdialog2 = this.showReport = false
},

  // documents
},
mounted() {
	this.loader=true
	axios.post('getSociety')
		.then((response) => {
		this.Allsociety = response.data
	})
	.catch((error) => {
		this.errors = error.response.data.errors
	})


	axios.post('getBuyers')
		.then((response) => {
		this.loader=false
		this.buyers = response.data
	})
	.catch((error) => {
		this.loader=false
		this.errors = error.response.data.errors
	})
},
}
</script>
