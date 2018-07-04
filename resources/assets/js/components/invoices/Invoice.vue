<template>
<div>
	<v-content>
		<v-container fluid fill-height>
			<div v-show="loader" style="text-align: center; width: 100%; margin-top: 200px;">
				<v-progress-circular :width="3" indeterminate color="red" style="margin: 1rem"></v-progress-circular>
			</div>
			<v-layout justify-center align-center v-show="!loader">
				<div class="row">
					<div class="col-md-12">
						<!-- {{form.start_date}} and {{form.end_date}} -->
						<v-btn @click="invoiceAdd" flat color="primary">Add Invoice</v-btn>
						<!-- <v-flex xs12 sm4> -->
							<div class="row">
							<div class="col-md-4">
						    <v-text-field
						    v-model="form.start_date"
						    color="blue darken-2"
						    type="date"
						    required
						    ></v-text-field></div>
						<!-- </v-flex> -->
						<!-- <v-flex xs12 sm4 offset-sm1> -->
							<div class="col-md-4">
						    <v-text-field
						    v-model="form.end_date"
						    color="blue darken-2"
						    type="date"
						    required
						    ></v-text-field>
						</div>
						<!-- </v-flex> -->
						<!-- <v-flex sm3> -->
							<div class="col-md-4">
						   <v-btn color="primary" flat @click="sort">Sort</v-btn></div>
						</div>
						<!-- </v-flex> -->
					</div>

					<!-- <v-flex sm12> -->
					<div class="col-md-12 table-responsive">
					<table class="table table-hover table-striped">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Invoice Number</th>
								<th scope="col">Grand Total</th>
								<th scope="col">Client</th>
								<th scope="col">Due Date</th>
								<!-- <th scope="col">Created On</th> -->
								<th scope="col">Invoice Date</th>
								<th scope="col">#</th>
							</tr>
						</thead>
						<tbody>
							<tr 
							  v-for="invoice, key in invoices" 
							  :key="invoice.id"
							  v-if="invoice.created_at >= form.start_date || invoice.created_at >= form.end_date"
							>
								<td scope="row">{{key+1}}</td>
								<td>{{invoice.invoice_no}}</td>
								<td>{{invoice.grand_total}}</td>
								<td v-for="buyers in AllBuyers" v-if="invoice.client === buyers.client_id">{{buyers.name}}</td>
								<td>{{invoice.due_date}}</td>
								<!-- <td>{{invoice.created_at}}</td> -->
								<td>{{invoice.invoice_date}}</td>
								<td>
									<v-btn @click="invoiceEdit(invoice)" flat color="primary">Edit</v-btn>
									<v-btn @click="invoiceShow(invoice)" flat color="info">View</v-btn>
									<!-- <v-btn @click="invoicedel(key, invoice.id)" flat color="danger">Delete</v-btn> -->
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
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
	<AddInvoice @closeRequest="close" :openAddRequest="dispAdd" @alertRequest="showAlert" :buyers="AllBuyers"></AddInvoice>
	<EditInvoice @closeRequest="close" :openAddRequest="dispEdit" @alertRequest="showAlert" :buyers="AllBuyers" :invoiceData="editinvoice"></EditInvoice>
	<ShowInvoice @closeRequest="close" :openAddRequest="dispShow" @alertRequest="showAlert" :invoice="editinvoice"></ShowInvoice>
</div>
</template>

<script>
let AddInvoice = require('./AddInvoice');
let EditInvoice = require('./EditInvoice');
let ShowInvoice = require('./ShowInvoice');
export default{
	components: {
		AddInvoice, EditInvoice, ShowInvoice
	},
	data() {
		return{
			dispAdd: false,
			dispEdit: false,
			dispShow: false,
			loader: false,
			snackbar: false,
			timeout: 5000,
			color: '',
			message: '',
			Allusers: [],
			invoices: {},
			AllBuyers: {},
			editinvoice: {},
			form: {
				start_date: '',
				end_date: ''
			}
		}
	}, 
	methods: {
		sort() {
		     this.loader=true
		    axios.post('getInvoiceSort', this.form)
		    .then((response) => {
		     this.loader=false
		     this.invoices = response.data
		   })
		    .catch((error) => {
		     this.loader=false
		     this.errors = error.response.data.errors
		   })
		},
		invoiceEdit(invoice) {
			// console.log(invoice);
		  this.editinvoice = Object.assign({}, invoice)
		  this.editedIndex = this.invoices.indexOf(invoice)
		  // console.log(this.editedItem);
		  this.dispEdit = true
		},
		invoiceAdd(){
			this.dispAdd  = true
		},
		/*invoiceEdit(key){
      	this.$children[2].list = this.invoices[key]
			this.dispEdit  = true
		},*/
		invoiceShow(invoice){
			this.editinvoice = Object.assign({}, invoice)
		  this.editedIndex = this.invoices.indexOf(invoice)
		  // console.log(this.editedItem);
		  this.dispShow = true
      	// this.$children[3].list = this.invoices[key]
			this.dispShow  = true
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

		invoicedel(key, id) {
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
		  this.dispAdd= this.dispShow = this.dispEdit = false
		},
	},

	computed: {
		Start_dates () {
			return this.form.start_date;
		},
		end_dates () {
			return this.form.end_date;
		}
	},

	mounted() {
		this.loader=true
		axios.post('getUsers')
			.then((response) => {
			this.Allusers = response.data
		})
		.catch((error) => {
			this.errors = error.response.data.errors
		})

		axios.post('getBuyers')
			.then((response) => {
			this.AllBuyers = response.data
		})
		.catch((error) => {
			this.errors = error.response.data.errors
		})

		axios.post('getInvoice')
			.then((response) => {
			this.loader=false
			this.invoices = response.data
		})
		.catch((error) => {
			this.loader=false
			this.errors = error.response.data.errors
		})
	},
}
</script>