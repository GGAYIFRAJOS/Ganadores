<!--Display Messages-->
<?php if($this->session->flashdata('registered')) : ?>
    <?php echo '<p class="text-success">' .$this->session->flashdata('registered') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('logged_out')) : ?>
    <?php echo '<p class="text-success">' .$this->session->flashdata('logged_out') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('need_login')) : ?>
    <?php echo '<p class="text-error">' .$this->session->flashdata('need_login') . '</p>'; ?>
<?php endif; ?>
<h1><u>Ganadores Investment Club</u></h1>
<h3>Loans and Savings Management System</h3>


<p>This app us a dynamic application designed to help Ganadores Investment Club manage  day to day savings and Loans Transactions.</p>

<br>
<br>
<h2 style="text-align: center;">GENERAL INFORMATION</h2>

<h4><u>Member Info</u></h4>
<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Names</th>
      <th scope="col">Savings</th>
      <th scope="col">Loan Amount Due</th>
      <th scope="col">Loan Amount Paid</th>
      <th scope="col">Balances</th>
      <th scope="col">Fines</th>
      <?php if($this->session->userdata('user_role') == 'admin'): ?>
      <th scope="col" >Edit</th>
      <th scope="col">Delete</th>
      <?php else: ?>
        <?php echo ""; ?>
      <?php endif; ?>
    </tr>
  </thead>
  <tbody>
  <?php $i = 0; ?>
  <?php $total_loans = 0;$total_payments = 0; $total_savings = 0; $total_balances = 0; $total_fines = 0; ?>
  <?php foreach ($members as $member) : ?>
    
    <tr>
        
     <td><?php echo $member->member_id; ?></td>
      <td><a href="<?php echo base_url(); ?>members/get_member_info/<?php echo $member->member_id; ?>"><?php echo $member->names; ?></a></td>
      <td><?php echo $member->amount_total; ?><?php  $total_savings += $member->amount_total; ?></td>
      <td><?php echo $member->balance; ?><?php  $total_loans += $member->balance; ?></td>
      <td><?php echo $member->total_amount; ?><?php  $total_payments += $member->total_amount; ?></td>
      <td><?php echo $member->total_balances; ?><?php $total_balances += $member->total_balances; ?></td>
      <td><?php echo $member->total_fines; ?><?php $total_fines += $member->total_fines; ?></td>
      <?php if($this->session->userdata('user_role') == 'admin'): ?>
      <td><a href="<?php echo base_url(); ?>members/edit_member/<?php echo $member->member_id ?>/<?php echo $member->names; ?>" style="margin-left: 12px;"><img src="<?php echo base_url(); ?>public/images/document_edit.png" /></td>
      <td><a href="<?php echo base_url(); ?>members/delete_member/<?php echo $member->member_id ?>" style="margin-left: 12px;"><span class="btn-delete"><img src="<?php echo base_url(); ?>public/images/document_delete.png" /></span></td>
    <?php else: ?>
    <?php echo ""; ?>
      <?php endif; ?>
    </tr>
    </tr>
  <?php endforeach; ?>

  </tbody>

  <tfoot>
    <tr>
        <td><b>TOTAL</b></td>
        <td></td>
        <td><b><?php echo $total_savings; ?></b></td>

        <td><b><?php echo $total_loans; ?></b></td>
        <td><b><?php echo $total_payments; ?></td>
        <td><?php echo $total_balances; ?></td>
        <td><?php echo $total_fines; ?></td>
        <?php if($this->session->userdata('user_role') == 'admin'): ?>
        <td></td>
        <td></td>
        <?php else: ?>
        <?php echo ""; ?>
      <?php endif; ?>
    </tr>
    </tr>
</tfoot>
</table>

<h4><u>Non Member Info</u></h4>
<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Names</th>
      <th scope="col">Loan Amount Due</th>
      <th scope="col">Loan Amount Paid</th>
      <th scope="col">Loan Amount Balance</th>
      <?php if($this->session->userdata('user_role') == 'admin'): ?>
      <th scope="col">Edit</th>
      <th scope="col">Delete</th>
      <?php else: ?>
        <?php echo ""; ?>
      <?php endif; ?>
    </tr>
  </thead>
  <tbody>
    <?php $total_loans2 = 0;$total_payments2 = 0; $total_loans3 = 0 ?>
  <?php foreach ($non_members as $member) : ?>
    
    <tr>
        
     <td><?php echo $member->non_member_id; ?></td>
      <td><a href="<?php echo base_url(); ?>members/get_non_member_inform/<?php echo $member->non_member_id; ?>/<?php echo $member->non_member; ?>"><?php echo $member->non_member; ?></a></td>
      <td><?php echo $member->bamount; ?><?php $total_loans3 += $member->amount; ?></td>
      <td><?php echo $member->total_amount; ?><?php $total_payments2 += $member->total_amount; ?></td>
      <td><?php echo $member->balance; ?><?php $total_loans2 += $member->balance; ?></td>
      <?php if($this->session->userdata('user_role') == 'admin'): ?>
      <td><a href="#" style="margin-left: 12px;"><img src="<?php echo base_url(); ?>public/images/document_edit.png" /></td>
      <td><a href="#" style="margin-left: 12px;"><img src="<?php echo base_url(); ?>public/images/document_delete.png" /></td>
        <?php else: ?>
        <?php echo ""; ?>
      <?php endif; ?>
    </tr>
    </tr>
  <?php endforeach; ?>


  </tbody>
  <tfoot>
    <tr>
        <td><b>TOTAL</b></td>
        <td></td>
        <td><b><?php echo $total_loans2; ?></b></td>

        <td><b><?php echo $total_payments2; ?></b></td>
        <td><b><?php echo $total_loans3; ?></b></td>

        <?php if($this->session->userdata('user_role') == 'admin'): ?>
        <td></td>
        <td></td>
        <?php else: ?>
        <?php echo ""; ?>
      <?php endif; ?>
    </tr>
</tfoot>
    
</table>
</table>

<?php $total_cash_balance =  ($total_savings +  $total_payments +$total_payments2);?>
<P><b>TOTAL CASH  = <?php echo  number_format($total_cash_balance, 0, '.', ','); ?></b></P>
<br>
<?php $total_loan_sum = $total_loans + $total_loans2; ?>
<P><b>TOTAL AMOUNT DUE = <?php echo  number_format($total_loan_sum, 0, '.', ','); ?></b></P>
<br>
<p><b>TOTAL BALANCES: <?php echo $balances; ?></b></p>
<br>
<p><b>TOTAL FINES: <?php echo $fines; ?></b></p>

<div class="clearFix"></div>


<div class="clearFix"></div>

<H4 style="color:white; background-color: black; text-align: center;"><u>ANNUAL REPORTS FOR MEMBERS:</u></H4>


<?php 

$arr = array();
foreach ($years_mem as $year) {
    $arr[] = date('Y',strtotime($year->date));
}
$unique_data  = array_unique($arr);
// now use foreach loop on unique data
?>

<?php foreach($unique_data as $val): ?> 

    <p><b>YEAR:&nbsp <a href="<?php echo base_url(); ?>transactions/view_transactions_times/<?php echo $val; ?>"><?php echo $val; ?></a></b></p>

<?php endforeach; ?>



<H4 style="color:white; background-color: black; text-align: center;"><u>ANNUAL REPORTS FOR NON-MEMBERS:</u></H4>


<?php 

$arr = array();
foreach ($years_non_mem as $year) {
    $arr[] = date('Y',strtotime($year->date));
}
$unique_data  = array_unique($arr);
// now use foreach loop on unique data
?>

<?php foreach($unique_data as $val): ?> 

    <p><b>YEAR:&nbsp <a href="<?php echo base_url(); ?>transactions/view_non_transactions_times/<?php echo $val; ?>"><?php echo $val; ?></a></b></p>

<?php endforeach; ?>

<div style='display:none'>
                            <div class="frm_container" id="dialog-modal-pay-savings">
                                <div class="frm_heading"><span>Payment Confirmation</span></div>
                                <div class="frm_inputs">
                                    
                                    <?php echo validation_errors('<p class="text-error">'); ?>
                                     <?php echo form_open('savings/add_chairman/'); ?>
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
                

                    $(document).ready(function(){
                        $(".btn-delete").click(function(e){
                            if(!confirm('Are you sure you want to delete this Member?')){
                                e.preventDefault();
                                return false;
                            }
                            return true;
                        });
                    });
                
</script>

<script type="text/javascript">
            $( '.button_cart' ).button({ icons: {primary:'ui-icon-suitcase'} });
            $( '.button_cart').colorbox({width:'30%', inline:true, href:'#dialog-modal-pay-savings'});
        </script>







