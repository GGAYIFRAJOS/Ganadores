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
  <?php foreach ($fines as $fine) : ?>
  	
    
    <tr>  
    <td style="width:25%;"><?php echo ++$i; ?></td>
    <td style="width:25%;"><?php echo $fine->member; ?></td>
    <td style="width:25%;"><?php echo $fine->amount_paid; ?><?php $total_paid += $fine->amount_paid; ?></td>
    <td style="width:25%;"><?php echo $fine->total_fines; ?><?php $total_fines += $fine->total_fines; ?></td>
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

