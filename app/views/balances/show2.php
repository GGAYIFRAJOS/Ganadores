<h3>Balances list </h3>

<?php if($this->session->flashdata('amount_excess')) : ?>
    <?php echo '<p class="error">' .$this->session->flashdata('amount_excess') . '</p>'; ?>
<?php endif; ?>

<?php if($this->session->flashdata('amount_excess')) : ?>
    <?php echo '<p class="error">' .$this->session->flashdata('amount_excess') . '</p>'; ?>
<?php endif; ?>

<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th >No</th>
      <th>Remmitance balance</th>
      <th >Amount Paid</th>
      <th>Balance</th>
      
    </tr>
  </thead>
  <tbody>
  <?php $i = 0; $total_balances = 0; $total_paid = 0;?>
  <?php foreach ($balances as $balance) : ?>
    
    <tr>  
    <td style="width:25%;"><?php echo ++$i; ?></td>
    <td style="width:25%;"><?php echo $balance->Balance; ?></td>
    <td style="width:25%;"><?php echo $balance->amount_paid; ?><?php $total_paid += $balance->amount_paid; ?></td>
    <td style="width:25%;"><?php echo $balance->pay_balance; ?><?php $total_balances += $balance->pay_balance; ?></td>
    </tr>
  <?php endforeach; ?>

  </tbody>

  <tfoot>
    <td>TOTAL</td>
    <td></td>
    <td><?php echo $total_paid; ?></td>
    <td><?php echo $total_balances; ?></td>
  </tfoot>

</table>

<div class="clearFix"></div>

  <H3 style="text-align:center;"><u>BALANCES</u></H3>
<div class="manage_menu"><a href="<?php echo base_url(); ?>balances/get_balances/<?php echo $id ?>/<?php echo $names ?>" style="margin-left: 12px;"><button class="btn-primary">PRINT BALANCE INFORMATION<img src="<?php echo base_url(); ?>public/images/pdf.png" /></button></a></div>


  <table class="tablesorter" cellspacing="1">
      <thead>
        <tr>
          <th>No</th>
          <th>Amount Due </th>
          <th>Amount Paid </th>
          <th>Balance</th>
          
                  
        </tr>
      </thead>
      <tbody>
      
     
        
        <tr>  
        <td style="width:20%;"><?php echo $total_balance->member_id; ?></td>
        <td style="width:20%;"><?php echo $total_balance->member; ?></td>
        <td style="width:20%;"><?php echo $total_balance->amount_paid; ?></td>
         <td style="width:20%;"><?php echo $total_balance->total_balances; ?></td>
        
       
        
        </tr>
     

      </tbody>
        
      </tbody>
</table>
  
</table>


