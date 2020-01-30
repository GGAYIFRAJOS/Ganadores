<div class="frm_container">
<div class="frm_heading"><span>Loan Info</span></div>
<div class="frm_inputs">
	<table class="info_view">

		<tr>
			<td>Non Member ID Number:</td>
			<td><?php echo $inform->non_member_id; ?></td>
		</tr>

		<tr>
			<td>Names:</td>
			<td><b><?php echo $inform->non_member; ?></b></td>
		</tr>
		
		
		<tr>
			<td>Loan Amount:</td>
			<td><?php echo $info->amount; ?></a></td>
		</tr>
		<tr>
			<td>Loan Interest:</td>
			<td><?php echo $info->interest; ?></a></td>
		</tr>
		<tr>
			<td>Interest Amount:</td>
			<td><?php echo $info->interest_amount; ?></a></td>
		</tr>
		<tr>
			<td>Total Amount Paid:</td>
			<td><?php echo $info->total_amount; ?></a></td>
		</tr>

		<tr>
			<td>Balance:</td>
			<td><?php echo $info->balance; ?></a></td>
		</tr>
	</table>
</div>
</div>

<div class="clearFix"></div>
<div class="frm_container">
	<div class="frm_heading">Transactions</span></div>
	<div class="frm_inputs">
	
		<table class="info_view">

			<tr>
				<td>No:</td>
				<td><?php echo $payment->status; ?></td>
			</tr>

			<tr>
				<td>Date</td>
				<td><?php echo $payment->payment_number; ?></td>
			</tr>

			<tr>
				<td>Amount</td>
				<td><?php echo $this->config->item('currency_symbol') . $payment->amount; ?></td>
			</tr>
			<tr>
				<td>Balance:</td>
				<td><?php echo $payment->payment_sched; ?></td>
			</tr>
			
		</table>
	</div>
</div>

<div class="clearFix"></div>

