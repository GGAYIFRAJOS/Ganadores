<H4>MEMBER TRANSACTIONS FOR <?php echo urldecode($name); ?> YEAR <?php echo $year; ?></H4>

<div class="manage_menu"><a href="<?php echo base_url(); ?>transactions/view_report_member/<?php echo $year; ?>/<?php echo $id; ?>/<?php echo urldecode($name); ?>" style="margin-left: 12px;"><button class="btn-primary">PRINT TRANSACTIONS<img src="<?php echo base_url(); ?>public/images/pdf.png" /></button></a></div>

<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Type</th>
      <th scope="col">Amount</th>
      <th scope="col">Date</th>
      <th>Delete</th>
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
      <td><a href="#" style="margin-left: 12px;"><img src="<?php echo base_url(); ?>public/images/document_delete.png" /></td>
    </tr>
    </tr>
  <?php endforeach; ?>

  </tbody>
    
  </tbody>
</table>