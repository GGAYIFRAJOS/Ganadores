<h1>Savings's List</h1>

<?php if($this->session->flashdata('Loan_added')) : ?>
    <?php echo '<p class="text-success">' .$this->session->flashdata('Loan_added') . '</p>'; ?>
<?php endif; ?>

<?php if($this->session->flashdata('savings_full')) : ?>
    <?php echo '<p class="text-success">' .$this->session->flashdata('savings_full') . '</p>'; ?>
<?php endif; ?>
     



<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th >No</th>
      <th >Member Names</th>
      <th >Amount</th>
      
      
    </tr>
  </thead>
  <tbody>
  <?php $i = 0; ?>
  <?php foreach ($savings as $save) : ?>
    
    <tr>
        
    <td style="width:30%;"><?php echo ++$i; ?></td>
    <td><a href="<?php echo base_url(); ?>members/get_member_info/<?php echo $save->member_id; ?>"><?php echo urldecode($save->member); ?></a></td>
    <td style="width:30%;"><?php echo $save->Total; ?></td>
      
    </tr>
    </tr>
  <?php endforeach; ?>

  </tbody>
    
  </tbody>
</table>

