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
      <th >Names</th>
      <th >Amount Paid</th>
      <th>Balances</th>
    </tr>
  </thead>
  <tbody>
  <?php $i = 0; $total_balances = 0; $total_paid = 0;?>
  <?php foreach ($balances as $balance) : ?>
    
    <tr>  
    <td style="width:25%;"><?php echo ++$i; ?></td>
    <td style="width:25%;"><?php echo $balance->member; ?></td>
    <td style="width:25%;"><?php echo $balance->amount_paid; ?><?php $total_paid += $balance->amount_paid; ?></td>
    <td style="width:25%;"><?php echo $balance->total_balances; ?><?php $total_balances += $balance->total_balances; ?></td>
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


