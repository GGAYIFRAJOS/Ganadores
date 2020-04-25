<h3>Fines list</h3>

<?php if($this->session->flashdata('amount_excess')) : ?>
    <?php echo '<p class="error">' .$this->session->flashdata('amount_excess') . '</p>'; ?>
<?php endif; ?>

<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th >No</th>
      <th >Fines</th>
      <th >Amount Paid</th>
      <th>Balances</th>
    </tr>
  </thead>
  <tbody>
  <?php $i = 0; $total_fines = 0; $total_paid = 0; $total_balances = 0;?>
  <?php foreach ($fines as $fine) : ?>
  	
    
    <tr>  
    <td style="width:25%;"><?php echo ++$i; ?></td>
    <td style="width:25%;"><?php echo $fine->fine; ?><?php $total_fines += $fine->fine; ?></td>
    <td style="width:25%;"><?php echo $fine->amount_paid; ?><?php $total_paid += $fine->amount_paid; ?></td>
    <td style="width:25%;"><?php echo $fine->Balance; ?><?php $total_balances += $fine->Balance; ?></td>
    </tr>
  <?php endforeach; ?>

  </tbody>

  <tfoot>
    <td>TOTAL</td>
    <td></td>
    <td><?php echo $total_paid; ?></td>
    <td><?php echo $total_fines; ?></td>
  </tfoot>
    
  
</table>

<H3 style="text-align:center;"><u>FINES</u></H3>
<div class="manage_menu"><a href="<?php echo base_url(); ?>fines/get_fines/<?php echo $id ?>/<?php echo $names ?>" style="margin-left: 12px;"><button class="btn-primary">PRINT FINE INFORMATION<img src="<?php echo base_url(); ?>public/images/pdf.png" /></button></a></div>

  <div class="clearFix"></div>

  <table class="tablesorter" cellspacing="1">
      <thead>
        <tr>
          <th>No</th>
          <th>Member</th>
          <th>Amount Paid </th>
          <th>Balance</th>
          
                  
        </tr>
      </thead>
      <tbody>
      
      
        
        <tr>  
        <td style="width:20%;"><?php echo $total_fine->member_id; ?></td>
        <td style="width:20%;"><?php echo $total_fine->member; ?></td>
        <td style="width:20%;"><?php echo $total_fine->amount_paid; ?></td>
         <td style="width:20%;"><?php echo $total_fine->total_fines; ?></td>
       
       
        
        </tr>
     

      </tbody>
        
      </tbody>
</table>


