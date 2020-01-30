<div class="frm_container">

<?php if($this->session->flashdata('refreshed')) : ?>
   <?php echo '<p class="text-success">' .$this->session->flashdata('refreshed') . '</p>'; ?>
<?php endif; ?>

<div class="frm_heading"><span>Member Info <a href="<?php echo base_url(); ?>members/refresh_non_member_info/<?php echo $id; ?>"><span class="button_cart">REFRESH</span></a></td></span></a></div>

<div class="frm_inputs">
	<table class="tablesorter" cellspacing="1">

		<tr>
			<td><b>Non Member ID Number:</b></td>
			<td><?php echo $inform->non_member_id; ?></td>
		</tr>

		<tr>
			<td><b>Names:</b></td>
			<td><?php echo $inform->non_member; ?></td>
		</tr>
		
		
		<tr>
			<td><b>Loan Amount:</b></td>
			<td><?php echo $inform->amount; ?></a></td>
		</tr>
		<tr>
			<td><b>Loan Interest:</b></td>
			<td><?php echo $inform->interest; ?></a></td>
		</tr>
		<tr>
			<td><b>Interest Amount:</b></td>
			<td><?php echo $inform->interest_amount; ?></a></td>
		</tr>
		<tr>
			<td><b>Total Amount Paid:</b></td>
			<td><?php echo $inform->total_amount; ?></a></td>
		</tr>

		<tr>
			<td><b>Balance:</b></td>
			<td><?php echo $inform->balance; ?></a></td>
		</tr>
	</table>
</div>
</div>

<div class="manage_menu"><a href="<?php echo base_url(); ?>loans/get_loan_progress_non_member/<?php echo $inform->non_member_id ?>/<?php echo $inform->non_member ?>" style="margin-left: 12px;"><button class="btn-primary">PRINT LOAN INFORMATION<img src="<?php echo base_url(); ?>public/images/pdf.png" /></button></a></div>


<div class="clearFix"></div>
<div class="frm_container">
	<div class="frm_heading">Transactions</span></div>
	<table class="tablesorter" cellspacing="1">
	  <thead>
	    <tr>
	      <th scope="col">No</th>
	      <th scope="col">payment</th>
	      <th scope="col">Date</th>
	    </tr>
	  </thead>
	  <tbody>
	  <?php $i = 0; ?>
	  <?php foreach ($transactions as $transact) : ?>
	    
	    <tr>
	        
	     <td style="width: 33%;"><?php echo ++$i; ?></td>
	      <td style="width: 33%;"><?php echo $transact->payment; ?></td>
	      <td style="width: 33%;"><?php echo $transact->date;; ?></td>
	    </tr>
	    </tr>
	  <?php endforeach; ?>


	  </tbody>
    
</table>
</div>

<div class="clearFix"></div>

<?php 

$arr = array();
foreach ($years as $year) {
    $arr[] = date('Y',strtotime($year->date));
}
$unique_data  = array_unique($arr);
// now use foreach loop on unique data
?>

<?php foreach($unique_data as $val): ?> 

	<p><b>YEAR:&nbsp <a href="<?php echo base_url(); ?>transactions/view_non_mem_transactions_time/<?php echo $val; ?>/<?php echo $id; ?>/<?php echo  $names; ?>"><?php echo $val; ?></a></b></p>

<?php endforeach; ?>


<script type="text/javascript">
			$( '.button_cart' ).button({ icons: {primary:'ui-icon-refresh'} });
		</script>


<script type="text/javascript">
                

                    $(document).ready(function(){
                        $(".button_cart").click(function(e){
                            if(!confirm('Are you sure you want to refresh this Member\'s info ?')){
                                e.preventDefault();
                                return false;
                            }
                            return true;
                        });
                    });
                
</script>


