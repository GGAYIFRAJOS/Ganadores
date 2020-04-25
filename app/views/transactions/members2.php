<H4>MEMBER TRANSACTIONS FOR <?php echo urldecode($name); ?></H4>


<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Type</th>
      <th scope="col">Amount</th>
      <th scope="col">Date</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 0; ?>
  <?php foreach ($member_transactions as $mem) : ?>
    
    <tr>
     <td><?php echo ++$i; ?></td>
      <td><?php echo $mem->type; ?></td>
      <td><?php echo $mem->amount; ?></td>
      <td><?php echo $mem->date; ?></td>
    </tr>
    </tr>
  <?php endforeach; ?>

  </tbody>
    
  </tbody>
</table>