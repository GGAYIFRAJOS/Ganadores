<h2  style="text-align: center;"><u>MEMBER LOAN INFORMATION FOR <?php echo urldecode($names); ?></u></h2>



		<div class="frm_container">
<div class="frm_heading"><span>Member Info</span><a href="<?php echo base_url(); ?>members/refresh_info/<?php echo $id; ?>"><span class="button_cart">LOANS</span></a></div>
<div class="frm_inputs">

	<table class="tablesorter" cellspacing="1" >

		<tr>
			<td><b>Member ID Number:</b></td>
			<td><b><?php echo $id; ?></b></td>
		</tr>

		<tr>
			<td><b>Names:</b></td>
			<td><b><?php echo urldecode($names); ?></b></td>
		</tr>
		<tr>
			<td><b>Loan Date:</b></td>
			<td><b><?php echo $loan_date; ?></b></td>
		</tr>
		<tr>
			<td><b>Principal:</b></td>
			<td><b><?php echo $loan_amount; ?></b></td>
		</tr>
		<tr>
			<td><b>Interest:</b></td>
			<td><b><?php echo $loan_interest; ?>%</b></td>
		</tr>
		
	</table>
</div>
</div>


<h2  style="text-align: center;"><u>General Loan Info</u></h2>
<div class="manage_menu"><a href="<?php echo base_url(); ?>loans/get_loan_progress_member/<?php echo $id ?>/<?php echo $names ?>" style="margin-left: 12px;"><button class="btn-primary">PRINT LOAN INFORMATION<img src="<?php echo base_url(); ?>public/images/pdf.png" /></button></a></div>


	<table class="tablesorter" cellspacing="1">
		  <thead>
		    <tr>
		      <th>No</th>
		      <th>Member</th>
		      <th>Amount Paid </th>
		      <th>Balance</th>
		      <th>Due Date</th>
		      
		       	      
		    </tr>
		  </thead>
		  <tbody>
		  
		  <?php foreach ($loans as $loan) : ?>
		  	
		    <tr>  
		    <td style="width:20%;"><?php echo $loan->member_id; ?></td>
		    <td style="width:20%;"><?php echo $loan->names; ?></td>
		    <td style="width:20%;"><?php echo $loan->amount_paid; ?></td>
		     <td style="width:20%;"><?php echo $loan->balance; ?></td>
		     <td style="width:20%;"><?php echo $loan->due_date; ?></td>
		   
		   
		    
		    </tr>
		  <?php endforeach; ?>

		  </tbody>
		    
		  </tbody>
</table>


<div class="clearFix"></div>
<div class="frm_container">
	<h2  style="text-align: center;"><u>Loan Report</u></h2>
	<table class="tablesorter" cellspacing="1" >
		  <thead>
		    <tr>
		      
		      
		      <th>Transaction N<u>o</u></th>
		      <th>Period</th>
		      <th>Type</th>
		      <th>Amount Carried Forward</th>
		      <th>Fine</th>
		      <th>Interest</th>
		      <th>Total Owed</th>
		      <th>Amount_paid</th>
		      <th>Total Amount Paid</th>
		      <th>Balance</th>

		    </tr>
		  </thead>
		  <tbody>
		  <?php $i = 0; $range_dates = 0; $trans = 0; ?>
		  <?php foreach ($progress as $saving) : ?>
		  	
		    <?php if($range_dates != $saving->range_dates ): ?>
		    	<?php if($saving->fine == 0): ?>

				    <tr>
				   
				   
				    <td ><b><?php echo ++$trans; ?></b></td>
				     <td ><b><?php echo $saving->range_dates; ?></b></td>
				    <td ><b><?php echo 'loan payment'; ?></b></td>
				    <td ><b><?php echo $saving->amount_forward; ?></b></td>
				    <td ><b><?php echo $saving->fine; ?></b></td>
				    <td ><b><?php echo $saving->interest; ?></b></td>
				    <td><?php echo $saving->amount_forward + $saving->fine + $saving->interest; ?></td>
				    <td ><b><?php echo $saving->amount_paid; ?></b></td>
				    <td ><b><?php echo $saving->total_paid; ?></b></td>
				    <td ><b><?php echo $saving->balance; ?></b></td>
				    </tr>
		    	<?php else: ?>
		    		<tr>
				   
				    
				    <td ><b><?php echo ++$trans; ?></b></td>
				    <td ><b><?php echo $saving->range_dates; ?></b></td>
				    <td ><b><?php echo 'loan fine'; ?></b></td>
				    <td ><b><?php echo $saving->amount_forward; ?></b></td>
				    <td ><b><?php echo $saving->fine; ?></b></td>
				    <td ><b><?php echo $saving->interest; ?></b></td>
				    <td><?php echo $saving->amount_forward + $saving->fine + $saving->interest; ?></td>
				    <td ><b><?php echo $saving->amount_paid; ?></b></td>
				    <td ><b><?php echo $saving->total_paid; ?></b></td>
				    <td ><b><?php echo $saving->balance; ?></b></td>
				    </tr>
		    	<?php endif; ?>
		    <?php else: ?>
		    	<?php if($saving->fine == 0): ?>
				    <tr>
				   
				   
				    <td ><b><?php echo ++$trans; ?></b></td>
				     <td ><b><?php echo $saving->range_dates; ?></b></td>
				    <td ><b><?php echo 'loan payment'; ?></b></td>
				    <td ><b><?php echo $saving->amount_forward; ?></b></td>
				    <td ><b><?php echo $saving->fine; ?></b></td>
				    <td ><b><?php echo $saving->interest; ?></b></td>
				    <td><?php echo $saving->amount_forward + $saving->fine + $saving->interest; ?></td>
				    <td ><b><?php echo $saving->amount_paid; ?></b></td>
				    <td ><b><?php echo $saving->total_paid; ?></b></td>
				    <td ><b><?php echo $saving->balance; ?></b></td>
				    </tr>
		    	<?php else: ?>
		    		<tr>
				   
				    
				    <td ><b><?php echo ++$trans; ?></b></td>
				    <td ><b><?php echo $saving->range_dates; ?></b></td>
				    <td ><b><?php echo 'loan fine'; ?></b></td>
				    <td ><b><?php echo $saving->amount_forward; ?></b></td>
				    <td ><b><?php echo $saving->fine; ?></b></td>
				    <td ><b><?php echo $saving->interest; ?></b></td>
				    <td><?php echo $saving->amount_forward + $saving->fine + $saving->interest; ?></td>
				    <td ><b><?php echo $saving->amount_paid; ?></b></td>
				    <td ><b><?php echo $saving->total_paid; ?></b></td>
				    <td ><b><?php echo $saving->balance; ?></b></td>
				    </tr>
				<?php  endif; ?>
			<?php endif; ?>
			
			<?php $range_dates = $saving->range_dates; ?>

		  <?php endforeach; ?>

		  </tbody>
		    
		  </tbody>
</table>
</div>

<script type="text/javascript">
			$( '.button_cart' ).button({ icons: {primary:'ui-icon-refresh'} });
			$( '.button_cartx' ).button({ icons: {primary:'ui-icon-refresh'} });
		</script>
<script type="text/javascript">
                

                    $(document).ready(function(){
                        $(".button_cart").click(function(e){
                            if(!confirm('Are you sure you want to refresh this Member\'s loan info ?')){
                                e.preventDefault();
                                return false;
                            }
                            return true;
                        });
                    });

                    $(document).ready(function(){
                        $(".button_cartx").click(function(e){
                            if(!confirm('Are you sure you want to refresh this Member\'s savings info ?')){
                                e.preventDefault();
                                return false;
                            }
                            return true;
                        });
                    });
                
</script>
