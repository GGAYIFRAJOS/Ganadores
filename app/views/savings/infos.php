<div class="frm_container">
<div class="frm_heading"><span>Loan Info</span></div>
<div class="frm_inputs">
	<table class="info_view">

		<tr>
			<td>Member ID Number:</td>
			<td><?php echo $info->id; ?></td>
		</tr>

		<tr>
			<td>Names:</td>
			<td><?php echo $info->names; ?></td>
		</tr>
		
		
		<tr>
			<td>Savings:</td>
			<td><a href="<?php echo base_url(); ?>savings/infos/"><?php echo $total_savings->amount_total; ?></a></td>
		</tr>
		<tr>
			<td>Balances:</td>
			<td><a href="<?php echo base_url(); ?>/balances/info"><?php echo $balances; ?></a></td>
		</tr>
		<tr>
			<td>Fines:</td>
			<td><a href="<?php echo base_url(); ?>fines/info"><?php echo $fines ?></a></td>
		</tr>
	</table>
</div>
</div>

<div class="clearFix"></div>
<div class="frm_container">
	<div class="frm_heading"><span>Last 10 Transactions</span></div>
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

