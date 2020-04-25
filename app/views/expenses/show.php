<h3>Expenses list</h3>

<?php if($this->session->flashdata('amount_excess')) : ?>
    <?php echo '<p class="error">' .$this->session->flashdata('amount_excess') . '</p>'; ?>
<?php endif; ?>

<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th >No</th>
      <th >Description</th>
      <th >Amount</th>
      <th>Date</th>
      
    </tr>
  </thead>
  <tbody>
  <?php $i = 0; $total_fines = 0; $total_paid = 0;?>
  <?php foreach ($expenses as $expense) : ?>
  	
    
    <tr>  
    <td style="width:25%;"><?php echo $expense->id; ?></td>
    <td style="width:25%;"><?php echo $expense->description; ?></td>
    <td style="width:25%;"><?php echo $expense->date; ?></td>
    <td style="width:25%;"><?php echo $expense->amount; ?><?php $total_paid += $expense->amount; ?></td>
   
    </tr>
  <?php endforeach; ?>

  </tbody>

  <tfoot>
    <td><b>TOTAL</b></td>
    <td></td>
    <td></td>
    <td><?php echo $total_paid; ?></td>
    
  </tfoot>
    
  
</table>

