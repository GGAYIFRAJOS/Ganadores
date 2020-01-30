<H4>MEMBER TRANSACTIONS</H4>

<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Names</th>
      <th scope="col">Type</th>
      <th scope="col">Amount</th>
      <th scope="col">Date</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($member_transactions as $mem) : ?>
    
    <tr>
     <td><?php echo $mem->member_id; ?></td>
      <td><a href="<?php echo base_url(); ?>members/get_member_info/<?php echo $mem->member_id; ?>"><?php echo $mem->names; ?></a></td>
      <td><?php echo $mem->type; ?></td>
      <td><?php echo $mem->amount; ?></td>
      <td><?php echo $mem->date; ?></td>
    </tr>
    </tr>
  <?php endforeach; ?>

  </tbody>
    
  </tbody>
</table>

<H4>NON-MEMBER TRANSACTIONS</H4>

<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
     <th scope="col">No</th>
      <th scope="col">Names</th>
      <th scope="col">Type</th>
      <th scope="col">Amount</th>
      <th scope="col">Date</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($non_member_transactions as $non) : ?>
    
    <tr>
     <td><?php echo $non->non_member_id; ?></td>
      <td><a href="<?php echo base_url(); ?>members/get_non_member_inform/<?php echo $non->non_member_id; ?>"><?php echo $non->names; ?></a></td>
      <td><?php echo $non->type; ?></td>
      <td><?php echo $non->amount; ?></td>
       <td><?php echo $non->date; ?></td>
      <td><a href="#" style="margin-left: 12px;"><img src="<?php echo base_url(); ?>public/images/document_edit.png" /></td>
      <td><a href="#" style="margin-left: 12px;"><img src="<?php echo base_url(); ?>public/images/document_delete.png" /></td>
    </tr>
    </tr>
  <?php endforeach; ?>

  </tbody>
    
  </tbody>
</table>

