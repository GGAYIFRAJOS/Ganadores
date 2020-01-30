<h1>General Loans List</h1>

<?php if($this->session->flashdata('Loan_added')) : ?>
    <?php echo '<p class="text-success">' .$this->session->flashdata('Loan_added') . '</p>'; ?>
<?php endif; ?>


<?php if($this->session->flashdata('Loan_freeze')) : ?>
    <?php echo '<p class="text-success">' .$this->session->flashdata('Loan_freeze') . '</p>'; ?>
<?php endif; ?>


<?php if($this->session->flashdata('Loan_not_freeze')) : ?>
    <?php echo '<p class="text-success">' .$this->session->flashdata('Loan_not_freeze') . '</p>'; ?>
<?php endif; ?>
<H4>MEMBER LOANS</H4>

<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Names</th>
      <th scope="col">Amount</th>
      <th scope="col">Interest</th>
      <th scope="col">Loan Date</th>
      <th scope="col">Amount Paid</th>
      <th scope="col">Balance</th>
      <th scope="col"><b>Status</b></th>
      <?php if($this->session->userdata('user_role') == 'admin'): ?>
      <th scope="col">Delete</th>
      <?php else: ?>
      <?php echo ""; ?>
      <?php endif; ?>
      
    </tr>
  </thead>
  <tbody>
  <?php foreach ($mem_loans as $mem) : ?>
    
    <tr>
     <td><?php echo $mem->member_id; ?></td>
      <td><a href="<?php echo base_url(); ?>members/get_member_info/<?php echo $mem->member_id; ?>"><?php echo $mem->names; ?></a></td>
      <td><?php echo $mem->amount; ?></td>
      <td><?php echo $mem->interest; ?></td>
      <td><?php echo $mem->loan_date; ?></td>
      <td><?php echo $mem->total_amount; ?></td>
      <td><?php echo $mem->balance; ?></td>
      <td><b><?php echo $mem->status; ?></b></td>

      <?php if($this->session->userdata('user_role') == 'admin'): ?>
      <td><a href="<?php echo base_url(); ?>loans/delete_loan_member/<?php echo $mem->member_id; ?>"><span class="btn-delete"><img src="<?php echo base_url(); ?>public/images/document_delete.png" /></span></a></td>
     
      
      <?php else: ?>
      <?php echo ""; ?>
      <?php endif; ?>
    </tr>
  <?php endforeach; ?>

  </tbody>
    
  </tbody>
</table>

<H4>NON-MEMBER LOANS</H4>

<table class="tablesorter" cellspacing="1">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Names</th>
      <th scope="col">Amount</th>
      <th scope="col">Interest</th>
      <th scope="col">Date</th>
      <th scope="col">Amount Paid</th>
      <th scope="col">Total Amount Due</th>
      <th scope="col">Date</th>
      <th scope="col"><b>Status</b></th>
      <?php if($this->session->userdata('user_role') == 'admin'): ?>
      <th scope="col">Delete</th>
      <?php else: ?>
        <?php echo ""; ?>
      <?php endif; ?>
      
    </tr>
  </thead>
  <tbody>
  <?php foreach ($non_loans as $non) : ?>
    
    <tr>
     <td><?php echo $non->non_member_id; ?></td>
      <td><a href="<?php echo base_url(); ?>members/get_non_member_inform/<?php echo $non->non_member_id; ?>"><?php echo $non->non_member; ?></a></td>
      <td><?php echo $non->amount; ?></td>
      <td><?php echo $non->interest; ?></td>
      <td><?php echo $non->loan_date; ?></td>
	  <td><?php echo $non->total_amount; ?></td>
      <td><?php echo $non->balance; ?></td>
      <td><b><?php echo $non->status; ?></b></td>
      <?php if($this->session->userdata('user_role') == 'admin'): ?>
      <td><a href="<?php echo base_url(); ?>loans/delete_loan_non_member/<?php echo $non->non_member_id; ?>"><span class="btn-delete"><img src="<?php echo base_url(); ?>public/images/document_delete.png" /></span></a></td>
        <?php else: ?>
        <?php echo ""; ?>
      <?php endif; ?>
      
    </tr>
 
  <?php endforeach; ?>

  </tbody>


  <script type="text/javascript">
                

                    $(document).ready(function(){
                        $(".btn-delete").click(function(e){
                            if(!confirm('Are you sure you want to delete this Loan?')){
                                e.preventDefault();
                                return false;
                            }
                            return true;
                        });
                    });
              
</script>
    
 
