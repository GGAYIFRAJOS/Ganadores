<div class="frm_container">
<div class="frm_heading"><span>Member Info</span></div>
<div class="frm_inputs">
<div class="manage_menu"><a href="<?php echo base_url(); ?>transactions/view_info_report/<?php echo $id ?>" style="margin-left: 12px;"><button class="btn-primary">PRINT MEMBER INFORMATION<img src="<?php echo base_url(); ?>public/images/pdf.png" /></button></a></div>
	<table class="tablesorter" cellspacing="1">

		<tr>
			<td><b>Member ID Number:</b></td>
			<td><b><?php echo $id; ?></b></td>
		</tr>

		<tr>
			<td><b>Names:</b></td>
			<td><b><?php echo $names; ?></b></td>
		</tr>
		
		
		<tr>
			<td><b><a href="<?php echo base_url(); ?>savings/show_savings_member/<?php echo $id; ?>/<?php echo $names; ?>">Savings:</b></a></td>
			<td><b><?php echo $total_savings->amount_total; ?></b></td>
		</tr>
		<tr>
			<td><b><a href="<?php echo base_url(); ?>balances/info/<?php echo $id; ?>">Remittance Balances:</b></a></td>
			<td>
					<b><?php echo $balances ?></b>&nbsp&nbsp<a href="<?php echo base_url(); ?>balances/pay_balances/<?php echo $id;?>/<?php echo $names;?>"><span class="button_cart1">PAY BALANCES</span></a>
				
			</td>
		
		</tr>
		<tr>
			<td><b><a href="<?php echo base_url(); ?>fines/info/<?php echo $id;?>">Fines:</b></a></td>
			<td><b><?php echo $fines ?></b>&nbsp&nbsp<a href="<?php echo base_url(); ?>fines/pay_fines/<?php echo $id;?>/<?php echo $names;?>"><span class="button_cart2">PAY FINES</span></a></td>
		</tr>
	</table>
</div>
</div>

<div class="clearFix"></div>
<div class="frm_container">
	<div class="frm_heading"><span>Annual Savings: <a href="<?php echo base_url(); ?>savings/add_savings_direct/<?php echo $id;?>/<?php echo $names;?>"><span class="button_cart3">ADD SAVINGS</span></a></span></div>
	<table class="tablesorter" cellspacing="1">
		  <thead>
		    <tr>
		      <th >No</th>
		      <th >Dates</th>
		      <th >Amount Due</th>
		      <th>Amount Paid</th>
		      <th>Balance</th>
		      <th>Status</th>

		    </tr>
		  </thead>
		  <tbody>
		  
		  <?php foreach ($savings as $saving) : ?>
		  	<?php if($ranges == $saving->saving_range): ?>
		    <tr style="background-color: green;">  
		    <td style="width:15%;background-color: green !important;"><b><?php echo $saving->saving_range; ?></b></td>
		    <td style="width:15%;background-color: green !important;"><b><?php echo $saving->range_dates; ?></b></td>
		    <td style="width:15%;background-color: green !important;"><b><?php echo 200000; ?></b></td>
		    <td style="width:15%;background-color: green !important;"><b><?php echo $saving->total_paid; ?></b></td>
		    <td style="width:15%;background-color: green !important;"><b><?php echo $saving->balance; ?></b></td>
		    <td style="width:15%;background-color: green !important;"><b><?php echo $saving->status; ?></b></td>
		    </tr>
		    <?php else: ?>
		    <tr>  
		    <td style="width:15%;"><b><?php echo $saving->saving_range; ?></b></td>
		    <td style="width:15%;"><b><?php echo $saving->range_dates; ?></b></td>
		    <td style="width:15%;"><b><?php echo 200000; ?></b></td>
		    <td style="width:15%;"><b><?php echo $saving->total_paid; ?></b></td>
		    <td style="width:15%;"><b><?php echo $saving->balance; ?></b></td>
		    <td style="width:15%;"><b><?php echo $saving->status; ?></b></td>
		    </tr>
			<?php endif; ?>
		  <?php endforeach; ?>

		  </tbody>
		    
		  </tbody>
</table>
</div>


<div class="clearFix"></div>

<H3 style="text-align:center;"><u>LOANS</u></H3>


	<table class="tablesorter" cellspacing="1">
		  <thead>
		    <tr>
		      <th >No</th>
		      <th >Amount Due </th>
		      <th >Amount Paid </th>
		      <th >Balance</th> 
		      <th >Due Date</th> 
		      		      
		    </tr>
		  </thead>
		  <tbody>
		  
		  <?php foreach ($loans as $loan) : ?>
		  	
		    <tr>  
		    <td style="width:20%;"><?php echo $loan->member_id; ?></td>
		    <td style="width:20%;"><?php echo $loan->balance; ?></td>
		    <td style="width:20%;"><?php echo $loan->total_amount; ?></td>
		     <td style="width:20%;"><?php echo $loan->balance; ?></td>
		    <td style="width:20%;"><?php echo $loan->due_date; ?></td>
		    
		    
		    </tr>
		  <?php endforeach; ?>

		  </tbody>
		    
		  </tbody>
</table>



<div class="clearFix"></div>

<H3>YEARLY REPORTS:</H3>




<?php 

$arr = array();
foreach ($years as $year) {
    $arr[] = date('Y',strtotime($year->date));
}
$unique_data  = array_unique($arr);
// now use foreach loop on unique data
?>

<?php foreach($unique_data as $val): ?> 

	<p><b>YEAR:&nbsp <a href="<?php echo base_url(); ?>transactions/view_transactions_time/<?php echo $val; ?>/<?php echo $id; ?>/<?php echo  $names; ?>"><?php echo $val; ?></a></b></p>

<?php endforeach; ?>


<div style='display:none'>
							<div class="frm_container" id="dialog-modal-pay">
				        		<div class="frm_heading"><span>Balance Payment Confirmation</span></div>
				        		<div class="frm_inputs">
				        			<?php echo validation_errors('<p class="text-error">'); ?>
									<?php echo form_open(base_url('balances/pay_balance/'.$id.'/'.$names)); ?>
									<p>
									<?php echo form_label('Amount:'); ?>
									<?php
									$data = array(
									              'name'        => 'amount',
									              'value'       => set_value('amount')
									            );
									?>
									<?php echo form_input($data); ?>
									</p>
									<!--Field: Password2-->
									<p>
									<?php echo form_label('Date:'); ?>
									<?php
									$data = array(
									              'name'        => 'date',
									              'value'       => set_value('date'),
									               'id' => 'dos'
									            );
									?>
									<?php echo form_input($data); ?>
									</p>

									<!--Submit Buttons-->
									<?php $data = array("value" => "Pay Balance",
									                    "name" => "submit",
									                    "class" => "btn btn-primary"); ?>
									<p>
									    <?php echo form_submit($data); ?>
									</p>
									<?php echo form_close(); ?>

								</div>
							</div>   
</div>

<div style='display:none'>
							<div class="frm_container" id="dialog-modal-pay-fine">
				        		<div class="frm_heading"><span>Fine Payment Confirmation</span></div>
				        		<div class="frm_inputs">
				        			<?php echo validation_errors('<p class="text-error">'); ?>
									<?php echo form_open(base_url('fines/pay_fines/'.$id.'/'.$names)); ?>
									<p>
									<?php echo form_label('Amount:'); ?>
									<?php
									$data = array(
									              'name'        => 'amount',
									              'value'       => set_value('amount')
									            );
									?>
									<?php echo form_input($data); ?>
									</p>
									<!--Field: Password2-->
									<p>
									<?php echo form_label('Date:'); ?>
									<?php
									$data = array(
									              'name'        => 'date',
									              'value'       => set_value('date'),
									               'id' => 'dos2'
									            );
									?>
									<?php echo form_input($data); ?>
									</p>

									<!--Submit Buttons-->
									<?php $data = array("value" => "Pay Fine",
									                    "name" => "submit",
									                    "class" => "btn btn-primary"); ?>
									<p>
									    <?php echo form_submit($data); ?>
									</p>
									<?php echo form_close(); ?>
								</div>
							</div>   
</div>

<div style='display:none'>
							<div class="frm_container" id="dialog-modal-pay-savings">
				        		<div class="frm_heading"><span>Savings Payment Confirmation</span></div>
				        		<div class="frm_inputs">
				        			
									<?php echo validation_errors('<p class="text-error">'); ?>
									 <?php echo form_open('savings/add_savings_direct/'.$id.'/'.urldecode($names)); ?>
									<!--Field: First Name-->


									<p>
									<?php echo form_label('Amount:'); ?>
									<?php
									$data = array(
									              'name'        => 'amount',
									              'value'       => set_value('amount')
									            );
									?>
									<?php echo form_input($data); ?>
									</p>

									<p>
									<?php echo form_label('Date:'); ?>
									<?php
									$data = array(
									              'name'        => 'date',
									              'value'       => set_value('date'),
									              'id' => 'dos3'
									            );
									?>
									<?php echo form_input($data); ?>
									</p>
									<!--Field: Password2-->

									<!--Submit Buttons-->
									<?php $data = array("value" => "Save",
									                    "name" => "submit",
									                    "class" => "btn btn-primary"); ?>
									<p>
									    <?php echo form_submit($data); ?>
									</p>
									<?php echo form_close(); ?>
								</div>
							</div>   
</div>

<script type="text/javascript">
			$( '.button_cart1' ).button({ icons: {primary:'ui-icon-cart'} });
			$( '.button_cart1').colorbox({width:'30%', inline:true, href:'#dialog-modal-pay'});
		</script>


<script type="text/javascript">
			$( '.button_cart2' ).button({ icons: {primary:'ui-icon-cart'} });
			$( '.button_cart2').colorbox({width:'30%', inline:true, href:'#dialog-modal-pay-fine'});
		</script>

<script type="text/javascript">
			$( '.button_cart3' ).button({ icons: {primary:'ui-icon-cart'} });
			$( '.button_cart3').colorbox({width:'30%', inline:true, href:'#dialog-modal-pay-savings'});
		</script>



<script type="text/javascript">
$(function() {
    $("#dos").datepicker();
});
</script>

<script type="text/javascript">
$(function() {
    $("#dos2").datepicker();
});
</script>

<script type="text/javascript">
$(function() {
    $("#dos3").datepicker();
});
</script>

