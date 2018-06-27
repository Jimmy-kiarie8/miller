<template>
	<div class="panel panel-default">

	    <div class="panel-heading">
	        <div class="clearfix">
	            <span class="panel-title">Invoices</span>
	            <a @click="invoiceAdd" class="btn btn-success pull-right">Create</a>
	        </div>
	    </div>
	    <div class="panel-body">
	        <table class="table table-striped"  v-if="invoices.length > 0">
	            <thead>
	                <tr>
	                    <th>Invoice No.</th>
	                    <th>Grand Total</th>
	                    <th>Client</th>
	                    <th>Invoice Date</th>
	                    <th>Due Date</th>
	                    <th colspan="2">Created At</th>
	                </tr>
	            </thead>
	            <tbody>
	                    <tr v-for="invoice in invoices">
	                        <td>{{invoice.invoice_no}}</td>
	                        <td>${{invoice.grand_total}}</td>
	                        <td>{{invoice.client}}</td>
	                        <td>{{invoice.invoice_date}}</td>
	                        <td>{{invoice.due_date}}</td>
	                        <td>{{invoice.created_at}}</td>
	                        <td class="text-right">
	                            <!-- <a href="{{route('invoices.show', $invoice)}}" class="btn btn-default btn-sm">View</a>
	                            <a href="{{route('invoices.edit', $invoice)}}" class="btn btn-primary btn-sm">Edit</a>
	                            <form class="form-inline" method="post"
	                                action="{{route('invoices.destroy', $invoice)}}"
	                                onsubmit="return confirm('Are you sure?')"
	                            >
	                                <input type="hidden" name="_method" value="delete">
	                                <input type="hidden" name="_token" value="{{csrf_token()}}">
	                                <input type="submit" value="Delete" class="btn btn-danger btn-sm">
	                            </form> -->
	                        </td>
	                    </tr>
	                @endforeach
	            </tbody>
	        </table>
	        <!-- {!! $invoices->render() !!} -->
	        <!-- @else -->
	            <div class="invoice-empty" v-if="invoices.length < 1">
	                <p class="invoice-empty-title">
	                    No Invoices were created.
	                    <!-- <a href="{{route('invoices.create')}}">Create Now!</a> -->
	                </p>
	            </div>
	        <!-- @endif -->
	    </div>
	<Add @closeRequest="close" :openAddRequest="dispAdd"></Add>

	</div>
</template>

<script>
let Add = require('./Add.vue');
export default{
	components: {
		Add
	},
	data() {
		return{
			isProcessing: false,
			form: {},
			dispAdd: false,
			errors: {},
			invoices: {},
		}
	},
	created: function () {
	  // Vue.set(this.$data, 'form', _form);
	},
	methods: {
		invoiceAdd(){
			this.dispAdd  = true
		},

		close() {
		  this.dispAdd = false
		},
	 /* addLine: function() {
	    this.form.products.push({name: '', price: 0, qty: 1});
	  },
	  remove: function(product) {
	    this.form.products.$remove(product);
	  },
	  create: function() {
	    this.isProcessing = true;
	    this.$http.post('/invoices', this.form)
	      .then(function(response) {
	        if(response.data.created) {
	          window.location = '/invoices/' + response.data.id;
	        } else {
	          this.isProcessing = false;
	        }
	      })
	      .catch(function(response) {
	        this.isProcessing = false;
	        Vue.set(this.$data, 'errors', response.data);
	      })
	  },
	  update: function() {
	    this.isProcessing = true;
	    this.$http.put('/invoices/' + this.form.id, this.form)
	      .then(function(response) {
	        if(response.data.updated) {
	          window.location = '/invoices/' + response.data.id;
	        } else {
	          this.isProcessing = false;
	        }
	      })
	      .catch(function(response) {
	        this.isProcessing = false;
	        Vue.set(this.$data, 'errors', response.data);
	      })
	  }*/
	},

	mounted() {
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
			this.invoices = response.data
		})
		.catch((error) => {
			this.errors = error.response.data.errors
		})
	},
	computed: {
	  subTotal: function() {
	    return this.form.products.reduce(function(carry, product) {
	      return carry + (parseFloat(product.qty) * parseFloat(product.price));
	    }, 0);
	  },
	  grandTotal: function() {
	    return this.subTotal - parseFloat(this.form.discount);
	  }
	}
}
</script>