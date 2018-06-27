<template>
  <v-layout row justify-center>
    <v-dialog v-model="openAddRequest" persistent max-width="900px">
    	<div v-if="openAddRequest">
	<div class="row">
	    <div class="col-sm-4">
	        <div class="form-group">
	            <label>Invoice No.</label>
	            <input type="text" class="form-control" v-model="form.invoice_no">
	            <!-- <p v-if="errors.invoice_no" class="error">@{{errors.invoice_no[0]}}</p> -->
	        </div>
	        <div class="form-group">
	            <label>Client</label>
	            <input type="text" class="form-control" v-model="form.client">
	            <!-- <p v-if="errors.client" class="error">@{{errors.client[0]}}</p> -->
	        </div>
	    </div>
	    <div class="col-sm-4">
	        <div class="form-group">
	            <label>Client Address</label>
	            <textarea class="form-control" v-model="form.client_address"></textarea>
	            <!-- <p v-if="errors.client_address" class="error">@{{errors.client_address[0]}}</p> -->
	        </div>
	    </div>
	    <div class="col-sm-4">
	        <div class="form-group">
	            <label>Title</label>
	            <input type="text" class="form-control" v-model="form.title">
	            <!-- <p v-if="errors.title" class="error">@{{errors.title[0]}}</p> -->
	        </div>
	        <div class="row">
	            <div class="col-sm-6">
	                <label>Invoice Date</label>
	                <input type="date" class="form-control" v-model="form.invoice_date">
	                <!-- <p v-if="errors.invoice_date" class="error">@{{errors.invoice_date[0]}}</p> -->
	            </div>
	            <div class="col-sm-6">
	                <label>Due Date</label>
	                <input type="date" class="form-control" v-model="form.due_date">
	                <!-- <p v-if="errors.due_date" class="error">@{{errors.due_date[0]}}</p> -->
	            </div>
	        </div>
	    </div>
	</div>
	<hr>
	<div v-if="errors.products_empty">
	    <!-- <p class="alert alert-danger">{{errors.products_empty[0]}}</p> -->
	    <hr>
	</div>
	<table class="table table-bordered table-form">
	    <thead>
	        <tr>
	            <th>Product Name</th>
	            <th>Price</th>
	            <th>Qty</th>
	            <th>Total</th>
	        </tr>
	    </thead>
	    <tbody>
	        <tr v-for="product in form.products">
	            <td class="table-name">
	                <textarea class="table-control" v-model="product.name"></textarea>
	            </td>
	            <td class="table-price">
	                <input type="text" class="table-control"  v-model="product.price">
	            </td>
	            <td class="table-qty">
	                <input type="text" class="table-control" v-model="product.qty">
	            </td>
	            <td class="table-total">
	                <span class="table-text">@{{product.qty * product.price}}</span>
	            </td>
	            <td class="table-remove">
	                <span @click="remove(product)" class="table-remove-btn">&times;</span>
	            </td>
	        </tr>
	    </tbody>
	    <tfoot>
	        <tr>
	            <td class="table-empty" colspan="2">
	                <span @click="addLine" class="table-add_line">Add Line</span>
	            </td>
	            <td class="table-label">Sub Total</td>
	            <td class="table-amount">@{{subTotal}}</td>
	        </tr>
	        <tr>
	            <td class="table-empty" colspan="2"></td>
	            <td class="table-label">Discount</td>
	            <td class="table-discount">
	                <input type="text" class="table-discount_input" v-model="form.discount">
	            </td>
	        </tr>
	        <tr>
	            <td class="table-empty" colspan="2"></td>
	            <td class="table-label">Grand Total</td>
	            <td class="table-amount">@{{grandTotal}}</td>
	        </tr>
	    </tfoot>
	</table>
</div>
</v-dialog>
</v-layout>
</template>

<script>
export default{
	props: ['openAddRequest'],
	data() {
		return{
			errors: {},
			form: {
			    invoice_no: '',
			    client: '',
			    client_address: '',
			    title: '',
			    invoice_date: '',
			    due_date: '',
			    discount: 0,
			    products: [{
			        name: '',
			        price: 0,
			        qty: 1
				}],
			},
			isProcessing: false,
		}
	},
	methods: {
	  addLine: function() {
	    this.form.products.push({name: '', price: 0, qty: 1});
	  },
	  remove: function(product) {
	    this.form.products.$remove(product);
	  },
    close() {
      this.$emit('closeRequest')
    },
	 

	  create: function() {
	    this.isProcessing = true;
	    // this.$http.post('/invoices', this.form)
      	axios.post('/invoice', this.$data.form)
	      .then((response) => {
	        if(response.data.created) {
	          console.log(response);
	          window.location = '/invoices/' + response.data.id;
	          this.isProcessing = false;
	        } else {
	          this.isProcessing = false;
	        }
	          
	      })
	      .catch(function(response) {
	        this.isProcessing = false;
	        Vue.set(this.$data, 'errors', response.data);
	      })
	  },
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