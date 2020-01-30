<h3><u>MEMBER PAYMENTS FOR <?php echo $year; ?></u></h3>

<?php if($this->session->flashdata('deleted')) : ?>
    <?php echo '<p class="text-success">' .$this->session->flashdata('deleted') . '</p>'; ?>
<?php endif; ?>

<br>

<div class="manage_menu"><a href="<?php echo base_url(); ?>payments/print_report/"><button class="btn-primary">PRINT GENERAL TRANSACTIONS<img src="<?php echo base_url(); ?>public/images/pdf.png" /></button></a></div>


<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Names</th>
      <th scope="col">Membership</th>
      <th scope="col">Amount</th>
      <th scope="col">Date</th>
      <th scope="col">Type</th>
       <?php if($this->session->userdata('user_role') == 'admin'): ?>
      <th scope="col">Delete</th>
      <?php else: ?>
        <?php echo ""; ?>
      <?php endif; ?>
    </tr>
  </thead>

  <?php $i = 0; ?>
  <tbody>
  <?php foreach ($payments as $payment) : ?>
    
    <tr>
     <td><?php echo ++$i; ?></td>
      <td><a href="<?php echo base_url(); ?>members/get_member_info/<?php echo $payment->member_id; ?>"><?php echo $payment->names; ?></a></td>
       <td><?php echo $payment->membership; ?></td>
      <td><?php echo $payment->payment_amount; ?></td>
      <td><?php echo $payment->payment_date; ?></td>
      <td><?php echo $payment->type; ?></td>
       <?php if($this->session->userdata('user_role') == 'admin'): ?>
      <td><a href="<?php echo base_url(); ?>payments/delete_payment/<?php echo $payment->id ?>/<?php echo $payment->payment_amount; ?>/<?php echo $payment->member_id; ?>/<?php echo $payment->names; ?>/<?php echo $payment->type; ?>/<?php echo $payment->payment_date; ?>" style="margin-left: 12px;"><span class="btn-delete"><img src="<?php echo base_url(); ?>public/images/document_delete.png" /></span></td>
        <?php else: ?>
        <?php echo ""; ?>
      <?php endif; ?>
    </tr>
    </tr>
  <?php endforeach; ?>

  </tbody>
    
  </tbody>
</table>