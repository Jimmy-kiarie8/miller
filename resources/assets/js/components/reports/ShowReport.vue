<template>
<v-layout row justify-center>
	<v-dialog v-model="openRequest" persistent max-width="900px">
		<v-card v-if="openRequest">
			<v-card-title fixed>
				<span class="headline">Reports</span>
			</v-card-title>
			<v-card-text>
				<v-container grid-list-md>
					<!-- Buyers Report -->
					<v-layout wrap v-if="stateR === 'client'">
						<!-- Invoices -->
						<h2 class="text-center">Invoices</h2>
						<table class="table table-hover table-striped table-responsive">
							<thead v-if="report.invoicesArr.length > 0">
								<tr>
									<th scope="col">#</th>
									<th scope="col">Client Id</th>
									<th scope="col">Invoice Number</th>
									<th scope="col">Grand Total</th>
									<th scope="col">Due Date</th>
									<th scope="col">Created On</th>
									<th scope="col">Invoice Date</th>
								</tr>
							</thead>
							<tbody v-if="report.invoicesArr.length > 0">
								<tr v-for="invoice, key in report.invoicesArr" :key="invoice.id">
									<th scope="row">{{key+1}}</th>
									<td>{{invoice.client}}</td>
									<td>{{invoice.invoice_no}}</td>
									<td>{{invoice.grand_total}}</td>
									<td>{{invoice.due_date}}</td>
									<td>{{invoice.created_at}}</td>
									<td>{{invoice.invoice_date}}</td>
								</tr>
							</tbody>
							<thead v-else class="text-center">
								No Invoices
							</thead>
						</table>	
						<!-- Invoices -->

						<!-- Receipts -->
						<h2 class="text-center">Receipts</h2>
						<table class="table table-hover table-striped table-responsive">
							<thead v-if="report.receiptsArr.length > 0">
								<tr>
									<th scope="col">#</th>
									<th scope="col">Client</th>
									<th scope="col">Receipt Number</th>
									<th scope="col">Grand Total</th>
									<th scope="col">Due Date</th>
									<th scope="col">Created On</th>
									<th scope="col">Receipt Date</th>
								</tr>
							</thead>
							<tbody v-if="report.receiptsArr.length > 0">
								<tr v-for="receipt, key in report.receiptsArr" :key="receipt.id">
									<th scope="row">{{key+1}}</th>
									<td>{{receipt.client_id}}</td>
									<td>{{receipt.receipt_no}}</td>
									<td>{{receipt.grand_total}}</td>
									<td>{{receipt.due_date}}</td>
									<td>{{receipt.created_at}}</td>
									<td>{{receipt.invoice_date}}</td>
								</tr>
							</tbody>
							<thead v-else class="text-center">
								No Invoices
							</thead>

							<tfoot>
							    <tr>
							        <td class="table-empty" colspan="2"></td>
							        <td class="table-label">Balance</td>
							        <td class="table-amount">{{report.balance}}</td>
							    </tr>
							</tfoot>
						</table>						
						<!-- Receipts -->
					</v-layout>
					<!-- Buyers Report -->



					<!-- Derivery Report -->
					<v-layout wrap v-if="stateR === 'derivery'">
						<!-- Invoices -->
						<h2 class="text-center">Invoices</h2>
						<table class="table table-hover table-striped table-responsive">
							<thead v-if="report.length > 0">
								<tr>
									<th scope="col">#</th>
									<th scope="col">Grower Name</th>
									<th scope="col">Clerks Name</th>
									<th scope="col">Society Name</th>
									<th scope="col">Grower Representative</th>
									<th scope="col">Pammit Number</th>
									<th scope="col">Code</th>
									<th scope="col">Weight</th>
									<th scope="col">Units</th>
									<th scope="col">Number Of Bags</th>
									<th scope="col">Coffee Type</th>
									<th scope="col">vehicle Regestration</th>
									<th scope="col">Weighing Bridge</th>
									<th scope="col">Invoice Date</th>
								</tr>
							</thead>
							<tbody v-if="report.length > 0">
								<tr v-for="derivery, key in report" :key="derivery.id">
									<th scope="row">{{key+1}}</th>
									<td>{{derivery.grower_name}}</td>
									<td>{{derivery.clerks_name}}</td>
									<td>{{derivery.society}}</td>
									<td>{{derivery.grower_rep}}</td>
									<td>{{derivery.pamm_no}}</td>
									<td>{{derivery.code}}</td>
									<td>{{derivery.weight}}</td>
									<td>{{derivery.units}}</td>
									<td>{{derivery.no_of_bags}}</td>
									<td>{{derivery.coffee_type}}</td>
									<td>{{derivery.vihicle_reg}}</td>
									<td>{{derivery.weighing_bridge}}</td>
									<td>{{derivery.invoice_date}}</td>
								</tr>
							</tbody>
							<thead v-else class="text-center">
								No Deriveries
							</thead>
						</table>	
						<!-- Invoices -->
					</v-layout>
					<!-- Derivery Report -->
				</v-container>
			</v-card-text>
			<v-card-actions>
				<v-btn @click="close" flat color="primary">Close</v-btn>
			</v-card-actions>
		</v-card>
	</v-dialog>
</v-layout>
</template>

<script>
export default{
	props: ['openRequest', 'report', 'stateR'],
	data() {
		return{

		}
	}, 
	methods: {
    close() {
      this.$emit('closeRequest')
    },
	},

	mounted() {
	},
}
</script>