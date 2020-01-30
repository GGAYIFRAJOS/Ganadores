<H4>NON-MEMBER TRANSACTIONS FOR YEAR <?php echo $year; ?></H4>

<div class="manage_menu"><a href="<?php echo base_url(); ?>transactions/view_non_report/<?php echo $year; ?>" style="margin-left: 12px;"><button class="btn-primary">PRINT TRANSACTIONS<img src="<?php echo base_url(); ?>public/images/pdf.png" /></button></a></div>

<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Type</th>
      <th scope="col">Names</th>
      <th scope="col">Amount</th>
      <th scope="col">Date</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 0; ?>
  <?php foreach ($non_member_transactions as $mem) : ?>
    
    <tr>
     <td><?php echo ++$i; ?></td>
      <td><?php echo $mem->type; ?></td>
      <td><a href="<?php echo base_url(); ?>members/get_non_member_inform/<?php echo $mem->non_member_id; ?>"><?php echo $mem->names; ?></a></td>
      <td><?php echo $mem->amount; ?></td>
      <td><?php echo $mem->date; ?></td>
    </tr>
    </tr>
  <?php endforeach; ?>

  </tbody>
    
  </tbody>
</table>