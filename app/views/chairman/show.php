<h3>Fines list</h3>

<?php if($this->session->flashdata('amount_excess')) : ?>
    <?php echo '<p class="error">' .$this->session->flashdata('amount_excess') . '</p>'; ?>
<?php endif; ?>

<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th >No</th>
      <th >Names</th>
      <th >Amount Paid</th>
      <th >Fines</th>
    </tr>
  </thead>
  <tbody>
  <?php $i = 0; $total_fines = 0; $total_paid = 0;?>
  <?php foreach ($chairman as $chair) : ?>
  	
    
    <tr>  
    <td style="width:25%;"><?php echo $chair->member_id; ?></td>
    <td style="width:25%;"><?php echo $chair->member; ?></td>
    <td style="width:25%;"><?php echo $chair->amount; ?><?php $total_paid += $chair->amount; ?></td>
    <td style="width:25%;"><?php echo $chair->fine; ?><?php $total_fines += $chair->fine; ?></td>
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

